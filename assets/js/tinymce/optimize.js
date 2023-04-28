jQuery(document).ready(function ($) {
  var parent_editor = tinymce.activeEditor
  var ai_idea_button = $('#ai-idea-btn')
  var ai_search_button = $('#ai-search-btn')
  var current_windowManager
  var _worker = null
  var AiConceptContent = ''
  var _isRequesting = false

  var _isSearching = false

  init_worker()

  // 为自定义按钮绑定点击事件
  ai_idea_button.on('click', function (event) {
    event.preventDefault() // 取消默认行为
    showAIConcept()
  })

  ai_search_button.on('click', function (event) {
    event.preventDefault()
    showAISearch()
  })

  /*------------AI智能搜图----------------- */

  function setIsSearching(status) {
    var mask = $('#mask')
    var btn_txt = $('#search_button .mce-txt')
    var btn = $('#search_button-button')
    _isSearching = status
    if (status) {
      // 即正在搜索请求
      mask.addClass('loading').addClass('search_loading')
      btn_txt.text('正在搜索中...')
    } else {
      mask.removeClass('loading').removeClass('search_loading')
      btn_txt.text('重新搜索')
    }
    btn.prop('disabled', status)
  }

  function showAISearch() {
    if (typeof classic_optimize.search_images_url === 'undefined') {
      // tinymce 弹出提示框
      tinymce.activeEditor.windowManager.alert('未开启智能搜图功能')
      return
    }

    var search_value

    current_windowManager = tinymce.activeEditor.windowManager.open({
      title: 'AI智能搜图',
      body: [
        {
          type: 'textbox',
          name: 'input_search',
          label: '您想要搜索的图片',
          value: search_value,
          onkeyup: function () {
            // 当 input_title 的值发生变化时更新绑定的值
            search_value = this.value()
          },
        },
        {
          type: 'button', // 新增的 button 对象
          name: 'search_button', // 按钮名称，可随意命名
          id: 'search_button',
          text: '搜索', // 按钮显示文本
          style:
            'background: #3582c4; border-color: #2271b1 #135e96 #135e96; box-shadow: 0 1px 0 #135e96; color: #fff; text-decoration: none; text-shadow: 0 -1px 1px #135e96,1px 0 1px #135e96,0 1px 1px #135e96,-1px 0 1px #135e96;', // 设置样式
          onclick: function () {
            search_images(search_value)
          },
        },

        {
          type: 'container',
          html: '<div id="mask"><div id="image-results"></div></div>',
          minHeight: 650,
        },
      ],
      buttons: [],
      minWidth: 1200, // 设置最大宽度
      minHeight: 800, // 设置最大高度
    })

    
  }

  function search_images(keyword) {
    var apiUrl = classic_optimize.search_images_url

    // 构建请求参数对象
    var postData = { query: keyword }

    // 发送 POST 请求，并处理响应结果
    var resultsContainer = $('#image-results')
    resultsContainer.empty()
    setIsSearching(true)
    $.ajax({
      url: apiUrl,
      type: 'POST',
      data: postData,
      dataType: 'json',
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', classic_optimize.hotspot_nonce)
      },
      success: function (data) {
        setIsSearching(false)
        // 处理返回的数据
        if (data && data.data) {
          display_images(data.data, false)
        }
      },
      error: function (data) {
        setIsSearching(false)
        display_images(data.responseJSON, true)
      },
    })
  }

  function display_images(images, error) {
    // 获取要显示搜索结果的 DOM 元素
    var resultsContainer = $('#image-results')
    resultsContainer.empty()
    if (error) {
      resultsContainer.text(images.message)
      return
    }

    // 如果搜索结果为空，显示无结果提示信息
    if (images.length === 0) {
      resultsContainer.text('未找到相关图片')
      return
    }

    // 将所有图片包装在一个 <div> 中
    var $imageWrapper = $('<div>').addClass('image-wrapper')
    resultsContainer.append($imageWrapper)

    // 遍历搜索结果，为每个图片创建一个 <div> 元素，并添加到 DOM 树中
    $.each(images, function (index, image) {
      // 创建新的 <div> 元素
      var $imgWrap = $('<div>').addClass('image-wrap')

      // 创建新的 <img> 标签和 <p> 标签
      var $img = $('<img>')
        .attr('src', image.img_url)
        .css('height', '270px')
        .css('width', '270px')
      var $author = $('<p>').text(image.Photographer)

      $imgWrap.on('click', function () {
        insertImageToClassicEditor(image.img_url, image.Photographer)
      })

      // 将 <img> 标签和 <p> 标签添加到图片包装器中
      $imgWrap.append($img).append($author)

      // 将图片包装器添加到图片包装器中
      $imageWrapper.append($imgWrap)

      // 每行最多 4 张图片，创建新的图片包装器
      if ((index + 1) % 4 === 0) {
        $imageWrapper = $('<div>').addClass('image-wrapper')
        resultsContainer.append($('<div>').addClass('image-wrapper-gap')) // 新增：添加行间隔
        resultsContainer.append($imageWrapper)
      }
    })
  }

  function insertImageToClassicEditor(imgUrl, authorName) {
    var insertImage = confirm('是否插入该图片？')
    if (!insertImage) {
      return
    }

    var current_upload_window = tinymce.activeEditor.windowManager.open({
      title: '上传组件',
      type: 'container',
      html: '<div id="upload_mask"></div>',
      minHeight: 300,
      minWidth: 400,
      buttons:[]
    })

    var mask = $('#upload_mask')
    mask.addClass('loading').addClass('search_downloading')

    fetch(imgUrl)
      .then((response) => response.blob())
      .then((blob) => {
        // 将 blob 数据转换为 Base64 编码
        var reader = new FileReader()
        reader.onloadend = function () {
          var base64data = reader.result

          // 创建一个 FormData 对象，并添加需要上传的文件
          var formData = new FormData()
          formData.append('file', base64data)
          formData.append('action', 'hotspot_upload_file')

          // 通过 AJAX 请求上传文件
          mask.removeClass('search_downloading').addClass('search_uploading')
          $.ajax({
            url: ajaxurl, // WordPress AJAX 接口地址
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
              if (data.success) {
                var imageUrl = data.data.url
                var editor = tinymce.activeEditor
                // current_upload_window.close()
                mask.removeClass('search_uploading').addClass('search_finished')

                setTimeout(() => {
                  // 判断是否有光标位置
                  current_upload_window.close()
                  current_windowManager.close()
                  if (editor.selection) {
                    // 如果有光标位置，使用 execCommand() 方法插入图片
                    editor.execCommand(
                      'mceInsertContent',
                      false,
                      '<img src="' + imageUrl + '" />'
                    )
                  } else {
                    // 如果没有光标位置，使用 insertContent() 方法插入图片
                    editor.insertContent('<img src="' + imageUrl + '" />')
                    console.log("有光标位置")
                  }
                }, 1000)

                
              } else {
                // 如果上传失败，显示错误信息
                alert('上传图片失败：' + data.data.message)
              }
            },
            error: function () {
              // 如果请求失败，显示错误信息
              alert('上传图片失败：请求错误')
            },
          })
        }
        reader.readAsDataURL(blob)
      })
  }

  // 初始化 service woker
  function init_worker() {
    if (!_worker) {
      var workerUrl = URL.createObjectURL(
        new Blob(
          ['importScripts("' + classic_optimize.request_worker_url + '")'],
          {
            type: 'text/javascript',
          }
        )
      )
      var w = new Worker(workerUrl)
      _worker = w
      console.log('Worker registered successfully')
    } else {
      console.log('Worker instance already exists.')
    }
  }

  function insert_to_post(content) {
    parent_editor.setContent(content)
  }

  function showAIConcept() {
    // 获取当前文章标题
    const articleTitle = document.getElementById('title').value

    // 将获取到的标题赋值给 titleValue
    let titleValue = articleTitle

    tinymce.activeEditor.windowManager.open({
      title: 'AI构思',
      body: [
        {
          type: 'textbox',
          name: 'input_title',
          label: '标题',
          value: titleValue,
          onkeyup: function () {
            // 当 input_title 的值发生变化时更新绑定的值
            titleValue = this.value()
          },
        },
        {
          type: 'container',
          html: '<div id="mask"><textarea id="AI_Concept_textarea"></textarea></div>',
          minHeight: 500,
        },
      ],
      buttons: [
        {
          text: '开始构思',
          id: 'ai_concept',
          style: 'width:120px',
          onclick: function () {
            handleAIConcept(titleValue)
          },
        },
        {
          text: '插入内容',
          onclick: function () {
            insert_to_post(ai_concept_editor.getContent())
            parent_editor.windowManager.close()
          },
        },
      ],
      width: 800,
      height: 600,
      onOpen: function () {
        tinymce.init({
          selector: '#AI_Concept_textarea',
          height: 450,
          menubar: false,
          content_css: classic_optimize.editor_css,
          setup: function (editor) {
            editor.on('input', function () {
              console.log(editor.getContent())
            })
            ai_concept_editor = editor
          },
        })
      },
      onClose: function () {
        tinymce.remove('#AI_Concept_textarea')
      },
    })
  }

  // 设置 isLoading 状态
  function setIsRequesting(isRequesting) {
    _isRequesting = isRequesting
  }

  // 处理 AI 创作的函数
  function handleAIConcept(titleValue) {
    if (_isRequesting) {
      console.log('正在构思中...')
      return
    }

    // 设置按钮文本和标题为“正在构思中...”

    const btn = $('#ai_concept-button')
    const oldText = btn.text()
    btn.text('正在构思中...')

    // 开始构思
    setIsRequesting(true)
    AiConceptContent = ''

    // 更新编辑器内容
    setEditorContent(AiConceptContent)
    $('#mask').addClass('loading')
    ai_concept_editor.getBody().classList.add('loading')

    _worker.postMessage({
      url: classic_optimize.request_proxy_url,
      data: {
        prompt: titleValue,
        options: {},
      },
      nonce: classic_optimize.hotspot_nonce,
      js_add: classic_optimize.he_js_url,
    })

    // 在 Worker 接收到消息时执行的函数，处理 Worker 传回的数据并设置为 state 变量
    function handleWorkerMessage(data) {
      if (data === 'done') {
        setIsRequesting(false)

        // 恢复按钮文本和标题为原文本
        btn.text(oldText)
        $('#mask').removeClass('loading')
        ai_concept_editor.getBody().classList.remove('loading')
      } else if (data != undefined) {
        AiConceptContent += data
        setEditorContent(AiConceptContent)
      }
    }

    // 监听 Worker 消息事件
    _worker.onmessage = function (event) {
      handleWorkerMessage(event.data)
    }
  }

  function setEditorContent(content) {
    ai_concept_editor.setContent(content)
  }

  /*----------------SEO分析-------------------*/

  function setAnalysisLoading(status) {
    var mask = $('.mask')
    _analysis_loading = status
    $('#ai_seo_analysis').prop('disabled', status)
    if (status) {
      // 即正在等待
      mask.addClass('loading').addClass('analysis_loading')
    } else {
      mask.removeClass('loading').removeClass('analysis_loading')
    }
  }

  function setAnalysisValue(content) {
    $('#hotspot_seo_analysis_content').text(content)
  }

  // 绑定 AI分析事件
  $('#ai_seo_analysis').on('click', function () {
    handleAiAnalysis()
  })

  function handleAiAnalysis() {
    if (typeof classic_optimize.seo_analysis_url === 'undefined') {
      alert('未开启SOE分析功能！')
      return
    }

    setAnalysisLoading(true) // 开始分析之前，将 _analysis_loading 状态设为 true

    content = parent_editor.getContent()

    fetch(classic_optimize.seo_analysis_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': wpApiSettings.nonce,
      },
      body: JSON.stringify({
        prompt: content,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        // 处理API返回的数据
        // ...
        const result = `${data.data}`

        // 更新分析结果输入区域的值
        setAnalysisValue(result)
        setAnalysisLoading(false)
      })
      .catch((error) => console.error(error))
  }
})
