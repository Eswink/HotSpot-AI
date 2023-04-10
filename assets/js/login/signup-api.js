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
  var signupForm = $('#signup_form')
  var feedback = $('#feedback')
  var signupButton = $('#signup')

  signupForm.validate({
    rules: {
      password: {
        required: true,
      },
      confirm_password:{
        required:true,
        equalTo: "#password"
      },
      email: {
        required: true,
        email: true,
      },
      username:{
        required:true
      }


    },
    messages: {
      password: {
        required: '请输入密码!',
      },
      confirm_password:{
        required: "请再次输入密码",
        equalTo: "两次输入的密码不一致"
      },
      email: {
        required: '请填写邮箱!',
        email: '请输入正确的邮箱格式',
      },
      username:{
        required:"请输入用户名"
      }
    },
    errorClass: 'signup-error',
  })

  // 绑定点击事件
  signupButton.on('click', function (event) {
    // 阻止表单的默认提交行为
    event.preventDefault()

    if (h_token) {
      if (signupForm.valid()) {
        var formData = signupForm.serialize()
        signup(formData)
      }
    } else {
      feedback.css('display', 'block')
      feedback.removeClass('valid-feedback')
      feedback.addClass('invalid-feedback')
      feedback.text('请先通过验证,正在加载验证码...')
      hcaptcha.execute() // 否则，执行 hcaptcha 验证
    }
  })

  function signup(data) {
    switch_signup_state()
    $.ajax({
      method: 'POST',
      url: access_token.hotspot_signup,
      data: data,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', access_token.wp_nonce)
      },
      success: function (data) {
        if (data.success) {
          swal({
            title: '注册成功',
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
            title: '注册失败',
            icon: 'error',
            text: '鉴权未成功',
            button: '确定',
          })
          reload_token()
          switch_signup_state()
        }

      },
      error: function (data) {
        swal({
          title: '注册失败',
          icon: 'error',
          text: data.responseJSON.message,
          button: '确定',
        })
        reload_token()
        switch_signup_state()
      },
    })
  }

  function reload_token() {
    h_token = undefined
    hcaptcha.reset()
  }

  function switch_signup_state(text) {
    if (text) {
      signupButton.text(text)
      return
    }
    if (signupButton.text() === '注册') {
      signupButton.text('注册中')
    } else {
      signupButton.text('注册')
    }

    signupButton.prop('disabled', function (i, val) {
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
