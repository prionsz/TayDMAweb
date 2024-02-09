<?php

/**
 * Used to configure all Customizer, load needed files and config
 * 
 * @package june WordPress Theme
 * @subpackage Framework
 * @version 1.0.1
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    exit;
}

// Start Class
if( !class_exists( 'CodelessCustomizerConfig' ) ) {
    
    class CodelessCustomizerConfig {
        
        public function __construct() {
            
            
            // Force KIRKI to load all font weights

            if( !class_exists( 'Kirki' ) )
                return;

            if(class_exists('Kirki_Fonts_Google'))
                Kirki_Fonts_Google::$force_load_all_variants = true;

            
            // Load Customizer Preview Scripts for live edit options
            add_action( 'customize_preview_init', array(
                 &$this,
                'register_preview_scripts' 
            ) );

            // Load Customizer Controls Pane Scripts
            add_action( 'customize_controls_enqueue_scripts', array(
                 &$this,
                'register_customizePane_scripts' 
            ) );

            
            
            global $cl_theme_mods;
            $cl_theme_mods = apply_filters( 'codeless_theme_mods', get_theme_mods() );
            

            
            $this->load_options();
        }

        
        function register_preview_scripts() {

            // Load WebFont Script to dynamically load fonts with JS
            wp_enqueue_script( 'codeless_google_fonts', get_template_directory_uri() . '/js/webfont.js', array(
                 'customize-preview',
                'jquery' 
            ) );
            
            // Live Edit Options JS Functions
            wp_enqueue_script( 'codeless_css_preview', get_template_directory_uri() . '/includes/codeless_customizer/js/codeless_postMessages.js', array(
                 'customize-preview',
                'jquery',
                'codeless_google_fonts' 
            ) );
            
            
            wp_localize_script( 'codeless_css_preview', 'cl_options', codeless_dynamic_css_register_tags() );
        }
        
        
        function register_customizePane_scripts() {
            
            $fields = Kirki::$fields;
            
            $newvars = array();
            
            foreach( $fields as $setting => $field ) {
                if( isset( $field['required'] ) && count( $field['required'] ) > 0 ) {
                    foreach( $field['required'] as $ac ) {
                        if( isset( $ac['transport'] ) && $ac['transport'] == 'postMessage' ) {
                            $ac['current'] = $setting;
                            $setting_      = $ac['setting'];
                            if( !isset( $newvars[$setting_] ) ) {
                                $newvars[$setting_] = array();
                            }
                            
                            $newvars[$setting_][] = $ac;
                        }
                    }
                }
            }
            
            //wp_localize_script( 'codeless_pane_script', 'newvars', $newvars );
            wp_enqueue_style( 'codeless-customizer-style', CODELESS_BASE_URL . 'includes/codeless_customizer/css/codeless-customizer.css' );
        }

    

        
        public function load_options() {

            if( !class_exists( 'Kirki' ) )
                return;

            Kirki::add_config( 'cl_remake', array(
                'capability' => 'edit_theme_options',
                'option_type' => 'theme_mod',
                'disable_loader' => true
            ) );
            
            require_once 'codeless_options/general.php';
            require_once 'codeless_options/styling.php';
            require_once 'codeless_options/layout.php';
            require_once 'codeless_options/blog.php';
            
            if( class_exists( 'woocommerce' ) )
                require_once 'codeless_options/shop.php';
            
            require_once 'codeless_options/custom_types.php';
        }

       
        
    }
}

new CodelessCustomizerConfig();

?>