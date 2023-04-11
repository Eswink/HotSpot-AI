var h_token

function validate_token(token) {
  var feedback = document.querySelector('#feedback')
  if (token) {
    //验证成功'
    h_token = token
    feedback.classList.remove('invalid-feedback')
    feedback.classList.add('valid-feedback')
    feedback.style.display = 'block'
    feedback.textContent = '验证成功！'
  } else {
    feedback.classList.add('invalid-feedback')
    feedback.classList.remove('valid-feedback')
    feedback.style.display = 'block'
    feedback.textContent = '验证失败，请重试！'
  }
}

;(function ($) {
  var signinForm = $('#signin_form')
  var feedback = $('#feedback')
  var signinButton = $('#signin')

  signinForm.validate({
    rules: {
      password: {
        required: true,
        minlength:8
      },
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      password: {
        required: '请填写密码!',
        minlength: '密码必须至少包含 8 个字符！'
      },
      email: {
        required: '请填写邮箱!',
        email: '请输入正确的邮箱格式',
      },
    },
    errorClass: 'signin-error',
  })

  // 绑定点击事件
  signinButton.on('click', function (event) {
    // 阻止表单的默认提交行为
    event.preventDefault()

    if (h_token) {
      if (signinForm.valid()) {
        var formData = signinForm.serialize()
        signin(formData)
      }
    } else {
      feedback.css('display', 'block')
      feedback.removeClass('valid-feedback')
      feedback.addClass('invalid-feedback')
      feedback.text('请先通过验证,正在加载验证码...')
      hcaptcha.execute() // 否则，执行 hcaptcha 验证
    }
  })

  function signin(data) {
    switch_signin_state()
    $.ajax({
      method: 'POST',
      url: access_token.hotspot_signin,
      data: data,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', access_token.wp_nonce)
      },
      success: function (data) {
        if (data.success) {
          swal({
            title: '登录成功',
            icon: 'success',
            text: '点击确定，自动跳转',
            button: '确定',
          }).then((sbumit_true)=>{
            if(sbumit_true){
              close_window()
            }
          })
          
        } else {
          swal({
            title: '登录失败',
            icon: 'error',
            text: '邮箱地址与密码不匹配',
            button: '确定',
          })
          reload_token()
          switch_signin_state()
        }

      },
      error: function (data) {
        swal({
          title: '登录失败',
          icon: 'error',
          text: data.responseJSON.message,
          button: '确定',
        })
        reload_token()
        switch_signin_state()
      },
    })
  }

  function reload_token() {
    h_token = undefined
    hcaptcha.reset()
  }

  function switch_signin_state(text) {
    if (text) {
      signinButton.text(text)
      return
    }
    if (signinButton.text() === '登录') {
      signinButton.text('登录中')
    } else {
      signinButton.text('登录')
    }

    signinButton.prop('disabled', function (i, val) {
      return !val
    })
  }

  function close_window() {
    var targetWindow = window.opener || window.parent; // 获取 A 窗口对象
    var message = 'refresh'
    
    
    let countDownTime = 0.5 * 1000

    // 倒计时结束后关闭网页
    setTimeout(function () {
      targetWindow.postMessage(message, location.origin); // 发送信息到 A 窗口
      window.close()
    }, countDownTime)
  }
})(jQuery)
