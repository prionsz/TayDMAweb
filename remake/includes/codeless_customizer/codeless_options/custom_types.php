<?php

    Kirki::add_panel( 'cl_custom_types', array(
	    'priority'    => 20,
	    'type' => '',
	    'title'       => esc_html__( 'Custom Types', 'remake' ),
	    'tooltip' => esc_html__( 'All Custom Types Options', 'remake' ),
	) );
	    
	    
	    Kirki::add_section( 'cl_custom_portfolio', array(
    	    'title'          => esc_html__( 'Portfolio', 'remake' ),
    	    'description'    => esc_html__( 'All Portfolio Page and single options', 'remake' ),
    	    'panel'          => 'cl_custom_types',
    	    'type'			 => '',
    	    'priority'       => 160,
    	    'capability'     => 'edit_theme_options'
    	) );

    	Kirki::add_section( 'cl_custom_staff', array(
    	    'title'          => esc_html__( 'Staff', 'remake' ),
    	    'description'    => esc_html__( 'All Staff (Members) options', 'remake' ),
    	    'panel'          => 'cl_custom_types',
    	    'type'			 => '',
    	    'priority'       => 160,
    	    'capability'     => 'edit_theme_options'
    	) );
 
    	Kirki::add_section( 'cl_custom_testimonial', array(
    	    'title'          => esc_html__( 'Testimonial', 'remake' ),
    	    'description'    => esc_html__( 'All Testimonial options', 'remake' ),
    	    'panel'          => 'cl_custom_types',
    	    'type'			 => '',
    	    'priority'       => 160,
    	    'capability'     => 'edit_theme_options'
    	) );
    	

    	Kirki::add_field( 'cl_remake', array(

			'settings' => 'portfolio_slug',
			'label'    => esc_html__( 'Portfolio Slug', 'remake' ),
			'tooltip' => esc_html__( 'Used as prefix for portfolio items links', 'remake' ),
			'section'  => 'cl_custom_portfolio',
			'type'     => 'text',
			'default'  => 'portfolio',
			'transport' => 'postMessage'

			) );

			Kirki::add_field( 'cl_remake', array(

				'settings' => 'portfolio_cat_slug',
				'label'    => esc_html__( 'Portfolio Categories Slug', 'remake' ),
				'tooltip' => esc_html__( 'Used as prefix for portfolio categories links', 'remake' ),
				'section'  => 'cl_custom_portfolio',
				'type'     => 'text',
				'default'  => 'portfolio_entries',
				'transport' => 'postMessage'
	
				) );

    	Kirki::add_field( 'cl_remake', array(
			'settings' => 'single_portfolio_navigation',
			'label'    => esc_html__( 'Single Portfolio Nav ', 'remake' ),
			'tooltip' => esc_html__( 'Turn On / Off Portfolio Navigation functionalities', 'remake' ),
			'section'  => 'cl_custom_portfolio',
			'type'     => 'switch',
			'priority' => 10,
			'default'  => 1,
			'choices'     => array(
				1  => esc_attr__( 'Enable', 'remake' ),
				0 => esc_attr__( 'Disable', 'remake' ),
			),
		) );

			
			

?>