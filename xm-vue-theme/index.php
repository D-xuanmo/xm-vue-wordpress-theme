<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
  <title><?php bloginfo( 'name' ); ?></title>
  <meta name="keywords" content="<?php echo get_option('xm_vue_options')['keywords']; ?>">
  <meta name="description" content="<?php echo get_option('xm_vue_options')['description']; ?>">
  <meta name="format-detection" content="telephone=no">
  <?php
    if (!empty(get_option('xm_vue_options')['all_head'])) echo get_option('xm_vue_options')['all_head'];
    if (!empty(get_option('xm_vue_options')['common_css'])) echo '<style>' . get_option('xm_vue_options')['common_css'] . '</style>';
  ?>
  <link rel="icon" href="<?php echo get_option('xm_vue_options')['favicon']; ?>">
  <?php wp_head(); ?>
  <script src=//at.alicdn.com/t/font_556506_fosg14c49ehtzkt9.js></script>
</head>
<body>
  <div id="app"></div>
  <?php
    if (!empty(get_option('xm_vue_options')['footer_js'])) echo '<script>' . get_option('xm_vue_options')['footer_js'] . '</script>';
    wp_footer();
  ?>
</body>
</html>
