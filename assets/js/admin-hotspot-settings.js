;(function ($) {
  $('#docs').on('click', function () {
    window.open('https://docs.eswlnk.com')
  })

  $('#check_credit').on('click', function () {
    var timestamp = new Date().getTime()

    swal({
      title: '提示',
      text: '您确定要验证API秘钥吗？',
      icon: 'warning',
      buttons: ['取消', '确定'],
      dangerMode: true,
    }).then((sbumit_true) => {
      $('#check_credit').text('正在验证中')
      if (sbumit_true) {
        $.ajax({
          method: 'POST',
          url: check_credit.url,
          data: {
            key: $('#openai_key')[0].value,
          },
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', check_credit.wp_nonce)
          },
          success: function (data) {
            if (data.error) {
              swal({
                title: '出错',
                dangerMode: true,
                icon: 'warning',
                text: data.msg,
                button: '了解',
              })
              $('#check_credit').text('验证秘钥')
              return
            }
            swal({
              title: '查询结果',
              icon: 'success',
              text: `到期时间:${data.expires_at}\n总额度:${data.grant_amount} 刀\n可用余额:${data.total_available} 刀\n已使用:${data.used_amount} 刀`,
              button: '了解',
            })
            $('#check_credit').text('验证秘钥')
            return
          },
          error: function (data) {
            swal({
              title: '出错',
              dangerMode: true,
              icon: 'warning',
              text: data.msg,
              button: '了解',
            })
            $('#check_credit').text('验证秘钥')
            return
          },
        })
      } else {
        $('#check_credit').text('验证秘钥')
      }
    })
  })

  $('#check_delay').on('click', function (e) {
    e.preventDefault()
    swal({
      title: '提示',
      text: '确认是否需要检测延迟，这将会消耗一点时间',
      icon: 'warning',
      buttons: ['取消', '确定'],
      dangerMode: true,
    }).then((sbumit_true) => {
      $('#check_delay').text('正在检测...请耐心等待')
      if (sbumit_true) {
        $.ajax({
          method: 'GET',
          url: check_delay.url,
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', check_delay.wp_nonce)
          },
          success: function (data) {
            if (data.error) {
              swal({
                title: '失败',
                icon: 'warning',
                text: `${data.msg}`,
              })
              $('#check_delay').text('检测延迟')
              return
            }

            swal({
              title: '检测成功',
              icon: 'success',
              text: `当前线路:${data.server}\n延迟:${data.delay}`,
              button: '确定',
            })
            $('#check_delay').text('检测延迟')
            return
          },
          error: function (data) {
            swal({
              title: '失败',
              icon: 'warning',
              text: `${data.msg}`,
              button: '确定',
            })
            $('#check_delay').text('检测延迟')
            return
          },
        })
      } else {
        $('#check_delay').text('检测延迟')
      }
    })
  })

  $('#submit').on('click', function (e) {
    e.preventDefault() // 阻止提交表单的默认行为

    var postData = $('#hotpot-settings').serialize()

    var form = $('#hotpot-settings')[0].elements

    swal({
      title: '提示',
      text: '请再次检查必填选项是否填写!',
      icon: 'warning',
      buttons: ['再次检查', '保存'],
      dangerMode: true,
    }).then((sbumit_true) => {
      // 判断相关元素是否完整

      if (
        (form['ai_select'].selectedOptions[0].value === 'Open_AI_Domestic' ||
          form['ai_select'].selectedOptions[0].value === 'Open_AI_Custom') &&
        form['openai_key'].value === ''
      ) {
        swal('您未填写相关的Key', {
          icon: 'error',
        })
        return
      }

      if (
        form['ai_select'].selectedOptions[0].value === 'Open_AI_Custom' &&
        (form['openai_key'].value === '' || form['custom_proxy'].value === '')
      ) {
        swal('您未正确填写自定义代理或API秘钥', {
          icon: 'error',
        })
        return
      }

      if (sbumit_true) {
        $.ajax({
          url: 'options.php',
          method: 'POST',
          data: postData,
          success: function (data) {
            swal('保存成功！', {
              icon: 'success',
            })
          },
          error: function (data) {
            swal('保存失败，请检查服务器是否开启防火墙', {
              icon: 'error',
            })
          },
        })
      } else {
        swal('您并未选择保存配置', {
          icon: 'error',
        })
      }
    })

    return
  })

  $('#open_qq_group').on('click', function () {
    window.open(
      'https://qm.qq.com/cgi-bin/qm/qr?k=PGSoVERGbzotMDJAqTOsDXU82edfEgDh&jump_from=webapi&authKey=8wxrbef+Kpx2HFHvlXHQKK8c0/H+oN0NRRQ/3KO0isQTjv3Z9rWTtSACk/PC2E0A'
    )
  })

  // 定义全局变量
  var signin_window = null

  // 注册点击事件监听器
  $('#hotspot-signin').on('click', function () {
    $(this).text('正在登录，请稍等...')

    let url = '/wp-admin/admin.php?page=hotspot-signin'
    // 新窗口的大小和位置
    let width = 430
    let height = 690
    let left = (window.innerWidth - width) / 2
    let top = (window.innerHeight - height) / 2

    // 如果 signin_window 不为 null，则检查其是否已经被关闭或刷新
    if (signin_window && signin_window.closed) {
      signin_window = null
    }

    // 如果 signin_window 为 null，或者已经被关闭或刷新，则打开一个新窗口
    if (!signin_window) {
      signin_window = window.open(
        url,
        'signin_window',
        'width=' +
          width +
          ', height=' +
          height +
          ', left=' +
          left +
          ', top=' +
          top
      )

      // 在新窗口中注册 load 事件监听器
      signin_window.addEventListener('DOMContentLoaded', function () {
        // 在新窗口中删除目标元素...
        let wpadminbar = signin_window.document.getElementById('wpadminbar')
        let adminmenuback =
          signin_window.document.getElementById('adminmenuback')
        let adminmenuwrap =
          signin_window.document.getElementById('adminmenuwrap')
        if (wpadminbar) wpadminbar.parentNode.removeChild(wpadminbar)
        if (adminmenuback) adminmenuback.parentNode.removeChild(adminmenuback)
        if (adminmenuwrap) adminmenuwrap.parentNode.removeChild(adminmenuwrap)

        let targetElement = signin_window.document.getElementsByClassName(
          'login-card login-dark'
        )[0]
        let targetOffset = targetElement.getBoundingClientRect().top

        // 滚动到目标位置...
        signin_window.scrollTo({
          top: targetOffset,
          behavior: 'smooth',
        })
      })
    }

    // 如果 signin_window 不为 null，并且尚未被关闭或刷新，则不执行任何操作
  })

  function receiveMessage(event) {
    if (event.origin !== location.origin) {
      // 这里需要根据实际情况修改域名地址
      return // 忽略来自其他域名的消息
    }

    if (event.data === 'refresh') {
      $('#hotspot-signin').text('登录成功！')

      // 延迟两秒后刷新页面...
      setTimeout(function () {
        location.reload()
      }, 2000) // 时间单位为毫秒
    }
  }

  // 注册 message 事件监听器
  window.addEventListener('message', receiveMessage)
})(jQuery)
