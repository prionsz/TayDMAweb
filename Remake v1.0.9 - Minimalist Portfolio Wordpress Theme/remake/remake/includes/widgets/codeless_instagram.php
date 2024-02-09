<?php 

class CodelessInstagram extends WP_Widget{



    function __construct(){

        $options = array('classname' => 'widget_instagram', 'description' => '', 'customize_selective_refresh' => true );

		parent::__construct( 'widget_instagram', THEMENAME.' Widget Instagram', $options );

    }


 
    function widget($atts, $instance){

        extract($atts, EXTR_SKIP);

		echo codeless_complex_esc( $before_widget );

        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $text = empty($instance['text']) ? '' : $instance['text'];

        if ( !empty( $title ) ) { 

            echo codeless_complex_esc( $before_title . $title . $after_title ); 

        }

        ?>

        <p><?php echo codeless_complex_esc( $text ) ?></p>

       <div class="cl-instafeed" data-token="<?php echo codeless_get_mod( 'instagram_feed_token' ); ?>" data-userid="<?php echo codeless_get_mod( 'instagram_feed_userid' ); ?>"></div>

      
        <?php

        echo codeless_complex_esc( $after_widget );

    }

    



    function update($new_instance, $old_instance){

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['text'] = $new_instance['text'];

        return $instance;

    }



    function form($instance){

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '') );

        $title = isset($instance['title']) ? $instance['title']: "";
        $text = isset($instance['text']) ? $instance['text']: "";
     
        ?>

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Widget Title', 'remake' ) ?>: 

    		<input id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>

        </p>

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('text') ); ?>"><?php echo esc_attr__('Text', 'remake') ?>: 

                <textarea id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>"><?php echo esc_attr($text); ?></textarea>
            
            </label>

        </p>
        

        <p>

            <?php esc_html_e( 'Add token and userid at Theme Options (Customizer) -> General -> Instagram', 'remake' ); ?>
           
        </p>

      

   

        <?php

    }

}