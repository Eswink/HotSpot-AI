// 创建 AbortController 对象
const abortController = new AbortController();
let isAborted = false;


// 监听来自主线程的消息
self.addEventListener('message', function(event) {
  const apiUrl = event.data.url;
  const requestData = event.data.data;
  const nonce = event.data.nonce

  const he_js = event.data.js_add

  if (typeof self.importScripts !== "undefined" && !self.he_js_loaded) {
    self.he_js_loaded = true;
    importScripts(he_js);
  }
  

  // 发送fetch请求获取响应数据
  fetch(apiUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/octet-stream',
      'X-WP-Nonce':nonce
    },
    body: JSON.stringify(requestData),
    signal: abortController.signal // 将 AbortController 对象传给 fetch
  })
  .then(response => {
    const reader = response.body.getReader(); // 获取ReadableStream对象的阅读器
    let buffer = ''; // 字符串缓冲区
    let isLasted = false

    // 循环读取数据并解析完整的JSON字符串
    const readChunk = () => {
      reader.read().then(({ done, value }) => {
        // 转义！
        const text = new TextDecoder().decode(value); // 将二进制数据转换为文本
        buffer += text; // 将文本添加到字符串缓冲区中

        while (true) { // 在缓冲区中查找完整的JSON字符串并解析它
          buffer = he.decode(buffer)

          const index = buffer.indexOf('\n');
        
          if (index === -1) {
            break; // 如果没有找到完整的JSON字符串，则跳出循环等待下一次读取
          }

          try {
            const jsonString = buffer.substring(0, index).trim(); // 获取完整的JSON字符串并去除两端的空格
            const json = JSON.parse(jsonString); // 解析JSON字符串为JavaScript对象
            self.postMessage(json.delta); // 将解析出的delta值发送到主线程
          } catch (error) {
            self.dispatchEvent(new ErrorEvent('error', { message: error.message })); // 向主线程发送错误消息
          }

          buffer = buffer.substring(index + 1); // 从缓冲区中删除已解析的JSON字符串
        }
        if (done) {
          self.postMessage('done'); // 如果是最后一条数据，则向主线程发送特殊消息
          return;
        }

        readChunk(); // 递归调用自身以继续读取数据
      }).catch(error => {
        self.dispatchEvent(new ErrorEvent('error', { message: error.message })); // 向主线程发送错误消息
      });
    };

    readChunk(); // 开始读取数据
  })
  .catch(error => {
    if (!isAborted) { // 判断请求是否被手动终止
      self.dispatchEvent(new ErrorEvent('error', { message: error.message })); // 向主线程发送错误消息
    }
  });

  // 监听来自主线程的终止请求
  self.addEventListener('terminate', () => {
    console.log('Worker terminating...');
    isAborted = true;
    abortController.abort(); // 手动终止当前请求
    self.close(); // 关闭 Worker 线程
  });
});
