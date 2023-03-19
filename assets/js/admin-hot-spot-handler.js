/*
 * @Descripttion: js
 * @Version: 1.0
 * @Author: name
 * @Date: 2023-03-12 18:02:22
 * @LastEditors: name
 * @LastEditTime: 2023-03-13 03:28:31
 */
var se_pv


jQuery(document).ready(function ($) {
  //创建功能函数

  function renderPagination(currentPageNum, totalPages) {
    // 清空容器元素
    $('#pagination-container').html('')
  
    // 创建分页控件
    var pagination = $('<ul>')
    pagination.addClass('hotspot-pagination');
  
    if (currentPageNum == 1) {
      pagination.append($('<li>').addClass('disabled').append($('<span>').addClass('hotspot-page-btn hotspot-prev-btn hotspot-disabled-btn').html('<i class="fas fa-angle-left"></i>')));
    } else {
      pagination.append($('<li>').append($('<a>').attr('href', 'javascript:void(0)').addClass('hotspot-page-btn hotspot-prev-btn hotspot-disabled-btn').html('<i class="fas fa-angle-left"></i>')).on('click', function() {
        currentPageNum--;
        saveCurrentPageNumToCookie(currentPageNum);
        loadPosts(currentPageNum);
      }));
    }
  
    // 分页按钮
    var maxBtnsToShow = 4; // 最多显示的分页按钮数量（不包括“...”）
    var startPageNum = Math.max(currentPageNum - 3, 1); // 起始分页按钮数字
    var endPageNum = Math.min(startPageNum + maxBtnsToShow - 1, totalPages); // 结束分页按钮数字
  
    if (startPageNum > 1) {
      pagination.append($('<li>').append($('<a>').addClass('hotspot-page-btn').text(1)).on('click',function(){
        currentPageNum = parseInt($(this).text());
        saveCurrentPageNumToCookie(currentPageNum);
        loadPosts(currentPageNum);
      }));
      if (startPageNum > 2) {
        pagination.append($('<li>').append($('<span>').addClass('hotspot-page-btn hotspot-ellipsis').text('...')));
      }
    }
  
    for (var i = startPageNum; i <= endPageNum; i++) {
      var pageBtn = $('<a>').attr('href', 'javascript:void(0)').text(i).addClass('hotspot-page-btn');
      if (i == currentPageNum) {
        pageBtn.addClass('hotspot-active-btn');
      }
      pagination.append($('<li>').append(pageBtn).on('click', function() {
        currentPageNum = parseInt($(this).text());
        saveCurrentPageNumToCookie(currentPageNum);
        loadPosts(currentPageNum);
      }));
    }
  
    if (endPageNum < totalPages) {
      if (endPageNum < totalPages - 1) {
        pagination.append($('<li>').append($('<span>').addClass('hotspot-page-btn hotspot-ellipsis').text('...')));
      }
      pagination.append($('<li>').append($('<a>').addClass('hotspot-page-btn').text(totalPages)).on('click',function(){
        currentPageNum = parseInt($(this).text()) - 1;
        saveCurrentPageNumToCookie(currentPageNum);
        loadPosts(currentPageNum);
      }));
    }
  
    // 下一页按钮
    if (currentPageNum == totalPages) {
      pagination.append($('<li>').addClass('disabled').append($('<span>').addClass('hotspot-page-btn hotspot-next-btn hotspot-disabled-btn').html('<i class="fas fa-angle-right"></i>')));
    } else {
      pagination.append($('<li>').append($('<a>').attr('href', 'javascript:void(0)').addClass('hotspot-page-btn hotspot-next-btn hotspot-disabled-btn').html('<i class="fas fa-angle-right"></i>')).on('click', function() {
        currentPageNum++;
        saveCurrentPageNumToCookie(currentPageNum);
        loadPosts(currentPageNum);
      }));
    }
    
    // 将分页控件添加到容器元素中
    $('#pagination-container').append(pagination)
  }
  

  function formatDate(timestamp) {
    var date = new Date(timestamp * 1000) // 将时间戳乘以1000，以便在创建Date对象时正确解析为日期时间

    var year = date.getFullYear()
    var month = ('0' + (date.getMonth() + 1)).slice(-2) // getMonth()方法返回0~11之间的数字，需要加1并补零
    var day = ('0' + date.getDate()).slice(-2) // getDate()方法返回1~31之间的数字，需要补零

    return year + '-' + month + '-' + day
  }

  function pv_convert(pv) {
    if (pv == 1) {
      return '普通词'
    }
    if (pv == 2) {
      return '热词'
    }
    return '普通词'
  }

  function loadPosts(pageNum) {
    $('.hotspot-container').html(`    <div class="loader-container">
    <div class="loader"></div>
  <p class="loading-text">正在加载...</p>`)
    $('#pagination-container').html('')

    $.ajax({
      url: hotSpotObject.ajax_url,
      type: 'POST',
      data: {
        action: 'baidu_hot_pot',
        nonce: hotSpotObject.nonce,
        page_no: pageNum,
        page_size: 10,
        se_pv:se_pv
      },
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', hotSpotObject.nonce)
      },
      success: function (response) {

        if(response.error){
          $('.hotspot-container').html(`    <div class="loader-box"><div class="loader-container">
          <div class="loader"></div>
        <p class="loading-text">${response.msg}，点击重新加载</p></div>`)
          return
        }



        $('.hotspot-container').html('')
        var table = $('<table>').addClass('hotspot-table')
        var tbody = $('<tbody>').attr('id', 'hotspot-posts-table-body')
        table.append(tbody)

        for (var i = 0; i < response.data.length - 1; i += 2) {
          var item = response.data[i]
          var row = $('<tr>')

          // 左侧单元格
          var leftCell = $('<td>')
            .addClass('hotspot-cell')
            .html(
              `          <div class="cell-box">
              <div class="up-line">
                <div class="num-tag">
                  <div class="hotspot-ranking">${
                    (response.current_page -1) * response.page_size + i + 1
                  }</div>
                </div>
                <div class="hotspot-title">${item.headline}</div>
              </div>
              <div class="down-line">
                <div class="hotspot-date">${formatDate(item.updated_at)}</div>
                <div class="split-point-box"></div>
                <div class="hotspot-level">${pv_convert(item.se_pv)}</div>
              </div>
            </div>
            <div class="cell-box-right">
              <div class="task-publish">
              <a href="#" class="hotspot-create-post">创作</a>
              </div>
            </div>`
            )
          row.append(leftCell)

          // 右侧单元格
          if (i + 1 < response.data.length) {
            var rightCell = $('<td>')
              .addClass('hotspot-cell')
              .html(
                `          <div class="cell-box">
              <div class="up-line">
                <div class="num-tag">
                  <div class="hotspot-ranking">${
                    (response.current_page-1) * response.page_size + i + 2
                  }</div>
                </div>
                <div class="hotspot-title">${
                  response.data[i + 1].headline
                }</div>
              </div>
              <div class="down-line">
                <div class="hotspot-date">${formatDate(
                  response.data[i + 1].updated_at
                )}</div>
                <div class="split-point-box"></div>
                <div class="hotspot-level">${pv_convert(
                  response.data[i + 1].se_pv
                )}</div>
              </div>
            </div>
            <div class="cell-box-right">
              <div class="task-publish">
              <a href="#" class="hotspot-create-post">创作</a>
              </div>
            </div>`
              )
            row.append(rightCell)
          }

          tbody.append(row)
        }

        // 将table添加到页面中指定的div中
        $('.hotspot-container').append(table)
        renderPagination(response.current_page, response.total_pages)
      },
      error: function () {
        // 处理错误
      },
    })
  }

  // 保存当前页码到cookie中
  function saveCurrentPageNumToCookie(pageNum) {
    var expires = new Date()
    expires.setTime(expires.getTime() + 7 * 24 * 60 * 60 * 1000) // cookie有效期为7天

    document.cookie =
      'currentPageNum=' +
      pageNum +
      ';expires=' +
      expires.toUTCString() +
      ';path=/'
  }

  // 从cookie中获取当前页码
  function getCurrentPageNumFromCookie() {
    var name = 'currentPageNum='
    var ca = document.cookie.split(';')

    for (var i = 0; i < ca.length; i++) {
      var c = ca[i]
      while (c.charAt(0) == ' ') {
        c = c.substring(1)
      }
      if (c.indexOf(name) == 0) {
        return parseInt(c.substring(name.length, c.length))
      }
    }

    return 1 // 如果没有保存过当前页码，则返回默认值1
  }

  // currentPageNum = getCurrentPageNumFromCookie()
  currentPageNum = 1
  loadPosts(currentPageNum)


  $('.hotspot-container').on('click', '.loader-box', function() {
    currentPageNum = 1
    loadPosts(currentPageNum)
  });

  $('#hot-spot-selection').on('change', function () {
    // 选择框ID为"select_option"
    var ajaxUrl = hotSpotObject.ajaxurl
    var nonce = hotSpotObject.nonce // 获取nonce值
    se_pv = $(this).val() // 获取选中选项的值

    currentPageNum = 1
    saveCurrentPageNumToCookie(currentPageNum)
    loadPosts(currentPageNum)


  })




  //绑定点击事件

  var container = $('.hotspot-container')

  var createPostUrl = hotspot_vars.create_post_url

  // 绑定点击事件
  container.on('click', '.hotspot-create-post', function (event) {
    // 处理点击事件的回调函数
    event.preventDefault()

    // 获取需要的变量和信息
    var title = $(this).parent().parent().parent().find('.hotspot-title').text()
    console.log(title)
    if (confirm('你确定要进行创作吗?')) {

      $.ajax({
        url: createPostUrl,
        type: 'POST',
        data: {
          title: title,
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-WP-Nonce', hotSpotObject.nonce)
        },
        success:function(data){
          window.location.href = data.editLink
        }
      })
    }
  })
})
