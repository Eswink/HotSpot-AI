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

  function set_email_verify() {
    signupForm.validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
      },
      messages: {
        email: '请输入有效的邮箱地址',
      },
      errorPlacement: function (error, element) {
        error.insertAfter(element)
      },
      errorClass: 'signup-error',
    })
  }

  signupForm.validate({
    rules: {
      password: {
        required: true,
        minlength:8
      },
      confirm_password: {
        required: true,
        equalTo: '#password',
      },
      email: {
        required: true,
        email: true,
      },
      username: {
        required: true,
        minlength:6
      },
      code: {
        required: true,
      },
    },
    messages: {
      password: {
        required: '请输入密码!',
        minlength: '密码必须至少包含 8 个字符！'
      },
      confirm_password: {
        required: '请再次输入密码',
        equalTo: '两次输入的密码不一致',
      },
      email: {
        required: '请填写邮箱!',
        email: '请输入正确的邮箱格式',
      },
      username: {
        required: '请输入用户名',
        minlength: '用户名必须至少包含 6 个字符！'
      },
      code: {
        required: '请填入验证码',
      },
    },
    errorClass: 'signup-error',
  })

  // 绑定点击事件
  signupButton.on('click', function (event) {
    // 阻止表单的默认提交行为
    event.preventDefault()

    if (h_token) {
      if (signupForm.valid()) {
        if($('#checkbox1').prop('checked')){
          var formData = signupForm.serialize()
          signup(formData)
        }else{
          swal.fire({
            title:"请同意注册协议！",
            icon:"error",
          })
        }

      }
    } else {
      feedback.css('display', 'block')
      feedback.removeClass('valid-feedback')
      feedback.addClass('invalid-feedback')
      feedback.text('请先通过验证,正在加载验证码...')
      hcaptcha.execute() // 否则，执行 hcaptcha 验证
    }
  })

  $('#send_email').on('click', function (event) {
    event.preventDefault()

    const email = $('input[name="email"]').val()

    if (!email) {
      swal.fire({
        text: '未填写邮箱！',
        icon: 'error',
        title: '提示',
      })
      return
    }

    swal
      .fire({
        title: '请完成验证码',
        html: '<div id="hcaptcha-container-email"><div class="waiting-message">正在加载 hCaptcha 验证...</div></div>',
        showCancelButton: true,
        confirmButtonText: '提交',
        cancelButtonText: '取消',
      })
      .then((result) => {
        if (result.isConfirmed) {
          // 确认按钮被点击
          const hcaptcha = document.querySelector(
            '#hcaptcha-container-email > iframe'
          )

          if (!hcaptcha.dataset.hcaptchaResponse) {
            // hCaptcha 验证未完成，提示用户重新验证
            swal.fire({
              title: '未完成验证，请重试！',
              icon: 'error',
              html: '<div id="hcaptcha-container-email"><div class="waiting-message">请点击发送按钮重新进行 Captcha 验证。</div></div>',
            })
            return
          }

          // 获取 hcaptcha token 并发送邮件
          const token = hcaptcha.dataset.hcaptchaResponse
          $('#send_email').text("正在等待...")
          $('#send_email').prop('disabled', true)

          $.ajax({
            method: 'POST',
            url: access_token.hotspot_send,
            data: {
              email: email,
              token: token,
            },
            beforeSend: function (xhr) {
              xhr.setRequestHeader('X-WP-Nonce', access_token.wp_nonce)
            },
            success: function (data) {
              if (!data.success) {
                swal.fire({
                  title: '发送失败',
                  icon: 'error',
                  text: '如果多次出现，请联系开发者Q群：689155556',
                  button: '确定',
                })
                return
              }

              // 发送成功开始计时
              let countDown = 120
              const timer = setInterval(() => {
                countDown--
                if (countDown <= 0) {
                  clearInterval(timer)
                  $('#send_email').text('重新发送')
                  $('#send_email').prop('disabled', false)
                } else {
                  $('#send_email').text(countDown + '秒后重新发送')
                  $('#send_email').prop('disabled', true)
                }
              }, 1000)

              swal.fire({
                title: '发送成功',
                icon: 'success',
                text: data.message,
                button: '确定',
              })
            },
            error: function (data) {
              swal.fire({
                title: '发送失败',
                icon: 'error',
                text: data.responseJSON.message,
                button: '确定',
              })
            },
          })

          console.log('hcaptcha token: ', token)
        }
      })

    // 在hcaptcha容器中渲染hcaptcha验证码
    hcaptcha.render('hcaptcha-container-email', {
      sitekey: 'd78793af-cd0a-4e7c-8309-aee03edbdd69',
      // 添加 ready 事件监听器
    })
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
          swal
            .fire({
              title: '注册成功',
              icon: 'success',
              text: '点击确定，自动跳转',
              button: '确定',
            })
            .then((sbumit_true) => {
              if (sbumit_true) {
                close_window()
              }
            })
        } else {
          swal.fire({
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
        swal.fire({
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
    var targetWindow = window.opener || window.parent // 获取 A 窗口对象
    var message = 'refresh'

    let countDownTime = 0.5 * 1000

    // 倒计时结束后关闭网页
    setTimeout(function () {
      targetWindow.postMessage(message, location.origin) // 发送信息到 A 窗口
      window.close()
    }, countDownTime)
  }
})(jQuery)
