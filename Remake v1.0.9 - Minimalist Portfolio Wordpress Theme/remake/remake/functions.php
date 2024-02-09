<?php

/**
 * Remake functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Remake
 * @subpackage Functions
 * @since 1.0
 */

if ( ! isset( $content_width ) )
	$content_width = 1070;

// Load Codeless Framework Constants
require_once( get_template_directory() . '/includes/core/codeless_constants.php' );

// Load Customizer Control Types
//include_once( get_template_directory() . '/includes/codeless_customizer/kirki/kirki.php' );

// Load Required Plugins Tool
require_once( get_template_directory().'/includes/core/codeless_required_plugins.php' );
require_once( get_template_directory().'/includes/codeless_post_meta.php' );

//Demo Importer
require_once( get_template_directory().'/includes/codeless_theme_panel/importer/codeless_importer.php' );

/**
 * All Start here...
 * 
 * @since 1.0.0
 */
function codeless_setup(){

    // Register Nav Menus Locations to use
    codeless_navigation_menus();
    // Load Codeless Customizer files and Options
    codeless_load_customizer();
    // Load All Codeless Framework Files
    codeless_load_framework();

    // Language and text-domain setup
    add_action('init', 'codeless_language_setup');

    // Register Scripts and Styles
    add_action('wp_enqueue_scripts', 'codeless_register_global_styles');
    add_action('wp_enqueue_scripts', 'codeless_register_global_scripts');

    // Https filters
    add_filter( 'https_ssl_verify', '__return_false' );
    add_filter( 'https_local_ssl_verify', '__return_false' );

    // WP features that this theme supports
    codeless_theme_support();
    // Create Custom Image Sizes
    codeless_images_sizes(); 
    

    // Widgets
    codeless_load_widgets();
    codeless_register_widgets();  

    update_option( 'elementor_disable_color_schemes', 'yes' );
    update_option( 'elementor_disable_typography_schemes', 'yes' );

    add_filter( 'ce_portfolio_slug', 'codeless_set_portfolio_slug' );
    add_filter( 'ce_portfolio_cat_slug', 'codeless_set_portfolio_cat_slug' );

    update_option( '_elementor_editor_upgrade_notice_dismissed', time()*1000 );
}

add_action( 'after_setup_theme', 'codeless_setup' );

function codeless_set_portfolio_slug(){
    return codeless_get_mod( 'portfolio_slug', 'portfolio' );
}

function codeless_set_portfolio_cat_slug(){
    return codeless_get_mod( 'portfolio_cat_slug', 'portfolio_entries' );
}

function codeless_switch_theme(){
    update_option( 'elementor_disable_color_schemes', 'no' );
    update_option( 'elementor_disable_typography_schemes', 'no' );
}
add_action( 'switch_theme', 'codeless_switch_theme' );

/**
 * After theme activation
 * 
 * @since 1.0.0
 */
function codeless_after_switch_theme(){
    wp_redirect('admin.php?page=codeless-panel');
}

add_action( 'after_switch_theme', 'codeless_after_switch_theme' );


/**
 * Load Customizer Related Options and Customizer Cotrols Classes
 * 
 * @since 1.0.0
 */
function codeless_load_customizer() {

    // Load and Initialize Codeless Customizer
    include_once( get_template_directory() . '/includes/codeless_customizer/codeless_customizer_config.php' );
}


/**
 * Load all Codeless Framework Files
 * 
 * @since 1.0.0
 */
function codeless_load_framework() {

    // Register all Theme Hooks (add_action, add_filter)
    require_once( get_template_directory() . '/includes/codeless_hooks.php' );

    // Codeless Routing Templates and Custom Type Queries
    require_once( get_template_directory().'/includes/core/codeless_routing.php' );
    

    // Register all theme related sidebars
    require_once( get_template_directory().'/includes/register/register_sidebars.php' );


    // Load all functions that are responsable for Extra Classes and Extra Attrs
    require_once( get_template_directory().'/includes/codeless_html_attrs.php' );

    // Load all blog related functions
    require_once( get_template_directory().'/includes/codeless_functions_blog.php' );

    // Load Theme Panels
    require_once( get_template_directory().'/includes/codeless_theme_panel/codeless_backpanel.php' );
    require_once( get_template_directory().'/includes/codeless_theme_panel/codeless_theme_panel.php' );
   
    require_once( get_template_directory().'/includes/codeless_theme_panel/codeless_custom_sidebars.php' ); 
    
    // Image Resize - Module - Resize image only when needed
    require_once( get_template_directory().'/includes/core/codeless_image_resize.php' );

    // Load Comment Walker
    require_once( get_template_directory().'/includes/core/codeless_comment_walker.php' );

    // Fallback Class for Header when Codeless Builder Plugin is not active

    // Load Woocommerce Functions
    if( class_exists( 'Woocommerce' ) )
        require_once( get_template_directory().'/includes/codeless_functions_woocommerce.php' );
}





/**
 * Load Codeless Custom Widgets
 * 
 * @since 1.0.0
 */
function codeless_load_widgets() {
    require_once get_template_directory().'/includes/widgets/codeless_mostpopular.php';
    require_once get_template_directory().'/includes/widgets/codeless_shortcodewidget.php';
    require_once get_template_directory().'/includes/widgets/codeless_socialwidget.php';
    require_once get_template_directory().'/includes/widgets/codeless_twitter.php';
    require_once get_template_directory().'/includes/widgets/codeless_ads.php';
    require_once get_template_directory().'/includes/widgets/codeless_instagram.php';
    require_once get_template_directory().'/includes/widgets/codeless_about.php';
}


/**
 * Setup Language Directory and theme text domain
 * 
 * @since 1.0.0
 */
function codeless_language_setup() {
    $lang_dir = get_template_directory() . '/lang';
    load_theme_textdomain('remake', $lang_dir);
} 


/**
 * Gutenberg Editor CSS
 * 
 * @since 1.0.0
 */

add_action( 'enqueue_block_editor_assets', 'codeless_gutenberg_css', 999 );
function codeless_gutenberg_css(){
    wp_enqueue_style(
		'codeless-guten-css', // Handle.
		get_template_directory_uri() . '/css/gutenberg-editor.css', // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
    );

    $body_type = codeless_get_mod( 'body_typo', array( 'font-family' => 'Inter', 'font-size' => '16px', 'line-height' => '28px', 'color' => '#000000' ) );
    $headings_typo = codeless_get_mod( 'headings_typo', array( 'font-family' => 'DM Sans' ) );

    $custom_font_link = add_query_arg( array(
		'family' => str_replace( '%2B', '+', urlencode( implode( '|', array( $body_type['font-family'], $headings_typo['font-family'] ) ) . ':400,500,600,700'  ) )
	), 'https://fonts.googleapis.com/css' );

	wp_enqueue_style( 'codeless-guten-font-family', $custom_font_link  );
    
    $dynamic_styles = '.editor-post-title__block .editor-post-title__input{ font-family:\''.$headings_typo['font-family'].'\'; font-weight:700; font-size: 34px; line-height:42px; color:#383838; }';
    $dynamic_styles .= '.editor-styles-wrapper .wp-block-quote div p{ font-size:'.$body_type['font-size'].' !important; font-weight:400; }';
    $dynamic_styles .= '.editor-styles-wrapper .wp-block-quote__citation{ font-weight: 500; font-style: normal; font-size:16px; }';
    
    $dynamic_styles .= '.editor-styles-wrapper{ font-family: '.$body_type['font-family'].' !important; line-height:'.$body_type['line-height'].' !important; font-size:'.$body_type['font-size'] .'; -webkit-font-smoothing: antialiased !important;   }';

    $dynamic_styles .= '.editor-styles-wrapper .wp-block-paragraph:not(.has-small-font-size):not(.has-large-font-size):not(.has-larger-font-size), .editor-styles-wrapper li{ font-size:'.$body_type['font-size'].' !important;  }';
    $dynamic_styles .= '.editor-styles-wrapper p.has-drop-cap:not(:focus):first-letter { color: '.codeless_get_mod('primary_color').'; } ';    
    $dynamic_styles .= '.editor-styles-wrapper p:not(.has-text-color):not(.wp-block-cover-text):not(.wp-block-pullquote), .editor-styles-wrapper .wp-block-quote__citation { color:'.$body_type['color'].' !important; }'; 
    $dynamic_styles .= '.editor-styles-wrapper h1, .editor-styles-wrapper h2, .editor-styles-wrapper h3, .editor-styles-wrapper h4, .editor-styles-wrapper h5, .editor-styles-wrapper h6{ font-family:\''.$headings_typo['font-family'].'\'; font-weight:600; color: #444; }';
    
    $dynamic_styles .= ' .editor-styles-wrapper .wp-block-quote p{ font-family:\''.$body_type['font-family'].'\';}';
    $dynamic_styles .= '.editor-styles-wrapper .wp-block[data-type="core/cover"] .wp-block[data-type="core/paragraph"] p{ font-size: 24px !important; color:#fff !important; }';
    $dynamic_styles .= '.editor-styles-wrapper .wp-block-pullquote:not(.has-text-color) p:not(.has-text-color):not(.wp-block-cover-text):not(.wp-block-pullquote{ color:#40464d !important; }';

    $dynamic_styles .= '.editor-styles-wrapper h1{ font-size:'.codeless_get_mod( 'h1_font_size', '34px').'; font-weight:bold; }';
    $dynamic_styles .= '.editor-styles-wrapper h2{ font-size:'.codeless_get_mod( 'h2_font_size', '28px').'; text-transform:'.codeless_get_mod( 'h2_text_transform', 'uppercase').'; }';
    $dynamic_styles .= '.editor-styles-wrapper h3{ font-size:'.codeless_get_mod( 'h3_font_size', '18px').'; }';
    $dynamic_styles .= '.editor-styles-wrapper h4{ font-size:'.codeless_get_mod( 'h4_font_size', '16px').'; }';
    $dynamic_styles .= '.editor-styles-wrapper h5{ font-size:'.codeless_get_mod( 'h5_font_size', '14px').'; text-transform:'.codeless_get_mod( 'h5_text_transform', 'uppercase').';}';
    $dynamic_styles .= '.editor-styles-wrapper h6{ font-size:'.codeless_get_mod( 'h6_font_size', '12px').';text-transform:'.codeless_get_mod( 'h6_text_transform', 'uppercase').'; }';

    

    wp_add_inline_style( 'codeless-guten-css', $dynamic_styles );
}


/**
 * Add Theme Supports
 * 
 * @since 1.0.0
 */
function codeless_theme_support(){
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'codeless_testt', 740, 490, true );
    require_once( get_template_directory().'/includes/codeless_theme_panel/codeless_image_sizes.php' );
    
    add_theme_support('woocommerce');
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-slider' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support('nav_menus');
    add_theme_support( 'post-formats', array( 'quote', 'gallery','video', 'audio', 'link' ) ); 
    add_theme_support( "title-tag" );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    // Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    $logo_defaults = array(
        'height'      => 18,
        'width'       => 89,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
        'default-image' => get_template_directory_uri() . '/img/logo.png',
    );
    add_theme_support( 'custom-logo', $logo_defaults );
}


/**
 * Regster Theme Related Image Sizes
 * 
 * @since 1.0.0
 */
function codeless_images_sizes(){
    // Empty
}


/**
 * Register Navigation Menus
 * 
 * @since 1.0.0
 */
function codeless_navigation_menus(){
    $navigations = array('main' => 'Main Navigation');

    foreach($navigations as $id => $name){ 
    	register_nav_menu($id, THEMETITLE.' '.$name); 
    }
}


/**
 * Regster Loaded Widgets
 * 
 * @since 1.0.0
 */ 
function codeless_register_widgets(){
    if( !function_exists( 'codeless_widget_register' ) )
        return;

	codeless_widget_register( 'CodelessTwitter' );
    codeless_widget_register( 'CodelessSocialWidget' );
    codeless_widget_register( 'CodelessShortcodeWidget' );
    codeless_widget_register( 'CodelessMostPopularWidget');
    codeless_widget_register( 'CodelessAdsWidget');
    codeless_widget_register( 'CodelessInstagram' );
    codeless_widget_register( 'CodelessAboutMe' );
}


/**
 * Enqueue all needed styles
 * 
 * @since 1.0.0
 */
function codeless_register_global_styles(){ 

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('codeless-style', get_stylesheet_uri());
    wp_enqueue_style('codeless-theme', get_template_directory_uri() . '/css/theme.min.css');

    if( !class_exists( 'Kirki' ) )
        wp_enqueue_style('codeless-default', get_template_directory_uri() . '/css/codeless-default.css' );



    
    if( function_exists('is_woocommerce') && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ){ 
        wp_enqueue_style('select2', get_template_directory_uri() . '/css/select2.min.css');
    }

    wp_enqueue_style('feather', get_template_directory_uri() . '/css/feather.css', null, '1.0.0');
    wp_enqueue_style('codeless-remake-icons', get_template_directory_uri() . '/css/codeless-remake-icons.css', null, '1.0.0');

    // Create Dynamic Styles
    wp_enqueue_style( 'codeless-dynamic', get_template_directory_uri() . '/css/codeless-dynamic.css');
    
    
    /* Load Custom Dynamic Style and enqueue them with wp_add_inline_style */
    ob_start();
    codeless_custom_dynamic_style();
    $styles = ob_get_clean();

    wp_add_inline_style( 'codeless-dynamic', apply_filters( 'codeless_register_styles', $styles ) );    
}


/**
 * Enqueue all global scripts
 * 
 * @since 1.0.0
 * @version 2.1
 */
function codeless_register_global_scripts(){
    
    $needed_js = array( 'jquery', 'imagesloaded' );

    if( codeless_get_mod( 'preload_effect', false ) && strpos($request_uri, 'elementor') === false  ){
        if( codeless_get_mod( 'preload_effect_type', 'heavy' ) == 'heavy' ){
            wp_enqueue_script( 'three', get_template_directory_uri() . '/js/three.min.js' );
            wp_enqueue_script( 'orbit-controls', get_template_directory_uri() . '/js/OrbitControls.js' );
            wp_enqueue_script( 'fast-simplex-noise', get_template_directory_uri() . '/js/fast-simplex-noise.js' );
            wp_enqueue_script( 'pace', get_template_directory_uri() . '/js/pace.min.js' );
            wp_enqueue_script( 'codeless-page-loader-momentum', get_template_directory_uri() . '/js/page-loader-momentum.js', array( 'three', 'orbit-controls', 'fast-simplex-noise', 'pace' ) );

            $needed_js[] = 'codeless-page-loader-momentum'; 
        }else{
            wp_enqueue_script( 'pace', get_template_directory_uri() . '/js/pace.min.js' );
        }
    }


    wp_enqueue_script( 'codeless-main', get_template_directory_uri() . '/js/codeless-main.js', $needed_js );
    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'bowser', get_template_directory_uri() . '/js/bowser.min.js' );


    if( ( codeless_get_mod( 'nicescroll', false ) && !is_customize_preview() ) )
        wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js' ); 

    if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
        // Load comment-reply.js
        wp_enqueue_script( 'comment-reply' );
    }

    wp_localize_script(
        'codeless-main',
        'codeless_global',
        array(
            'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
            'FRONT_LIB_JS' => esc_url( get_template_directory_uri() . '/js/' ),
            'FRONT_LIB_CSS' => esc_url( get_template_directory_uri() . '/css/' ),
            'postSwiperOptions' => codeless_get_post_slider_options(),
            'cl_btn_classes' => esc_attr( codeless_button_classes() ),
            'cursorColor' => esc_attr( codeless_get_mod( 'cursor_color', '#000000' ) ),
            'is_customize_preview' => is_customize_preview(),
            'preloader' => codeless_get_mod( 'preload_effect', false ) && strpos($request_uri, 'elementor') === false,
            'preloader_type' => codeless_get_mod( 'preload_effect_type', 'heavy' )
            // Blog Slider Data
            
        )
    );
}

/**
 * Load all styles from register_styles.php
 * Added with wp_add_inline_style on codeless_register_global_styles, action wp_enqueue_scripts
 * @since 1.0.0
 */
function codeless_custom_dynamic_style(){
    include get_template_directory().'/includes/register/register_styles.php';
}


/**
 * Apply Filters for given tag.
 * Use: add_filter('codeless_extra_classes_wrapper') for ex,
 * will add a custom class at wrapper html tag
 * 
 * @since 1.0.0
 * @version 1.0.3
 */
 
function codeless_extra_classes($tag){
    
    if( empty($tag) )
        return '';
      
    $classes = apply_filters('codeless_extra_classes_'.$tag, array()); 
    return (!empty($classes) ? implode(" ", $classes) : '');
}


/**
 * Apply Filters for given tag.
 * Use: add_filter('codeless_extra_attr_viewport') for ex,
 * will add a custom attr at viewport html tag
 * 
 * @since 1.0.0
 * @version 1.0.3
 */
 
function codeless_extra_attr($tag){
    
    if( empty($tag) )
        return '';
      
    $attrs = apply_filters('codeless_extra_attr_'.$tag, array()); 
    return (!empty($attrs) ? implode(" ", $attrs) : '');
}


/**
 * Core Function: Return the value of a specific Mod
 * 
 * @since 1.0.0
 */
function codeless_get_mod( $id, $default = '', $sub_array = '' ){

    //For Online

    global $codeless_online_mods, $cl_from_element;

    if( isset($cl_from_element[$id]) && !empty($cl_from_element[$id]) ){
        return $cl_from_element[$id];
    }

    if( isset($codeless_online_mods[$id])  && ! is_customize_preview() ){
        return $codeless_online_mods[$id];
    }

    if($default == '')
        $default = codeless_theme_mod_default($id);


    if ( is_customize_preview() ) {
        
        if($sub_array == '')
            return get_theme_mod( $id, $default );
        else if(isset($var[$sub_array])){
            $var = get_theme_mod( $id, $default );
            return $var[$sub_array];
        }
    }
    
    global $cl_theme_mods;
    
    if ( ! empty( $cl_theme_mods ) ) {

        if ( isset( $cl_theme_mods[$id] ) ) {

            if($sub_array == '')
                return $cl_theme_mods[$id];
            else
                return $cl_theme_mods[$id][$sub_array];
        }

        else {
            return $default;
        }

    }

    else {

        if($sub_array == '')
            return get_theme_mod( $id, $default );
        else if(isset($var[$sub_array])){
            $var = get_theme_mod( $id, $default );
            return $var[$sub_array];
        }
    }

}






/**
 * Get the Default Value of a theme mod from Codeless Options
 * 
 * @since 1.0.0
 */
function codeless_theme_mod_default($id){

    if( class_exists('Kirki') && isset( Kirki::$fields[$id] ) && isset( Kirki::$fields[$id]['default'] ) && ! empty( Kirki::$fields[$id]['default'] ) )
        return Kirki::$fields[$id]['default'];
    else
        return '';
}

/**
 * Add Meta in page Metabox plugin
 * 
 * @since 2.0.0
 */
add_filter( 'rwmb_meta_boxes', 'codeless_register_meta_boxes_inpage' );
function codeless_register_meta_boxes_inpage( $meta_boxes ) {
    if( ! class_exists('Cl_Post_Meta') )
        return array();
    // all meta
    $meta = codeless_transform_meta_inpage( Cl_Post_Meta::$meta );

    if( isset( $meta['general'] ) )
        $meta_boxes[] = array(
            'id'         => 'general',
            'title'      => esc_html__( 'General', 'remake' ),
            'post_types' => array('page', 'post', 'portfolio', 'product' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'fields' => $meta['general']
        );
    
    if( isset( $meta['post_data'] ) )
        $meta_boxes[] = array(
            'id'         => 'post_data',
            'title'      => esc_html__( 'Post Data', 'remake' ),
            'post_types' => array( 'post' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'fields' => $meta['post_data']
        );
    if( isset( $meta['portfolio_data'] ) )
        $meta_boxes[] = array(
            'id'         => 'portfolio_data',
            'title'      => esc_html__( 'Portfolio Data', 'remake' ),
            'post_types' => array( 'portfolio' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'fields' => $meta['portfolio_data']
        );

        
    if( isset( $meta['staff_data'] ) )
        $meta_boxes[] = array(
            'id'         => 'staff_data',
            'title'      => esc_html__( 'Staff Data', 'remake' ),
            'post_types' => array( 'staff' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'fields' => $meta['staff_data']
        );

    if( isset( $meta['testimonial_data'] ) )
        $meta_boxes[] = array(
            'id'         => 'testimonial_data',
            'title'      => esc_html__( 'Testimonial Data', 'remake' ),
            'post_types' => array( 'testimonial' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'fields' => $meta['testimonial_data']
        );

    if( isset( $meta['staff_social'] ) )
        $meta_boxes[] = array(
            'id'         => 'staff_social',
            'title'      => esc_html__( 'Staff Social', 'remake' ),
            'post_types' => array( 'staff' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'fields' => $meta['staff_social']
        );


    return $meta_boxes;
}


function codeless_transform_meta_inpage($post_metas){

    $organized_metas = array();

    foreach( $post_metas as $meta ){
        $new_meta = array();
        foreach($meta as $key => $value){
            
            if( $key == 'label' )
                $new_meta['name'] = $value;

            if( $key == 'choices' )
                $new_meta['options'] = $value;

            

            if( $key == 'meta_key' )
                $new_meta['id '] = $value;

            if( $key == 'default' )
                $new_meta['std'] = $value;

            if( $key == 'tooltip' )
                $new_meta['desc'] = $value;

            if( $key == 'multiple' )
                $new_meta['multiple'] = true;

        }

        $new_meta['id'] = $meta['meta_key'];

        if( $meta['control_type'] == 'kirki-switch' ){
            $new_meta['options'] = array(
                0 => 'Off',
                1 => 'On'
            );
        }
        
        if( $meta['control_type'] == 'kirki-select' || $meta['control_type']== 'kirki-switch'  )
            $new_meta['type'] = 'select';
        else if( $meta['control_type'] == 'kirki-color'  )
            $new_meta['type'] = 'color';
        else if( $meta['control_type'] == 'textarea' )
            $new_meta['type'] = 'wysiwyg';
        else if( $meta['control_type'] == 'select_advanced' ){
            $new_meta['type'] = 'select_advanced';
        }
        else{
            $new_meta['type'] = $meta['control_type'];
        }


        if( isset( $meta['group_in'] ) )
            $organized_metas[ $meta['group_in'] ][ $new_meta['id'] ] = $new_meta;
    }

    return $organized_metas;
}




/**
 * Check if is modern layout
 * @since 1.0.0
 */
function codeless_is_layout_modern(){
    $layout_modern = codeless_get_mod( 'layout_modern', false );

    if( codeless_get_meta( 'layout_modern', false ) != 'default' &&  codeless_get_meta( 'layout_modern', false ) != '' ){
        $layout_modern = codeless_get_meta( 'layout_modern', false );
    }

    return $layout_modern;
}


/**
 * Loop Counter
 * @since 1.0.0
 */
function codeless_loop_counter( $i = false ){
    global $codeless_loop_counter;
    
    if( $i !== false )
        $codeless_loop_counter = $i;
    
    return $codeless_loop_counter;
}


/**
 * Select and output sidebar for current page
 * @since 1.0.0
 */
function codeless_get_sidebar(){
    
    // Get current page layout
    $layout = codeless_get_page_layout();
  
    // No sidebar if fullwidth layout
    if( $layout == 'fullwidth' )
        return;
    
    // Load custom sidebar template for dual
    if( $layout == 'dual_sidebar' ){
        get_sidebar( 'dual' );
        return;
    }
    
    // For left/right sidebar layouts get default sidebar template
    get_sidebar();
    
}


/**
 * Two functions used for creating a wrapper for sticky sidebar
 * @since 1.0.0
 */
function codeless_sticky_sidebar_wrapper(){
    echo '<div class="cl-sticky-wrapper">';
}
function codeless_sticky_sidebar_wrapper_end(){
    echo '</div><!-- .cl-sticky-wrapper -->';
}


/**
 * Determine if page uses a left/right sidebar or a fullwidth layout
 * @since 1.0.0 
 */
function codeless_get_page_layout(){
    
    global $codeless_page_layout;

    // Make a test and save at the global variable to make the function works faster
    if(!isset($codeless_page_layout) || empty($codeless_page_layout) || (isset($codeless_page_layout) && !$codeless_page_layout) || is_customize_preview() ){
    
        // Default 
        $codeless_page_layout = codeless_get_mod( 'layout', 'fullwidth' );
        
        
        // Check if query is a blog query
        if( codeless_is_blog_query() && codeless_get_mod( 'blog_layout', 'right_sidebar' ) != 'none' )
            $codeless_page_layout = codeless_get_mod( 'blog_layout', 'right_sidebar' );
        
        // Blog Post layout
        if( is_single() && get_post_type( codeless_get_post_id() ) == 'post' )
            $codeless_page_layout = codeless_get_mod( 'blog_post_layout', 'right_sidebar' );       
       
        // Add single page layout check here
        if( codeless_get_meta( 'page_layout', 'default' ) != 'default' )
            $codeless_page_layout = codeless_get_meta( 'page_layout', 'default');

        if( function_exists('is_product_category') && is_product_category() )
            $codeless_page_layout = codeless_get_mod( 'shop_category_layout', 'fullwidth' ); 

        if( is_archive() )
            $codeless_page_layout = codeless_get_mod( 'blog_archive_layout', 'fullwidth' );


        // if no sidebar is active return 'fullwidth'
        if( ! codeless_is_active_sidebar() )
            $codeless_page_layout = 'fullwidth';

        // Apply filter and return
        $codeless_page_layout = apply_filters( 'codeless_page_layout', $codeless_page_layout );

    }
    return $codeless_page_layout;
}



/**
 * Generate Content Column HTML class based on layout type
 * @since 1.0.0
 */
function codeless_content_column_class(){
    
    // Get page layout
    $layout = codeless_get_page_layout();
    
    // First part of class "col-sm-"
    $col_class = codeless_cols_prepend();
    
    if( $layout == 'fullwidth' )
        $col_class .= '12';
    elseif( $layout == 'dual_sidebar' )
        $col_class .= '6';
    else
        $col_class .= '8';

    
    return $col_class;
    
}


/**
 * HTML / CSS Column Class Prepend
 * @since 1.0.0
 */
function codeless_cols_prepend(){
    return apply_filters( 'codeless_cols_prepend', 'col-sm-' );
}


/**
 * Buttons Style (Classes)
 * @since 1.0.0
 * @version 1.0.3
 */
function codeless_button_classes( $classes = array(), $overwrite = false, $postID = false ){
    
    if( !is_array( $classes ) )
        $classes = array();

    if( ! $overwrite ){
        $classes[] = 'cl-btn';

        $btn_style = codeless_get_mod( 'button_style', 'rounded' );

        $classes[] = 'btn-style-' . $btn_style;
        $classes[] = 'btn-effect-' . codeless_get_mod( 'button_effect', 'default' );
    }

    $classes = apply_filters( 'codeless_button_classes', $classes );
    
    return (!empty($classes) ? implode(" ", $classes) : '');
}



/**
 * Convert Width (1/2 or 1/3 etc) to col-sm-6... 
 * @since 1.0.0
 */
function codeless_widthToSpan( $width ) {
    preg_match( '/(\d+)\/(\d+)/', $width, $matches );

    if ( ! empty( $matches ) ) {
        $part_x = (int) $matches[1];
        $part_y = (int) $matches[2];
        if ( $part_x > 0 && $part_y > 0 ) {
            $value = ceil( $part_x / $part_y * 12 );
            if ( $value > 0 && $value <= 12 ) {
                $width = codeless_cols_prepend() . $value;
            }
        }
    }

    return $width;
}



/**
 * Extract Page Header Shortcode from Content
 * @since 1.0.0
 */
function codeless_extract_page_header($content){
    $pattern = get_shortcode_regex(array('cl_page_header'));
    preg_match('/'.$pattern.'/s', $content, $matches);
    if (is_array($matches) && isset($matches[2]) ) {
       $shortcode = $matches[0];
       return $shortcode;
    }
}


/**
 * Add Default page title for core wordpress pages.
 * @since 1.0.0
 */
function codeless_add_default_page_title(){

}


/**
 * Add content of Blog Page at the top of page before the loop
 * @since 1.0.0
 */
function codeless_add_page_header(){
    $id = get_the_ID();

    if( function_exists( 'is_shop' ) && is_shop() )
        $id = woocommerce_get_page_id('shop');
        
    if( codeless_get_meta( 'page_header_active', 'off', $id ) == 'on' || is_archive() || ( !function_exists( 'codeless_widget_register' ) && is_singular('page') ) || is_search() )
        get_template_part( 'template-parts/page-header' );
}


/**
 * Displays the generated output from header builder
 * or output the default header layout
 * 
 * @since 1.0.0
 */
function codeless_show_header(){
    //default header
    get_template_part('template-parts/header/default');
}



/**
 * Return true if have widget on given page sidebar
 * 
 * @since 1.0.0
 */
function codeless_is_active_sidebar(){

    return is_active_sidebar( codeless_get_sidebar_name() );
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 * 
 * @global int $content_width
 * @since 1.0.0
 */
function codeless_content_width() {
    
	global $content_width;
	
	if( codeless_get_page_layout() != 'fullwidth' ){
	    $content_width = 795;

	    
	    if( codeless_get_page_layout() == 'dual_sidebar' )
	        $content_width = 520;
	}

	// Blog Alternate
	if( codeless_is_blog_query() && codeless_blog_style() == 'alternate' && ! is_single() ){
	    $content_width = 500;
	}
	
	// Blog Grid
	if( codeless_is_blog_query() && codeless_is_blog_isotope() && ! is_single() ){
	    $content_width = 500;
	}

}
add_action( 'template_redirect', 'codeless_content_width' );


/**
 * Return the exact thumbnail size to use for portfolio
 *
 * @since 1.0.0
 */
function codeless_get_portfolio_thumbnail_size(){
    global $codeless_masonry_size;

    $portfolio = codeless_get_mod( 'portfolio_image_size', 'portfolio_entry' );

    if( codeless_get_mod( 'portfolio_layout', 'grid' ) == 'masonry' ){

        if( isset( $codeless_masonry_size ) && !empty( $codeless_masonry_size ) )
            $portfolio = 'masonry_' . $codeless_masonry_size;
        else{

            $meta = codeless_get_meta( 'portfolio_masonry_layout', 'default', get_the_ID() );
          
            if( $meta != 'default' && !empty( $meta ) )
                $portfolio = 'masonry_' . $meta;

            if( $meta == 'default' )
                $portfolio = 'masonry_small';
        }

    }

    $codeless_masonry_size = '';

    return $portfolio;
}  

/**
 * Return the exact thumbnail size to use for team
 *
 * @since 1.0.0
 */
function codeless_get_team_thumbnail_size(){
    $team = codeless_get_mod( 'team_image_size', 'team_entry' );
    return $team;
}  


/**
 * Array of Custom Image Sizes
 * Can be modified by user in Theme Panel
 *
 * @since 1.0.0
 */
add_filter( 'codeless_image_sizes', 'codeless_image_sizes' );
function codeless_image_sizes(){
    
    $default = array(
        'blog_entry'  => array(
			'label'   => esc_html__( 'Blog Entry', 'remake' ),
			'width'   => 'blog_entry_image_width',
			'height'  => 'blog_entry_image_height',
			'crop'    => 'blog_entry_image_crop',
			'section' => 'blog',
            'description' => esc_html__('Used as default for all blog images.', 'remake' ),
		),
		
		'blog_entry_small'  => array(
			'label'   => esc_html__( 'Blog Entry Small', 'remake' ),
			'width'   => 'blog_entry_small_image_width',
			'height'  => 'blog_entry_small_image_height',
			'crop'    => 'blog_entry_small_image_crop',
			'section' => 'blog',
            'description' => esc_html__('Used for Blog Grid and Carousels, News, Media, Alternate', 'remake'),
			'defaults' => array( '740', '490', 'center-center' )
		),	
		
		'blog_post'  => array(
			'label'   => esc_html__( 'Blog Post', 'remake' ),
			'width'   => 'blog_post_image_width',
			'height'  => 'blog_post_image_height',
			'crop'    => 'blog_post_image_crop',
			'section' => 'blog',
		),

        'portfolio_entry'  => array(
            'label'   => esc_html__( 'Portfolio Entry', 'remake' ),
            'width'   => 'portfolio_entry_image_width',
            'height'  => 'portfolio_entry_image_height',
            'crop'    => 'portfolio_entry_image_crop',
            'section' => 'portfolio',
            'description' => esc_html__('Used as default for all portfolio grid.', 'remake' ),
        ),

        'masonry_small'  => array(
            'label'   => esc_html__( 'Masonry Small', 'remake' ),
            'width'   => 'masonry_small_image_width',
            'height'  => 'masonry_small_image_height',
            'crop'    => 'masonry_small_image_crop',
            'section' => 'portfolio',
            'description' => esc_html__('Used as default for small masonry item.', 'remake' ),
            'defaults' => array( '500', '500', 'center-center' )
        ),

        'masonry_large'  => array(
            'label'   => esc_html__( 'Masonry Large', 'remake' ),
            'width'   => 'masonry_large_image_width',
            'height'  => 'masonry_large_image_height',
            'crop'    => 'masonry_large_image_crop',
            'section' => 'portfolio',
            'description' => esc_html__('Used as default for large masonry item.', 'remake' ),
            'defaults' => array( '1000', '1000', 'center-center' )
        ),

        'masonry_wide'  => array(
            'label'   => esc_html__( 'Masonry Wide', 'remake' ),
            'width'   => 'masonry_wide_image_width',
            'height'  => 'masonry_wide_image_height',
            'crop'    => 'masonry_wide_image_crop',
            'section' => 'portfolio',
            'description' => esc_html__('Used as default for wide masonry item.', 'remake' ),
            'defaults' => array( '1000', '500', 'center-center' )
        ),

        'masonry_long'  => array(
            'label'   => esc_html__( 'Masonry Long', 'remake' ),
            'width'   => 'masonry_long_image_width',
            'height'  => 'masonry_long_image_height',
            'crop'    => 'masonry_long_image_crop',
            'section' => 'portfolio',
            'description' => esc_html__('Used as default for wide masonry item.', 'remake' ),
            'defaults' => array( '500', '1000', 'center-center' )
        ),

        'team_entry'  => array(
            'label'   => esc_html__( 'Team Entry', 'remake' ),
            'width'   => 'team_entry_image_width',
            'height'  => 'team_entry_image_height',
            'crop'    => 'team_entry_image_crop',
            'section' => 'team',
            'description' => esc_html__('Used as default for all team members', 'remake' ),
        ),

        'slider_thumb'  => array(
            'label'   => esc_html__( 'Slider Thumbnail', 'remake' ),
            'width'   => 'slider_thumb_width',
            'height'  => 'slider_thumb_height',
            'crop'    => 'slider_thumb_crop',
            'section' => 'other',
            'defaults' => array( '200', '200', 'center-center' ),
            'description' => esc_html__('', 'remake' ),
        ),

	);

    $custom = codeless_get_mod('cl_custom_img_sizes', array());
    if( empty( $custom ) )
        return $default;

    foreach( $custom as $new ){
        $default[$new] = array(
            'label'   => esc_html__( 'Custom', 'remake' ) . ': ' . $new,
            'width'   => $new . '_image_width',
            'height'  => $new . '_image_height',
            'crop'    => $new . '_image_crop',
            'section' => 'other',
            'description' => '',
        );
    }

    return $default;
}



/**
 * Array of image crop positions
 *
 * @since 1.0.0
 */
function codeless_image_crop_positions() {
	return array(
		''              => esc_html__( 'Default', 'remake' ),
		'left-top'      => esc_html__( 'Top Left', 'remake' ),
		'right-top'     => esc_html__( 'Top Right', 'remake' ),
		'center-top'    => esc_html__( 'Top Center', 'remake' ),
		'left-center'   => esc_html__( 'Center Left', 'remake' ),
		'right-center'  => esc_html__( 'Center Right', 'remake' ),
		'center-center' => esc_html__( 'Center Center', 'remake' ),
		'left-bottom'   => esc_html__( 'Bottom Left', 'remake' ),
		'right-bottom'  => esc_html__( 'Bottom Right', 'remake' ),
		'center-bottom' => esc_html__( 'Bottom Center', 'remake' ),
	);
}


/**
 * Resize the Image (first time only)
 * Replace SRC attr with the new url created
 * 
 * @since 1.0.0
 */
function codeless_post_thumbnail_attr( $attr, $attachment, $size){
    
    if( is_array($size) && $size['bfi_thumb'] )
        return $attr;

    if( is_admin() )
        return $attr;
    
    $size_attr = array();
    $additional_sizes = codeless_wp_get_additional_image_sizes();
    
    
    if( get_post_type( get_the_ID() ) == 'post' && codeless_get_mod( 'blog_lazyload', false ) ){
        $attr['class'] .= ' lazyload ';
        $attr['data-original'] = codeless_get_attachment_image_src($attachment->ID, $size);
        unset($attr['src']);
    }

    if( is_string( $size ) && ! isset($additional_sizes[ $size ] ) )
        return $attr;
    
    if( ! codeless_get_mod( 'optimize_image_resizing', true ) )
        return $attr;
        
    if( is_string( $size ) )
        $size_attr = $additional_sizes[ $size ];
      
    $image = codeless_image_resize( array(
		'image'  => $attachment->guid,
		'width'  => isset($size_attr['width']) ? $size_attr['width'] : '',
		'height' => isset($size_attr['height']) ? $size_attr['height'] : '',
		'crop'   => isset($size_attr['crop']) ? $size_attr['crop'] : ''
	));
	
	
	$image_meta = wp_get_attachment_metadata($attachment->ID);

    if( isset( $image['url'] ) && !empty( $image['url'] ) )
        $attr['src'] = $image['url'];
    
    // Replace old url and width with new cropped url and width
    if( isset( $attr['srcset'] ) && ! empty( $attr['srcset'] ) ){
        $attr['srcset'] = str_replace($attachment->guid, $image['url'], $attr['srcset']);

        if( ! empty( $image['width'] ) )
            $attr['srcset'] = str_replace($image_meta['width'], $image['width'], $attr['srcset']);
    }
    
    $attr['sizes'] = '(max-width: '.$image['width'].'px) 100vw, '.$image['width'].'px';

    if( codeless_get_from_element( 'portfolio_layout' ) == 'masonry' )
        $attr['sizes'] = '(max-width:767px) 100vw, ' . $image['width'].'px';

	return $attr;
} 

add_filter('wp_get_attachment_image_attributes', 'codeless_post_thumbnail_attr', 10, 3);


/**
 * Resize the Image (first time only)
 * Return the resized image url
 * 
 * @since 1.0.0
 */
function codeless_get_attachment_image_src( $attachment_id, $size = false ){
    
    if( $size === false )
        $size = 'full';
    
    $src = wp_get_attachment_image_src( $attachment_id, 'full' );
    
    $size_attr = array();
    $additional_sizes = codeless_wp_get_additional_image_sizes();
    
    if( is_array( $size ) || ! isset( $additional_sizes[ $size ] ) )
        return $src[0];
    
    $size_attr = $additional_sizes[ $size ];

    if( is_array( $size_attr ) && ! empty( $src ) ){
        
        $image = codeless_image_resize( array(
    		'image'  => $src[0],
    		'width'  => isset($size_attr['width']) ? $size_attr['width'] : '',
    		'height' => isset($size_attr['height']) ? $size_attr['height'] : '',
    		'crop'   => isset($size_attr['crop']) ? $size_attr['crop'] : ''
    	));
    	
    	return $image['url'];
    	
    }
	
	return $src[0];
	
}


/**
 * Removes width and height attributes from image tags
 *
 * @param string $html
 *
 * @return string
 * @since 1.0.0
 */
function codeless_remove_image_size_attributes( $html ) {
    return preg_replace( '/(width|height)="\d*"/', '', $html );
}
 
// Remove image size attributes from post thumbnails
//add_filter( 'post_thumbnail_html', 'codeless_remove_image_size_attributes' );


/**
 * List of share buttons and links
 * 
 * @since 1.0.0
 */
function codeless_share_buttons( $for_element = false ){
    
    // Get current page URL 
    $url = urlencode(get_permalink());
 
    // Get current page title
    $title = str_replace( ' ', '%20', get_the_title());
        
    // Get Post Thumbnail for pinterest
    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
    
    $shares = array();

    
    $share_option = codeless_get_mod( 'blog_share_buttons', array( 'twitter', 'pinterest', 'facebook' ) );
    
    if( $for_element )
        $share_option = array( 'twitter', 'facebook', 'google', 'whatsapp', 'linkedin', 'pinterest' );
    
    // Construct sharing URL without using any script
    if( in_array( 'twitter', $share_option ) ){
        $shares['twitter']['link'] = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url;
        $shares['twitter']['icon'] = 'cl-icon-twitter';
    }

    
    if( in_array( 'facebook', $share_option ) ){
        $shares['facebook']['link'] = 'https://www.facebook.com/sharer/sharer.php?u='.$url;
        $shares['facebook']['icon'] = 'cl-icon-facebook';
    }
    
    if( in_array( 'google', $share_option ) ){
        $shares['google']['link'] = 'https://plus.google.com/share?url='.$url;
        $shares['google']['icon'] = 'cl-icon-google';
    }
    
    if( in_array( 'whatsapp', $share_option ) ){
        $shares['whatsapp']['link'] = 'whatsapp://send?text='.$title . ' ' . $url;
        $shares['whatsapp']['icon'] = 'cl-icon-whatsapp';
    }
    
    if( in_array( 'linkedin', $share_option ) ){
        $shares['linkedin']['link'] = 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&amp;title='.$title;
        $shares['linkedin']['icon'] = 'cl-icon-linkedin';
    }
    
    if( in_array( 'pinterest', $share_option ) ){
        
        $image = '';
        if( is_array( $thumbnail ) && isset( $thumbnail[0] ) )
            $image = $thumbnail[0];
        $shares['pinterest']['link'] = 'https://pinterest.com/pin/create/button/?url='.$url.'&amp;media='.$image.'&amp;description='.$title;
        $shares['pinterest']['icon'] = 'cl-icon-pinterest';
    }
    
    
    return apply_filters( 'codeless_share_buttons', $shares, $title, $url, $thumbnail );
}


/**
 * Change default excerpt length
 *
 * @since 1.0.0
 */
function codeless_custom_excerpt_length( $length ) {
	return codeless_get_mod( 'blog_excerpt_length', 40 );
}
add_filter( 'excerpt_length', 'codeless_custom_excerpt_length', 990 );


/**
 * Get first url on content if post format is LINK
 *
 * @since 1.0.0
 */
function codeless_get_permalink( $id ){
    
    $link = get_permalink( $id );
    
    if( get_post_format() == 'link' )
        $link = get_url_in_content( get_the_content() );

    return $link;
    
}


/**
 * Returns fallback for Menu.
 * 
 * @since 1.0.0
 */

if(!function_exists('codeless_default_menu')){
  
    function codeless_default_menu($args){
        
      $current = "";
      if (is_front_page())
        $current = "class='current-menu-item'";
      
      echo "<ul class='menu'>";

        echo "<li $current><a href='".esc_url(home_url())."'>Home</a></li>";
        wp_list_pages('title_li=&sort_column=menu_order&number=2&depth=0');

      echo "</ul>";

    }
}



/**
 * Basic Pagination Output of theme
 * 
 * @since 1.0.0
 */
function codeless_number_pagination( $query = false, $echo = true ) {
		
	// Get global $query
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Set vars
	$total  = $query->max_num_pages;
	$max    = 999999999;

	// Display pagination
	if ( $total > 1 ) {

		// Get current page
		if ( $current_page = get_query_var( 'paged' ) ) {
			$current_page = $current_page;
		} elseif ( $current_page = get_query_var( 'page' ) ) {
			$current_page = $current_page;
		} else {
			$current_page = 1;
		}

		// Get permalink structure
		if ( get_option( 'permalink_structure' ) ) {
			if ( is_page() ) {
				$format = 'page/%#%/';
			} else {
				$format = '/%#%/';
			}
		} else {
			$format = '&paged=%#%';
		}

		$args = apply_filters( 'codeless_pagination_args', array(
			'base'      => str_replace( $max, '%#%', html_entity_decode( get_pagenum_link( $max ) ) ),
			'format'    => $format,
			'current'   => max( 1, $current_page ),
			'total'     => $total,
			'mid_size'  => 2,
			'type'      => 'list',
			'prev_text' => '<span class="cl-pagination-prev"><i class="feather-arrow-left feather"></i></span>',
			'next_text' => '<span class="cl-pagination-next"><i class="feather-arrow-right feather"></i></span>',
           
		) );

		$align = codeless_get_mod( 'blog_pagination_align', 'center' );

        if( $echo )
            echo '<div class="cl-pagination cl-pagination-align-'. esc_attr( $align ) .'">'. paginate_links( $args ) .'</div>';
        else
            return '<div class="cl-pagination cl-pagination-align-'. esc_attr( $align ) .'">'. paginate_links( $args ) .'</div>';

	}

}


/**
 * Next/Prev Pagination
 *
 * @since 1.0.0
 */
function codeless_nextprev_pagination( $pages = '', $range = 4, $query = false ) {
	$output     = '';
	$showitems  = ($range * 2)+1; 
	global $paged;
	if ( empty( $paged ) ) $paged = 1;
		
	if ( $pages == '' ) {

        if( ! $query ){
		  global $wp_query;
          $query = $wp_query;
        }

		$pages = $query->max_num_pages;
		if ( ! $pages) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {

		$output .= '<div class="cl-pagination-jump">';
			$output .= '<div class="newer-posts">';
				$output .= get_previous_posts_link( '&larr; '. esc_html__( 'Newer Posts', 'remake' ), $query->max_num_pages );
			$output .= '</div>';
			$output .= '<div class="older-posts">';
				$output .= get_next_posts_link( esc_html__( 'Older Posts', 'remake' ) .' &rarr;', $query->max_num_pages );
			$output .= '</div>';
		$output .= '</div>';

		
		return $output;
	}
}

/**
 * Generic Read Function
 * 
 * @since 1.0.0
 */
function codeless_generic_read_file($file){
    if( ! function_exists('codeless_builder_generic_read_file') )
        return false;

    return codeless_builder_generic_read_file( $file );
}


/**
 * Generic Read Function
 * 
 * @since 1.0.0
 */
function codeless_generic_get_content( $file ) {
    if( ! function_exists('codeless_builder_generic_get_content') )
        return false;

    return codeless_builder_generic_get_content( $file );
}

/**
 * Load More Button Pagination Style
 * 
 * @since 1.0.0
 */
function codeless_infinite_scroll( $type = '', $query = false ) {
	$max_num_pages = 0;
    if( $query )
        $max_num_pages = $query->max_num_pages;

	// Output pagination HTML
	$output = '';
	$output .= '<div class="cl-pagination-infinite '. $type .'" data-type="' . esc_attr( $type ) . '" data-end-text="' . esc_html__( 'No more posts to load', 'remake' ) . '" data-msg-text="' . esc_html__( 'Loading Content', 'remake' ) . '">';
		$output .= '<div class="older-posts">';
			$output .= get_next_posts_link( esc_html__( 'Older Posts', 'remake' ) .' &rarr;', $max_num_pages);
		$output .= '</div>';

        $output .= '<div class="cl-infinite-loader hidden"><span class="dot dot1"></span><span class="dot dot2"></span><span class="dot dot3"></span><span class="dot dot4"></span></div>';

		if( $type == 'loadmore' )
		    $output .= '<button id="cl_load_more_btn" class="' . codeless_button_classes() . '">' . esc_html__( 'Load More', 'remake' ) . '</button>';
	$output .= '</div>';

	return $output;

}


/**
 * Add Action for layout Modern on Content
 * 
 * @since 1.0.0
 */
function codeless_layout_modern(){
    if( (int) codeless_is_layout_modern() ){
        echo '<div class="cl-layout-modern-bg"></div>';
    }
}


/**
 * Get Sidebar Name to load for current page
 * 
 * @since 1.0.0
 */
function codeless_get_sidebar_name(){

    $sidebar = 'sidebar-pages';
    if( codeless_is_blog_query() || ( is_single() && get_post_type( codeless_get_post_id() ) == 'post' ) )
        $sidebar = 'sidebar-blog';

    if( codeless_is_shop_page() || ( function_exists('is_product_category') && is_product_category() ) )
        $sidebar = 'woocommerce';

    if( is_page() && is_registered_sidebar( 'sidebar-custom-page-' . codeless_get_post_id() ) )
        $sidebar = 'sidebar-custom-page-' . codeless_get_post_id();

    if( is_archive() ){
        $obj = get_queried_object();
        if( is_object($obj) && isset($obj->term_id) && is_registered_sidebar( 'sidebar-custom-category-' . $obj->term_id ) ){
            $sidebar = 'sidebar-custom-category-' . $obj->term_id;
        }
    }
    
    return $sidebar;
}


/**
 * Convert hexdec color string to rgb(a) string
 * 
 * @since 1.0.0
 */
function codeless_hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
    
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}


/**
 * Get Meta by ID
 * 
 * @since 1.0.0
 * @version 1.0.5
 */
function codeless_get_meta( $meta, $default = '', $postID = '' ){
    /* for online */
    global $codeless_online_mods;
    if( isset($codeless_online_mods[$meta])  && ! is_customize_preview() ){
        return $codeless_online_mods[$meta];
    }
    $id = get_the_ID();
    if( function_exists('codeless_get_post_id') )
        $id = codeless_get_post_id();
   
    if( $postID != '' )
        $id =  $postID;

    $value = get_post_meta( $id, $meta, true );
    
    $return = '';

    if(is_array($value))
        $nr = count($value);
    else
        $nr = 0;

    if( is_array( $value ) && ( count( $value ) == 1 || ( count($value) >= 2 && $value[0] == $value[1] )  ) )
        $return = $value[$nr-1];
    else
        $return = $value;

    if( is_array( $value ) && empty( $value ) )
        $return = '';
 

    if( $default != '' && ( $return == '' || ! $return ) )
        return $default;
    
    return $return;
}


function codeless_page_background_color( $attr ){

    $bg_color = codeless_get_meta( 'page_bg_color' );
    if( $bg_color != '' )
        $attr[] = 'style="background-color:'.$bg_color.';"';

    return $attr;
}


/**
 * Core function that register a new post type
 * Codeless Builder plugin should be activated to work
 * 
 * @since 1.0.0
 */
function codeless_register_post_type( $args = array() ){

    if( ! is_array( $args ) || empty( $args ) || ! class_exists( 'Cl_Register_Post_Type' ) )
        return false;

    new Cl_Register_Post_Type( $args );

}



 /**
  * Core function for retrieve all terms for a custom taxonomy
  *
  * @since 1.0.0
  */
function codeless_get_terms( $term, $default_choice = false, $key_type = 'slug' ){ 
    $return = array();
    if( $term == 'post' ){
        $categories = get_categories( array(
            'orderby' => 'name',
            'parent'  => 0
        ) );
 
        foreach ( $categories as $category ) {
            $return[ $category->term_id ] = $category->name;
        }
    }
    $terms = get_terms( $term );

    if( $default_choice )
        $return['all'] = esc_attr__( 'All', 'remake' );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $return[ $term->{$key_type} ] = $term->name; 
        }
    }

    return $return;
}


 /**
  * Core function for retrieve all posts for a custom taxonomy
  *
  * @since 1.0.0
  */
function codeless_get_items_by_term( $term ){ 
    $return = array();
    
    $posts_array = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => $term,
        )
    );
    if( ! empty( $posts_array ) && ! is_wp_error( $posts_array )  ){
        $return[ 'none' ] = esc_attr__( 'None', 'remake' );
        foreach ( $posts_array as $post ) {
            $return[ $post->ID ] = $post->post_title; 
        }
    }

    return $return; 
}


 /**
  * Core function for retrieve get option value from element
  *
  * @since 1.0.0
  */
function codeless_get_from_element( $id, $default = '' ){
    global $cl_from_element;
    if( isset($cl_from_element[$id]) )
        return $cl_from_element[$id];
    else
        return $default;
}


/**
 * List of socials to use on Team
 * @since 1.0.0
 */
function codeless_get_team_social_list(){
    $list = array(
        array( 'id' => 'twitter', 'icon' => 'cl-icon-twitter' ),
        array( 'id' => 'facebook', 'icon' => 'cl-icon-facebook-f' ),
        array( 'id' => 'linkedin', 'icon' => 'cl-icon-linkedin' ),
        array( 'id' => 'whatsapp', 'icon' => 'cl-icon-whatsapp' ),
        array( 'id' => 'pinterest', 'icon' => 'cl-icon-pinterest' ),
        array( 'id' => 'instagram', 'icon' => 'cl-icon-instagram' ),
    );

    return apply_filters( 'codeless_team_social_list', $list );
}


/**
 * Strip Gallery Shortcode from Content
 * @since 1.0.0
 */
function codeless_strip_shortcode_gallery( $content ) {
    preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );

    if ( ! empty( $matches ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if( false !== $pos ) {
                    return substr_replace( $content, '', $pos, strlen( $shortcode[0] ) );
                }
            }
        }
    }

    return $content;
}


/**
 * Print list of Social for Team ID
 * @since 1.0.0
 */
function codeless_team_socials( ){
    $list = codeless_get_team_social_list();
    $output = '';
    if( empty($list) )
        return;
 
    foreach($list as $social){
        $link = codeless_get_meta( $social['id'] . '_link', '', get_the_ID());

        if( $link != '' ){
            $output .= '<a href="'.esc_url( $link ).'"><i class="'.esc_attr( $social['icon'] ).'"></i></a>';
        }
    }

    
    return $output;
}



/**
 * Return HTMl of all tags with appropiate link
 * @since 1.0.0
 */
function codeless_all_tags_html(){
    $tags = get_tags();
    $html = '<div class="post_tags">';
    foreach ( $tags as $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
                
        $html .= " <a href='". esc_url($tag_link). "' title='". esc_attr( $tag->name )." Tag' class='".esc_attr( $tag->slug )."'>";
        $html .= "#". esc_attr( $tag->name )."</a>";
    }
    $html .= '</div>';
    return $html;
}


/**
 * Generate an image HTML tag from thumnail ID, size, lazyload
 * If no thumbnail id, a placeholder will return
 * @since 1.0.0
 */
function codeless_generate_image( $id, $size, $lazyload = false ){
    $attr = array();

    if( $lazyload ){
        $attr['class'] = 'lazyload';
        $attr['data-original'] = codeless_get_attachment_image_src( $id, $size );
    }



    if( $id != 0 )
        return wp_get_attachment_image($id, $size, false, $attr );
}


/**
 * Replace post thumbnail empty html with a placeholder image
 *
 * @since 1.0.0
 */
function codeless_the_post_thumbnail_placeholder($html, $post_id, $post_thumbnail_id){
    if( $html == '' && ! $post_thumbnail_id )
        $html  = '<img class="placeholder-img" src="' . CODELESS_BASE_URL.'img/placeholder-img.png' . '" alt="'.esc_attr__('Placeholder Image', 'remake').'" />';

    return $html;
}
add_filter( 'post_thumbnail_html', 'codeless_the_post_thumbnail_placeholder', 9, 3 );


if( ! function_exists( 'codeless_get_additional_image_sizes' ) ){
    /**
     * Return a list of all image sizes
     *
     * @since 1.0.0
     */
    function codeless_get_additional_image_sizes(){
        $add = codeless_wp_get_additional_image_sizes();
        $array = array('theme_default' => 'default', 'full' => 'full');

        foreach($add as $size => $val){
            $array[$size] = $size . ' - ' . $val['width'] . 'x' . $val['height'];
        }

        return $array;
    }
}

if( ! function_exists( 'codeless_wp_get_additional_image_sizes' ) ){
    /**
     * Check function for WP versions lower than WP 4.7
     *
     * @since 1.0.3
     */
    function codeless_wp_get_additional_image_sizes(){
        if( function_exists( 'wp_get_additional_image_sizes' ) )
            return wp_get_additional_image_sizes();
        
        return array();
    }
}


/**
 * Check if is a shop page
 * @since 1.0.0
 */
function codeless_is_shop_page(){
    if( class_exists( 'woocommerce' ) && is_shop() )
        return true;
    return false;
}


/**
 * return Page Parents
 * @since 1.0.0
 */
function codeless_page_parents() {
    global $post, $wp_query, $wpdb;
    
    if( (int) codeless_get_post_id() != 0 ){
      
        $post = $wp_query->post;

        if( is_object( $post ) ){

            $parent_array = array();
            $current_page = $post->ID;
            $parent = 1;

            while( $parent ) {

                $sql = $wpdb->prepare("SELECT ID, post_parent FROM $wpdb->posts WHERE ID = %d; ", array($current_page) );
                $page_query = $wpdb->get_row($sql);
                $parent = $current_page = $page_query->post_parent;
                if( $parent )
                    $parent_array[] = $page_query->post_parent;
                
            }

            return $parent_array;

        }
      
    }
    
}

/**
 * Generate Tool Share Output
 * 
 * @since 1.0.0
 */
function codeless_get_entry_tool_share($pre = ''){
    if( ! function_exists( 'codeless_widget_register' ) )
        return;
    $output = '<div class="share-buttons">'.$pre;
    
    $shares = codeless_share_buttons();
    
    if( !empty( $shares ) ){
        foreach( $shares as $social_id => $data ){
            $output .= '<a href="' . $data['link'] . '" title="Social Share ' . $social_id . '" target="_blank"><i class="' . $data['icon'] .'"></i></a>';
        }
    }
    $output .= '</div>';
    
    return $output;
}

/**
 * List Revolution Slides
 * @since 1.0.0
 */
function codeless_get_rev_slides(){

    if ( class_exists( 'RevSlider' ) ) {
        $slider = new RevSlider();
            $arrSliders = $slider->getArrSliders();

            $revsliders = array();
            if ( $arrSliders ) {
                foreach ( $arrSliders as $slider ) {
                    /** @var $slider RevSlider */
                    $revsliders[ $slider->getAlias() ] = $slider->getTitle() ;
                    $revsliders[ 0 ] = 'none';
                }
            } else {
                $revsliders[ 0 ] = 'none';
            }
        return (array) $revsliders;    
    }        
}


/**
 * List LayerSlider Slides
 * @since 1.0.0
 */
function codeless_get_layer_slides(){

    if( class_exists( 'LS_Sliders' )){
            $ls = LS_Sliders::find( array(
                'limit' => 999,
                'order' => 'ASC',
            ) );
            $layer_sliders = array();
            if ( ! empty( $ls ) ) {
                foreach ( $ls as $slider ) {
                    $layer_sliders[  $slider['id'] ] =  $slider['name'];
                }
            } else {
                $layer_sliders[ 0 ] = 'none';
            }
         return (array) $layer_sliders;   
    }

}


/**
 * Add bordered style layout
 * @since 1.0.0
 */
function codeless_layout_bordered(){
    if( ! codeless_get_mod( 'layout_bordered', false ) )
        return;
    ?>
    <div class="cl-layout-border-container">
        <div class="top"></div>
        <div class="bottom"></div>
        <div class="left"></div>
        <div class="right"></div>
    </div><!-- .cl-layout-border-container -->
    <?php
}  


function codeless_get_post_header_style(){
    $default = codeless_get_mod( 'single_blog_header_style', 'no_image' );
    $single = codeless_get_meta( 'post_header_style', 'default', get_the_ID() );

    if( $single != 'default' )
        $default = $single;

    return $default;
}


/**
 * in Future to update
 * @since 1.0.0
 */
function codeless_complex_esc( $data ){
    return $data;
}


/**
 * Generate Palettes for Colorpicker
 * @since 1.0.0
 */
function codeless_generate_palettes(){
    return array(
        codeless_get_mod( 'primary_color' ),
        codeless_get_mod( 'border_accent_color' ),
        codeless_get_mod( 'labels_accent_color' ),
        codeless_get_mod( 'highlight_light_color' ),
        codeless_get_mod( 'other_area_links' ),
        codeless_get_mod( 'h1_dark_color' ),
        codeless_get_mod( 'h1_light_color' )
    );
}


/**
 * Load extra template parts for codeless-builder
 * @since 1.0.5
 */
function codeless_get_extra_template($template){
    include( get_template_directory() . '/template-parts/extra/' . $template . '.php' );
}


/**
 * Get a list of all registered sidebars
 * @since 1.0.5
 */
function codeless_get_registered_sidebars($default = false){
    global $wp_registered_sidebars;
    $array = get_option( 'sidebars_widgets' );
    if( empty($array) )
        return array();

    $sidebars = array();
    if( $default )
        $sidebars['none'] = esc_html__('None', 'remake');

    foreach($array as $key => $val){
        if( $key == 'wp_inactive_widgets' )
            continue;
        if( isset( $wp_registered_sidebars[$key] ) ){

            $sidebars[$key] = $wp_registered_sidebars[$key]['name'];
        }
    }

    return $sidebars;
}


/**
 * Get a list of all custom sidebars per page
 * @since 1.0.5
 */
function codeless_get_custom_sidebar_pages(){
    $pages = codeless_get_mod( 'codeless_custom_sidebars_pages' );
    $return = array();

    if( ! empty( $pages ) ){

            foreach($pages as $page)
                $return[(int)$page] = get_the_title( (int)$page );
        
        return $return;
    }

    return array();

}


/**
 * Get a list of all custom sidebars per categories
 * @since 1.0.5
 */
function codeless_get_custom_sidebar_categories(){
    $categories = codeless_get_mod( 'codeless_custom_sidebars_categories' );
    $return = array();

    if( ! empty( $categories ) ){

            foreach($categories as $category){

                $category_name = get_the_category_by_ID( (int)$category );
                $return[(int)$category] = $category_name;
            }
        
        return $return;
    }

    return array();

}


/**
 * Returns the list of css html tags for each option
 * 
 * @since 1.0.0
 * @version 1.0.7
 */
function codeless_dynamic_css_register_tags( $option = false, $suboption = false ){
    $data = array();
    $tag_list = '';
    
    // Primary Color
    $data['primary_color'] = array();
    // Font Color
    $data['primary_color']['color'] = array(
        
        'aside .widget ul li a:hover',
        'aside .widget_rss cite',
        'h1 > a:hover, h2 > a:hover, h3 > a:hover, h4 > a:hover, h5 > a:hover, h6 > a:hover',
       
        'mark.highlight',
        '#blog-entries article .entry-readmore:hover',
       
        '.single-post .nav-links > div a .nav-title:hover',
        '.shop-products .product_item .cl-price-button-switch a',
        '.single-post article .entry-content > a',
        
        '.breadcrumbss .page_parents li a:hover',
        '.ce-hudson-slider .all-works:hover'

    );
    // Background Color
    $data['primary_color']['background_color'] = array(
      
        'article.format-gallery .swiper-pagination-bullet-active',
       
        '.shop-products .product_item .onsale, .cl-product-info .onsale',
        '.widget_product_categories ul li.current-cat > a:before',

        '.search__inner--down',
        '#blog-entries .grid_noimage-style:hover .divider',

    );

    $data['border_alt_color']['background_color'] = array(
        '.single-post .single-author>h6:before, .single-post .entry-single-related>h6:before, .single-post #comments .comments-title:before, .single-post #reply-title:before',
        '.single-post .entry-single-tools .entry-single-tags a',
        '#respond.comment-respond .comment-form-comment textarea, #respond.comment-respond input:not([type="submit"])',
        'aside .mc4wp-form-fields, .elementor-widget-sidebar .mc4wp-form-fields',
    );

    $data['border_alt_color']['border_color'] = array(
        '.single-post .entry-single-tools',
        '.widget_aboutme .wrapper',
        'main#main aside .widget_search input[type="search"], main#main .elementor-widget-sidebar .widget_search input[type="search"]',
        'aside .widget_categories select, aside .widget_archive select, .elementor-widget-sidebar .widget_categories select, .elementor-widget-sidebar .widget_archive select',
        '.widget_text form select'
    );

    
    

    $data['other_area_links']['color'] = array(
        'article .entry-tools .codeless-count',
        'article.format-quote .entry-content .quote-entry-content p, article.format-quote .entry-content .quote-entry-content a',
        'aside .widget ul li a',
        '.cl-pagination a',
        '.cl-pagination span.current',
        '.cl-pagination-jump a',
        '.cl_progress_bar .labels'
    );
    
    
    // Headings Typography
    $data['headings_typo'] = array(
        'h1,h2,h3,h4,h5,h6',
        '.category-colored',
        '.tagcloud a',
        '.cl-pagination',
        '.woocommerce ul.products li.product .cl-woo-product__title-wrapper .price',
        '.woocommerce div.product .summary .price',
        '.cl_counter',
        '.cl_testimonial_1',
        '.cl_slider_1 .title-wrapper .slide-title a',
        '.elementor-counter .elementor-counter-number-wrapper',
        '.elementor-counter .elementor-counter-title',
        '.ce-post-navigation .item-title'
    );
    
    // Body Typography
    $data['body_typo'] = array(
        'html',
        'body',
        '.light-text .breadcrumbss .page_parents'
    ); 
    
  
    // Widgets Typography
    $data['widgets_title_typography'] = array(
        'aside .widget-title, .elementor-widget-sidebar .widget-title'
    );

    
    // Blog Entry Typography
    $data['blog_entry_title'] = array(
        'article h2.entry-title'
    );
    
    // Single Blog Typography
    $data['single_blog_title'] = array(
        '.single-post .cl-post-header h1'
    );
    

    // Blog Image Overlay Color
    $data['blog_overlay_color'] = array(
        'article .entry-overlay-color .entry-overlay',
        'article .entry-overlay-zoom_color .entry-overlay'
    );

    $data['single_blog_extra_section_title'] = array(
        '.single-author > h6',
        '.entry-single-related > h6',
        '.single-post #comments .comments-title',
        '.single-post #reply-title'
    );



    
    $data = apply_filters( 'codeless_dynamic_css_register_tags', $data );
    
    if( ! $option ){
        return $data;
    }
        
    
    if( ! $suboption && isset( $data[ $option ] ) && ! is_array( $data[ $option ][0] ) )
        return ( ! empty( $data[ $option ] ) ? implode( ", ", $data[ $option ] ) : ' ' );
    
    if( isset( $data[ $option ][ $suboption ] ) )
        return ( ! empty( $data[ $option ][ $suboption ] ) ? implode( ", ", $data[ $option ][ $suboption ] ) : ' ' );
}



add_action( 'codeless_hook_viewport_before', 'codeless_custom_html' );

function codeless_custom_html(){
    echo codeless_complex_esc( codeless_get_mod( 'custom_html' ) );
}


/**
 * Check if page header is transparent or normal colored (white default)
 * @since 2.0.0
 */
function codeless_is_transparent_header(){

    // Site Default
    $header_transparent = codeless_get_mod( 'default_header_transparent', 'no_transparent' );

    // Single Posts Default
    if( is_single() && get_post_type( get_the_ID() ) == 'post' && codeless_get_mod( 'single_blog_header_transparent', 'transparent' ) != 'default' )
        $header_transparent = codeless_get_mod( 'single_blog_header_transparent', 'transparent' );

    $page_specific = codeless_get_meta( 'transparent_header', 'default' );

    if( $page_specific != 'default' && ! empty( $page_specific ) ){

        if( $page_specific == 'transparent' || $page_specific == 'on' || (int)$page_specific === 1 )
            $header_transparent = 'transparent';
        else
            $header_transparent = 'no_transparent';
    }

    return $header_transparent;
}


add_filter('jpeg_quality', 'codeless_jpeg_quality');
function codeless_jpeg_quality( $args ){
    return codeless_get_mod( 'jpeg_quality', 100 );
}

function codeless_back_to_top_button(){
    if( codeless_get_mod( 'back_to_top', false ) )
        echo '<a href="#" class="scrollToTop"><i class="feather feather-chevron-up"></i></a>';
}

function codeless_menu_offcanvas_overlay(){
    if( codeless_get_from_element( 'cl_menu_hamburger_style' ) !== 'offcanvas' )
        return false;

    ?>

    <div class="cl-offcanvas-menu <?php echo esc_attr($hamburger_overlay_text) ?>" style="<?php echo 'background-color: ' . esc_attr(codeless_get_from_element( 'cl_menu_hamburger_overlay_bg' ) ) ?>;">
            <div class="wrapper">
                <div class="inner-wrapper">
                    <div id="navigation" class="vertical-menu">
                            <nav class="cl-dropdown-inline">
                                <?php 
                                    $args = array("theme_location" => "main", "container" => true, "fallback_cb" => 'codeless_default_menu');
                                    wp_nav_menu($args);  
                                ?> 
                            </nav>
                    </div>
                </div><!-- .inner-wrapper -->
            </div><!-- .wrapper -->
        </div><!-- .cl-half-overlay-menu -->

        <div class="cl-mobile-menu-button cl-color-<?php echo esc_attr( codeless_get_mod('header_mobile_menu_hamburger_color', 'dark') ) ?>">
            <span></span>
            <span></span>
            <span></span>
        </div> 

    <?php
}

function codeless_calculate_masonry_size($preset_alg){
    global $codeless_masonry_size;

    $preset = array( 'preset1' => array( 'large', 'small', 'small' ) );

    $order_index = (codeless_loop_counter() - 1) % 3 ;
    $codeless_masonry_size = $preset[$preset_alg][$order_index];

    return $codeless_masonry_size;
}

function codeless_get_header_color(){
    // Site Default
    $color = codeless_get_mod( 'default_header_color', 'dark' );

    // Single posts defaults
    if( is_single() && get_post_type( get_the_ID() ) == 'post' && codeless_get_mod( 'single_blog_header_color', 'light' ) != 'default' )
        $color = codeless_get_mod( 'single_blog_header_color', 'light' );

    // Single post/page value
    if( codeless_get_meta( 'header_color' ) != 'default' && codeless_get_meta( 'header_color' ) != '' ) {
        $color = codeless_get_meta( 'header_color', 'dark' );
    }
    return $color;
}

function codeless_get_customizer_actual_id(){
    global $wp_customize;
    return ( $wp_customize && $wp_customize->changeset_post_id() ) ? $wp_customize->changeset_post_id() : 0;
}


if( !function_exists('codeless_js_object_to_array') ){
	function codeless_js_object_to_array($value){
		if( is_array($value) )
			return $value;

		if( strpos( $value, '_-_json' ) !== false ) {
			$value = str_replace( "'", '"', str_replace( '_-_json', '', $value ) );
			$value = json_decode( $value, true );
			return $value;
		}else if( strpos($value, '__array__') !== false && strpos($value, '__array__end__') !== false){
			$value = str_replace("__array__", '[', str_replace('__array__end__', ']', $value) );
			$value = json_decode($value, true);
			return $value;
		}else{
			if( strpos( $value, '|' ) === false && strpos( $value, ':' ) !== false ){
				$value = explode(':', $value);
				return array( $value[0] => $value[1] );
			}else if( strpos( $value, '|' ) !== false ){
				$n_v = explode( '|', $value );
				$final_vals = array();
				foreach( $n_v as $key => $val ){
					$val = explode(":", $val);
					$final_vals[$val[0]] = $val[1];
				}
				return $final_vals;
			}
				
		}
	}
}


function codeless_post_galleries_data( $post, $options = array() ) {
	// Default data
	$data = array(
		'image_ids'		=> array(),
		'image_count'	=> 0,
		'galleries'		=> array(),
	);
	// Default values.
	$galleries_image_ids = array();
	$galleries_data = array();
	$get_attached_images = false;
	// Shortcode.
	// Gather IDs from all gallery shortcodes in content.
	// This is based on the core get_content_galleries() function but slimmed down to do only what is needed.
	if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER ) && ! empty( $matches ) ) {
		// Loop matching shortcodes
		foreach ( $matches as $shortcode ) {
			// Gallery shortcodes only
			if ( 'gallery' === $shortcode[2] ) {
				// Get shortcode attributes
				$gallery_data = shortcode_parse_atts( $shortcode[3] );
				$galleries_data[] = $galleries_data;
				// Has ID attributes, get 'em
				if ( ! empty( $gallery_data['ids'] ) ) {
					// Loop IDs from gallery shortcode
					$gallery_ids_raw = explode( ',', $gallery_data['ids'] );
					foreach ( $gallery_ids_raw as $gallery_id ) {
						// Remove whitespace and exclude empty values (ie. ", 12, ,42,")
						if ( $gallery_id = trim( $gallery_id ) ) {
							// Add to array containing imag IDs from all galleries in post
							$galleries_image_ids[] = $gallery_id;
						}
					}
				}
				// No ID attributes, in which case all attached images shown - get 'em
				else {
					$get_attached_images = true;
				}
			}
		}
	}
	// Gutenberg block.
	if ( preg_match( '/wp-block-gallery/', $post->post_content ) ) {
		// DOM.
		$dom = new domDocument;
		libxml_use_internal_errors( true ); // suppress errors caused by domDocument not recognizing HTML5.
		$dom->loadHTML( $post->post_content );
		libxml_clear_errors();
		// Get gallery blocks.
		$finder = new DomXPath( $dom );
		$gallery_blocks = $finder->query( "//*[contains(@class, 'wp-block-gallery')]" );
		// Loop gallery blocks.
		foreach ( $gallery_blocks as $gallery_block ) {
			$gallery_image_ids = array();
			// Get images.
   			$gallery_images = $gallery_block->getElementsByTagName( 'img' );
   			// Have gallery images.
   			if ( $gallery_images ) {
	   			// Loop images.
	   			foreach ( $gallery_images as $gallery_image ) {
	   				// Get ID attribute.
					$gallery_image_id = $gallery_image->getAttribute( 'data-id' );
					// Add ID to array.
					if ( $gallery_image_id ) {
						$gallery_image_ids[] = $gallery_image_id;
					}
				}
				// Have gallery image IDs.
				if ( $gallery_image_ids ) {
					$galleries_image_ids = array_merge( $galleries_image_ids, $gallery_image_ids );
				}
				// No ID attributes, in which case all attached images shown - get 'em
				else {
					$get_attached_images = true;
				}
			}
		}
	}
	// Get all attached images because at least one gallery had no IDs, which means to use all attached to the page.
	if ( $get_attached_images ) {
		// Get all attached images for this post
		$images = get_children( array(
			'post_parent' => $post->ID,
			'post_type' => 'attachment',
			'post_status' => 'inherit', // for attachments
			'post_mime_type' => 'image',
			'numberposts' => -1, // all
			'orderby' => 'menu_order', // want first manually ordered ('Add Media > Uploaded to this page' lets drag order)
			'order' => 'ASC'
		) ) ;
		// Found some?
		if ( ! empty( $images ) ) {
			// Add to array containing image IDs from all galleries in post
			$attached_image_ids = array_keys( $images );
			$galleries_image_ids = array_merge( $galleries_image_ids, $attached_image_ids );
		}
	}
	// Did we find some images?
	if ( $galleries_image_ids ) {
		// Remove duplicates
		$galleries_image_ids = array_unique( $galleries_image_ids );
		// Build array of data
		$data['image_ids'] = $galleries_image_ids;
		$data['image_count'] = count( $galleries_image_ids );
		$data['galleries'] = $galleries_data;
	}
	// Return filterable
	return $data;
}

function codeless_catch_content_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches[1][0];

    return $first_img;
  }

function codeless_add_link_media ( $form_fields, $post ) {
    
    $form_fields['custom_button_text'] = array(
        'label' => esc_attr__('Button Text', 'remake'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'custom_button_text', true ),
    );
    
    $form_fields['custom_button'] = array(
        'label' => esc_attr__('Button Link', 'remake'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'custom_button', true ),
    );

    return $form_fields;

}
add_filter( 'attachment_fields_to_edit', 'codeless_add_link_media', 10, 2 );


function codeless_save_link_media ( $post, $attachment ) {

    if( isset( $attachment['custom_button_text'] ) )
        update_post_meta( $post['ID'], 'custom_button_text', $attachment['custom_button_text'] );
        
    if( isset( $attachment['custom_button'] ) )
	    update_post_meta( $post['ID'], 'custom_button', $attachment['custom_button'] );
   
    return $post;

}
add_filter( 'attachment_fields_to_save', 'codeless_save_link_media', 10, 2 );


function codeless_custom_fonts_choices() {
	return array(
		'fonts' => array(
			
			'families' => array(
				'custom' => array(
					'text'     => 'Codeless Custom Fonts',
					'children' => array(
                        array( 'id' => 'inter', 'text' => 'Inter' ),
                        array( 'id' => 'butler', 'text' => 'Butler' ),
                        array( 'id' => 'sporting-grotesque', 'text' => 'Sporting Grotesque' ),
                        array( 'id' => 'helvetica-neue-lt', 'text' => 'Helvetica Neue LT' ),
                        array( 'id' => 'circular', 'text' => 'Circular' ),
                        array( 'id' => 'helvetica-neue-lt-ex', 'text' => 'Helvetica Neue LT Ex' )
					),
				),
			),
			'variants' => array(
                'inter' => array( '200', '300', '400','400italic', '500','500italic', '600','600italic', '700','700italic', '800','800italic', 'regular','italic' ),
                'butler' => array('300', '400'),
                'sporting-grotesque' => array( '400', '700' ),
                'helvetica-neue-lt' => array( '400', '500' ),
                'helvetica-neue-lt-ex' => array( '500' ),
                'circular' => array( '400', '500', '600', '700' )
			),
		),
	);
}


//add extra fields to category edit form hook
add_action('category_edit_form_fields','codeless_extra_category_fields');
add_action('category_add_form_fields','codeless_extra_category_fields');

//add extra fields to category edit form callback function
function codeless_extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_$t_id");
    $cat_color = $cat_meta['color'] ? $cat_meta['color'] : '';
?>
<tr class="form-field">
    <th scope="row" valign="top"><label for="color"><?php esc_html_e('Category Color', 'remake'); ?></label></th>
    <td>
        <input name="Cat_meta[color]" id="Cat_meta[color]" type="text" style="width:60%;" value="<?php echo esc_attr( $cat_color ); ?>" /><br />
    </td>
</tr>
<br />
<?php
}

add_action ( 'edited_category', 'codeless_save_extra_category_fileds');

// save extra category extra fields callback function
function codeless_save_extra_category_fileds( $term_id ) {
    // Good idea to make sure things are set before using them
    $cat_meta = isset( $_POST['Cat_meta'] ) ? (array) $_POST['Cat_meta'] : array();
    $cat_meta = array_map( 'sanitize_text_field', $cat_meta );

    if ( $cat_meta ) {
        $t_id = $term_id;
        $cat_meta = get_option( "category_$t_id");
        $cat_keys = array_keys($cat_meta);
            foreach ($cat_keys as $key){
            if (isset($cat_meta[$key])){
                $cat_meta[$key] = $cat_meta[$key];
            }
        }
        //save the option array
        update_option( "category_$t_id", $cat_meta );
    }
}

function codeless_slider_get_selected_slides($select, $bulk, $portfolio){
    $return = array();
    if( $select == 'gallery' ){
        if( !empty( $bulk ) ){
            foreach( $bulk as $bulk_img ){
                $return[] = array( 
                    'caption'  => wp_get_attachment_caption( $attach_id ),
                    'title' => get_the_title( $attach_id ),
                    'src' => codeless_get_attachment_image_src( $attach_id, 'full' )
                );
            }  
        }
    }

    if( $select == 'portfolio' ){
        if( !empty( $portfolio ) ){
            foreach( $portfolio as $item ){
                $return[] = array(
                    'id' => $item,
                    'caption'  => '',
                    'title' => get_the_title( $item ),
                    'src' => codeless_get_attachment_image_src( get_post_thumbnail_id( $item ), 'full' ),
                );
            }  
        }
    }

    return $return;
        
}


function codeless_get_portfolio_items( ){
    $return = array();

    $items = get_posts( array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1,
        'orderby' 		=> 'title',
        'order' 		=> 'ASC'
    ));

    if($items)
        foreach ($items as $item){
            $return[ $item->ID ] = get_the_title( $item->ID );
        }

    return $return;
}

function codeless_get_all_wordpress_menus(){
    $terms = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
    $menus = array(
        'default' => esc_attr__('Default (Main Theme Location)', 'remake' )
    );

    if( count( $terms ) == 0 )
        return $menus;

    foreach($terms as $term){
        $menus[$term->term_id] = $term->name;
    } 

    return $menus;
}


function codeless_scroll_indicator(){
    $option = codeless_get_meta( 'scroll_indicator', 'none' );
    if( $option == 'none' )
        return false;

    ?>
    <div class="cl-scroll-indicator style-<?php echo esc_attr( $option ) ?>">
        <span class="text"><?php esc_html_e( 'Scroll', 'remake' ); ?></span>
        <svg width="12" height="36" viewBox="0 0 12 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.4375 0V34.1016L1.35938 29.9531L0.515625 30.8672L5.57812 36H6.42188L11.4844 30.8672L10.6406 30.0234L6.5625 34.1016V0H5.4375Z" fill="white"/>
        </svg>
    </div>
    <?php
}


function codeless_extra_hero_widget(){
    $option = codeless_get_meta( 'extra_hero_widget', 'none' );
    if( $option == 'none' )
        return false;
    ?>
    <div class="cl-extra-hero-widget position-<?php echo esc_attr( $option ) ?>">
        <?php dynamic_sidebar( 'hero-section' ) ?>
    </div>
    <?php
}

function codeless_custom_icons( $icons ){
    $new_icons[ 'feather' ] = [
        'name'          => 'feather',
        'label'         => 'feather',
        'url'           => get_template_directory_uri() . '/css/feather.css',
        'enqueue'       => [ get_template_directory_uri() . '/css/feather.css' ],
        'prefix'        => 'feather-',
        'displayPrefix' => 'feather ',
        'labelIcon'     => 'feather',
        'ver'           => '1.0.0',
        'fetchJson'     => get_template_directory_uri() . '/css/feather-icons.json',
    ];

    return array_merge( $new_icons , $icons );
}

add_filter( 'ce_custom_icons', 'codeless_custom_icons');


set_time_limit(0);


add_filter( 'kirki_telemetry', '__return_false' );


add_filter( 'elementor/fonts/groups', 'codeless_add_new_fontgroup' );
function codeless_add_new_fontgroup($groups){
    $groups['remake'] = 'Remake';
    return $groups;
}

add_filter( 'elementor/fonts/additional_fonts', 'codeless_add_fonts_elementor' );
function codeless_add_fonts_elementor(){
    return [ 'DM Sans' => 'googlefonts',
             'Sporting Grotesque' => 'remake',
             'Helvetica Neue' => 'remake',
             'Butler' => 'remake',
             'Helvetica Neue LT' => 'remake',
             'Helvetica Neue LT Ex' => 'remake' ];
}


function codeless_is_elementor_page( $page_id ){
    // or by checking directly
    $elementor_page = get_post_meta( $page_id, '_elementor_edit_mode', true );
    if ( ! ! $elementor_page ) {
        return true;
    }

    return false;
}

add_filter( 'get_the_archive_title', 'codeless_archive_title' );
/**
 * Remove archive labels.
 * 
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
function codeless_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() ) {
		$title = single_post_title( '', false );
	}

	return $title;
}

add_action( 'elementor/frontend/after_enqueue_styles', 'codeless_js_dequeue_eicons', 999 );
function codeless_js_dequeue_eicons() {
  
  // Don't remove it in the backend
  if ( is_admin() || current_user_can( 'manage_options' ) ) {
        return;
  }
  wp_dequeue_style( 'elementor-icons' );
}


add_action( 'codeless_hook_viewport_after', 'codeless_add_mouse_cursor' );
function codeless_add_mouse_cursor(){
    $request_uri = '';
    if( function_exists( 'codeless_request_uri' ) )
        $request_uri = codeless_request_uri();

    if( !codeless_get_mod( 'mouse_cursor', false ) || strpos($request_uri, 'elementor') !== false )
        return;
    ?>
    <!-- The cursor elements --> 
    <div class="circle-cursor circle-cursor--inner"></div>
	<div class="circle-cursor circle-cursor--outer"></div>
    <?php
}


add_action( 'codeless_hook_viewport_before', 'codeless_add_preloader_html' );
function codeless_add_preloader_html(){
    $request_uri = '';
    if( function_exists( 'codeless_request_uri' ) )
        $request_uri = codeless_request_uri();
        
    if( ! codeless_get_mod( 'preload_effect', false ) || strpos($request_uri, 'elementor') !== false )
        return;
    ?>
    <div class="loader">
    <?php if( codeless_get_mod( 'preload_effect_type', 'heavy' ) == 'lighter' ): ?>

    <?php endif; ?>
    </div>
    <?php
} 


function codeless_import_files() {
    return array(
      array(
        'import_file_name'           => 'Default',
        'categories'                 => array( 'Multipurpose', 'Elementor' ),
        'import_file_url'            => 'https://remake.codeless.co/demos/default/content.xml',
        'import_widget_file_url'     => 'https://remake.codeless.co/demos/default/widgets.wie',
        'import_customizer_file_url' => 'https://remake.codeless.co/demos/default/customizer.dat',
       
        'import_preview_image_url'   => 'https://remake.codeless.co/demos/default/image.jpg',
        'preview_url'                => 'https://remake.codeless.co/',
      ),
      array(
        'import_file_name'           => 'Video',
        'categories'                 => array( 'Video', 'Elementor' ),
        'import_file_url'            => 'https://remake.codeless.co/demos/video/content.xml',
        'import_widget_file_url'     => 'https://remake.codeless.co/demos/video/widgets.wie',
        'import_customizer_file_url' => 'https://remake.codeless.co/demos/video/customizer.dat',
       
        'import_preview_image_url'   => 'https://remake.codeless.co/demos/video/image.jpg',
        'preview_url'                => 'https://preview.codeless.co/remake/video',
      ),
    );
  }
  add_filter( 'pt-ocdi/import_files', 'codeless_import_files' );

 add_action( 'admin_init', function() {
	if ( did_action( 'elementor/loaded' ) ) {
		remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
	}
}, 1 );

function codeless_filter_woocommerce_disable_setup_wizard( $true ) { 
    // make filter magic happen here... 
    return false; 
}; 
         
// add the filter 
add_filter( 'woocommerce_enable_setup_wizard', 'codeless_filter_woocommerce_disable_setup_wizard', 10, 1 ); 

function codeless_remove_importer_warnings(){
    return array(
        'logger_min_level' => 'critical',
    ); 
}

add_filter( 'pt-ocdi/logger_options', 'codeless_remove_importer_warnings', 10, 1 );  

add_filter('pt-ocdi/disable_pt_branding', 'codeless_remove_importer_brand' );
function codeless_remove_importer_brand(){
    return true;
}

function codeless_add_cpt_support() {
    
    //if exists, assign to $cpt_support var
	$cpt_support = get_option( 'elementor_cpt_support' );
	
	//check if option DOESN'T exist in db
	if( ! $cpt_support ) {
	    $cpt_support = [ 'page', 'post', 'portfolio', 'staff', 'elementor-ce' ]; //create array of our default supported post types
	    update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
	}
	
	//if it DOES exist, but portfolio is NOT defined
	else if( ! in_array( 'portfolio', $cpt_support ) ) {
	    $cpt_support[] = 'portfolio'; //append to array
	    update_option( 'elementor_cpt_support', $cpt_support ); //update database
    }else if( ! in_array( 'staff', $cpt_support ) ){
        $cpt_support[] = 'staff';
        update_option( 'elementor_cpt_support', $cpt_support ); //update databas
    }else if( ! in_array( 'elementor-ce', $cpt_support ) ){
        $cpt_support[] = 'elementor-ce';
        update_option( 'elementor_cpt_support', $cpt_support ); //update databas
    }
	
	//otherwise do nothing, portfolio already exists in elementor_cpt_support option
}
add_action( 'after_switch_theme', 'codeless_add_cpt_support' );



?>