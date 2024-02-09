<?php

$slider_data = codeless_post_galleries_data( get_post( get_the_ID() ) );

?>
<div class="entry-media">
    <div class="entry-gallery">
        
                <!-- Slides -->
                <?php
                    
                    // Generate Slide
                    if( is_array( $slider_data ) && ! empty( $slider_data['image_ids'] ) ):
                        foreach( $slider_data['image_ids'] as $attachment_id ):
                            echo '<div class="gallery-item">';
                                echo '<img src="'.codeless_get_attachment_image_src( $attachment_id, codeless_get_post_thumbnail_size() ).'" alt="'.esc_attr__('Slider Image', 'remake').'" />';
                                
                                    
                            echo '</div><!-- .gallery-item --> ';
                        endforeach;
                    endif;
                    
                    
                ?>

    </div>
</div><!-- .entry-media --> 