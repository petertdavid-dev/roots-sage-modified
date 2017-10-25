<?php
/**
 * Shortcodes.
 */

/*
 *  Get image ID from URL
 */
function get_attachment_id_from_src( $url ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col( $wpdb->prepare( 'SELECT ID FROM ' . $prefix . 'posts' . " WHERE guid='%s';", $url ) );
	return $attachment[0];
}

/*
 *  Responsive shortcode
 */
function responsive_image( $atts ) {

	extract(
		shortcode_atts(
			array(
				'class' => '',
				'id' => '',
				'src' => '',
				'caption' => '',
				'picture' => '',
				'ispageheader' => 'false',
			), $atts
		)
	);

	if ( $id != '' ) {
		$img_ID = $id;
	} else {
		$img_ID = get_attachment_id_from_src( $src );
	}

	$imgAttr = ($ispageheader == 'true') ? ' itemprop="image" ' : '';

	// $image_thumb = wp_get_attachment_image_src( $img_ID );
	// $image_small = wp_get_attachment_image_src( $img_ID, 'rwd-small' );
	// $image_medium = wp_get_attachment_image_src( $img_ID, 'rwd-medium' );
	// $image_large = wp_get_attachment_image_src( $img_ID, 'rwd-large' );
	// $image_mediumx2 = wp_get_attachment_image_src( $img_ID, 'rwd-mediumx2' );
	// $image_xl = wp_get_attachment_image_src( $img_ID, 'rwd-xl' );
	// $image_largex2 = wp_get_attachment_image_src( $img_ID, 'rwd-largex2' );
	// $image_xlx2 = wp_get_attachment_image_src( $img_ID, 'rwd-xlx2' );
	$image_thumb = wp_get_attachment_image_src( $img_ID );
	$image_small = wp_get_attachment_image_src( $img_ID, 'rwd-medium' );
	$image_medium = wp_get_attachment_image_src( $img_ID, 'rwd-large' );
	$image_large = wp_get_attachment_image_src( $img_ID, 'rwd-mediumx2' );
	$image_mediumx2 = wp_get_attachment_image_src( $img_ID, 'rwd-xl' );
	$image_xl = wp_get_attachment_image_src( $img_ID, 'rwd-xl' );
	$image_largex2 = wp_get_attachment_image_src( $img_ID, 'rwd-xlx2' );
	$image_xlx2 = wp_get_attachment_image_src( $img_ID, 'rwd-xlx2' );

	$image_alt_text = ($caption != '') ? $caption : get_post_meta( $img_ID , '_wp_attachment_image_alt', true );

	$output = '';

	if ( $picture == 'true' ) {
		// object-fit isn't adopted by IE yet :(
		$output .= '<picture>';
			$output .= '<!--[if IE 9]><video style="display: none;"><![endif]-->';
			$output .= '<source srcset="' . $image_xl[0] . ', ' . $image_xlx2[0] . ' 2x" media="(min-width: 1200px)">';
			$output .= '<source srcset="' . $image_large[0] . ', ' . $image_largex2[0] . ' 2x" media="(min-width: 800px)">';
			$output .= '<source srcset="' . $image_medium[0] . ', ' . $image_mediumx2[0] . ' 2x" media="(min-width: 400px)">';
			$output .= '<source srcset="' . $image_medium[0] . ', ' . $image_mediumx2[0] . ' 2x">';
			$output .= '<!--[if IE 9]></video><![endif]-->';
			$output .= '<img class="' . $class . '" srcset="' . $image_medium[0] . ', ' . $image_mediumx2[0] . ' 2x" alt="' . $image_alt_text . '" ' . $imgAttr . ' >';
		$output .= '</picture>';
	} else {
		$output .= '<div alt="' . $image_alt_text . '"  ' . $imgAttr . ' class="rwd-background ' . $class . '" style="background-image:url(' . $image_small[0] . ');" ';
			$output .= ' data-rwd-small="' . $image_medium[0] . '" ';
			$output .= ' data-rwd-medium="' . $image_medium[0] . '" ';
				$output .= ' data-rwd-large="' . $image_large[0] . '" ';
				$output .= ' data-rwd-mediumx2="' . $image_mediumx2[0] . '" ';
				$output .= ' data-rwd-xl="' . $image_xl[0] . '" ';
				$output .= ' data-rwd-largex2="' . $image_largex2[0] . '" ';
				$output .= ' data-rwd-xlx2="' . $image_xlx2[0] . '" ';
			$output .= '></div>';
	}

	return $output;
}
add_shortcode( 'rimg', 'responsive_image' );


/*
 *  Sidebar navigation
 */
function sidebar_nav( $atts ) {

	$user = wp_get_current_user();
	$output = '';

	// Show conditional navigation.
	$navname = '';
	if ( in_array( 'employer', (array) $user->roles ) ) {
		$navname = 'employer';
	} elseif ( in_array( 'candidate', (array) $user->roles ) ) {
		$navname = 'jobseeker';
	} elseif ( ! is_user_logged_in() ) {
		$navname = 'loggedout';
	} else {
		$navname = 'loggedin';
	}

	if ( has_nav_menu( $navname . '_navigation' ) ) :
		$output .= wp_nav_menu(
			[
				'theme_location' => $navname . '_navigation',
				'container_class' => 'small sidebar_nav_shortcode',
				'menu_class' => 'nav flex-column',
				'echo' => false,
			]
		);
	endif;

	return $output;
}
add_shortcode( 'sidebar_nav', 'sidebar_nav' );



function mailchimp_form() {

	$html = '';

	$html .= '<div class="mailchimp-form">';
		$html .= '<form action="//greenstreetjobs.us16.list-manage.com/subscribe/post?u=dc6f2f59bb95cad632e3b3d7f&amp;id=279e56821f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';

			$html .= '<div id="mc_embed_signup_scroll" class="row">';
				$html .= '<div class="col-md-9">';
					$html .= '<label for="mce-EMAIL">Subscribe to the Haven Girl Newsletter</label>';
					$html .= '<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your email address" required>';
				$html .= '</div>';

				$html .= '<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_dc6f2f59bb95cad632e3b3d7f_279e56821f" tabindex="-1" value=""></div>';

				$html .= '<div class="clear col-md-3">
							<input type="submit" value="Add me!" name="subscribe" id="mc-embedded-subscribe" class="button">
						</div>';
			$html .= '</div>';
		$html .= '</form>';
	$html .= '</div>';

	return $html;
}
add_shortcode( 'mailchimp_form', 'mailchimp_form' );



/**
 * returns a random string for a class name
 */
function random_id() {
	$characters = 'abcdefghijklmnopqrstuvwxyz';
	$randomString = '';
	for ($i = 0; $i < 6; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}


function google_simple_marker_dynamic( $params = array() ) {

	extract(
		shortcode_atts(
			array(
				'fallback_img_id'   => '',
				'address'           => '',
				'zoom'              => 12,
				'height'            => '300px',
				'width'             => '100%',
			), $params
		)
	);

	// hijack the api code from the jobs plugin
	$options = get_option( 'avm_settings' );
	$api     = 'AIzaSyC1kXOPoBFRpJXbgeATk8YaqP93QFEVQJI';
	$address = strip_tags( $address );

	$mapstyles = '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a0d6d1"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#dedede"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#dedede"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f1f1f1"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]';

	$mapid = random_id();

	$map = '';

	$map .= '<script type="text/javascript" src="//maps.google.com/maps/api/js?key=' . $api . '&sensor=false"></script>';

	$map  .= "<script type='text/javascript'>


			function initialize() {

				var geocoder = new google.maps.Geocoder();
				var latitude;
				var longitude;

				geocoder.geocode( { 'address': '" . $address . "'}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {

			    		latitude = results[0].geometry.location.lat();
						longitude = results[0].geometry.location.lng();

						var myLatlng = new google.maps.LatLng(latitude, longitude);
						var mapOptions = {
							zoom: " . $zoom . ',
							center: myLatlng,
							styles: ' . $mapstyles . '
						};


						var ' . $mapid . "map = new google.maps.Map(document.getElementById('" . $mapid . "'), mapOptions);

						var " . $mapid . 'marker = new google.maps.Marker({
							position: myLatlng,
							map: ' . $mapid . "map,
							title: '" . $address . "',
						});

						google.maps.event.addListener(" . $mapid . "marker, 'click', function() {
						    window.open( 'https://maps.google.com/?q=" . urlencode( $address ) . "');
						});

			    	} else {

						document.getElementById('" . $mapid . "').style.display = 'none';

						if( document.getElementById('map-fallback-img_" . $mapid . "') ) {
							document.getElementById('map-fallback-img_" . $mapid . "').style.display = 'block';
						}

			    	}

				});


			}

			google.maps.event.addDomListener(window, 'load', initialize);

			</script>";

	$map .= "<div class='map-canvas' id='" . $mapid . "' style='height: " . $height . '; width: ' . $width . "'></div>";

	if ( $fallback_img_id !== '' ) {
		$map .= "<div id='map-fallback-img_" . $mapid . "' style='display: none;' >";
			$map .= do_shortcode( "[rimg id='" . $fallback_img_id . "' picture='true' ]" );
		$map .= '</div>';
	}

	return $map;

}
add_shortcode( 'googlemap_custom', 'google_simple_marker_dynamic' );

function cta_recent_posts( $params = array() ) {

	extract(
		shortcode_atts(
			array(
				'posts_per_page'   => '3',
			), $params
		)
	);

	$recent_posts = new WP_Query( array(
	    'post_type' => 'post',
	    'posts_per_page' => $posts_per_page,
	    'no_found_rows' => true,
	    'update_post_meta_cache' => false,
	    'update_post_term_cache' => false
	) );

	wp_reset_query();

	$html = '';

	$html .= '';

	foreach ($recent_posts->posts as $recent_post) {
		$html .= '<h2>'. $recent_post->post_title.'</h2>';
	}

	return $html;

}
add_shortcode( 'cta_recent_posts', 'cta_recent_posts' );
