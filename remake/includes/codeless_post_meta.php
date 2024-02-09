<?php

class Cl_Post_Meta{
    
    
    public static $meta = array();
    public $post_meta = array();
    
    public static function map($meta){
        if( ! function_exists( 'codeless_get_meta' ) )
            return;

        if( ! codeless_get_meta( $meta['meta_key'] ) )
            $meta['value'] = isset( $meta['default'] ) ? $meta['default'] : '';
        else
            $meta['value'] = codeless_get_meta( $meta['meta_key'] );

        self::$meta[] = $meta;
    }

    
}



Cl_Post_Meta::map(array(
   
   'post_type' => 'page',
   'feature' => 'page_options_title',
   'meta_key' => 'page_options_title',
   'control_type' => 'grouptitle',
   'label' => esc_attr__( 'Page Options', 'remake' ),
   'priority' => 1,
   'inline_control' => true,
   'id' => 'page_options_title',
   'transport' => 'auto', 
   'default' => 'default'
   
));


// ---------- Page Layout -------------
Cl_Post_Meta::map(array(
   
   'post_type' => array('page', 'post', 'portfolio'),
   'feature' => 'page_layout',
   'priority' => 2,
   'meta_key' => 'page_layout',
   'control_type' => 'kirki-select',
   'label' => esc_attr__( 'Page Layout', 'remake' ),
   'choices'     => array(
      'default'  => esc_attr__( 'Default', 'remake' ),
      'fullwidth' => esc_attr__( 'Fullwidth', 'remake' ),
      'left_sidebar' => esc_attr__( 'Left Sidebar', 'remake' ),
      'right_sidebar' => esc_attr__( 'Right Sidebar', 'remake' ),
      'dual' => esc_attr__( 'Dual', 'remake' ),
   ),
   'group_in' => 'general',
   'inline_control' => true,
   'id' => 'page_layout',
   'transport' => 'auto', 
   'default' => 'default'
   
));

// ---------- Page Fullwidth Content -------------
Cl_Post_Meta::map(array(
   
   'post_type' => 'page',
   'priority' => 2,
   'feature' => 'page_fullwidth_content',
   'meta_key' => 'page_fullwidth_content',
   'control_type' => 'kirki-select',
   'label' => esc_attr__('Page Fullwidth Content', 'remake' ),
   'tooltip' => esc_html__( 'Remove container from page and show page content from left of the screen to the right', 'remake' ),
   'choices'     => array(
      'off' => esc_attr__( 'Off', 'remake' ),
      'on'  => esc_attr__( 'On', 'remake' ),
   ),
   'group_in' => 'general',
   'inline_control' => true,
   'id' => 'page_fullwidth_content',
   'transport' => 'postMessage', 
   'default' => 0
   
));


Cl_Post_Meta::map(array(
   
   'post_type' => 'page',
   'priority' => 2,
   'feature' => 'page_header_active',
   'meta_key' => 'page_header_active',
   'control_type' => 'kirki-select',
   'label' => esc_attr__( 'Page Header & Breadcrumbs', 'remake' ),
   'tooltip' => '',
   'choices'     => array(
      'off' => esc_attr__( 'Off', 'remake' ),
      'on'  => esc_attr__( 'On', 'remake' ),
   ),
   'group_in' => 'general',
   'inline_control' => true,
   'id' => 'page_header_active',
   'transport' => 'postMessage', 
   'default' => 'off'
   
));


// ---------- Page BG Color -------------
Cl_Post_Meta::map(array(
   
   'post_type' => array('page', 'portfolio'),
   'priority' => 3,
   'feature' => 'page_bg_color',
   'meta_key' => 'page_bg_color',
   'control_type' => 'kirki-color',
   'tooltip' => esc_html__('Actual Page Content Background Color', 'remake' ),
   'label' => esc_html__( 'Page Content BG Color', 'remake' ),
   'default' => '',
   'group_in' => 'general',
   'inline_control' => true,
   'id' => 'page_bg_color',
   'transport' => 'postMessage'
   
));


Cl_Post_Meta::map(array(
   
   'post_type' => array('page', 'post', 'portfolio'),
   'feature' => 'scroll_indicator',
   'priority' => 2,
   'meta_key' => 'scroll_indicator',
   'control_type' => 'kirki-select',
   'label' => esc_html__('Scroll Indicator', 'remake' ),
   'tooltip' => esc_html__( 'Option to show a small Scroll indicator on top section of this page. Useful when using sliders or hero sections. Some sliders included with theme may include this by default. In that case, no need to activate this.', 'remake' ),
   'choices'     => array(
      'none'  => esc_attr__( 'None', 'remake' ),
      'left_side_light' => esc_attr__( 'Left Side Light (for dark bg)', 'remake' ),
      'left_side_dark' => esc_attr__( 'Left Side Dark (for light bg)', 'remake' ),
      'right_side_light' => esc_attr__( 'Right Side Light (for dark bg)', 'remake' ),
      'right_side_dark' => esc_attr__( 'Right Side Dark (for light bg)', 'remake' ),
   ),
   'group_in' => 'general',
   'inline_control' => true,
   'id' => 'scroll_indicator',
   'transport' => 'auto', 
   'default' => 'none'
   
));

Cl_Post_Meta::map(array(
   
   'post_type' => array('page', 'post', 'portfolio'),
   'feature' => 'extra_hero_widget',
   'priority' => 2,
   'meta_key' => 'extra_hero_widget',
   'control_type' => 'kirki-select',
   'label' => esc_html__('Extra Widget for Slider/Hero', 'remake' ),
   'tooltip' => esc_html__('Useful option for some particular layout of this theme. Use carefully! You can modify content on Widgets -> Extra Hero Widget', 'remake' ),
   'choices'     => array(
      'none'  => esc_attr__( 'None', 'remake' ),
      'right_vertical' => esc_attr__( 'Right Center Vertical Position', 'remake' ),
   ),
   'group_in' => 'general',
   'inline_control' => true,
   'id' => 'extra_hero_widget',
   'transport' => 'auto', 
   'default' => 'none'
   
));

Cl_Post_Meta::map(array(
   
   'post_type' => 'page',
   'feature' => 'divider_header_page',
   'meta_key' => 'divider_header_page',
   'control_type' => 'groupdivider',
   'label' => '',
   'priority' => 4,
   'inline_control' => true,
   'id' => 'divider_header_page',
   'transport' => 'auto', 
   'default' => 'default',
   
));

// --------- Header Color --------------------



// --------------------- Other Page dividers --------------------------------
Cl_Post_Meta::map(array(
   
   'post_type' => 'page',
   'feature' => 'other_page_options_divider',
   'meta_key' => 'other_page_options_divider',
   'control_type' => 'groupdivider',
   'label' => '',
   'priority' => 8,
   'inline_control' => true,
   'id' => 'other_page_options_divider',
   'transport' => 'auto', 
   'default' => 'default'
   
));

Cl_Post_Meta::map(array(
   'priority' => 9,
   'post_type' => 'page',
   'feature' => 'other_page_options_title',
   'meta_key' => 'other_page_options_title',
   'control_type' => 'grouptitle',
   'label' => 'WP Default',
   'inline_control' => true,
   'id' => 'other_page_options_title',
   'transport' => 'auto', 
   'default' => 'default'
   
));



// Post

Cl_Post_Meta::map(array(
   
   'post_type' => 'post',
   'feature' => 'post_header_style',
   'meta_key' => 'post_header_style',
   'control_type' => 'kirki-select',
   'label' => esc_html__('Post Header Style', 'remake' ),
   'choices'     => array(
      'default'  => esc_attr__( 'Default (Site Default)', 'remake' ),
      'no_image'  => esc_attr__( 'No Image', 'remake' ),
      'with_image' => esc_attr__( 'With Image', 'remake' )
   ),
   'inline_control' => true,
   'group_in' => 'post_data',
   'id' => 'post_header_style',
   'transport' => 'auto', 
   'default' => 'default',
   /*'cl_required'    => array(
         'setting'  => 'blog_style',
         'operator' => '==',
         'value'    => 'masonry',
   ),*/
   
));

?>