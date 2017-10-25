<?php use Roots\Sage\Titles; ?>

<?php 

  $hero_title = get_post_meta( $post->ID, 'hero_title', true);

  if ( empty( $hero_title ) ) {
  	$hero_title = Titles\title();
  }

  $class = ' bg-inverse text-white ';
  $hero_styles = get_post_meta( $post->ID, 'side_hero_styles', true);

  if ( ! empty( $hero_styles ) ) {
	  foreach ($hero_styles as $style) {
		  $class = ' img--' . $style . ' ';
	  }
  }

  $hero_wysiwyg = get_post_meta( $post->ID, 'hero_wysiwyg', true);
  $hero_img = get_post_thumbnail_id( $post->ID );

  // If there isn't an image just show a page title.
  if ( empty( $hero_img ) ) {
    echo '<div class="container">';
      echo '<h1>'. $hero_title .'</h1>';
      echo '<p>'. $hero_wysiwyg .'</p>';
    echo '</div>';
  } else {
    echo do_shortcode('[jumbotron id="'. $hero_img .'" class="'. $class .'" background="primary" ispageheader="true" title="'. $hero_title .'" overlayclass="inverse" ]'. $hero_wysiwyg .'[/jumbotron]');
  }



