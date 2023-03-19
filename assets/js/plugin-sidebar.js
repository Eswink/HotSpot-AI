;(function (wp) {
  // 获取所需的 WordPress API 工具
  var registerPlugin = wp.plugins.registerPlugin
  var PluginSidebar = wp.editPost.PluginSidebar
  var el = wp.element.createElement
  var TextControl = wp.components.TextControl
  var Button = wp.components.Button
  var Modal = wp.components.Modal
  var RichText = wp.blockEditor.RichText
  var PanelBody = wp.components.PanelBody

  // 定义需要用到的变量
  var AiConceptContent = ''
  var _worker = null

  function HotspotAISidebar() {
    // 使用 useState 钩子定义 state 变量
    var [_isOpen, setIsOpen] = wp.element.useState(false)
    var [_title, setTitle] = wp.element.useState('')
    var [_content, setContent] = wp.element.useState('')
    var [_isRequesting, setIsRequesting] = wp.element.useState(false)

    // 打开模态框时执行的函数
    function openModal() {
      setIsOpen(true)
      // 获取文章标题并设置为 state 变量
      setTitle(wp.data.select('core/editor').getEditedPostAttribute('title'))

      // 如果 Worker 实例不存在，则创建一个新实例并保存到 _worker 变量中
      if (!_worker) {
        var workerUrl = URL.createObjectURL(
          new Blob(['importScripts("' + window.request_worker_url + '");'], {
            type: 'text/javascript',
          })
        )
        var w = new Worker(workerUrl)
        _worker = w
      } else {
        console.log('Worker instance already exists.')
      }
    }

    // 关闭模态框时执行的函数
    function closeModal() {
      if (_isRequesting) {
        // 判断当前是否正在请求数据
        var confirmed = confirm('文章还未生成完毕，你确定要终止生成吗？')
        if (confirmed) {
          if (_worker) {
            _worker.terminate() // 终止当前的 Worker 实例
            _worker = null // 将 _worker 置为 null
          }
          setIsRequesting(false)
          setIsOpen(false)
        }
      } else {
        setIsOpen(false)

        // 终止 Worker 实例，并将 _worker 置为 null
        if (_worker) {
          _worker.terminate()
          _worker = null
        }
      }
    }

    // 处理表单提交的函数
    function handleFormSubmit() {
      if (_isRequesting) {
        // 判断当前是否正在请求数据
        var confirmed = confirm('文章还未生成完毕，你确定要直接插入内容吗？')
        if (confirmed) {
          if (_worker) {
            _worker.terminate() // 终止当前的 Worker 实例
            _worker = null // 将 _worker 置为 null
          }
          _isRequesting = false
        } else {
          return
        }
      }
      var newContent = _content
      var contentBlock = wp.blocks.parse(newContent)
      var html = wp.blocks.serialize(contentBlock)
      wp.data.dispatch('core/editor').editPost({
        content: '',
      })
      wp.data.dispatch('core/block-editor').insertBlocks(contentBlock, 0)
      closeModal()
    }

    // 处理 AI 创作的函数
    function handleAiConcept() {
      setContent('')
      // 如果正在构思中，则不进行操作
      if (_isRequesting) {
        console.log('正在构思中...')
        return
      }

      var button = document.querySelector('.ai-concept')
      button.textContent = '正在思考中。。'
      setIsRequesting(true)
      var editorInput = document.querySelector('.hotspot-editor-input')
      editorInput.setAttribute('contenteditable', false)

      // 发送消息给 Worker 实例进行处理
      AiConceptContent = ''

      _worker.postMessage({
        url: window.request_proxy_url,
        data: {
          prompt: wp.data.select('core/editor').getEditedPostAttribute('title'),
          options: {},
        },
        nonce: hotspot_nonce,
      })

      // 在 Worker 接收到消息时执行的函数，处理 Worker 传回的数据并设置为 state 变量
      function handleWorkerMessage(data) {
        if (data === 'done') {
          editorInput.setAttribute('contenteditable', true)
          button.textContent = '重新构思'
          setIsRequesting(false)
        } else if (data != undefined) {
          AiConceptContent += data
          setContent(AiConceptContent)
        }
      }

      // 监听 Worker 消息事件
      _worker.onmessage = function (event) {
        handleWorkerMessage(event.data)
      }
    }

    // 描述本插件的文本
    var pluginDescription = el(
      'p',
      {},
      '智能构思，创意无限。让AI带您发现文章的更多可能性！'
    )
    return el(
      'div',
      { className: 'plugin-sidebar-content' },
      el(
        'div',
        { className: 'my-plugin-panel' },
        el(
          PanelBody,
          {
            title: 'AI辅助撰写',
          },
          pluginDescription
        ),
        el(
          PanelBody,
          {
            title: '热点创作',
          },
          el(
            Button,
            {
              className: 'hotspot-editor-button',
              isPrimary: true,
              onClick: openModal,
            },
            'AI创作'
          )
        )
      ),
      _isOpen &&
        el(
          Modal,
          {
            title: 'AI创作',
            onRequestClose: closeModal,
          },
          // 添加一个 TextControl 组件作为示例
          el(TextControl, {
            label: '文章标题',
            value: _title,
            onChange: function onChange(newTitle) {
              setTitle(newTitle)
            },
          }),
          el(RichText, {
            tagName: 'div',
            value: _content,
            onChange: setContent,
            className: 'hotspot-editor-input',
          }),
          el('p', {}, '将会在此生成 AI 创作的内容。'),
          el(
            Button,
            {
              className: 'ai-concept',
              isPrimary: true,
              onClick: handleAiConcept,
            },
            '开始构思'
          ),
          el(
            Button,
            {
              variant: 'secondary',
              onClick: closeModal,
            },
            '关闭'
          ),
          el(
            Button,
            {
              isPrimary: true,
              onClick: handleFormSubmit,
            },
            '插入内容'
          )
        )
    )
  }

  // 注册侧边栏插件
  registerPlugin('hotspot-ai-sidebar', {
    render: function render() {
      return el(
        PluginSidebar,
        {
          name: 'hotspot-ai-sidebar',
          icon: 'lightbulb',
          title: 'Hotspot AI Sidebar',
        },
        el(HotspotAISidebar, {})
      )
    },
  })
})(window.wp)
