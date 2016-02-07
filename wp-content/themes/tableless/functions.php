<?php

  // Enable featured images
  add_theme_support( 'post-thumbnails' );

  // Unable the admin bar
  add_filter('show_admin_bar', '__return_false');

  // Add Excerpt to pages
  add_post_type_support( 'page', 'excerpt' );

  // Remove GENERATED BY WORDPRESS
  remove_action('wp_head', 'wp_generator');

  // Windows Livr Writer
  remove_action('wp_head', 'wlwmanifest_link');

  // Remove the Shortcut link of header.
  remove_action( 'wp_head', 'wp_shortlink_wp_head' );

  // Upgrade without FTP
  define('FS_METHOD','direct');

  // get the "contributor" role object
  // $obj_existing_role = get_role( 'contributor' );

  // add the "organize_gallery" capability
  // $obj_existing_role->add_cap( 'edit_published_posts' );

  // Adding new image formats
  // add_action( 'after_setup_theme', 'tb_theme_setup' );
  // function tb_theme_setup() {
  //   add_image_size( 'medium-img', 300 );
  //   add_image_size( 'small-img', 100, 80, true );
  // }

  // Insert featured image in Feeds.
  add_filter('the_content_feed', 'rss_post_thumbnail');
  function rss_post_thumbnail($content) {
    global $post;
    if( has_post_thumbnail($post->ID) )
      $content = '<p>' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</p>' . $content;
    return $content;
  }

  /////
  // SCRIPT ENQUEUE
  /////
  function tableless_scripts() {
    wp_deregister_script('jquery');
    wp_deregister_style('noticons');
    wp_dequeue_script('devicepx');
    wp_dequeue_script('e-201408');

    wp_register_script('disqus', get_template_directory_uri().'/assets/js/vendor/disqus.js', array(), '1.0', true );
    wp_register_script('prettify', get_template_directory_uri().'/assets/js/vendor/prettify/src/prettify.js', array(), '1.0', true );
    wp_register_script('scripts', get_template_directory_uri().'/assets/js/scripts.js', array(), '1.0', true );

    if (is_single()) {
      wp_enqueue_script('prettify');
      wp_enqueue_script('disqus');
    }

    wp_enqueue_script('scripts');
  }

  add_action( 'wp_enqueue_scripts', 'tableless_scripts' );

  //////
  // CSS ENQUEUE
  //////
  function tableless_styles() {
    wp_dequeue_style('subscriptions');
    wp_deregister_style('subscriptions');

    wp_register_style( 'home', get_template_directory_uri() . '/assets/css/home.css', '1.0' );
    wp_register_style( 'single', get_template_directory_uri() . '/assets/css/content.css', '1.0' );
    wp_register_style( 'prettify', get_template_directory_uri() . '/assets/css/prettify.css', '1.0' );
    wp_register_style( 'category', get_template_directory_uri() . '/assets/css/category.css', '1.0' );

    if (is_home()) {
      wp_enqueue_style( 'home' );
    }
    if (is_single() || is_page()) {
      // wp_enqueue_style( 'prettify' );
      wp_enqueue_style( 'single' );
    }
    if (is_category() || is_search() || is_author() || is_page(42486, 'ultimos-posts')) {
      wp_enqueue_style( 'category' );
    }

  }

  add_action( 'wp_enqueue_scripts', 'tableless_styles' );

/////
// Widgets
/////
function tableless_widgets_init() {
  // Area 1, located at the top of the sidebar.
  register_sidebar( array(
    'name' => __( 'Sidebar do site', 'tableless' ),
    'id' => 'sidebar',
    'description' => __( 'Sidebar principal das páginas de posts e artigos', 'tableless' ),
    'before_widget' => '<div id="%1$s" class="tb-widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="tb-widget-title">',
    'after_title' => '</h3>',
  ) );

}
/** Register sidebars by running tableless_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'tableless_widgets_init' );


///
/// Deregister JetPack garbage
///
// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

// Then, remove each CSS file, one at a time
function jeherve_remove_all_jp_css() {
  wp_deregister_style( 'AtD_style' ); // After the Deadline
  wp_deregister_style( 'jetpack_likes' ); // Likes
  wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
  wp_deregister_style( 'jetpack-carousel' ); // Carousel
  wp_deregister_style( 'grunion.css' ); // Grunion contact form
  wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
  wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
  wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
  wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
  wp_deregister_style( 'noticons' ); // Notes
  wp_deregister_style( 'post-by-email' ); // Post by Email
  wp_deregister_style( 'publicize' ); // Publicize
  wp_deregister_style( 'sharedaddy' ); // Sharedaddy
  wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
  wp_deregister_style( 'stats_reports_css' ); // Stats
  wp_deregister_style( 'jetpack-widgets' ); // Widgets
  wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
  wp_deregister_style( 'presentations' ); // Presentation shortcode
  wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
  wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
  wp_deregister_style( 'widget-conditions' ); // Widget Visibility
  wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
  wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
  wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
  wp_deregister_style( 'jetpack-top-posts-widget' ); // Top Posts widget
  wp_deregister_style( 'jetpack-widgets' ); // Widgets
}
add_action('wp_print_styles', 'jeherve_remove_all_jp_css' );

?>
