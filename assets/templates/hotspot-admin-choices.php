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
        <form class="form-inline search-full col" action="#" method="get">
          <div class="form-group w-100">
            <div class="Typeahead Typeahead--twitterUsers">
              <div class="u-posRelative">
                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                  placeholder="Search Cuba .." name="q" title="" autofocus>
                <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span>
                </div><i class="close-search" data-feather="x"></i>
              </div>
              <div class="Typeahead-menu"></div>
            </div>
          </div>
        </form>
        <div class="header-logo-wrapper col-auto p-0">
          <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/logo/logo.png"
                alt=""></a></div>
          <!-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div> -->
        </div>
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
    <div class="page-body-wrapper default-menu default-menu">
      <!-- Page Sidebar Start-->
      <!-- Page Sidebar Ends-->
      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-6">
                <h4>
                  热词筛选
                </h4>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->


        <div class="container-fluid">
          <div class="row project-cards">
            <div class="col-md-12 project-list">
              <div class="card force-card">
                <div class="row">
                  <div class="col-md-6">
                    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                      <!-- <li class="nav-item"><a class="nav-link active" id="common-words-tab" data-bs-toggle="tab"
                          href="#common-words" role="tab" aria-controls="common-words" aria-selected="true"><i
                            data-feather="info"></i>普通词</a></li> -->
                      <li class="nav-item"><a class="nav-link active" id="hotwords-tab" data-bs-toggle="tab"
                          href="#hotwords" role="tab" aria-controls="hotwords" aria-selected="true"><i
                            data-feather="check-circle"></i>热词</a></li>
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-0 me-0"></div>
                    <!-- <button class="btn btn-primary-gradien" id="serach"><span>搜索</span></button> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="card force-card">
                <div class="card-body">
                  <div class="tab-content" id="top-tabContent">

                    <!-- ALL 结束 -->


                    <!-- <div class="tab-pane fade show active" id="common-words" role="tabpanel" aria-labelledby="common-words-tab">
                      <div class="row"> -->
                        <!-- 动态渲染 普通词-->

                      <!-- </div>
                    </div> -->



                    <div class="tab-pane fade show active" id="hotwords" role="tabpanel" aria-labelledby="hotwords-tab">
                      <div class="row">
                        <!-- 动态渲染 热词 -->


                      </div>
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
