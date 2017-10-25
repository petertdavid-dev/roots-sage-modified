<?php
/**
 * General Theme functions.
 */


function content_areas( $pageid = null, $addHeader = false ) {

	global $post;

	// var_dump($post);
	$pageid = ( $pageid ) ? $pageid : get_the_id();
	$field_data = get_post_meta( $pageid, 'repeating-group', false );

	$count = 0;

	if ( empty( $field_data ) ) return;

	foreach ( $field_data[0] as $single_field ) {

		$title = ( ! empty( $single_field['repeating-section-title'] ) ) ? $single_field['repeating-section-title'] : '';
		$content = ( ! empty( $single_field['repeating-wysiwyg'] ) ) ? $single_field['repeating-wysiwyg'] : '';
		$imgbackground = ( isset( $single_field['repeating-bkgd-img_id'] ) ) ? $single_field['repeating-bkgd-img_id'] : '';
		// $overlay = ( ! empty( $single_field['repeating-background-wysiwyg'] ) )?$single_field['repeating-background-wysiwyg']:'';
		// $isPageHeader = ( ( $count == 0 && is_page() ) || ( $count == 0 && $addHeader ) )?'true':'false';
		// $section_styling = ( ! empty( $single_field['repeating_section_styling'] ) )?$single_field['repeating_section_styling']:'';
		$class = '';

		// if (is_array($section_styling)) {
		// foreach ( $section_styling as $section_style ){
		// $class .= ' rbkgd--' . $section_style . ' ';
		// }
		// }
		$count++;

		// echo do_shortcode('[jumbotron id="'. $hero_img .'" class="'. $class .'" background="primary" ispageheader="true" title="'. $hero_title .'" overlayclass="inverse" ]'. $hero_wysiwyg .'[/jumbotron]');
		echo do_shortcode( '[jumbotron elid="section' . $count . '" id="' . $imgbackground . '" title="' . $title . '" class="' . $class . ' clearfix"  innertext="' . urlencode( $content ) . '" ][/jumbotron]' );

	}
}


// Add woocommerce support
// function woocommerce_support() {
// add_theme_support( 'woocommerce' );
// }
// add_action( 'after_setup_theme', 'woocommerce_support' );
