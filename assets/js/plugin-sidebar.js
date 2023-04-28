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
  var ToolbarButton = wp.blockEditor.RichTextToolbarButton
  var Dashicon = wp.components.Dashicon
  var TextareaControl = wp.components.TextareaControl

  // 定义需要用到的变量
  var AiConceptContent = ''
  var _worker = null

  function HotspotAISidebar() {
    // 使用 useState 钩子定义 state 变量
    var [_isOpen, setIsOpen] = wp.element.useState(false)
    var [_title, setTitle] = wp.element.useState('')
    var [_content, setContent] = wp.element.useState('')
    var [_isRequesting, setIsRequesting] = wp.element.useState(false)
    const [_tagValue, setTagValue] = wp.element.useState('')
    const [_tags, setTags] = wp.element.useState([])
    const [_analysisValue, setAnalysisValue] = wp.element.useState('')
    const [_analysis_loading, setAnalysisLoading] = wp.element.useState(false)

    // 打开模态框时执行的函数
    function openModal() {
      setIsOpen(true)
      // 获取文章标题并设置为 state 变量
      setTitle(wp.data.select('core/editor').getEditedPostAttribute('title'))

      // 如果 Worker 实例不存在，则创建一个新实例并保存到 _worker 变量中
      if (!_worker) {
        var workerUrl = URL.createObjectURL(
          new Blob(['importScripts("' + gutenberg_optimize.request_worker_url + '")'], {
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

      var mask = document.querySelector('.mask')
      mask.classList.add('loading')

      // 发送消息给 Worker 实例进行处理
      AiConceptContent = ''

      _worker.postMessage({
        url: gutenberg_optimize.request_proxy_url,
        data: {
          prompt: _title,
          options: {},
        },
        nonce: gutenberg_optimize.hotspot_nonce,
        js_add: gutenberg_optimize.he_js_url,
      })

      // 在 Worker 接收到消息时执行的函数，处理 Worker 传回的数据并设置为 state 变量
      function handleWorkerMessage(data) {
        if (data === 'done') {
          editorInput.setAttribute('contenteditable', true)
          button.textContent = '重新构思'
          mask.classList.remove('loading')
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

    function handleAiAnalysis() {
      if (typeof gutenberg_optimize.seo_analysis_url === 'undefined') {
        alert('未开启SOE分析功能！')
        return
      }

      setAnalysisLoading(true) // 开始分析之前，将 _analysis_loading 状态设为 true

      const editor = wp.data.select('core/editor')
      const content = editor
        .getBlocks()
        .map((block) => block.attributes.content)
        .join(' ')

      fetch(gutenberg_optimize.seo_analysis_url, {
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
          var id = wp.data.select('core/editor').getCurrentPostId()
          var name_local = 'hotspot_' + id + '_analysisResult'
          localStorage.setItem(name_local, result)

          setAnalysisLoading(false) // 分析完成后，将 _analysis_loading 状态设为 false
        })
        .catch((error) => console.error(error))
    }

    async function handleAddTag() {
      const newTags = _tagValue.split(/[\s,]+/).filter((tag) => tag.trim())

      if (newTags.length === 0) {
        return
      }

      try {
        const addTagPromises = newTags.map((tag) =>
          fetch('/wp-json/wp/v2/tags', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-WP-Nonce': wpApiSettings.nonce,
            },
            body: JSON.stringify({
              name: tag,
            }),
          })
        )

        const responses = await Promise.all(addTagPromises)

        for (const response of responses) {
          if (!response.ok) {
            throw new Error('添加标签时出现错误！')
          }
        }

        const tags = await Promise.all(
          responses.map((response) => response.json())
        )

        // 为每个标签对象添加 isSelected 属性
        const selectedTags = tags.map((t) => ({ ...t, isSelected: true }))
        setTagValue('')
        setTags([..._tags, ...selectedTags])

        wp.data.dispatch('core/editor').editPost({
          tags: [..._tags, ...tags].map((t) => t.id),
        })
      } catch (error) {
        console.error('添加标签时出错：', error)
      }
    }

    function handleKeyDown(event) {
      if (event.key === 'Enter') {
        event.preventDefault()
        handleAddTag()
      }
    }

    function removeTag(tagId) {
      const newTags = _tags.filter((tag) => tag.id !== tagId)
      setTags(newTags)

      // 更新文章标签列表
      wp.data.dispatch('core/editor').editPost({
        tags: newTags.map((t) => t.id),
      })
    }

    // 使用 useEffect 钩子获取当前文章的标签
    wp.element.useEffect(() => {
      const postTags = wp.data
        .select('core/editor')
        .getEditedPostAttribute('tags')
      if (postTags && postTags.length > 0) {
        const fetchTags = async () => {
          try {
            const response = await fetch(
              `/wp-json/wp/v2/tags?include=${postTags.join(',')}`
            )
            const tags = await response.json()
            setTags(tags)
          } catch (error) {
            console.error('获取标签时出错：', error)
          }
        }
        fetchTags()
      }
    }, [])

    React.useEffect(() => {
      const id = wp.data.select('core/editor').getCurrentPostId()
      const analysisResult = localStorage.getItem(
        `hotspot_${id}_analysisResult`
      )
      if (analysisResult) {
        setAnalysisValue(analysisResult)
      }
    }, [])

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
        { className: 'hotspot-plugin-panel' },
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
        ),
        el(
          PanelBody,
          {
            title: '文章SEO',
          },
          el(
            'div',
            {
              style: { marginBottom: '10px' },
            },
            // 标签分析Pro标签
            el('h3', {}, [
              el('span', {}, '分析'),
              el(
                'span',
                {
                  style: {
                    lineHeight: '16px',
                    fontSize: '12px',
                    padding: '0 5px',
                    background: '#06c',
                    borderRadius: '3px',
                    color: '#fff',
                    cursor: 'pointer',
                    marginLeft: '5px',
                  },
                },
                'Pro'
              ),
            ]),

            el(
              Button,
              {
                isPrimary: true,
                onClick: handleAiAnalysis,
                style: { marginBottom: '10px' },
              },
              _analysis_loading ? '分析中...' : 'AI分析'
            ), // 根据 _analysis_loading 状态修改按钮文本

            el(TextareaControl, {
              label: '分析结果',
              value: _analysisValue,
              onChange: (newValue) => setAnalysisValue(newValue),
              placeholder: 'AI分析结果将在这里展现',
              rows: 15,
              disabled: _analysis_loading, // 根据 _analysis_loading 状态控制组件是否可编辑
              help: _analysis_loading ? '正在分析，请稍候...' : null, // 根据 _analysis_loading 状态显示提示信息
            })
          ),
          // 标签分析Pro标签

          el(TextControl, {
            label: '添加新标签',
            value: _tagValue,
            onChange: (newValue) => setTagValue(newValue),
            onKeyDown: handleKeyDown,
          }),
          el('p', null, '用逗号或空格分隔多个标签。'),
          _tags.map((tag) =>
            el(
              'span',
              {
                key: tag.id,
                className: 'components-form-token-field__token',
                style: { marginBottom: '10px' },
              },
              el(
                'span',
                {
                  className:
                    'components-form-token-field__token-text components-visually-hidden css-0 e19lxcc00',
                },
                tag.name
              ),
              el(
                Button,
                {
                  onClick: () => removeTag(tag.id),
                  className:
                    'components-button components-form-token-field__remove-token has-icon',
                },
                el(Dashicon, { icon: 'no-alt' })
              )
            )
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
          el(
            'div',
            {
              className:'mask'
            },
            el(RichText, {
              tagName: 'div',
              value: _content,
              onChange: setContent,
              className: 'hotspot-editor-input',
            })
          ),

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
  /*-----------------------------------------------------------------------*/
  // 注册AI智能搜索
  registerPlugin('hotspot-ai-toolbar', {
    render: function () {
      var [isOpen, setIsOpen] = wp.element.useState(false)
      var [_Query, setQuery] = wp.element.useState('')
      var [isLoading, setIsLoading] = wp.element.useState(false)
      var [error, setError] = wp.element.useState(null) // 添加 error 状态

      function onButtonClick() {
        if (typeof gutenberg_optimize.search_images_url === 'undefined') {
          alert('未开启智能搜图功能！')
          return
        }

        const selectedBlock = wp.data
          .select('core/block-editor')
          .getSelectedBlock()
        const blockText = selectedBlock.attributes.content
        _Query = blockText
        setIsOpen(true)

        search_images()
      }

      function closeModal() {
        setIsOpen(false)
      }

      function search_images() {
        setIsLoading(true)
        setError(null) // 在每次请求前重置 error 状态

        fetch(gutenberg_optimize.search_images_url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': gutenberg_optimize.hotspot_nonce,
          },
          body: JSON.stringify({
            query: _Query,
          }),
        })
          .then(function (response) {
            if (!response.ok) {
              return response.json().then(function (data) {
                throw new Error(
                  data && data.message
                    ? data.message
                    : '无法获取到数据，请检查登录信息是否正常。如果搜索其他图片也出现此错误，请联系开发者Q群：689155556'
                )
              })
            } else {
              return response.json() // 将响应体内容读取并保存为 JSON 格式的对象
            }
          })
          .then(function (data) {
            setIsLoading(false)

            if (!data.data || data.data.length === 0) {
              setError('未找到符合条件的图片') // 如果 data.data 不存在或为空，则设置 error 状态
            } else {
              var images = data.data.map(function (image) {
                // 添加点击事件处理函数
                function onClickOverlay() {
                  if (confirm('是否要插入该图片到文章中？')) {
                    const { createBlock } = wp.blocks
                    const selectedBlock = wp.data
                      .select('core/block-editor')
                      .getSelectedBlock()
                    const newImageBlock = createBlock('core/image', {
                      url: image.img_url,
                      caption: `来源 <a href = "http://${image.profile}" target = "_blank">${image.Photographer}</a>`,
                      alt: image.Photographer,
                      align: 'center',
                      href: image.img_url,
                      linkTarget: '_blalnk',
                    })
                    const oldBlockClientId = selectedBlock.clientId

                    // Replace the target block with the new image block
                    wp.data
                      .dispatch('core/block-editor')
                      .replaceBlock(oldBlockClientId, newImageBlock)
                  }
                }

                return el(
                  'li',
                  null,
                  el(
                    'div',
                    {
                      className: 'image-container',
                    },
                    el('img', {
                      src: image.img_url,
                      alt: image.Photographer,
                    })
                  ),
                  el(
                    'div',
                    { className: 'overlay', onClick: onClickOverlay },
                    el('p', null, image.Photographer)
                  )
                )
              })

              window.requestAnimationFrame(function () {
                ReactDOM.render(
                  el('ul', null, images),
                  document.querySelector('.image-results')
                )
              })
            }
          })
          .catch(function (error) {
            setIsLoading(false)
            setError(error.message) // 在请求失败时设置 error 状态
          })
      }

      return el(
        wp.element.Fragment,
        null,
        el(ToolbarButton, {
          icon: 'search',
          title: 'AI 智能搜图',
          onClick: onButtonClick,
        }),

        isOpen &&
          el(
            Modal,
            {
              onRequestClose: closeModal,
              title: 'AI 智能搜图',
              isOpen: isOpen,
              shouldCloseOnOverlayClick: true,
              onClose: closeModal,
            },
            isLoading
              ? el('p', { className: 'loading-text' }, 'Loading...')
              : error
              ? el('p', { className: 'error-text' }, error) // 如果存在 error，则展示错误信息
              : el('div', { className: 'image-results' })
          )
      )
    },
  })
})(window.wp)
