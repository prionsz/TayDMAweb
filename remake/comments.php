<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Remake WordPress Theme
 * @subpackage Templates
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment!
	
	if ( have_comments() ) : ?>
		
		<div class="cl-comments">

			<div class="cl-comments-wrapper">

				<h6 class="comments-title">
					<?php
						$comments_number = get_comments_number();
						if( $comments_number == 1 )
							echo codeless_complex_esc( $comments_number ) . ' ' . esc_html__('Comment', 'remake');
						else
							echo codeless_complex_esc( $comments_number ) . ' ' . esc_html__('Comments', 'remake');
					?>
				</h6>

				<ol class="comment-list"> 
					<?php
						wp_list_comments( array(
							'walker'      => new codeless_comment_walker(),
							'style'       => 'ul',
							'short_ping'  => true,

						) );
					?>
				</ol>

				<?php the_comments_pagination( array(
					'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous', 'remake' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next', 'remake' ) . '</span>',
				) );

			

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'remake' ); ?></p>
			<?php
			endif; ?>
		</div>
	</div>

	<?php endif;  // Check for have_comments(). ?>

	<?php ?>
	
	<div class="cl-comment-reply ">
		<?php comment_form( array( 'title_reply_before' => '<h6 id="reply-title" class="comment-reply-title">', 'title_reply_after' => '</h6>' ) );
		?>
	</div>

</div><!-- #comments -->
