<?php
/**
 * 删除不需要的字段
 */
global $wpdb;
function xm_rest_prepare_post( $data, $post, $request ) {
	$_data = $data->data;
	$params = $request->get_params();
	unset( $_data['template'] );
	unset( $_data['categories'] );
	unset( $_data['excerpt'] );
	$data->data = $_data;
	return $data;
}
add_filter( 'rest_prepare_post', 'xm_rest_prepare_post', 10, 3 );

/**
 * 添加自定义接口
 */

// 获取网站基本信息
function add_get_blog_info()
{
  $array = array(
		'baseUrl'             => get_bloginfo('home'),
		'adminAjax'           => admin_url('admin-ajax.php'),
    'templeteUrl'         => get_template_directory_uri(),
    'blogName'            => get_bloginfo('name'),
		'adminPic'            => get_the_author_meta('simple_local_avatar', 1),
		'setExtend'           => get_option('xm_vue_options'),
		'getAllCountArticle'  => wp_count_posts()->publish,
		'getAllCountCat'      => wp_count_terms('category'),
		'getAllCountTag'      => wp_count_terms('post_tag'),
		'getAllCountPage'     => wp_count_posts('page')->publish,
		'getSidebarCount'     => get_option('xm_vue_options')['aside_count']
  );
  return $array;
}

add_action( 'rest_api_init', function () {
  register_rest_route(
		'xm-blog/v1',
		'/info',
		array(
	    'methods' => 'GET',
	    'callback' => 'add_get_blog_info'
	  )
	);
} );

// 发表意见
function xm_opinion($request) {
	$data = $request->get_params()['params'];
	$count_key = 'xm_post_link';
  $id = $data['id'];
  $key = $data['key'];
  $count = get_post_meta($id, $count_key, true);
  update_post_meta($id, $count_key, array_merge($count, array($key => $count[$key] + 1)));
  return $count[$key] + 1;
}

add_action( 'rest_api_init', function(){
  register_rest_route(
    'xm-blog/v1',
    '/link/',
    array(
      'methods'  => 'POST',
      'callback' => 'xm_opinion',
    )
  );
} );

// 更新阅读量
function xm_get_view_count($request) {
	$postID = $request->get_params()['params']['id'];
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
  return $count;
}

add_action( 'rest_api_init', function(){
  register_rest_route(
    'xm-blog/v1',
    '/view-count/',
    array(
      'methods'  => 'POST',
      'callback' => 'xm_get_view_count',
    )
  );
} );

// 获取顶部置顶菜单
add_action( 'rest_api_init', function () {
        register_rest_route( 'xm-blog/v1', '/top-menu', array(
        'methods' => 'GET',
        'callback' => function () {
					return wp_get_nav_menu_items('Top');
				},
    ) );
} );

// 获取主菜单
function xm_get_menu() {
	$array_menu = wp_get_nav_menu_items('Home');
	$menu = array();
	foreach ($array_menu as $m) {
		if (empty($m->menu_item_parent)) {
			$menu[$m->ID] = array();
			$menu[$m->ID]['ID']        = $m->object_id;
			$menu[$m->ID]['title']     = $m->title;
			$menu[$m->ID]['url']       = $m->url;
			$menu[$m->ID]['type']      = $m->object;
			$menu[$m->ID]['children']  = array();
		}
	}
	$submenu = array();
	foreach ($array_menu as $m) {
		if ($m->menu_item_parent) {
			$submenu[$m->ID] = array();
			$submenu[$m->ID]['ID']      = $m->object_id;
			$submenu[$m->ID]['title']   = $m->title;
			$submenu[$m->ID]['url']     = $m->url;
			$submenu[$m->ID]['type']    = $m->object;
			$menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
		}
	}
	return $menu;
}

add_action( 'rest_api_init', function () {
        register_rest_route( 'xm-blog/v1', '/menu', array(
        'methods' => 'GET',
        'callback' => 'xm_get_menu',
    ) );
} );

// 获取page添加自定义字段
function add_api_page_meta_field() {
  register_rest_field( 'page', 'pageInfor', array(
      'get_callback'    => function() {
				$array = array(
					'commentCount' => get_comments_number()
				);
				return $array;
				},
      'schema'          => null,
    )
  );
}
add_action( 'rest_api_init', 'add_api_page_meta_field' );

/**
 * 添加自定义字段
 */
function add_api_posts_meta_field() {
  // 获取文章相关信息
  register_rest_field( 'post', 'articleInfor', array(
      'get_callback'    => 'xm_get_article_infor',
      'schema'          => null,
    )
  );
}

function xm_get_article_infor( $object ) {
  $postID = $object['id'];
	// 添加发表意见默认值
	if (get_post_meta($postID, 'xm_post_link', true) === '') {
		add_post_meta($postID, 'xm_post_link', array(
			'very_good' => 0,
			'good'      => 0,
			'commonly'  => 0,
			'bad'       => 0,
			'very_bad'  => 0
		));
	}
	$current_category = get_the_category($postID);
  $array = array(
    'auther'       => get_the_author(),
		'other'        => array(
			'autherPic'  => get_the_author_meta('simple_local_avatar'),
			'autherTro'  => get_the_author_meta('description'),
			'github'     => get_the_author_meta('github_url'),
			'qq'         => get_the_author_meta('qq'),
			'wechatNum'  => get_the_author_meta('wechat_num'),
			'wechatPic'  => get_the_author_meta('wechat_img'),
			'sina'       => get_the_author_meta('sina_url'),
			'email'      => get_the_author_meta('user_email'),
		),
    'thumbnail'    => wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'Full')[0],
    'viewCount'    => get_post_meta($postID, 'post_views_count', true) === '' ? 0 : get_post_meta($postID, 'post_views_count', true),
    'commentCount' => get_comments_number(),
    'xmLink'       => get_post_meta($postID, 'xm_post_link', true),
    'summary'      => xm_get_post_excerpt(300, ''),
    'classify'     => get_the_category(),
		'tags'         => get_the_tags($postID),
		'prevLink'     => get_previous_post($current_category, ''),
		'nextLink'     => get_next_post($current_category, '')
  );
  return $array;
}
add_action( 'rest_api_init', 'add_api_posts_meta_field' );
?>
