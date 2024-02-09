<article id="post-<?php the_ID(); ?>" <?php post_class(  ); ?>>
		
		<div class="cl-content">

			<?php get_template_part( 'template-parts/blog/formats/content', get_post_format() ) ?>
	
		</div><!-- .cl-content -->
		
</article><!-- #post-## -->