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
            <div class="d-flex h-100"><img src="<?php echo HOTSPOT_AI_URL_PATH ?>assets/images/giftools.gif" alt="gif">
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
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
        <script class="empty-template"
          type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
      </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">

      <!-- page-siderbar -->

      <div class="sidebar-wrapper" sidebar-layout="stroke-svg">
      </div>


      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-6">
                <h4>AI 统计分析</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-xxl-5 col-ed-6 col-xl-8 box-col-7">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card o-hidden welcome-card force-card">
                    <div class="card-body">
                      <h4 class="mb-3 mt-1 f-w-500 mb-0 f-22">您好，尊敬的主人<span> <img
                            src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/dashboard-3/hand.svg" alt="hand vector"></span></h4>
                      <p>希望您能在接下来的一天过得充实自在.</br>Free online writing available</p>
                    </div><img class="welcome-img" src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/dashboard-3/widget.svg" alt="search image">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card course-box force-card">
                    <div class="card-body">
                      <div class="course-widget">
                        <div class="course-icon">
                          <svg class="fill-icon">
                            <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#course-1"></use>
                          </svg>
                        </div>
                        <div>
                          <h4 class="mb-0">100+</h4><span class="f-light">新增访问量</span><a class="btn btn-light f-light"
                            href="#">前往查看<span class="ms-2">
                              <svg class="fill-icon f-light">
                                <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#arrowright"></use>
                              </svg></span></a>
                        </div>
                      </div>
                    </div>
                    <ul class="square-group">
                      <li class="square-1 warning"></li>
                      <li class="square-1 primary"></li>
                      <li class="square-2 warning1"></li>
                      <li class="square-3 danger"></li>
                      <li class="square-4 light"></li>
                      <li class="square-5 warning"></li>
                      <li class="square-6 success"></li>
                      <li class="square-7 success"></li>
                    </ul>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card course-box force-card">
                    <div class="card-body">
                      <div class="course-widget">
                        <div class="course-icon warning">
                          <svg class="fill-icon">
                            <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#course-2"></use>
                          </svg>
                        </div>
                        <div>
                          <h4 class="mb-0">50+</h4><span class="f-light">新增热点</span><a class="btn btn-light f-light"
                            href="#">前往查看<span class="ms-2">
                              <svg class="fill-icon f-light">
                                <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#arrowright"></use>
                              </svg></span></a>
                        </div>
                      </div>
                    </div>
                    <ul class="square-group">
                      <li class="square-1 warning"></li>
                      <li class="square-1 primary"></li>
                      <li class="square-2 warning1"></li>
                      <li class="square-3 danger"></li>
                      <li class="square-4 light"></li>
                      <li class="square-5 warning"></li>
                      <li class="square-6 success"></li>
                      <li class="square-7 success"></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-5 col-ed-3 col-xl-4 col-sm-6 box-col-5">
              <div class="card get-card force-card">
                <div class="card-header card-no-border">
                  <h5>今日份的工作</h5><span class="f-14 f-w-500 f-light">恭喜您，每日目标就快要完成了!</span>
                </div>
                <div class="card-body pt-0">
                  <div class="progress-chart-wrap">
                    <div id="progresschart"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- card -->

            <div class="col-xl-2 col-ed-3 d-xxl-block d-sm-none box-col-none">
              <div class="card get-card overflow-hidden force-card">
                <div class="card-header card-no-border">
                  <h5>您想要获得</h5><span class="f-14 f-w-500 f-light">更多的创作灵感吗？</span><a
                    class="btn btn-primary btn-hover-effect" href="#">快速构思<span class="ms-1">
                      <svg class="fill-icon">
                        <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#arrowright"></use>
                      </svg></span></a>
                </div>
                <div class="card-body pt-0">
                  <div class="get-image text-center"> <img class="img-fluid"
                      src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/dashboard-3/better.png" alt="leptop with men vector"></div>
                </div>
                <ul class="square-group">
                  <li class="square-1 warning"></li>
                  <li class="square-1 primary"></li>
                  <li class="square-2 warning1"></li>
                  <li class="square-3 danger"></li>
                  <li class="square-4 light"></li>
                  <li class="square-5 warning"></li>
                  <li class="square-6 success"></li>
                  <li class="square-7 success"></li>
                </ul>
              </div>
            </div>

            <!-- card -->







            <div class="col-xxl-5 col-ed-7 col-xl-7 box-col-7">
              <div class="card force-card">
                <div class="card-header card-no-border">
                  <div class="header-top">
                    <h5 class="m-0">创作总览<span class="f-14 f-w-500 ms-1 f-light">(记录你的日常)</span></h5>
                    <div class="card-header-right-icon">
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="learningButton" type="button"><i
                            class="fa fa-refresh"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <div class="learning-wrap">
                    <div id="basic-apex"></div>
                  </div>
                </div>
              </div>
            </div>


            <!-- 辅助构思的文章数量 -->


            <div class="col-xxl-4 col-ed-7 col-xl-7 col-md-6 box-col-7">
              <div class="card force-card">
                <div class="card-header card-no-border">
                  <div class="header-top">
                    <h5>辅助构思文章数量</h5>
                    <div class="dropdown icon-dropdown">
                      <button class="btn dropdown-toggle" id="learningButton" type="button"><i
                          class="fa fa-refresh"></i></button>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <div class="row m-0 overall-card">
                    <div class="col-xl-8">
                      <div class="chart-right">
                        <div class="row">
                          <div class="col-xl-12">
                            <div class="card-body p-0">
                              <div class="activity-wrap">
                                <div id="activity-chart"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-4 p-0">
                      <div class="row g-sm-3 g-2 mt-0">
                        <div class="col-xl-12 col-md-6 col-sm-4">
                          <div class="light-card balance-card">
                            <div> <span class="f-light">时间花费</span>
                              <h6 class="mt-1 mb-0">30<span
                                  class="badge badge-light-success rounded-pill ms-1">140%</span></h6>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-12 col-md-6 col-sm-4">
                          <div class="light-card balance-card">
                            <div> <span class="f-light">费用消耗</span>
                              <h6 class="mt-1 mb-0">45<span
                                  class="badge badge-light-success rounded-pill ms-1">86%</span></h6>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-12 col-md-6 col-sm-4">
                          <div class="light-card balance-card">
                            <div> <span class="f-light">发布量</span>
                              <h6 class="mt-1 mb-0">12<span
                                  class="badge badge-light-success rounded-pill ms-1">120%</span></h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- 辅助构思的文章数量 -->






            <div class="col-xxl-3 col-ed-5 col-xl-5 col-md-6 box-col-5">
              <div class="card force-card">
                <div class="card-header card-no-border">
                  <div class="header-top">
                    <h5>计划事件</h5>
                    <div class="dropdown icon-dropdown">
                      <button class="btn dropdown-toggle" id="learningButton" type="button"><i
                          class="fa fa-refresh"></i></button>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <div class="upcoming-event-wrap">
                    <div id="upcomingchart"></div>
                  </div>
                </div>
              </div>
            </div>




            <!-- 计划任务 -->





            <div class="col-xxl-5 col-ed-7 col-xl-7 box-col-7">
              <div class="card schedule-card force-card">
                <div class="card-header card-no-border">
                  <div class="header-top">
                    <h5 class="m-0">您的计划任务</h5>
                    <div class="card-header-right-icon"><a class="btn badge-light-primary" href="#">+ Create</a></div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <ul class="schedule-list">
                    <li class="primary"><img src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/dashboard/user/4.jpg" alt="profile">
                      <div>
                        <h6 class="mb-1">网页设计</h6>
                        <ul>
                          <li class="f-light">
                            <svg class="fill-icon f-light">
                              <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#bag"></use>
                            </svg><span>January 3, 2022</span>
                          </li>
                          <li class="f-light">
                            <svg class="fill-icon f-success">
                              <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#clock"></use>
                            </svg><span> 09.00 - 12.00 </span>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li class="warning"><img src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/dashboard/user/2.jpg" alt="profile">
                      <div>
                        <h6 class="mb-1">UI/UX 设计</h6>
                        <ul>
                          <li class="f-light">
                            <svg class="fill-icon f-light">
                              <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#bag"></use>
                            </svg><span>Febuary 10, 2022</span>
                          </li>
                          <li class="f-light">
                            <svg class="fill-icon f-success">
                              <use href="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/svg/icon-sprite.svg#clock"></use>
                            </svg><span> 11.00 - 13.00 </span>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>


            <!-- 计划任务 -->





          </div>
        </div>
        <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 footer-copyright text-center">
              <p class="mb-0">Copyright 2023 © theme by Eswlnk</p>
            </div>
          </div>
        </div>
       </footer>
    </div>
  </div>