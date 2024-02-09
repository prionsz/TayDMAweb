<?php
/**
 * Blog Template Part for displaying single blog related posts
 *
 * @package Remake
 * @subpackage Blog Parts
 * @since 1.0.0
 *
 */
?>

<div class="entry-single-related">
	<h6><?php esc_html_e( 'Recommended Reads', 'remake' ) ?></h6>
	<div class="related-wrapper">
		<?php echo codeless_single_post_related() ?>
	</div>
</div>
