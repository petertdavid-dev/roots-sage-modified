<?php
/**
 * Add cmb2 meta boxes
 */

function page_content_metaboxes() {

	$prefix = 'hero';

	$metabox = new_cmb2_box(
		array(
			'id'            => $prefix . '_area',
			'title'         => 'Top Hero Content',
			'object_types'  => array( 'page' ), // Post type
		// 'show_on'      => array( 'key' => 'page-template', 'value' => 'default' ),
		// 'show_on_cb' => 'cmb_only_show_content_metaboxes',
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'side',
		'priority'   => 'high',
		)
	);

	$metabox->add_field(
		array(
			'name'              => 'Page Header (h1)',
			'desc'              => 'Page Title will be used if left blank',
			'id'                => $prefix . '_title',
			'type'              => 'text',
			'sanitization_cb'   => false,
		)
	);

	$metabox->add_field(
		array(
			'name'    => 'Content',
			'id'      => $prefix . '_wysiwyg',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 10 ),
			'sanitization_cb' => false,
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		)
	);

}
add_action( 'cmb2_admin_init', 'page_content_metaboxes' );




function page_repeating_content_metaboxes() {

	$prefix = 'repeating';

	$metabox = new_cmb2_box(
		array(
			'id'            => $prefix . '_area',
			'title'         => 'Additional Content Sections',
			'object_types'  => array( 'page' ), // Post type
			'priority'   => 'high',
		)
	);

	$group_field_id = $metabox->add_field(
		array(
			'id'          => $prefix . '-group',
			'type'        => 'group',
			// 'description' => 'Add a content section with a background color',
			 'options'     => array(
				 'group_title'   => 'Add a content section', // since version 1.1.4, {#} gets replaced by row number
				 'add_button'    => 'Add Another Section',
				 'remove_button' => 'Remove Section',
				 'sortable'      => true, // beta
			 ),
		)
	);

	$metabox->add_group_field(
		$group_field_id, array(
			'name' => 'Title',
			'id'   => $prefix . '-section-title',
			'type' => 'text',
		)
	);

	$metabox->add_group_field(
		$group_field_id, array(
			'name' => 'Content',
			'id'   => $prefix . '-wysiwyg',
			'type' => 'wysiwyg',
			'options' => array(
				'textarea_rows' => '5',
			),
			'sanitization_cb' => false,
		)
	);

	$metabox->add_group_field(
		$group_field_id, array(
			'name' => 'Background Image',
			'id'   => $prefix . '-bkgd-img',
			'type' => 'file',
			'options' => array(
				'url' => false,
			),
		)
	);

	// $metabox->add_group_field( $group_field_id, array(
	// 'name' => 'Background / Overlay Color',
	// 'id'   => $prefix . '-background-wysiwyg',
	// 'type' => 'radio_inline',
	// 'options' => array(
	// 'none'      => 'No overlay <br> ',
	// 'white'     => '<span class="opt_paintchip whitebg" ></span> White <br> ',
	// 'first'     => '<span class="opt_paintchip firstbg" ></span> Green <br> ',
				// 'tenth'		=> '<span class="opt_paintchip tenthbg" ></span> Green <br> ',
				// 'third'		=> '<span class="opt_paintchip thirdbg" ></span> Orange <br> ',
				// 'fourth'	=> '<span class="opt_paintchip fourthbg" ></span> Blue <br> ',
				// 'fifth'		=> '<span class="opt_paintchip fifthbg" ></span> Dark Grey <br> ',
				// 'sixth'		=> '<span class="opt_paintchip sixthbg" ></span> Sixth Color <br> ',
				// 'seventh'	=> '<span class="opt_paintchip seventhbg" ></span> Cream <br> ',
				// 'gradient'	=> '<span class="opt_paintchip gradientbg" ></span> Gradient <br> ',
				// 'gradientgreen'	=> '<span class="opt_paintchip gradientgreenbg" ></span> Green Gradient <br> ',
	// ),
	// 'default'    => 'none',
	// ) );
	// $metabox->add_group_field( $group_field_id, array(
	// 'name' => 'Section styling',
	// 'id'   => $prefix . '_section_styling',
	// 'type'    => 'multicheck',
	// 'options' => array(
	// 'addshadow'         => 'Add shadow',
	// 'nopadding'         => 'No vertical section padding',
	// 'nohorizpadding'    => 'No horizontal section padding',
	// 'halfbackground'    => 'Half size background image',
	// 'smallheader'       => 'Small Header style',
	// ),
	// 'select_all_button' => false
	// ) );
}
add_action( 'cmb2_admin_init', 'page_repeating_content_metaboxes' );

