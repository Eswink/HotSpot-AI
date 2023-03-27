;(function ($) {
  $('#docs').on('click', function () {
    window.open('https://docs.eswlnk.com')
  })

  $('#check_credit').on('click', function () {
    var timestamp = new Date().getTime();

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
          url: check_credit.url ,
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
      }else{
        $('#check_credit').text('验证秘钥')
      }
    })
  })


  $('#check_delay').on('click',function(e){
    e.preventDefault()
    swal({
      title: '提示',
      text: '确认是否需要检测延迟，这将会消耗一点时间',
      icon: 'warning',
      buttons: ['取消', '确定'],
      dangerMode: true,
    }).then((sbumit_true)=>{
      $('#check_delay').text("正在检测...请耐心等待")
      if(sbumit_true){

        $.ajax({
          method: 'GET',
          url: check_delay.url ,
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', check_delay.wp_nonce)
          },
          success:function(data){

            if(data.error){
              swal({
                title:"失败",
                icon:"warning",
                text:`${data.msg}`
              })
              $('#check_delay').text("检测延迟")
              return 
            }




            swal({
              title:"检测成功",
              icon:"success",
              text:`当前线路:${data.server}\n延迟:${data.delay}`,
              button:"确定"
            })
            $('#check_delay').text("检测延迟")
            return 
          },
          error:function(data){
            swal({
              title:"失败",
              icon:"warning",
              text:`${data.msg}`,
              button:"确定"
            })
            $('#check_delay').text("检测延迟")
            return 
          }
        })

      }else{
        $('#check_delay').text("检测延迟")
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
        form['hotspot-switch'].checked == true &&
        form['baijiahao_hotspot_cookies'].textLength == 0
      ) {
        swal('您启用了百家号热点，但是未填写相关cookies', {
          icon: 'error',
        })
        return
      }

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

      if(form['ai_select'].selectedOptions[0].value === 'Open_AI_Custom' && (form['openai_key'].value === '' || form['custom_proxy'].value === '')){
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
})(jQuery)
