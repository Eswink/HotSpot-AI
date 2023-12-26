<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
<div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-12 p-0">
        <div class="login-card login-dark">
          <div>
            <div><img class="img-fluid for-light" src="<?php echo HOTSPOT_AI_URL_PATH . 'assets/images/login/login_logo.png' ?>"
                alt="looginpage" width="450px"></div>
            <div class="login-main">
              <form class="theme-form" id="signin_form" method="POST">
                <h4>Sign in</h4>
                <p>请登录以获得更好的AI体验</p>
                <div class="form-group">
                  <label class="col-form-label">邮箱地址</label>
                  <input class="form-control" type="email" placeholder="your@email.com" name="email">
                </div>
                <div class="form-group">
                  <label class="col-form-label">密码</label>
                  <div class="form-input position-relative">
                    <input class="form-control" type="password" name="password" placeholder="*********">
                    <div class="show-hide"><span class="show"> </span></div>
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
                  <!-- <div class="checkbox p-0">
                    <input id="checkbox1" type="checkbox">
                    <label class="text-muted" for="checkbox1">记住密码</label>
                  </div> -->
                  <!-- <a class="link" href="forget-password.html">忘记密码?</a> -->
                  <button id="signin" class="btn btn-primary btn-block w-100" type="submit">登录</button>
                </div>
                <p class="mt-4 mb-0 text-center">还未注册过？<a class="ms-2" href="admin.php?page=hotspot-signup">创建用户</a></p>
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