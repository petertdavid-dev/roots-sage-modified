<?php
/**
 * Shortcodes based on bootstrap.
 */

function jumbotron( $atts, $content ) {

	global $post;

	extract(
		shortcode_atts(
			array(
				'elid'              => '',
				'id'                => '',
				'src'               => '',
				'class'             => '',
				'title'             => '',
				'ispageheader'      => '',
				'overlayclass'      => 'none',
				'innertext'         => '',
			), $atts
		)
	);

	$img_ID = '';
	$output = '';

	if ( $id != '' ) {
		$img_ID = $id;
	} elseif ( $src != '' ) {
		$img_ID = get_attachment_id_from_src( $src );
	}

	// add header class
	$class .= ($ispageheader == '' || $ispageheader == 'false') ? '' : ' jumbotron--pageheader ';

	// add overlay color classes
	$overlayBgClass = '';

	if ( ($img_ID !== '' ) && $overlayclass !== 'none' ) {
		$overlayBgClass .= 'jumbotron__overlay overlay_opacity bg-gradient-' . $overlayclass;
	}

	if ( $overlayclass == 'none' ) {
		// nuthin
	} elseif ( $overlayclass == 'white' ) {
		$class .= ' bg-' . $overlayclass;
	} elseif ( $overlayclass !== 'none' ) {
		$class .= ' text-white bg-gradient-' . $overlayclass;
	}

	if ( $img_ID !== '' ) {

		$output .= '<div id="' . $elid . '" class="jumbotron cover__container ' . $class . '" >';

		$output .= do_shortcode( '[rimg id="' . $img_ID . '" class="cover__img" ispageheader="' . $ispageheader . '" ]' );

	} else {

		$output .= '<div id="' . $elid . '" class="jumbotron ' . $class . '" >';

	}

		$output .= '<div class="' . $overlayBgClass . '" ></div>';

		$output .= '<div class="jumbotron__content container" ><div class="jumbotron__content_wrapper accent">';

	if ( $title ) {
		$output .= ( $ispageheader == 'true' ) ? '<div class="page-header"><h1 class="jumbotron__title" itemprop="headline">' . $title . '</h1></div>' : '<h2 class="jumbotron__title">' . $title . '</h2>';
	}

			$output .= '<div class="jumbotron__section">';
				// $output .= $innertext;
				$output .= do_shortcode( wpautop( urldecode( $innertext ) ) );
				$output .= do_shortcode( wpautop( urldecode( $content ) ) );
			$output .= '</div>';

		$output .= '</div></div>';

	$output .= '</div>';

	return $output;

}
add_shortcode( 'jumbotron', 'jumbotron' );


// Boostrap Row
function row_shortcode( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'class' => '',
			// 'columns' => '3'
			), $atts
		)
	);

	$html = '';
	$html .= '<div class="row' . $class . '">';
		$html .= do_shortcode( $content );
	$html .= '</div>';

	return $html;
}
add_shortcode( 'row', 'row_shortcode' );


// Boostrap Row
function col_shortcode( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'class' => 'col',
			// 'columns' => '3'
			), $atts
		)
	);

	$html = '';
	$html .= '<div class="' . $class . '">';
		$html .= do_shortcode( $content );
	$html .= '</div>';

	return $html;
}
add_shortcode( 'col', 'col_shortcode' );



// [lead class="Optional Class(es)"] [/lead]
function lead_shortcode( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'class' => '',
			), $atts
		)
	);

	if ( $class != '' ) {
		$class = ' ' . $class;
	}

	return '<span class="lead' . $class . '">' . do_shortcode( $content ) . '</span>';
}
add_shortcode( 'lead', 'lead_shortcode' );


// [icon class="" type="i"]
// See Icon Reference: http://bootplate.jdmdigital.co/features/font-icons/
function icon_shortcode( $atts ) {
	extract(
		shortcode_atts(
			array(
				'type' => 'i',
				'class' => '',
			), $atts
		)
	);

	return '<' . $type . ' class="' . $class . '"></' . $type . '>';

}
add_shortcode( 'icon', 'icon_shortcode' );



// [btn classes="btn-default" type="submit, reset, button, link (default)"] [/btn]
function btn_shortcode( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'classes' => 'btn btn-default',
				'id' => '',
			), $atts
		)
	);
	$classes = 'btn ' . $classes;

	return '<a href="' . $btnurl . '" class="' . $classes . '" role="button">' . do_shortcode( $content ) . '</a>';

}
add_shortcode( 'btn', 'btn_shortcode' );


// [card col="col-md-4" class="" imgsrc="" title="" subtitle="" link="" linktext="" ] [/card]
function card_shortcode( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'class' => '', // text-center,
			 'color' => '', // primary
			 'outline' => '', // danger, none
			 'header' => '',
			 'imgsrc' => '',
			 'imgstyle' => '',
			 'imgbkgd' => '',
			 'title' => '',
			 'subtitle' => '',
			 'link' => '',
			 'linktext' => '',
			 'btn' => '',
			 'btntext' => '',
			), $atts
		)
	);

	$class .= ( ! empty( $color ) || ! empty( $imgbkgd ) ) ? ' card-inverse ' : '';
	$card_outline = ( empty( $outline ) ) ? '' : ' card-outline-' . $outline . ' ';
	$card_img_class = ( ! empty( $imgbkgd ) ) ? '' : ' card-img-top ';
	$card_img_class .= ( empty( $imgstyle ) ) ? '' : ' card-img-top--' . $imgstyle . ' ';
	$card_block_class = ( ! empty( $imgbkgd ) ) ? ' card-img-overlay ' : ' card-block ';

	$html = '';

	$html .= '<div class="card ' . $class . ' ' . $card_outline . ' card-' . $color . '">';

	if ( $header != '' ) {
		$html .= '<h4 class="card-title">' . $header . '</h4>';
	}

	if ( $imgsrc != '' ) {
		$html .= '<img class="' . $card_img_class . '" src="' . $imgsrc . '" >';
	}

		$html .= '<div class="' . $card_block_class . '">';

	if ( $title != '' ) {
		$html .= '<h4 class="card-title">' . $title . '</h4>';
	}

	if ( $subtitle != '' ) {
		$subtitle .= '<h6 class="card-subtitle mb-2 text-muted">' . $subtitle . '</h6>';
	}

			$html .= '<p class="card-text">' . do_shortcode( $content ) . '</p>';

	if ( $link != '' && $linktext != '' ) {
		$html .= '<a class="card-link" href="' . $link . '">' . $linktext . '</a>';
	}

	if ( $btn != '' && $btntext != '' ) {
		$html .= '<a class="btn btn-primary" href="' . $btn . '">' . $btntext . '</a>';
	}

		$html .= '</div>'; // .card-block
	$html .= '</div>'; // .card

	return $html;
}
add_shortcode( 'card', 'card_shortcode' );





// shortcode for tabs
function tabs_func( $atts, $content ) {

	// extract short code attr
	extract(
		shortcode_atts(
			array(
				'tab1' => '',
				'tab2' => '',
				'tab3' => '',
				'tab4' => '',
				'tab5' => '',
				'tab6' => '',
				'tab7' => '',
				'tab8' => '',
				'tab9' => '',
				'tab10' => '',
			), $atts
		)
	);

	$tab_arr = array(
		$tab1,
		$tab2,
		$tab3,
		$tab4,
		$tab5,
		$tab6,
		$tab7,
		$tab8,
		$tab9,
		$tab10,
	);

	$html = '<ul class="nav nav-tabs" role="tablist">';

	foreach ( $tab_arr as $key => $tab ) {
		if ( ! empty( $tab ) ) {
			$class = ( $key + 1 == '1') ? 'active' : '';

			$html .= '<li class="nav-item">';
				$html .= '<a class="nav-link ' . $class . '" data-toggle="tab" href="#tabs-' . ($key + 1) . '" role="tab">';
					$html .= $tab;
				$html .= '</a>';
			$html .= '</li>';
		}
	}

	$html .= '</ul>';

	$html .= '<div class="tab-content">';
		$html .= do_shortcode( $content );
	$html .= '</div>';

	return $html;
}
add_shortcode( 'tabs', 'tabs_func' );


function tab_func( $atts, $content ) {

	// extract short code attr
	extract(
		shortcode_atts(
			array(
				'id' => '',
			), $atts
		)
	);

	$class = ( $id == '1') ? 'active' : '';

	$html = '';

	$html .= '<div class="tab-pane ' . $class . '" id="tabs-' . $id . '" role="tabpanel">';
		$html .= do_shortcode( $content );
	$html .= '</div>';

	return $html;
}
add_shortcode( 'tab', 'tab_func' );


function modal_func( $atts, $content ) {

	extract(
		shortcode_atts(
			array(
				'id' => '',
				'label' => '',
			), $atts
		)
	);

	$html = '';

	$html .= '<div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $label . '">';
		$html .= '<div class="modal-dialog modal-lg" role="document">';
			$html .= '<div class="modal-content">';
			$html .= '<a class="modal__close" href="#" data-dismiss="modal" aria-label="Close" ><i class="gsj-icon-close"></i></a>';
					$html .= do_shortcode( $content );
			$html .= '</div>';
		$html .= '</div>';
	$html .= '</div>';
	return $html;
}
add_shortcode( 'modal', 'modal_func' );


function collapse_func( $atts, $content ) {

	extract(
		shortcode_atts(
			array(
				'id' => '',
			), $atts
		)
	);

	$html = '';

	$html .= '<div class="collapse" id="' . $id . '">';
	  $html .= '<div class="card card-block">';
		$html .= do_shortcode( $content );
	  $html .= '</div>';
	$html .= '</div>';

	return $html;
}
add_shortcode( 'collapse', 'collapse_func' );
