<?php

// Display the menu page content
// Display the menu page content
function hotspot_display_page()
{
    ?>
    <div class="background"></div> <!-- 添加背景 -->
    <div class="wrap">
        <h1><?php _e('Hotspot Settings', 'hotspot'); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('hotspot_settings_group'); ?>
            <?php do_settings_sections('hotspot_settings_group'); ?>
            <div class="settings-section">
            <h2><?php _e('热点设置', 'hotspot'); ?></h2>
              <hr>
                <h2><?php _e('Cookie填写', 'hotspot'); ?></h2>
                <div class="input-container">
                    <textarea name="hot_cookie" rows="5" cols="60" placeholder="<?php _e('请输入您的Cookie...', 'hotspot'); ?>"><?php echo esc_html(get_option('hot_cookie')); ?></textarea>
                    <button class="get-tutorial" style="color:#000" type="button">获取教程</button><button class="clear-cookie" style="color:#000;margin-left:10px" type="button">清空</button>
                  </div>
            </div>
            <div class="settings-section">
            <h2><?php _e('接口配置', 'hotspot'); ?></h2>
              <hr>
              <div class="settings-inputs">
                <h2><?php _e('接口选择:', 'hotspot'); ?></h2>
                <div class="input-container" style="margin-left:10px">
                    <select id="hotspot-select" name="AI_select_option">
                        <option value="domestic_interface"<?php selected(get_option('AI_select_option'), 'domestic_interface'); ?>><?php _e('国内代理 目前推荐', 'hotspot'); ?></option><label>123</label>
                        <option value="official_interface"<?php selected(get_option('AI_select_option'), 'official_interface'); ?>><?php _e('官方接口', 'hotspot'); ?></option>
                        <option value="exclusive_interface"<?php selected(get_option('AI_select_option'), 'exclusive_interface'); ?>><?php _e('专属代理接口', 'hotspot'); ?></option>
                    </select>
                </div>
                  </div>
              <div id="input-container"></div>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>

    <script>



document.addEventListener('DOMContentLoaded', function() {
  const select = document.getElementById('hotspot-select');
  const inputContainer = document.getElementById('input-container');

  // 根据所选选项创建新的输入框
  function createInputs(selectedOption) {
    const APPIDLabel = document.createElement('label');
    APPIDLabel.innerHTML = "APPID:";
    const APPID = document.createElement('input');
    APPID.type = 'text';
    APPID.name = 'APPID'; // 设置name属性
    APPID.placeholder = '请输入APPID';
    APPID.value = '<?php echo get_option('APPID') ?>';

    const APPSECRETLabel = document.createElement('label');
    APPSECRETLabel.innerHTML = "Secret:";
    const APPSECRET = document.createElement('input');
    APPSECRET.type = 'text';
    APPSECRET.placeholder = '请输入Secret';
    APPSECRET.value = '<?php echo get_option('APPSECRET') ?>'
    APPSECRET.name = "APPSECRET"

    if (selectedOption === 'official_interface') {
      inputContainer.innerHTML = ''
      inputContainer.appendChild(APPIDLabel);
      inputContainer.appendChild(APPID);
      inputContainer.appendChild(document.createElement("br"));

      inputContainer.appendChild(APPSECRETLabel);
      inputContainer.appendChild(APPSECRET);
    } else if (selectedOption === 'exclusive_interface') {
      inputContainer.innerHTML = ''
      // inputContainer.appendChild(APPIDLabel);
      // inputContainer.appendChild(APPID);
      //inputContainer.appendChild(document.createElement("br"));

      inputContainer.appendChild(APPSECRETLabel);
      inputContainer.appendChild(APPSECRET);
    } else if(selectedOption === 'domestic_interface'){
      inputContainer.innerHTML = ''
    }
  }

  // 初始化输入框
  createInputs(select.value);

  // 添加事件监听器
  select.addEventListener('change', function() {
    // 删除之前的输入框
    while (inputContainer.firstChild) {
      inputContainer.removeChild(inputContainer.firstChild);
    }
    createInputs(select.value);
  });
});


jQuery(document).ready(function($) {
        // 获取教程按钮点击事件处理程序

        $('.get-tutorial').click(function() {
        // 在此处添加相应的代码，以响应 .get-tutorial 元素的点击事件
        const tutorialWindow = window.open('https://blog.eswlnk.com', 'Hotspot Window', 'width=1200,height=600');
            tutorialWindow.focus();
        });

        $('.clear-cookie').click(function() {
          const cookieInput = document.querySelector('textarea[name="hot_cookie"]');
            cookieInput.value = '';
            cookieInput.focus();
      });
    })



    </script>

    <style>
        /* 全局样式 */
        :root {
            --primary-color: #fff;
            --secondary-color: #f5f5f5;
            --tertiary-color: #fff;
            --border-radius: 10px;
            --transition-duration: 0.3s;

            /* 模糊效果变量 */
            --blur-intensity: 10px;
            --blur-color: rgba(255,255,255,0.8);
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden; /* 隐藏body滚动条 */
        }

        /* 背景样式 */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: url('<?php echo HOTSPOT_AI_URL_PATH . 'assets/img/background-2.jpg' ?>');
            background-size: cover;
            filter: blur(var(--blur-intensity));
            backdrop-filter: blur(var(--blur-intensity)) saturate(180%) brightness(70%);
            z-index: -1;
            transition: opacity var(--transition-duration) ease-in-out;
            opacity: 0.9;
        }

        /* 表单样式 */
        .wrap {
            position: relative;
            margin: 50px auto;
            max-width: 800px;
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 20px;
            transition: transform var(--transition-duration) ease-in-out;
            transform: translateY(-50px);
            animation: slide-in 0.5s forwards;
            z-index: 1; /* 确保表单在背景之上 */
        }

        .settings-section {
            margin-bottom: 30px;
}

    h1 {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 30px;
    }

    h2 {
        color: var(--tertiary-color);
        margin-bottom: 10px;
    }

    .input-container {
        margin-top: 15px;
    }

    textarea {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f5f5f5;
  border: none;
  outline: none;
  padding: 10px;
  border-radius: 20px;
  box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2),
              -4px -4px 10px rgba(255, 255, 255, 0.5);
  font-size: 16px;
  line-height: 1.5;
  transition: all 0.3s ease-in-out;
  width:100%
}

textarea:focus {
  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2),
              -2px -2px 5px rgba(255, 255, 255, 0.5);
  background-color: #fff;
}
textarea::-webkit-scrollbar {
  display: none;
}

    button {
        border: none;
        outline: none;
        padding: 10px 20px;
        background-color: var(--primary-color);
        color: #fff;
        border-radius: var(--border-radius);
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        font-size: 16px;
        cursor: pointer;
        transition: background-color var(--transition-duration) ease-in-out;
    }

    button:hover {
        background-color: darken(var(--primary-color), 10%);
    }

    /* 过渡动画 */
    @keyframes slide-in {
        from {
            transform: translateY(-50px);
        }
        to {
            transform: translateY(0);
        }
    }

    @keyframes slide-out {
        from {
            transform: translateY(0);
        }
        to {
            transform: translateY(-50px);
        }
    }

    /* 响应式布局 */
    @media only screen and (max-width: 600px) {
        .wrap {
            max-width: 90%;
            margin-top: 30px;
            padding: 10px;
        }

        textarea {
            font-size: 14px;
        }
    }

    .settings-inputs{
      display:flex;
      align-items: center;
      margin-top:20px
    }
    .settings-inputs h2{
      margin:0!important
    }


    .settings-inputs .input-container{
      margin-top:0!important
    }

    #input-container label{
      color:#fff!important
    }
    #input-container{
      margin-top:10px
    }
</style>
<?php
}

function hotspot_choices_page()
{
    ?>
  <div class="hotspot-settings-container">
    <h1>热点文章</h1>
    <div class="hotspot-filters-container">
      <label for="hot-spot-selection">筛选</label>
      <select name="hot-spot-selection" id="hot-spot-selection">
      <option value='' disabled selected style='display:none;'>热度</option>
        <option value="1">普通词</option>
        <option value="2">热词</option>
      </select>
    </div>
    <div class="hotspot-container">
    </div>
    <div id="pagination-container"></div>
  </div>
  <?php
}

function hotspot_about_page()
{
    ?>
    <div class="wrap-container dynamic-height">
    <div class="wrap">
      <h1><?php _e('关于Hotspot插件', 'hotspot'); ?></h1>
      <p><?php _e('Hotspot是一款基于AI技术的WordPress插件，旨在帮助您分析获取全网热词并帮助构思和写作，提高您网站的整体权重。', 'hotspot'); ?></p>
      <h2><?php _e('工作原理', 'hotspot'); ?></h2>
      <p><?php _e('Hotspot使用机器学习算法来分析全网热词，自动生成观点、标题、摘要等内容，并为您提供有关该主题的更多详细信息。通过这种方式，Hotspot可以帮助您快速构思和编写高质量的内容，从而提高您网站的整体权重。', 'hotspot'); ?></p>

      <h2><?php _e('功能特点', 'hotspot'); ?></h2>
      <ul>
        <li><?php _e('分析全网热词', 'hotspot'); ?></li>
        <li><?php _e('自动生成观点、标题、摘要等内容', 'hotspot'); ?></li>
        <li><?php _e('提供有关主题的更多详细信息', 'hotspot'); ?></li>
        <li><?php _e('帮助用户快速构思和编写高质量的内容', 'hotspot'); ?></li>
        <li><?php _e('提高网站整体权重', 'hotspot'); ?></li>
      </ul>
      <h2><?php _e('效果展示', 'hotspot'); ?></h2>
      <img src="<?php echo HOTSPOT_AI_URL_PATH . 'assets/img/effect.png'; ?>" alt="<?php _e('Hotspot插件管理面板', 'hotspot'); ?>">
    </div>

    <div class="wrap">
      <h2><?php _e('快速入门指南', 'hotspot'); ?></h2>
      <ol>
        <li><?php _e('从WordPress插件库安装并激活Hotspot插件', 'hotspot'); ?></li>
        <li><?php _e('转到Hotspot设置页面以配置插件选项', 'hotspot'); ?></li>
        <li><?php _e('单击Hotspot文章类型页面上的“添加新”的按钮来开始构思和编写高质量的内容', 'hotspot'); ?></li>
        <li><?php _e('将生成的观点、标题和摘要复制并粘贴到任何要显示的文章或页面中，也可以使用生成的内容作为灵感来编写自己的内容', 'hotspot'); ?></li>
      </ol>

      <h2><?php _e('常见问题解答', 'hotspot'); ?></h2>
      <ul>
        <li><strong><?php _e('Hotspot是否适用于任何WordPress主题？', 'hotspot'); ?></strong> - <?php _e('是的，Hotspot插件设计为与任何WordPress主题兼容。', 'hotspot'); ?></li>
        <li><strong><?php _e('如何查看生成的观点、标题和摘要？', 'hotspot'); ?></strong> - <?php _e('您可以在编辑文章时使用Hotspot的生成工具来查看生成的观点、标题和摘要。此外，您还可以从管理员控制面板中访问历史生成记录。', 'hotspot'); ?></li>
        <li><strong><?php _e('Hotspot能否帮助我分析竞争对手？', 'hotspot'); ?></strong> - <?php _e('是的，Hotspot提供了强大的竞争对手分析工具，可帮助您了解竞争对手的关键词、排名和流量等信息。', 'hotspot'); ?></li>
</ul>

<h2><?php _e('用户评价', 'hotspot'); ?></h2>
<blockquote>
  <p><?php _e('我一直在使用Hotspot插件来帮助我构思和写作，它真的很棒！自从我开始使用这个插件以来，我的网站排名和流量都有了显著提高。', 'hotspot'); ?></p>
  <cite><?php _e('Eswlnk, 网站所有者', 'hotspot'); ?></cite>
</blockquote>
</div>
</div>

<script>
const container = document.querySelector('.dynamic-height');
const dy_height = document.getElementById('wpwrap').offsetHeight
container.style.height = `${dy_height - 60}px`;

</script>

<style>
.wrap {
  position: relative;
  display: inline-block;
  border-radius: 20px;
  box-shadow: 0px 0px 1em rgba(0, 0, 0, 0.2);
  padding: 30px;
  margin-right: 20px;
  max-width: 600px;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.5s ease-out forwards;
  z-index: 1;
  backdrop-filter: blur(10px);
}

@media (max-width: 600px) {
  .wrap {
    max-width: 100%;
    margin-right: 0;
  }
  .wrap-container {
    display: block!important;
  }
}

.wrap-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  position: relative; /* 新增 */
}

/* 新增样式 */
.wrap-container::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url('<?php echo HOTSPOT_AI_URL_PATH . 'assets/img/background.jpg' ?>'); /* 替换为你的背景图片链接 */
  background-size: cover;
  background-position: center center;
  filter: blur(10px);
  opacity: 0.6;
  z-index: -1;
}

.wrap img{
  width:100%
}

.wrap-container ul{
  list-style-type: decimal;
  margin-left:13px
}





@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(50%);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
<?php
}

function hotspot_statistics_page()
{
    ?>
    <div class="background"></div> <!-- 添加背景 -->
      <div class="hotspot-statistics-container">
    <div class="hotspot-statistics-card-container">
    </div>

  </div>
  <button id="load-more">Load More</button>



  <style>
            :root {
            --primary-color: #fff;
            --secondary-color: #f5f5f5;
            --tertiary-color: #fff;
            --border-radius: 10px;
            --transition-duration: 0.3s;

            /* 模糊效果变量 */
            --blur-intensity: 10px;
            --blur-color: rgba(255,255,255,0.8);
        }

  /* 设置背景 */
  .background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-image: url('<?php echo HOTSPOT_AI_URL_PATH . 'assets/img/background-2.jpg' ?>');
    background-size: cover;
    filter: blur(var(--blur-intensity));
    backdrop-filter: blur(var(--blur-intensity)) saturate(180%) brightness(70%);
    z-index: -1;
    transition: opacity var(--transition-duration) ease-in-out;
    opacity: 0.9;
  }

  .hotspot-statistics-container {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  padding-top: 40px; /* 添加顶部内边距 */
  z-index: 1;
  position: relative;
}

  .hotspot-statistics-card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
  }

  .hotspot-statistics-card {
    position: relative;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    background-color: #fff;
    background-image: linear-gradient(to bottom right, #f1f1f1, #fff);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  }

  .hotspot-statistics-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
  }

  .hotspot-statistics-card h1 {
    font-size: 24px;
  font-weight: bold;
  margin: 20px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
  line-height:normal;

  }
  .hotspot-statistics-card a{
    text-decoration-line: none!important;
  }


  .hotspot-statistics-table {
    margin-bottom: 0;
  }

  #load-more {
    display: block;
    margin: 40px auto 0;
    padding: 10px 20px;
    border: none;
    border-radius: 30px;
    background-color: #007cba;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    /* 新拟态效果 */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1;
  }

  #load-more:hover {
    background-color: #006799;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  }
</style>

<?php
}