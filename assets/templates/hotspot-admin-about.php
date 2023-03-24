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
        <!-- Page Sidebar Start-->
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>关于我们</h4>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->



          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card force-card">
                  <div class="card-header">
                    <h5>Hotspot AI</h5>
                    <span>智能辅助AI构思插件</span>
                  </div>
                  <div class="card-body">
                    <p>"Hotspot是一款基于AI技术的WordPress插件，旨在帮助您分析获取全网热词并帮助构思和写作，提高您网站的整体权重"</p>
                  </div>
                </div>
              </div>

              <div class="col-sm-6">

                <div class="card force-card">
                  <div class="card-header">
                    <h5>工作原理</h5>
                    <span>Working Principle</span>
                  </div>
                  <div class="card-body">
                    <p>使用机器学习算法来分析全网热词，自动生成观点、标题、摘要等内容，并为您提供有关该主题的更多详细信息</p>
                    <p>通过这种方式，Hotspot AI 可以帮助您快速构思和编写高质量的内容，从而提高您网站的整体权重。</p>
                    <br>
                    <br>
                    <br>

                  </div>
                </div>

              </div>


              <div class="col-sm-6">

                <div class="card force-card">
                  <div class="card-header">
                    <h5>功能特点</h5>
                    <span>Functional Characteristics</span>
                  </div>
                  <div class="card-body">
                      <li>分析全网热词</li>
                      <li>自动生成观点、标题、摘要等内容</li>
                      <li>提供有关主题的更多详细信息</li>
                      <li>帮助用户快速构思和编写高质量的内容</li>
                      <li>提高网站整体权重</li>
                  </div>
                </div>

              </div>


              <div class="col-sm-6">

                <div class="card force-card">
                  <div class="card-header">
                    <h5>效果展示</h5>
                    <span>Effect Display</span>
                  </div>
                  <div class="card-body">
                  <img src="<?php echo HOTSPOT_AI_URL_PATH ?>/assets/images/effect.png" alt="Hotspot插件管理面板" width="100%">
                  </div>
                </div>
              </div>

              <div class="col-sm-6">

                <div class="card force-card">
                  <div class="card-header">
                    <h5>常见问题</h5>
                    <span>Common Problems</span>
                  </div>
                  <div class="card-body">
                  <li><strong>Hotspot是否适用于任何WordPress主题？</strong> - 是的，Hotspot插件设计为与任何WordPress主题兼容。</li>
                  <li><strong>如何查看生成的观点、标题和摘要？</strong> - 您可以在编辑文章时使用Hotspot的生成工具来查看生成的观点、标题和摘要。此外，您还可以从管理员控制面板中访问历史生成记录。</li>
                  <li><strong>Hotspot能否帮助我分析竞争对手？</strong> - 是的，Hotspot提供了强大的竞争对手分析工具，可帮助您了解竞争对手的关键词、排名和流量等信息。</li>
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