<!-- // 定义设置界面 -->


  <!-- loader starts-->
  <div class="loader-wrapper">
    <div class="loader-index"> <span></span></div>
    <svg>
      <defs></defs>
      <filter id="goo">
        <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
      </filter>
    </svg>
  </div>
  <!-- loader ends-->
  <!-- tap on top starts-->
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->
  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
      <div class="header-wrapper row m-0">


        <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
          <div class="notification-slider">
            <div class="d-flex h-100"> <img src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/giftools.gif" alt="gif">
              <h6 class="mb-0 f-w-400"><span class="font-primary">不要错过! </span><span
                  class="f-light">&nbsp;&nbsp;它带着全新的UI界面来了!</span></h6>
            </div>
            <div class="d-flex h-100"><img src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/giftools.gif" alt="gif">
              <h6 class="mb-0 f-w-400"><span class="f-light">HotSopt AI 正在内测中! 立即</span></h6><a class="ms-1" href="#"
                target="_blank"> 体验新功能!</a>
            </div>
          </div>
        </div>
        <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
          <ul class="nav-menus">
          <li class="mobile-title"><span>Light / Dark</span></li>
            <li>
              <div class="mode">
                <svg>
                  <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#moon"></use>
                </svg>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <!-- Page Sidebar Start-->

      <!-- Page Sidebar Ends-->
      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-12">
                <div class="card force-card">
                <div class="card-header">
                    <h4><?php esc_html_e('Greetings') ?></h4>
                    <span><?php esc_html_e('请认真填写以下内容哦，不会配置的话点击右侧按钮查阅') ?><button class="btn btn-secondary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien" id="docs"><?php esc_html_e('文档') ?></button></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->

        <!-- 设置选项 -->


        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12 col-xl-12">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card" style="max-width: 100%!important;">
                    <!-- 头 -->
                    <div class="card-header">
                      <h5><?php esc_html_e('设置') ?></h5><span><?php esc_html_e('请完善插件信息，避免使用时出现错误') ?></span>
                    </div>
                    <!-- 头 -->


                    <!-- 表单开始 -->
                    <div class="card-body">
                      <form class="theme-form submit" method="POST" id="hotpot-settings">
                      <?php settings_fields('hotspot_settings_group'); ?>
                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="inputEmail3">热点筛选 - 开关</label>
                          <div class="col-sm-9 icon-state" style="display:flex;align-items: center;">
                            <label class="switch" style="margin-bottom:0">
                              <input class="form-control" type="checkbox" name="hotspot-switch" id="hotspot-switch" <?php checked(get_option('hotspot-switch'), 'on') ?> name="hospot-switch"><span class="switch-state"></span>
                            </label>
                            <span style="padding-left:10px;font-size:10px">若需要此功能，请开启本选项</span>
                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="inputEmail3">百家号热点</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" id="baijiahao_hotspot_cookies" name="baijiahao_hotspot_cookies"
                              placeholder="请先获取Cookies后在此填写" required="true" style="height:150px"><?php esc_html_e(get_option('baijiahao_hotspot_cookies')) ?></textarea>
                            <div class="invalid-feedback">请填写正确的Cookies</div>
                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="inputPassword3">AI选择</label>
                          <div class="col-sm-9">
                            <select class="js-example-basic-single col-sm-12" name="ai_select">
                              <optgroup label="OpenAI">
                                <option value="Open_AI_Offical" <?php selected('Open_AI_Offical', get_option('ai_select')) ?> disabled>官方接口(勿选)</option>
                                <option value="Open_AI_Free" <?php selected('Open_AI_Free', get_option('ai_select')) ?>>免费接口(有几率被限制构思)</option>
                                <option value="Open_AI_Domestic" <?php selected('Open_AI_Domestic', get_option('ai_select')) ?>>国内代理</option>
                                <option value="Open_AI_Custom" <?php selected('Open_AI_Custom', get_option('ai_select')) ?>>自定义代理</option>
                              </optgroup>
                              <optgroup label="文心一言">
                                <option value="ERNIE_Bot_Offical" disabled>官方接口</option>
                                <option value="ERNIE_Bot_Domestic" disabled>国内代理</option>
                              </optgroup>
                              <optgroup label="其他">
                                <option value="Friday_AI_Offical" disabled>Friday AI</option>
                                <option value="Friday_AI_Domestic" disabled>国内代理</option>
                              </optgroup>
                            </select>
                            <span class="valid-feedback"  style="display:block">保存配置后，点击右侧按钮即可检测API延迟！<button class="btn btn-primary-gradien btn-xs" id="check_delay" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien">检测延迟</button></span>
                          </div>
                        </div>

                        <!-- 自定义代理 -->
                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="custom_proxy">自定义代理</label>
                          <div class="col-sm-9">
                            <input class="form-control" id="custom_proxy" type="text"
                              placeholder="请填写正确的API地址(未实装)" name="custom_proxy" value="<?php esc_html_e(get_option('custom_proxy')) ?>">
                            <div class="valid-feedback" style="display:block">
                              <span>如果你有更好的代理地址，可以在这里填写，务必在上方选择<strong>「自定义代理」</strong></span>
                            </div>

                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="openai_key">API秘钥</label>
                          <div class="col-sm-9">
                            <input class="form-control" id="openai_key" type="text"
                              placeholder="请填写正确的API密钥" name="openai_key" value="<?php esc_html_e(get_option('openai_key')) ?>">
                            <div class="valid-feedback" style="display:block">
                              <span>您可以访问<a href="#">OpenAI 网站</a>获取密钥</span>
                              <button class="btn btn-primary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien" id="check_credit">验证秘钥</button>
                            </div>

                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="schedule-tasks">计划任务 - 开关</label>
                          <div class="col-sm-9  icon-state" style="display:flex;align-items: center;">
                            <label class="switch" style="margin-bottom:0">
                              <input class="form-control" type="checkbox" disabled name="schedule-tasks"><span class="switch-state"></span>
                            </label>
                            <span style="padding-left:10px;font-size:10px">选项默认关闭 暂无该功能</span>
                          </div>
                        </div>


                      </form>

                    </div>

                    <!-- 表单结束 -->



                    <div class="card-footer">
                      <button class="btn btn-primary-gradien btn-lg" id="submit">保存</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 footer-copyright text-center">
              <p class="mb-0">Copyright 2023 © theme by Eswlnk </p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>