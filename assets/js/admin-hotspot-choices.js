;(function ($) {
  // 进入页面后 自动加载

  // 获取div

  // 定义全局变量

  let page_no_common = 1
  let page_no_hot = 1
  let default_page_size = 12

  let common_loaded = false,
    hot_loaded = false,
    common_se_pv = 1,
    hot_se_pv = 2
  common_id = 'common-words'
  hot_id = 'hotwords'

  access_baidu_hotspot(
    page_no_hot,
    default_page_size,
    hot_se_pv,
    hot_id
  )

  // 绑定tab [普通词] 事件
  $('#hotwords-tab').on('click', function () {
    if (!hot_loaded) {
      access_baidu_hotspot(page_no_hot, default_page_size, hot_se_pv, hot_id)
      hot_loaded = true
    }
  })

  $('#common-words').on(
    'click',
    '#bottom_pagination_common a',
    function (event) {
      event.preventDefault()
      var pageNumber = $(this).data('page')

      access_baidu_hotspot(
        pageNumber,
        default_page_size,
        common_se_pv,
        common_id
      )
      set_page(page_no_common, pageNumber)
    }
  )

  $('#hotwords').on('click', '#bottom_pagination_hot a', function (event) {
    event.preventDefault()
    var pageNumber = $(this).data('page')
    access_baidu_hotspot(pageNumber, default_page_size, hot_se_pv, hot_id)
    set_page(page_no_hot, pageNumber)
  })

  $('#common-words').on('click', 'button', function (event) {
    event.preventDefault()
    var title = $(this).data('title')
    accsee_post_url(title, common_se_pv)
  })

  $('#hotwords').on('click', 'button', function (event) {
    event.preventDefault()
    var title = $(this).data('title')
    accsee_post_url(title, hot_se_pv)
  })

  function accsee_post_url(title, se_pv) {
    swal({
      title: '提示',
      text: '是否确认创作？',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((post_true) => {
      if (post_true) {
        //确认
        $.ajax({
          url: access_choices.create_post,
          nonce: access_choices.wp_nonce,
          type: 'POST',
          data: {
            title: title,
            se_pv: se_pv,
          },
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', access_choices.wp_nonce)
          },
          success: function (data) {
            window.location.href = data.editLink
          },
        })
      }
    })
  }

  function set_page(page_name, value) {
    page_name = value
  }

  function clear_div(div_id) {
    $('#' + div_id + ' .row').empty()
  }

  function insert_pagination(div_id, page_total, page_show, page_no, se_pv) {
    var content = `<div class="card-body">
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center ${
        se_pv == 1
          ? 'pagin-border-primary pagination-primary'
          : 'pagin-border-secondary pagination-secondary'
      }" id="${
      se_pv == 1 ? 'bottom_pagination_common' : 'bottom_pagination_hot'
    }">
        <li class="page-item"><a class="page-link" href="javascript:void(0)" aria-label="Previous" data-page=${
          page_no - 1
        } ><span aria-hidden="true">«</span></a></li>
        ${calculate_page(page_total, page_no, page_show, se_pv)}
        <li class="page-item"><a class="page-link" href="javascript:void(0)" aria-label="Next" data-page=${
          page_no + 1
        } ><span aria-hidden="true">»</span></a></li>
      </ul>
    </nav>
  </div>`
    var all_divs = $('#' + div_id + ' .row')[0]
    var div_content = $(content)
    div_content.appendTo(all_divs)
  }

  function calculate_page(page_end, page_no, page_show) {
    // 确定要显示的总页数
    var total_pages = Math.min(page_show, page_end)

    // 确定在页面上显示的第一页的页码
    var first_page = Math.max(1, page_no - Math.floor(total_pages / 2))

    // 为了避免最后一页超出范围，重新计算要显示的总页数
    total_pages = Math.min(total_pages, page_end - first_page + 1)

    // 填充要显示的页码列表
    var pages = []
    for (var i = 0; i < total_pages; i++) {
      pages.push(first_page + i)
    }

    var content = ''

    if (pages[0] > 3) {
      content +=
        '<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>'
    }

    for (i of pages) {
      content += `<li class="page-item ${
        i == page_no ? 'active' : ''
      }"><a class="page-link" href="javascript:void(0)" data-page=${i} >${i}</a></li>`
    }
    content += `<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page=${page_no}>...</a></li>`

    content += `<li class="page-item"><a class="page-link" href="javascript:void(0)"data-page=${page_end} >${page_end}</a></li>`

    return content
  }

  function combine_content(se_pv, title, date) {
    var add_content = `<div class="col-xxl-3 col-md-6">
    <div class="project-box"><span class="badge ${
      se_pv == 1 ? 'badge-primary' : 'badge-secondary'
    } ">${pv_convert(1, se_pv)}</span>
      <h6>${title}</h6>
      <p></p>
      <div class="row details">
        <div class="col-6"><span>发布日期</span></div>
        <div class="col-6 text-primary">${formatDate(date)}</div>
        <div class="col-6"> <span>搜索频率</span></div>
        <div class="col-6 text-primary">${pv_convert(2, se_pv)}</div>
      </div>

      <div class="project-status mt-4">
      <button class="btn ${
        se_pv == 1 ? 'btn-primary-gradien' : 'btn-secondary-gradien'
      }" data-title=${title}><span>创作</span></button>
      </div>
    </div>
  </div>`
    return $(add_content)
  }

  /*******
   * @name: access_baidu_hotspot
   * @param {*} page_no
   * @param {*} page_size
   * @param {*} se_pv
   * @param {*} div_id
   * @param {function} success
   * @return {*}
   * @description: 获取百度热点
   */

  function access_baidu_hotspot(page_no, page_size, se_pv, div_id) {
    clear_div(div_id)
    $.ajax({
      method: 'POST',
      url: access_choices.baidu_hotspot,
      nonce: access_choices.wp_nonce,
      data: {
        page_no: page_no,
        page_size: page_size,
        se_pv: se_pv,
      },
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', access_choices.wp_nonce)
      },
      success: function (data) {
        //解析 插入 card

        if (data.error) {
          swal({
            title: '提示',
            text: data.msg,
            icon: 'error',
            buttons:['放弃','重新加载'],
            dangerMode: true,
          }).then((loading_again) => {
            if(loading_again){
              access_baidu_hotspot(page_no, page_size, se_pv, div_id)
            }
            
          })
        }

        for (item of data.data) {
          var all_divs = $('#' + div_id + ' .row')[0]
          var div_content = combine_content(
            item.se_pv,
            item.headline,
            item.updated_at
          )
          div_content.appendTo(all_divs)
        }
        insert_pagination(div_id, data.total_pages, 5, page_no, se_pv)
        if (se_pv == 1) {
          page_no_common++
        }
        if (se_pv == 2) {
          page_no_hot++
        }
      },
      error: function (data) {
        swal({
          title: '提示',
          text: '出现了问题',
          icon: 'error',
          buttons:['放弃','重新加载'],
          dangerMode: true,
        }).then((loading_again) => {
          if(loading_again){
            access_baidu_hotspot(page_no, page_size, se_pv, div_id)
          }
        })
      },
    })
  }

  /*******
   * @name: formatDate
   * @param {*} timestamp
   * @return {*}
   * @description: 格式化日期
   */
  function formatDate(timestamp) {
    var date = new Date(timestamp * 1000) // 将时间戳乘以1000，以便在创建Date对象时正确解析为日期时间

    var year = date.getFullYear()
    var month = ('0' + (date.getMonth() + 1)).slice(-2) // getMonth()方法返回0~11之间的数字，需要加1并补零
    var day = ('0' + date.getDate()).slice(-2) // getDate()方法返回1~31之间的数字，需要补零

    return year + '-' + month + '-' + day
  }

  function pv_convert(mode, pv) {
    if (mode == 1) {
      if (pv == 1) {
        return '普通词'
      }
      if (pv == 2) {
        return '热词'
      }
      return '普通词'
    } else if (mode == 2) {
      if (pv == 1) return '低'
      if (pv == 2) {
        return '高'
      }
      return '低'
    }
  }
})(jQuery)
