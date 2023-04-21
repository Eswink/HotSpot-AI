jQuery(document).ready(function ($) {

  var gutenbergEditor = document.querySelector('.block-editor__container')


  
  if (typeof tinyMCE !== 'undefined' && !gutenbergEditor) {
    // 使用了经典编辑器并且未启用古腾堡
    if (classic_switch.checked === '' ) {
      alert('未开启经典编辑器支持，请在设置界面中开启')
      return
    }
  }

  
  if (gutenbergEditor) {
    if (classic_switch.checked === 'on') {
      alert(
        '启用了经典编辑器的同时开启了古腾堡编辑器，请在设置界面中关闭对经典编辑器的支持！'
      )
      return
    }
  }
})
