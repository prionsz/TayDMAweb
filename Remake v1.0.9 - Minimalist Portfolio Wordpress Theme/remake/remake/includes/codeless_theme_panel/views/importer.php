<?php 
     add_thickbox(); 

     $demos = cl_backpanel::get_demos();
?>


<div id="importer_dialog" style="display:none;">
     <div class="description">

     </div>

     <div class="demos">
          <?php foreach( $demos as $demo ): ?>
               <div class="demo">
                    <div class="inner">
                         <a href="#" class="demo_link" data-demo-id="<?php echo esc_attr( $demo['id'] ) ?>" data-parts="<?php echo esc_attr( $demo['parts'] ) ?>"></a>
                         <img src="<?php echo get_template_directory_uri() .'/includes/codeless_demos_content/'.$demo['id'].'/image.jpg'; ?>" alt="<?php echo esc_attr($demo['label']) ?>" />
                         <div class="overlay"><?php echo esc_attr($demo['label']) ?></div>
                    </div>
                    <a href="<?php echo esc_url( $demo['preview'] ) ?>" target="_blank" class="preview">Preview</a>
               </div>
          <?php endforeach; ?>
     </div>
</div>