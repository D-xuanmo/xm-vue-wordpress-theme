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
  wp_enqueue_style('app.css', get_template_directory_uri() . '/static/css/app.a58d5e0df9f4911645af675f1aa59356.css', false, null);

  wp_enqueue_script('manifest.js', get_template_directory_uri() . '/static/js/manifest.5b92d05d6834221e9e86.js', null, null, true);

  wp_enqueue_script('vendor.js', get_template_directory_uri() . '/static/js/vendor.1f5796b063a100971b87.js', null, null, true);

  wp_enqueue_script('app.js', get_template_directory_uri() . '/static/js/app.e5ef98eb7698ab5d2e81.js', null, null, true);
}
add_action('wp_enqueue_scripts', 'load_vue_scripts', 100);

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

/**
 * 获取文章阅读量
 */
function getPostViews($postID)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
    return '0';
  }
  return $count . '';
}
function setPostViews($postID)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    $count = 0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
  } else {
    $count++;
    update_post_meta($postID, $count_key, $count);
  }
}

/**
 * 文章发表意见
 */
function xm_set_post_link($id)
{
  $count_key = 'xm_post_link';
  $count = get_post_meta($id, $count_key, true);
  if ($count == '') {
    delete_post_meta($id, $count_key);
    add_post_meta($id, $count_key, array(
      'very_good' => 0,
      'good'      => 0,
      'commonly'  => 0,
      'bad'       => 0,
      'very_bad'  => 0
    ));
  }
}
function xm_post_link()
{
  $count_key = 'xm_post_link';
  $id = $_POST['post_id'];
  $key = $_POST['post_key'];
  $count = get_post_meta($id, $count_key, true);
  update_post_meta($id, $count_key, array_merge($count, array($key => $count[$key] + 1)));
  echo $count[$key] + 1;
  die();
}
add_action( 'wp_ajax_xm_post_link', 'xm_post_link' );
add_action( 'wp_ajax_nopriv_xm_post_link', 'xm_post_link' );

/**
 * 添加自定义接口
 */
require get_template_directory() . '/include/xm-api.php';

/**
 * 自定义上传头像
 */
require get_template_directory() . '/include/author-avatars.php';

?>
