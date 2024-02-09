<?php



	Kirki::add_panel( 'cl_general', array(
	    'priority'    => 10,
	    'type' => '',
	    'title'       => esc_html__( 'General', 'remake' ),
	    'tooltip' => esc_html__( 'All General Options of theme', 'remake' ),
	) );




	/* General */
	Kirki::add_section( 'cl_general_options', array(
	    'title'          => esc_html__( 'Site Options', 'remake' ),
	    'description'    => esc_html__( 'Some options about responsive, favicon and other theme features.', 'remake' ),
	    'panel'          => 'cl_general',
	    'type'           => '',
	    'priority'       => 160,
	    'capability'     => 'edit_theme_options'
	) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'responsive_layout',
			'label'    => esc_html__( 'Responsive Layout', 'remake' ),
			'tooltip' => esc_html__( 'Turn On / Off Responsive functionalities', 'remake' ),
			'section'  => 'cl_general_options',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 1,
			'transport' => 'postMessage',
			'choices'     => array(
				1  => esc_attr__( 'Enable', 'remake' ),
				0 => esc_attr__( 'Disable', 'remake' ),
			),
		) );




		Kirki::add_field( 'cl_remake', array(
			'settings' => 'nicescroll',
			'label'    => esc_html__( 'Smooth scroll', 'remake' ),
			'tooltip' => esc_html__('Active smoothscroll over pages to make scrolling more fluid to create better user experience', 'remake' ),
			'section'  => 'cl_general_options',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 0,
			'transport' => 'postMessage',
			'choices'     => array(
				1  => esc_attr__( 'Enable', 'remake' ),
				0 => esc_attr__( 'Disable', 'remake' ),
			),
		) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'jpeg_quality',
			'label'    => esc_html__( 'JPEG Quality', 'remake' ),
			'section'  => 'cl_general_transitions',
			'type'     => 'slider',
			'priority' => 10,
			'default'  => 82,
			'choices'     => array(
				'min' => '0',
				'max' => '100',
				'step' => '1'
			),
			
		) );

	

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'back_to_top',
			'label'    => esc_html__( 'Back To Top', 'remake' ),
			'description'    => esc_html__( 'Enable this option to show the "Back to Top" button on site', 'remake' ),
			'section'  => 'cl_general_options',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 0,
			'choices'     => array(
				1  => esc_attr__( 'Show', 'remake' ),
				0 => esc_attr__( 'Hide', 'remake' ),
			),
			'transport' => 'postMessage'
		) );

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'mouse_cursor',
			'label'    => esc_html__( 'Custom Mouse Cursor', 'remake' ),
			'description'    => esc_html__( 'Enable this option to activate animated and modern mouse cursor', 'remake' ),
			'section'  => 'cl_general_options',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 0,
			'choices'     => array(
				1  => esc_attr__( 'Show', 'remake' ),
				0 => esc_attr__( 'Hide', 'remake' ),
			),
			'transport' => 'postMessage'
		) );

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'preload_effect',
			'label'    => esc_html__( 'Preloader Effect', 'remake' ),
			'description'    => esc_html__( 'Enable this option to activate preloader effect on page loading', 'remake' ),
			'section'  => 'cl_general_options',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 0,
			'choices'     => array(
				1  => esc_attr__( 'Show', 'remake' ),
				0 => esc_attr__( 'Hide', 'remake' ),
			),
			'transport' => 'postMessage'
		) );

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'preload_effect_type',
			'label'    => esc_html__( 'Preload Effect Style', 'remake' ),
			'tooltip' => esc_html__( '', 'remake' ),
			'section'  => 'cl_general_options',
			'type'     => 'select',
			'priority' => 10,
			'default'  => 'heavy',
			'choices'     => array(
				'heavy'  => esc_attr__( 'Heavy Animation', 'remake' ),
				'lighter'  => esc_attr__( 'Lighter Progress', 'remake' )
			),
			'required'    => array(
				array(
					'setting'  => 'preload_effect',
					'operator' => '==',
					'value'    => 1,
					'transport' => 'postMessage'
				),
								
			),
		) );
		

		Kirki::add_field( 'cl_remake', array(
			'type'        => 'textarea',
			'settings'    => '404_error_message',
			'label'       => esc_attr__( '404 Error Message', 'remake' ),
			'section'     => 'cl_general_options',
			'default'     => esc_html__('It looks like nothing was found at this location. Maybe try a search?', 'remake' ),
			'priority'    => 10,
			
			'transport' => 'postMessage'
		) );






	


	/* Custom Codes */
	Kirki::add_section( 'cl_general_custom_codes', array(
	    'title'          => esc_html__( 'Custom Codes', 'remake' ),
	    'description'    => esc_html__( 'HTML, JS, CSS custom codes. Add Google Analytics or anything else.', 'remake' ),
	    'panel'          => 'cl_general',
	    'priority'       => 160,
	    'type'			 => '',
	    'capability'     => 'edit_theme_options'
	) );


		Kirki::add_field( 'cl_remake', array(
			'type'        => 'code',
			'settings'    => 'custom_css',
			'label'       => esc_html__( 'Custom CSS', 'remake' ),
			'section'     => 'cl_general_custom_codes',
			'default'     => '',
			'priority'    => 10,
			'choices'     => array(
				'language' => 'css',
				'theme'    => 'monokai',
				'height'   => 250,
			),
			'transport' => 'postMessage'
		) );

		Kirki::add_field( 'cl_remake', array(
			'type'        => 'code',
			'settings'    => 'custom_html',
			'label'       => esc_html__( 'Custom HTML', 'remake' ),
			'section'     => 'cl_general_custom_codes',
			'default'     => '',
			'priority'    => 10,
			'choices'     => array(
				'language' => 'html',
				'theme'    => 'monokai',
				'height'   => 250,
			),
			'transport' => 'postMessage'
		) );


	/* Custom Codes */
	
		
		Kirki::add_section( 'cl_general_insta', array(
			'title'          => esc_html__( 'Instagram', 'remake' ),
			'description'    => esc_html__( 'Instagram Setup', 'remake' ),
			'panel'          => 'cl_general',
			'priority'       => 160,
			'type'			 => '',
			'capability'     => 'edit_theme_options'
		) );

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'instagram_feed_token',
			'label'    => esc_html__( 'Instagram Feed Token', 'remake' ),
			'tooltip' => esc_html__( '', 'remake' ),
			'section'  => 'cl_general_insta',
			'type'     => 'text',
			'priority' => 10,
			'default'  => '',
			'choices'     => array(
				1  => esc_attr__( 'On', 'remake' ),
				0 => esc_attr__( 'Off', 'remake' ),
			),
			'transport' => 'postMessage'
		
		) );

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'instagram_feed_userid',
			'label'    => esc_html__( 'Instagram Feed User Id', 'remake' ),
			'tooltip' => esc_html__( '', 'remake' ),
			'section'  => 'cl_general_insta',
			'type'     => 'text',
			'priority' => 10,
			'default'  => '',
			'choices'     => array(
				1  => esc_attr__( 'On', 'remake' ),
				0 => esc_attr__( 'Off', 'remake' ),
			),
			'transport' => 'postMessage',

		) );

		





?>