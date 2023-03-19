<<<<<<< HEAD
var page = 1
jQuery(function ($) {
  // 定义一个名为 loadPosts 的函数，用于发送 AJAX 请求并渲染文章数据
  function loadPosts(page) {
    $('#load-more').text('正在加载中...')
    // 发送 AJAX 请求获取文章数据
    fetch(hotSpotObject.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': hotSpotObject.nonce,
      },
      body: JSON.stringify({
        page: page,
      }),
    })
      .then((response) => response.json())
      .then((data) => {

        if(data.data === 'none'){
          $('#load-more').text('无更多数据')
          return
        }


        // 将文章数据渲染到容器元素中
        data.forEach((post) => {
          const postHtml = `
                <div class="hotspot-statistics-card">
                    <h1><a href="${post.link}">${post.title}</a></h1>
                    <table class="hotspot-statistics-table">
                        <tbody>
                            <tr><td>日期:</td><td>${post.date}</td></tr>
                            <tr><td>作者:</td><td>${post.author}</td></tr>
                            <tr><td>分类:</td><td>${post.categories}</td></tr>
                        </tbody>
                    </table>
                </div>
            `
          $('.hotspot-statistics-card-container').append(postHtml)
        })
        $('#load-more').text('加载更多')
      })
      .catch((error) => console.error(error))
  }

  // 在文档加载完成后，立即调用 loadPosts 函数进行初次加载
  loadPosts(page)

  // 监听“加载更多”按钮的点击事件，每次点击时调用 loadPosts 函数加载下一页文章
  $('#load-more').on('click', function () {
    loadPosts(++page)
  })
})
=======
var page = 1
jQuery(function ($) {
  // 定义一个名为 loadPosts 的函数，用于发送 AJAX 请求并渲染文章数据
  function loadPosts(page) {
    $('#load-more').text('正在加载中...')
    // 发送 AJAX 请求获取文章数据
    fetch(hotSpotObject.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': hotSpotObject.nonce,
      },
      body: JSON.stringify({
        page: page,
      }),
    })
      .then((response) => response.json())
      .then((data) => {

        if(data.data === 'none'){
          $('#load-more').text('无更多数据')
          return
        }


        // 将文章数据渲染到容器元素中
        data.forEach((post) => {
          const postHtml = `
                <div class="hotspot-statistics-card">
                    <h1><a href="${post.link}">${post.title}</a></h1>
                    <table class="hotspot-statistics-table">
                        <tbody>
                            <tr><td>日期:</td><td>${post.date}</td></tr>
                            <tr><td>作者:</td><td>${post.author}</td></tr>
                            <tr><td>分类:</td><td>${post.categories}</td></tr>
                        </tbody>
                    </table>
                </div>
            `
          $('.hotspot-statistics-card-container').append(postHtml)
        })
        $('#load-more').text('加载更多')
      })
      .catch((error) => console.error(error))
  }

  // 在文档加载完成后，立即调用 loadPosts 函数进行初次加载
  loadPosts(page)

  // 监听“加载更多”按钮的点击事件，每次点击时调用 loadPosts 函数加载下一页文章
  $('#load-more').on('click', function () {
    loadPosts(++page)
  })
})
>>>>>>> remotes/origin/main
