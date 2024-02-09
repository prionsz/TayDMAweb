<?php
/**
 * Blog Template Part for displaying entry-thumnail image
 * Used for entry overlay too.
 *
 * @package Remake
 * @subpackage Blog Parts
 * @since 1.0.0
 *
 */

?>

<div class="entry-media entry-overlay-<?php echo codeless_get_mod( 'blog_overlay', 'color' ) ?>">
	
	<?php 
	
	/**
	 * Blog Overlay Styles with the appropiate icon
	 * Blog Entry Link
	 */ 
	if( ! codeless_is_single_post() )
		codeless_blog_overlay();

	?>
	
	
	<div class="post-thumbnail">
		
		<?php if( codeless_get_mod( 'blog_image_filter', 'normal' ) != 'normal' ): ?>
			<figure class="<?php echo codeless_get_mod( 'blog_image_filter', 'normal' ) ?>">
		<?php endif; ?>

			<?php the_post_thumbnail( 'blog_entry_small' ); ?>
			
		<?php if( codeless_get_mod( 'blog_image_filter', 'normal' ) != 'normal' ): ?>
			</figure>
		<?php endif; ?>

	</div><!-- .post-thumbnail --> 
</div><!-- .entry-media --> 