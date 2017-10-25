<?php  
/**
 * Fixes to make bootstrap work with WP and plugins.
 *
 */

function bootstrap_nav_class( $classes, $item ) {

    $classes[] = 'nav-item';

    return $classes;
}
add_filter( 'nav_menu_css_class', 'bootstrap_nav_class', 10, 2 );


function bootstrap_nav_link_class( $atts, $item, $args ) {

	$atts['class'] = 'nav-link';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bootstrap_nav_link_class', 10, 3 );


