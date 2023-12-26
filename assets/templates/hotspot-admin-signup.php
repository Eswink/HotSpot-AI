<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
<div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-12 p-0">
        <div class="login-card login-dark">
          <div>
            <div><img class="img-fluid for-light" src="<?php echo HOTSPOT_AI_URL_PATH . 'assets/images/login/login_logo.png' ?>"
                alt="looginpage" width="450px"></div>
            <div class="login-main">
              <form class="theme-form" id="signup_form" method="POST">
                <h4>Sign up</h4>
                <p>感谢您对本插件的支持</p>
                <div class="form-group">
                  <label class="col-form-label">用户名</label>
                  <input class="form-control" type="text" placeholder="New HotSpot User" name="username">
                </div>
                <div class="form-group">
                  <label class="col-form-label">邮箱地址</label>
                  <input class="form-control" type="email" placeholder="your@email.com" name="email">
                </div>
                <div class="form-group">
                  <label class="col-form-label">验证码</label>

                  <div class="form-input position-relative">
                  <input class="form-control" type="text" placeholder="*****" name="code">
                    <div class="show-hide">
                  <button class="btn btn-primary-gradien btn-xs" type="button" title=""
                                data-bs-original-title="btn btn-primary-gradien" id="send_email">发送</button></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-form-label">密码</label>
                  <div class="form-input position-relative">
                    <input class="form-control" type="password" name="password" id="password" placeholder="*********">
                    <div class="show-hide"><span class="show"> </span></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-form-label">重复密码</label>
                  <div class="form-input position-relative">
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="*********">
                    <div class="show-hide-confirm"><span class="show"> </span></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="h-captcha" name="h-captcha-response" data-sitekey="d78793af-cd0a-4e7c-8309-aee03edbdd69" data-callback="validate_token"></div>
                </div>
                <style>
                  .h-captcha{
                    padding-top:5px
                  }
                  .h-captcha iframe{
                    display: flex;
                    margin: 0 auto;
                  }
                </style>
                  <div class="text-end mt-3 invalid-feedback" id="feedback">
                    <span>请先通过验证,正在加载验证码...</span>
                  </div>
                  <div class="form-group mb-0">
                    <div class="checkbox p-0">
                      <input id="checkbox1" type="checkbox" name="checkbox1">
                      <label class="text-muted" for="checkbox1">同意<a class="ms-2" href="#">HotSpot AI 热点创作 注册协议</a></label>
                    </div>
                    <button class="btn btn-primary btn-block w-100" type="submit" id="signup">注册</button>
                  </div>
                <p class="mt-4 mb-0 text-center">已经有账户了？<a class="ms-2" href="admin.php?page=hotspot-signin">点我登录</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <style>
#wpadminbar{
  display: none!important;
}


#adminmenuback{
  display: none!important;
}

#adminmenuwrap{
  display: none!important;
}
</style>