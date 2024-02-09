<?php

    Kirki::add_panel( 'cl_custom_types', array(
	    'priority'    => 10,
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
		    			'settings' => 'portfolio_style',
		    			'label'    => esc_html__( 'Portfolio Style', 'remake' ),
		    			'tooltip' => esc_html__( 'Select style of portfolio pages', 'remake' ),
		    			'section'  => 'cl_custom_portfolio',
		    			'type'     => 'select',
						'priority' => 10,
						'default'  => 'default',
						'choices'     => array(
							'default'  => esc_attr__( 'Default', 'remake' ),
							'alternate'  => esc_attr__( 'Alternate', 'remake' ),
							'minimal'  => esc_attr__( 'Minimal', 'remake' ),
							'timeline'  => esc_attr__( 'Timeline', 'remake' ),
							'grid'  => esc_attr__( 'Grid', 'remake' ),
							'masonry' => esc_attr__( 'Masonry', 'remake' ),
						),
		    			'transport' => 'postMessage',
		
		    		) );

?>