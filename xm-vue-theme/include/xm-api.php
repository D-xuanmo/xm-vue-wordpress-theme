<?php
/**
 * 删除不需要的字段
 */
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
    'templeteUrl'    => get_template_directory_uri(),
    'blogName'       => get_bloginfo('name')
  );
  return $array;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'blog-info/v1', '/info', array(
    'methods' => 'GET',
    'callback' => 'add_get_blog_info'
  ) );
} );

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

  // 获取总文章
  register_rest_field( 'post', 'total_article', array(
      'get_callback'    => 'get_total_article',
      'schema'          => null,
    )
  );
}

function xm_get_article_infor( $object ) {
  $postID = $object['id'];
  $array = array(
    'thumbnail'    => wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'Full' )[0],
    'auther'       => get_the_author(),
    'viewCount'    => getPostViews($postID),
    'commentCount' => get_comments_number(),
    'xmLink'       => get_post_meta($postID, 'xm_post_link', true),
    'summary'      => xm_get_post_excerpt(300, ''),
    'classify'     => get_the_category()
  );
  return $array;
}

// 获取总文章
function get_total_article() {
  $count_posts = wp_count_posts()->publish;
  return $count_posts / 3 > intval($count_posts / 3)
          ? intval($count_posts / 3 + 1)
          : intval($count_posts / 3);
}
add_action( 'rest_api_init', 'add_api_posts_meta_field' );
?>
