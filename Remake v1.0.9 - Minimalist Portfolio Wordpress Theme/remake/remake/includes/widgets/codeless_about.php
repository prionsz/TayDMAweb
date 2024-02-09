<?php 

class CodelessAboutMe extends WP_Widget{



    function __construct(){

        $options = array('classname' => 'widget_aboutme', 'description' => 'About Me Widget', 'customize_selective_refresh' => true );

		parent::__construct( 'widget_aboutme', THEMENAME.' Widget About Me', $options );

    }


 
    function widget($atts, $instance){

        extract($atts, EXTR_SKIP);

		echo codeless_complex_esc( $before_widget );



        $image = empty($instance['image']) ? '' : $instance['image'];

        $logo = empty($instance['logo']) ? '' : $instance['logo'];

        $title_text = empty($instance['title_text']) ? '' : $instance['title_text'];

        $text = empty($instance['text']) ? '' : $instance['text'];

        $btn = empty($instance['btn']) ? '' : $instance['btn'];

        ?>

        
            <?php if( !empty( $image ) ): ?>
                <img class="image" src="<?php echo esc_url( $image ) ?>" alt="<?php echo esc_attr__( 'About Me', 'remake' ) ?>" />
            <?php endif; ?>
        <div class="wrapper">
            <div class="logo_circle">
                <img class="logo-img-about" src="<?php echo esc_url( $logo ) ?>" alt="<?php echo esc_attr__( 'About Me Logo', 'remake' ) ?>" />
            </div>
        
            <h6><?php echo esc_html($title_text) ?></h6>
            <p class="text"><?php echo codeless_complex_esc( $text ) ?></p>

            <?php if( !empty( $btn ) ): ?>
                <a class="btn" href="<?php echo esc_url( $btn ) ?>"><?php echo esc_attr__( 'More about us', 'remake' ) ?></a>
            <?php endif; ?>
        </div>

        <?php
        
        
        echo codeless_complex_esc( $after_widget );

    }

    



    function update($new_instance, $old_instance){

        $instance = array();
        $instance['title'] = $new_instance['title'];

        $instance['image'] = $new_instance['image'];
        $instance['logo'] = $new_instance['logo'];
        $instance['title_text'] = $new_instance['title_text'];
        $instance['text'] = $new_instance['text'];
        $instance['btn'] = $new_instance['btn'];
        
        return $instance;

    }



    function form($instance){

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'image' => '', 'logo' => '', 'text' => '', 'title_text' => '', 'btn' => '') );

        $title = isset($instance['title']) ? $instance['title']: "";
        $image = isset($instance['image']) ? $instance['image']: "";
        $logo = isset($instance['logo']) ? $instance['logo']: "";
        $title_text = isset($instance['title_text']) ? $instance['title_text']: "";

        $text = isset($instance['text']) ? $instance['text']: "";
        $btn = isset($instance['btn']) ? $instance['btn']: "";
        

        ?>


        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('image') ); ?>"><?php echo esc_attr__('Image Link', 'remake') ?>: 

                <input id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>" type="text" value="<?php echo esc_attr($image); ?>" />
            
            </label>

        </p>

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('logo') ); ?>"><?php echo esc_attr__('Logo Link', 'remake') ?>: 

                <input id="<?php echo esc_attr( $this->get_field_id('logo') ); ?>" name="<?php echo esc_attr( $this->get_field_name('logo') ); ?>" type="text" value="<?php echo esc_attr($logo); ?>" />
            
            </label>

        </p>

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('title_text') ); ?>"><?php echo esc_attr__('Title', 'remake') ?>: 

                <textarea id="<?php echo esc_attr( $this->get_field_id('title_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title_text') ); ?>"><?php echo esc_attr($title_text); ?></textarea>
            
            </label>

        </p>

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php echo esc_attr__('Text', 'remake') ?>: 

                <textarea id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>"><?php echo esc_attr($text); ?></textarea>
            
            </label>

        </p>

        <p>

            <label for="<?php echo esc_attr( $this->get_field_id('btn') ); ?>"><?php echo esc_attr__('Button Link', 'remake') ?>: 

                <input id="<?php echo esc_attr( $this->get_field_id('btn') ); ?>" name="<?php echo esc_attr( $this->get_field_name('btn') ); ?>" type="text" value="<?php echo esc_attr($btn); ?>" />

            </label>

        </p>


        <?php

    }

}