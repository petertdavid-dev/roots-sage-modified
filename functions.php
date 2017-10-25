<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
	'lib/assets.php',    // Scripts and stylesheets.
    'lib/bootstrap-fixes.php',    // Make WP and plugins work with bootstrap.
    'lib/extras.php',    // Custom functions.
    'lib/setup.php',     // Theme setup.
    'lib/titles.php',    // Page titles.
    'lib/wrapper.php',   // Theme wrapper class.
    'lib/customizer.php', // Theme customizer.
    'lib/theme-functions.php', // Theme functions.
    'lib/shortcodes.php', // Shortcodes.
    'lib/shortcodes-bootstrap.php', // Shortcodes for bootstrap components.
    'lib/cmb2-metaboxes.php', // Theme customizer.
    'lib/wordpress-fixes.php', // Fix wordpress.
];

foreach ( $sage_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'sage' ), $file ), E_USER_ERROR );
	}

	require_once $filepath;
}
unset( $file, $filepath );
