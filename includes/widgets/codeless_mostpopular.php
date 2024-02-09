<?php 

class CodelessMostPopularWidget extends WP_Widget{



    function __construct(){

        $options = array('classname' => 'widget_most_popular', 'description' => esc_html__('Add a widget to show the most popular posts', 'remake' ), 'customize_selective_refresh' => true );

		parent::__construct( 'widget_most_popular', THEMENAME.' Widget Popular Posts', $options );

    }


 
    function widget($atts, $instance){

        extract($atts, EXTR_SKIP);

		echo codeless_complex_esc( $before_widget );

        

        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

        $number_of_posts = empty($instance['number_of_posts']) ? '' : $instance['number_of_posts'];

        

        

        

        if ( !empty( $title ) ) { 

		      echo codeless_complex_esc( $before_title . $title . $after_title ); 

        }

        echo '<ul>';

        wp_reset_postdata();
        $new_query = array( 'showposts' => $number_of_posts, 'orderby' => 'comment_count' );
        $the_query = new WP_Query( $new_query );

        while ($the_query->have_posts()) : $the_query->the_post();
            
            $post_id = get_the_ID();
            $post_format = get_post_format($post_id);

            echo '<li>';
           
                
                if(has_post_thumbnail())
                    echo '<div class="media">'.codeless_generate_image(get_post_thumbnail_id(), 'thumbnail').'</div>';
    	            
                echo '<div class="content"><a href="'.esc_url(get_permalink()).'">'.esc_html(get_the_title()).'</a>';
                    echo '<span class="date">'.get_the_date().'</span>';
                echo '</div>';

            echo '</li>';

        endwhile;

        echo '</ul>';
        wp_reset_postdata();
        echo codeless_complex_esc( $after_widget );

    }

    



    function update($new_instance, $old_instance){

        $instance = array();

        $instance['title'] = $new_instance['title'];

        $instance['number_of_posts'] = $new_instance['number_of_posts'];

        

        return $instance;

    }



    function form($instance){

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number_of_posts' => '') );

        $title = isset($instance['title']) ? $instance['title']: "";

        $number_of_posts = isset($instance['number_of_posts']) ? $instance['number_of_posts']: "";

        

        ?>

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>">Title: 

    		<input id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>

        </p>

        

        <p>

    		<label for="<?php echo esc_attr( $this->get_field_id('number_of_posts') ); ?>">Number of posts: 

    		<input id="<?php echo esc_attr( $this->get_field_id('number_of_posts') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number_of_posts')); ?>" type="text" value="<?php echo esc_attr($number_of_posts); ?>" /></label>

        </p>

        

        

        <?php

    }

}