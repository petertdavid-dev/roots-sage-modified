<?php  
/**
 * Fixes for all the stuff that wordpress does that we don't like.
 *
 */

// Remove script that fixes inline js in old versions of WP.
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


// Remove jquery-migrate.
function dequeue_jquery_migrate( $scripts ) {
	if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
		$jquery_dependencies = $scripts->registered['jquery']->deps;
		$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
	}
}
add_action( 'wp_default_scripts', 'dequeue_jquery_migrate' );


// Add ie conditional html5 shim to header.
function add_ie_html5_shim () {
	echo '<!--[if lt IE 9]>';
	echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
	echo '<![endif]-->';
}
add_action('wp_head', 'add_ie_html5_shim');


/**
 * Disable open graph in jetpack > conflicts with wordpress seo by Yoast.
 */
add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );


/**
 * gsj fix shortcodes.
 */
function gsj_fix_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'gsj_fix_shortcodes');


// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');


// Remove image links.
function attachment_image_link_remove_filter( $content ) {

	$content = preg_replace(
		array(
			'{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}',
			'{ wp-image-[0-9]*" /></a>}'
		),
		array( '<img', '" />' ),
		$content
	);

	return $content;

}
add_filter( 'the_content', 'attachment_image_link_remove_filter' );


/**
 * Remove Query Strings From Static Resources.
 */
function gsj_remove_script_version($src){
	$parts = explode('?', $src);
	return $parts[0];
}


/**
 * Remove Read More Jump.
 */
function gsj_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

// Remove stuff from the head.
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// Remove 'hentry' from post_class.
function sr_remove_hentry( $classes ) {
    $classes = array_diff( $classes, array( 'hentry' ) );

    return $classes;
}
add_filter( 'post_class','sr_remove_hentry' );

/* Disable WordPress Admin Bar for all users but admins. */
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

