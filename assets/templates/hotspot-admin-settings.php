<!-- // 定义设置界面 -->
<?php
$auth_token   = get_option('auth_signin_token');
$disable_attr = '';
if ($auth_token) {
    $seo_analysis_checked  = (get_option('seo-analysis') == 'on') ? 'checked' : '';
    $search_images_checked = (get_option('search-images') == 'on') ? 'checked' : '';
} else {
    $seo_analysis_checked  = '';
    $search_images_checked = '';
    $disable_attr          = 'disabled';
}
?>

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
                      <h5><?php esc_html_e('设置') ?></h5>
                      <span>
                        <?php esc_html_e('请完善插件信息，避免使用时出现错误。若有其他问题，请联系开发者或加入本插件交流群') ?>
                        <button class="btn btn-secondary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien" id="open_qq_group"><?php esc_html_e('QQ群：689155556') ?>
                        </button>
                      </span>
                    </div>
                    <!-- 头 -->


                    <!-- 表单开始 -->
                    <div class="card-body">
                      <form class="theme-form submit" method="POST" id="hotpot-settings">



                      <?php $rest_api_is_active = !is_rest_api_disabled(); ?>
                      <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">REST API 状态</label>
                          <div class="col-sm-9 icon-state" style="vertical-align: middle;align-items: center;display: flex;">
                            <button class="btn <?php esc_html_e($rest_api_is_active ? 'btn-primary-gradien' : 'btn-secondary-gradien'); ?>" type="button" title="" data-bs-original-title="btn <?php esc_html_e($rest_api_is_active ? 'btn-primary-gradien' : 'btn-secondary-gradien'); ?>" id="check-restapi"><?php esc_html_e($rest_api_is_active ? '配置正常' : '功能无法正常使用，请加群689155556'); ?></button>
                          </div>

                        </div>




                      <?php settings_fields('hotspot_settings_group'); ?>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">登录状态</label>
                          <div class="col-sm-9 icon-state" style="vertical-align: middle;align-items: center;display: flex;">
                            <button class="btn <?php esc_html_e(get_option('auth_signin_token') ? 'btn-primary-gradien' : 'btn-secondary-gradien'); ?>" type="button" title="" data-bs-original-title="btn <?php esc_html_e(get_option('auth_signin_token') ? 'btn-primary-gradien' : 'btn-secondary-gradien'); ?>" id="hotspot-signin"><?php esc_html_e(get_option('auth_signin_token') ? '已登录' : '未登录'); ?></button>
                            <span style="padding-left:10px;font-size:10px"><?php esc_html_e(get_option('auth_signin_token') ? '正在享受登录特权中！' : '无法使用热点筛选、智能搜图等高级功能，点击即可登录'); ?></span>
                            <input type="hidden" id="auth_signin_token" name="auth_signin_token" value="<?php esc_html_e(get_option('auth_signin_token')) ?>">
                          </div>

                        </div>



                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">热点筛选 - 开关</label>
                          <div class="col-sm-9 icon-state" style="display:flex;align-items: center;">
                            <label class="switch" style="margin-bottom:0">
                              <input class="form-control" type="checkbox" name="hotspot-switch" id="hotspot-switch" <?php checked(get_option('hotspot-switch'), 'on') ?> name="hospot-switch"><span class="switch-state"></span>
                            </label>
                            <span style="padding-left:10px;font-size:10px">若需要此功能，请开启本选项</span>
                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">热点状态</label>
                          <div class="col-sm-9">
                          <button class="btn <?php esc_html_e(get_option('auth_signin_token') ? 'btn-primary-gradien' : 'btn-secondary-gradien'); ?>" type="button" title="" data-bs-original-title="btn <?php esc_html_e(get_option('auth_signin_token') ? 'btn-primary-gradien' : 'btn-secondary-gradien'); ?>" id="hotspot-baijiahao-display"><?php esc_html_e(get_option('auth_signin_token') ? '正在享受百家号热点特权！' : '无法使用'); ?></button>
                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">AI选择</label>
                          <div class="col-sm-9">
                            <select class="js-example-basic-single col-sm-12" name="ai_select">
                              <optgroup label="OpenAI">
                                <option value="Open_AI_Offical" <?php selected('Open_AI_Offical', get_option('ai_select')) ?> disabled>官方接口(勿选)</option>
                                <option value="Open_AI_Free" <?php selected('Open_AI_Free', get_option('ai_select')) ?>>免费高速接口(登录用户专用，不用填写秘钥，无需自定义代理)</option>
                                <option value="Open_AI_Domestic" <?php selected('Open_AI_Domestic', get_option('ai_select')) ?>>国内代理</option>
                                <option value="Open_AI_Custom" <?php selected('Open_AI_Custom', get_option('ai_select')) ?>>自定义代理(能直接提供反向代理的API，非Socket代理)</option>
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
                              placeholder="请填写正确的API地址" name="custom_proxy" value="<?php esc_html_e(get_option('custom_proxy')) ?>">
                            <div class="valid-feedback" style="display:block">
                              <span>如果你有更好的代理地址，可以在这里填写，务必在上方选择<strong>「自定义代理」</strong>，若不会填写，可发issue或者加入Q交流群：689155556</span>
                            </div>

                          </div>
                        </div>


                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="openai_key">API秘钥</label>
                          <div class="col-sm-9">
                            <input class="form-control" id="openai_key" type="text"
                              placeholder="请填写正确的API密钥" name="openai_key" value="<?php esc_html_e(get_option('openai_key')) ?>">
                            <div class="valid-feedback" style="display:block">
                              <span>您可以访问<a href="https://beta.openai.com" target="_blank">OpenAI 网站</a>获取密钥</span>&nbsp;
                              <!-- <button class="btn btn-primary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien" id="check_credit">验证秘钥</button> -->
                            </div>

                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">经典编辑器支持 - 开关</label>
                          <div class="col-sm-9 icon-state" style="display:flex;align-items: center;">
                            <label class="switch" style="margin-bottom:0">
                              <input class="form-control" type="checkbox" name="classic_editor_support_switch" id="classic_editor_support_switch" <?php checked(get_option('classic_editor_support_switch'), 'on') ?> name="classic_editor_support_switch"><span class="switch-state"></span>
                            </label>
                            <span style="padding-left:10px;font-size:10px">若使用经典编辑器，请务必开启本功能！</span>
                          </div>
                        </div>


                        <!-- <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="schedule-tasks">计划任务 - 开关</label>
                          <div class="col-sm-9  icon-state" style="display:flex;align-items: center;">
                            <label class="switch" style="margin-bottom:0">
                              <input class="form-control" type="checkbox" disabled name="schedule-tasks"><span class="switch-state"></span>
                            </label>
                            <span style="padding-left:10px;font-size:10px">选项默认关闭 暂无该功能</span>
                          </div>
                        </div> -->





                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="seo-analysis">SEO分析 - 开关</label>
                          <div class="col-sm-9  icon-state">
                            <label class="switch">
                              <input class="form-control" type="checkbox" name="seo-analysis" id="seo-analysis" <?php esc_html_e($seo_analysis_checked . " " . $disable_attr); ?>><span class="switch-state"></span>
                            </label>
                            <div class="valid-feedback" style="display:flex;align-items:center">
                              <span>开启将会新增SEO分析功能，包含当前创作文章</span>&nbsp;<button class="btn btn-primary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien">SEO分析<?php esc_html_e(get_option('auth_signin_token') ? '' : '(无法使用)'); ?></button>&nbsp;<button class="btn btn-secondary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-secondary-gradien">关键词提取<?php esc_html_e(get_option('auth_signin_token') ? '' : '(无法使用)'); ?></button>
                            </div>
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label" for="search-images">智能搜图 - 开关</label>
                          <div class="col-sm-9  icon-state">
                            <label class="switch">
                              <input class="form-control" type="checkbox" name="search-images" id="search-images" <?php esc_html_e($search_images_checked . " " . $disable_attr); ?>><span class="switch-state"></span>
                            </label>
                            <div class="valid-feedback" style="display:flex;align-items:center">
                              <span>开启后将会新增搜图功能，请认真选择相关搜图API</span>&nbsp;<button class="btn btn-secondary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-secondary-gradien" id="images_search_check">检测延迟<?php esc_html_e(get_option('auth_signin_token') ? '' : '(无法使用)'); ?></button>
                            </div>
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