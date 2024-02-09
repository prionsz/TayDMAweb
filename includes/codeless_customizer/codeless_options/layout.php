<?php

Kirki::add_section( 'cl_layout', array(
	    'priority'    => 10,
	    'type' => '',
	    'title'       => esc_html__( 'Layout', 'remake' ),
	    'tooltip' => esc_html__( 'Overall site layout options', 'remake' ),
	) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'layout',
			'label'    => esc_html__( 'All Pages Layout', 'remake' ),
			'tooltip' => esc_html__( 'The general website layout. This can be overwrite from Blog Layout and from single page/post layouts', 'remake' ),
			'section'  => 'cl_layout',
			'type'     => 'select',
			'priority' => 10,
			'default'  => 'fullwidth',
			'choices'     => array(
				'fullwidth'  => esc_attr__( 'Fullwidth', 'remake' ),
				'left_sidebar'  => esc_attr__( 'Left Sidebar', 'remake' ),
				'right_sidebar'  => esc_attr__( 'Right Sidebar', 'remake' ),
				'dual_sidebar'  => esc_attr__( 'Dual Sidebar', 'remake' )
			),
		) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'boxed_layout',
			'label'    => esc_html__( 'Boxed Layout', 'remake' ),
			'tooltip' => esc_html__( 'Switch on if you want to make all page boxed', 'remake' ),
			'section'  => 'cl_layout',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 0,
			'choices'     => array(
				1  => esc_attr__( 'On', 'remake' ),
				0 => esc_attr__( 'Off', 'remake' ),
			),
			'transport' => 'postMessage',
		) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'boxed_layout_width',
			'label'    => esc_html__( 'Boxed Wrapper Width', 'remake' ),
			'tooltip' => esc_html__( 'Define boxed wrapper width in pixel.', 'remake' ),
			'section'  => 'cl_layout',
			'type'     => 'slider',
			'priority' => 10,
			'default'  => '1200',
			'choices'     => array(
				'min'  => '970',
				'max'  => '1600',
				'step' => '10',
			),
			'inline_control' => true,
			'transport' => 'auto',
			'output' => array(
				array(
					'element' => '.cl-boxed-layout',
					'units' => 'px',
					'property' => 'width',
					'media_query' => '@media (min-width: 992px)'
				),
			),
			'required'    => array(
				array(
					'setting'  => 'boxed_layout',
					'operator' => '==',
					'value'    => true,
					'transport' => 'postMessage'
				),
								
			),
		) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'layout_container_width',
			'label'    => esc_html__( 'Site Container Width', 'remake' ),
			'tooltip' => esc_html__( 'Define site container width in pixel. A max-width:100% is set to not destroy the layout on smaller screens. It\'s applied on min-width media screens: 1200px', 'remake' ),
			'section'  => 'cl_layout',
			'type'     => 'slider',
			'priority' => 10,
			'default'  => '1100',
			'choices'     => array(
				'min'  => '970',
				'max'  => '1600',
				'step' => '10',
			),
			'inline_control' => true,
			'transport' => 'auto',
			'output' => array(
				array(
					'element' => '.container',
					'units' => 'px',
					'property' => 'width',
					'media_query' => '@media (min-width: 1200px)'
				),
			)
		) );

		
		

		
		
		Kirki::add_field( 'cl_remake', array(
			'settings' => 'inner_content_padding_top',
			'label'    => esc_html__( 'Inner Content Distance from Top', 'remake' ),
			'tooltip' => esc_html__( 'Define the default distance of Inner Content ( Content / Sidebar ) from Header ( Header / Page Header / Other inserted elements ). Usable with: Pages without page builder, blog, defined page templates, posts.', 'remake' ),
			'section'  => 'cl_layout',
			'type'     => 'slider',
			'priority' => 10,
			'default'  => '120',
			'choices'     => array(
				'min'  => '0',
				'max'  => '200',
				'step' => '1',
			),
			'inline_control' => true,
			'transport' => 'auto',
			'output' => array(
				array(
					'element' => '.inner-content-row, .single_blog_style-classic.cl-layout-fullwidth',
					'units' => 'px',
					'property' => 'padding-top'
				),
			)
		) );
		
		Kirki::add_field( 'cl_remake', array(
			'settings' => 'inner_content_padding_bottom',
			'label'    => esc_html__( 'Inner Content Distance from Bottom', 'remake' ),
			'tooltip' => esc_html__( 'Define the default distance of Inner Content ( Content / Sidebar ) from Footer. Usable with: Pages without page builder, blog, defined page templates, posts.', 'remake' ),
			'section'  => 'cl_layout',
			'type'     => 'slider',
			'priority' => 10,
			'default'  => '120',
			'choices'     => array(
				'min'  => '0',
				'max'  => '200',
				'step' => '1',
			),
			'inline_control' => true,
			'transport' => 'auto',
			'output' => array(
				array(
					'element' => '.inner-content-row',
					'units' => 'px',
					'property' => 'padding-bottom'
				),
			)
		) );


?>