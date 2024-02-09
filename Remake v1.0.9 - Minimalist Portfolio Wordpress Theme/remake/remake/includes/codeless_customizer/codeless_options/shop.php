<?php

Kirki::add_section( 'cl_shop', array(
	    'priority'    => 10,
	    'type' => '',
	    'title'       => esc_html__( 'Shop', 'remake' ),
	    'tooltip' => esc_html__( 'All Shop Options', 'remake' ),
	) );


		Kirki::add_field( 'cl_remake', array(
			'settings' => 'shop_columns',
			'label'    => esc_html__( 'Shop Columns', 'remake' ),
			'tooltip' => esc_html__( 'Select number of items to display per Row on SHOP Page', 'remake' ),
			'section'  => 'cl_shop',
			'type'     => 'select',
			'priority' => 10,
			'default'  => '3',
			'choices'     => array(
				'2'  => esc_attr__( '2 Columns', 'remake' ),
				'3'  => esc_attr__( '3 Columns', 'remake' ),
				'4'  => esc_attr__( '4 Columns', 'remake' ),
				'5'  => esc_attr__( '5 Columns', 'remake' ),
				'6'  => esc_attr__( '6 Columns', 'remake' ),
			),
		) );

		Kirki::add_field( 'cl_remake', array(
		    'type' => 'slider',
		    'settings' => 'shop_item_distance',
			'label' => esc_html__( 'Distance between items', 'remake' ),
			'default' => '15',
			'choices'     => array(
			'min'  => '0',
			'max'  => '30',
			'step' => '1',
							),
			'inline_control' => true,
			'section'  => 'cl_shop',
			'transport' => 'postMessage'
    	));

    	Kirki::add_field( 'cl_remake', array(
				'settings' => 'shop_animation',
				'label'    => esc_html__( 'Animation Type', 'remake' ),
				
				'section'  => 'cl_shop',
				'type'     => 'select',
				'priority' => 10,
				'default'  => 'bottom-t-top',
				'choices' => array(
					'none'	=> esc_html__( 'None', 'remake' ),
					'top-t-bottom' =>  esc_html__( 'Top-Bottom', 'remake' ),
					'bottom-t-top' =>	 esc_html__( 'Bottom-Top', 'remake' ),
					'right-t-left' =>  esc_html__( 'Right-Left', 'remake' ),
					'left-t-right' =>  esc_html__( 'Left-Right', 'remake' ),
					'alpha-anim' =>  esc_html__( 'Fade-In', 'remake' ),	
					'zoom-in' =>  esc_html__( 'Zoom-In', 'remake' ),	
					'zoom-out' =>  esc_html__( 'Zoom-Out', 'remake' ),
					'zoom-reverse' =>  esc_html__( 'Zoom-Reverse', 'remake' )
				),
				'transport' => 'postMessage'
	) );

    	Kirki::add_field( 'cl_remake', array(
			'settings' => 'shop_item_heading',
			'label'    => esc_html__( 'Shop Item Heading', 'remake' ),
			'section'  => 'cl_shop',
			'type'     => 'select',
			'priority' => 10,
			'default'  => 'h6',
			'choices'     => array(
				'h1'  => esc_attr__( 'H1', 'remake' ),
				'h2'  => esc_attr__( 'H2', 'remake' ),
				'h3'  => esc_attr__( 'H3', 'remake' ),
				'h4'  => esc_attr__( 'H4', 'remake' ),
				'h5'  => esc_attr__( 'H5', 'remake' ),
				'h6'  => esc_attr__( 'H6', 'remake' ),
			),
			'transport' => 'postMessage'
		) );


    	Kirki::add_field( 'cl_remake', array(
			'settings' => 'shop_pagination_style',
			'label'    => esc_html__( 'Shop Pagination Style', 'remake' ),
			'section'  => 'cl_shop',
			'type'     => 'select',
			'priority' => 10,
			'default'  => 'numbers',
			'choices'     => array(
				'numbers'  => esc_attr__( 'With Page Numbers', 'remake' ),
				'next_prev'  => esc_attr__( 'Next/Prev', 'remake' ),
				'load_more'  => esc_attr__( 'Load More Button', 'remake' ),
				'infinite_scroll'  => esc_attr__( 'Infinite Scroll', 'remake' ),
			),
			'transport' => 'refresh'
		) );

		Kirki::add_field( 'cl_remake', array(
			'settings' => 'shop_category_layout',
			'label'    => esc_html__( 'Shop Categories Layout', 'remake' ),
			'tooltip' => esc_html__( 'Select shop Product Categories page layout.', 'remake' ),
			'section'  => 'cl_shop',
			'type'     => 'select',
			'priority' => 10,
			'default'  => 'fullwidth',
			'choices'     => array(
				'fullwidth'  => esc_attr__( 'Fullwidth', 'remake' ),
				'left_sidebar'  => esc_attr__( 'Left Sidebar', 'remake' ),
				'right_sidebar'  => esc_attr__( 'Right Sidebar', 'remake' )
			),
		) );

		
?>