<?php
/**
 * Template part for displaying posts
 * Grid Standard Style
 * Switch styles at Theme Options (WP Customizer)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Remake
 * @subpackage Templates
 * @since 1.0.0
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( codeless_extra_classes( 'entry' ) ); ?> <?php echo codeless_extra_attr( 'entry' ) ?>>
	<div class="media-wrapper">
	<?php 
	
	$post_format = get_post_format() || '';
	
	/**
	 * Generate Post Thumbnail for Single Post and Blog Page
	 */ 
	
	if ( has_post_thumbnail() && $post_format != 'gallery' ) :
		
		get_template_part( 'template-parts/blog/parts/entry', 'thumbnail' );
	
	endif; ?>
	
	
	<?php
	
	/**
	 * Generate Slider if needed
	 */ 
	if ( get_post_format() == 'gallery' && codeless_post_galleries_data( get_post( get_the_ID() ) ) ):
	
		get_template_part( 'template-parts/blog/parts/entry', 'slider' );
	
	endif; ?>
	
	<?php
	
	/**
	 * Generate Video Output
	 */ 
	if ( get_post_format() == 'video' ):
	
		get_template_part( 'template-parts/blog/parts/entry', 'video' );
	
	endif; ?>
	
	<?php
	
	/**
	 * Generate Audio Output
	 */ 
	if ( get_post_format() == 'audio' ):
	
		get_template_part( 'template-parts/blog/parts/entry', 'audio' );
	
	endif; ?>

	</div>
	
	<div class="entry-wrapper">

		<div class="entry-wrapper-content">

            <?php echo codeless_get_category_colored(); ?>

			<?php


				/**
				 * Entry Header
				 * Output Entry Meta and title
				 */ 
				?>
				<header class="entry-header">

					<?php
						if( get_post_format() != 'quote' ) {
							the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						}
                    ?>
                    
                    <?php codeless_output_entry_meta(false) ?>

                    <?php get_template_part( 'template-parts/blog/formats/content', get_post_format() ) ?>

				</header><!-- .entry-header -->
		</div><!-- .entry-wrapper-content -->

	</div><!-- .entry-wrapper -->
	
</article><!-- #post-## -->
