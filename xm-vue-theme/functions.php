<?php
// Remove all default WP template redirects/lookups
remove_action('template_redirect', 'redirect_canonical');

// Redirect all requests to index.php so the Vue app is loaded and 404s aren't thrown
function remove_redirects()
{
  add_rewrite_rule('^/(.+)/?', 'index.php', 'top');
}
add_action('init', 'remove_redirects');

// Load scripts
function load_vue_scripts()
{
  wp_enqueue_style('app.css', get_template_directory_uri() . '/static/css/app.bee8604e28d1c74876f17f5fa70a863b.css', false, null);

  wp_enqueue_script('manifest.js', get_template_directory_uri() . '/static/js/manifest.65ce285847e160df6608.js', null, null, true);

  wp_enqueue_script('vendor.js', get_template_directory_uri() . '/static/js/vendor.fcab0834f307368f720c.js', null, null, true);

  wp_enqueue_script('app.js', get_template_directory_uri() . '/static/js/app.d9729705b453c19f0db4.js', null, null, true);
}
add_action('wp_enqueue_scripts', 'load_vue_scripts', 100);

/**
 * 自定义上传头像
 */
require_once(TEMPLATEPATH . '/include/author-avatars.php');

/**
 * 主题扩展设置
 */
require_once(TEMPLATEPATH . '/include/xm-theme-options.php');

/**
 * 添加自定义接口
 */
require_once(TEMPLATEPATH . '/include/xm-api.php');

/**
 * 关闭自动更新
 */
add_filter('automatic_updater_disabled', '__return_true');

/**
 * 注册菜单
 */
register_nav_menus();

/**
 * 添加特色头像
 */
add_theme_support('post-thumbnails');

/**
 * 设置摘要
 */
function xm_get_post_excerpt($length, $str)
{
  $post_content = wp_strip_all_tags(get_post()->post_content, true);
  return wp_trim_words($post_content, $length, $str);
}

/*
 * 自定义登录页面的LOGO链接为首页链接,LOGO提示为网站名称
 */
add_filter('login_headerurl', create_function(false, "return get_bloginfo('url');"));
add_filter('login_headertitle', create_function(false, "return get_bloginfo('name');"));

/*
 * 自定义登录页面的LOGO图片
 */
function my_custom_login_logo() {
  echo '
    <style>
    .login h1 a {
      background-image:url("' . get_option('xm_vue_options')['login_logo'] . '");
      border-radius: 50%;
    }
    ' . get_option('xm_vue_options')['login_css'] . '
    </style>
  ';
}
add_action('login_head', 'my_custom_login_logo');

/**
 * 给用户添加自定义字段
 */
function xm_user_contact($user_contactmethods){
  unset($user_contactmethods['aim']);
  unset($user_contactmethods['yim']);
  unset($user_contactmethods['jabber']);
  $user_contactmethods['qq'] = 'QQ链接';
  $user_contactmethods['github_url'] = 'GitHub';
  $user_contactmethods['wechat_num'] = '微信号';
  $user_contactmethods['wechat_img'] = '微信二维码链接';
  $user_contactmethods['sina_url'] = '新浪微博';
  return $user_contactmethods;
}
add_filter('user_contactmethods', 'xm_user_contact');

/*
 * 解决php添加分号斜杠问题
 */
if (get_magic_quotes_gpc()) {
  function stripslashes_deep($value)
  {
    $value = is_array($value) ?
      array_map('stripslashes_deep', $value) :
      stripslashes($value);
    return $value;
  }
  $_POST = array_map('stripslashes_deep', $_POST);
  $_GET = array_map('stripslashes_deep', $_GET);
  $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}

/**
 * 允许未登录评论
 */
add_filter( 'rest_allow_anonymous_comments', '__return_true' );

/*
 * 添加自定义编辑器按钮
 */
function add_my_media_button()
{
 echo '<a href="javascript:;" id="html-transform" class="button">html尖括号转义</a>';
}
function appthemes_add_quicktags()
{
?>
  <script>
    var aLanguage = ['html', 'css', 'sass', 'scss', 'less', 'javascript', 'php', 'json', 'git'];
    for( var i = 0, length = aLanguage.length; i < length; i++ ) {
      QTags.addButton(aLanguage[i], aLanguage[i], '\n<pre class="line-numbers language-' + aLanguage[i] + '"><code class="language-' + aLanguage[i] + '">\n', '\n</code></pre>\n');
    }
    QTags.addButton('c-code', 'c-code', '<span class="code">', '</span>');
    // 添加html转换容器
    jQuery(function() {
      jQuery('#html-transform').click(function() {
        jQuery('body').append(
          '<div id="xm-transform">'
          + '<textarea name="name" rows="15" cols="100"></textarea>'
          + '<span id="xm-transfom-btn">转换</span>'
          + '<span id="xm-copy-btn">复制</span>'
          + '</div>'
        );
        jQuery('#xm-transform')
          .css({
            position: 'fixed',
            top: 0,
            left: 0,
            zIndex: 99999,
            width: '100%',
            height: '100%',
            background: 'rgba(255,255,255,0.7)'
          })
          .children('textarea').css({
            resize: 'none',
            position: 'absolute',
            top: '50%',
            left: '50%',
            width: '60%',
            height: '300px',
            transform: 'translate(-50%, -50%)'
          })
          .siblings('span').css({
            position: 'absolute',
            top: '90%',
            left: '50%',
            width: '100px',
            height: '40px',
            borderRadius: '5px',
            background: '#2196F3',
            textAlign: 'center',
            lineHeight: '40px',
            color: '#fff',
            cursor: 'pointer'
          });
        jQuery('textarea').click(function(e) { e.stopPropagation(); });
        jQuery('#xm-transfom-btn')
          .css('transform', 'translateX(-115%)')
          .click(function(e) {
            e.stopPropagation();
            jQuery(this).siblings('textarea').val(function() {
              return jQuery(this).val().replace(/</g, '&lt;').replace(/>/g, '&gt;');
            });
          });
        jQuery('#xm-copy-btn').click(function(e) {
          e.stopPropagation();
          jQuery(this).siblings('textarea')[0].select();
          if (document.execCommand('Copy')) {
            jQuery(this).text('复制成功');
          }
        });
        jQuery('#xm-transform').click(function() {
          jQuery(this).remove();
        });
      });
    });
  </script>
<?php
}
add_action('media_buttons', 'add_my_media_button');
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags');

/*
 * 自定义表情路径和名称
 */
function custom_smilies_src($src, $img)
{
  return get_bloginfo('template_directory') . '/static/images/smilies/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);
if (!isset($wpsmiliestrans)) {
  $wpsmiliestrans = array(
    "/weixiao"     => "weixiao.gif",
    "/nanguo"      => "nanguo.gif",
    "/qiudale"     => "qiudale.gif",
    "/penxue"      => "penxue.gif",
    "/piezui"      => "piezui.gif",
    "/aoman"       => "aoman.gif",
    "/baiyan"      => "baiyan.gif",
    "/bishi"       => "bishi.gif",
    "/bizui"       => "bizui.gif",
    "/cahan"       => "cahan.gif",
    "/ciya"        => "ciya.gif",
    "/dabing"      => "dabing.gif",
    "/daku"        => "daku.gif",
    "/deyi"        => "deyi.gif",
    "/doge"        => "doge.gif",
    "/fadai"       => "fadai.gif",
    "/fanu"        => "fanu.gif",
    "/fendou"      => "fendou.gif",
    "/ganga"       => "ganga.gif",
    "/guzhang"     => "guzhang.gif",
    "/haixiu"      => "haixiu.gif",
    "/hanxiao"     => "hanxiao.gif",
    "/haqian"      => "haqian.gif",
    "/huaixiao"    => "huaixiao.gif",
    "/jie"         => "jie.gif",
    "/jingkong"    => "jingkong.gif",
    "/jingxi"      => "jingxi.gif",
    "/jingya"      => "jingya.gif",
    "/keai"        => "keai.gif",
    "/kelian"      => "kelian.gif",
    "/koubi"       => "koubi.gif",
    "/ku"          => "ku.gif",
    "/kuaikule"    => "kuaikule.gif",
    "/kulou"       => "kulou.gif",
    "/kun"         => "kun.gif",
    "/leiben"      => "leiben.gif",
    "/lenghan"     => "lenghan.gif",
    "/liuhan"      => "liuhan.gif",
    "/liulei"      => "liulei.gif",
    "/qiaoda"      => "qiaoda.gif",
    "/qinqin"      => "qinqin.gif",
    "/saorao"      => "saorao.gif",
    "/se"          => "se.gif",
    "/shuai"       => "shuai.gif",
    "/shui"        => "shui.gif",
    "/tiaopi"      => "tiaopi.gif",
    "/touxiao"     => "touxiao.gif",
    "/tu"          => "tu.gif",
    "/tuosai"      => "tuosai.gif",
    "/weiqu"       => "weiqu.gif",
    "/wozuimei"    => "wozuimei.gif",
    "/wunai"       => "wunai.gif",
    "/xia"         => "xia.gif",
    "/xiaojiujie"  => "xiaojiujie.gif",
    "/xiaoku"      => "xiaoku.gif",
    "/xieyanxiao"  => "xieyanxiao.gif",
    "/xu"          => "xu.gif",
    "/yinxian"     => "yinxian.gif",
    "/yiwen"       => "yiwen.gif",
    "/zuohengheng" => "zuohengheng.gif",
    "/youhengheng" => "youhengheng.gif",
    "/yun"         => "yun.gif",
    "/zaijian"     => "zaijian.gif",
    "/zhayanjian"  => "zhayanjian.gif",
    "/zhemo"       => "zhemo.gif",
    "/zhouma"      => "zhouma.gif",
    "/zhuakuang"   => "zhuakuang.gif",
    "/aini"        => "aini.gif",
    "/baoquan"     => "baoquan.gif",
    "/gouyin"      => "gouyin.gif",
    "/qiang"       => "qiang.gif",
    "OK"           => "OK.gif",
    "/woshou"      => "woshou.gif",
    "/quantou"     => "quantou.gif",
    "/shengli"     => "shengli.gif",
    "/aixin"       => "aixin.gif",
    "/bangbangtang"=> "bangbangtang.gif",
    "/baojin"      => "baojin.gif",
    "/caidao"      => "caidao.gif",
    "/lanqiu"      => "lanqiu.gif",
    "/chi"         => "chi.gif",
    "/dan"         => "dan.gif",
    "/haobang"     => "haobang.gif",
    "/hecai"       => "hecai.gif",
    "/hexie"       => "hexie.gif",
    "/juhua"       => "juhua.gif",
    "/pijiu"       => "pijiu.gif",
    "/shouqiang"   => "shouqiang.gif",
    "/xiaoyanger"  => "xiaoyanger.gif",
    "/xigua"       => "xigua.gif",
    "/yangtuo"     => "yangtuo.gif",
    "/youling"     => "youling.gif",
    '/色'           => 'icon_razz.gif',
    '/难过'         => 'icon_sad.gif',
    '/闭嘴'         => 'icon_evil.gif',
    '/吐舌头'       => 'icon_exclaim.gif',
    '/微笑'         => 'icon_smile.gif',
    '/可爱'         => 'icon_redface.gif',
    '/kiss'        => 'icon_biggrin.gif',
    '/惊讶'         => 'icon_surprised.gif',
    '/饥饿'         => 'icon_eek.gif',
    '/晕'           => 'icon_confused.gif',
    '/酷'           => 'icon_cool.gif',
    '/坏笑'         => 'icon_lol.gif',
    '/发怒'         => 'icon_mad.gif',
    '/憨笑'         => 'icon_twisted.gif',
    '/萌萌哒'       => 'icon_rolleyes.gif',
    '/吃东西'       => 'icon_wink.gif',
    '/色咪咪'       => 'icon_idea.gif',
    '/囧'          => 'icon_arrow.gif',
    '/害羞'        => 'icon_neutral.gif',
    '/流泪'        => 'icon_cry.gif',
    '/流汗'        => 'icon_question.gif',
    '/你懂的'      => 'icon_mrgreen.gif'
  );
}

/*
 * 评论区@功能
 */
function comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '" style="color: #16C0F8;">' . get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'comment_add_at', 20, 2);

/**
 * 禁止emoji表情
 */
function disable_emojis()
{
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
function disable_emojis_tinymce($plugins)
{
  if (is_array($plugins)) {
    return array_diff($plugins, array( 'wpemoji' ));
  } else {
    return array();
  }
}
add_action('init', 'disable_emojis');
?>
