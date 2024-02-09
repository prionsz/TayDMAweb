<?php
/**
 * Comment Walker
 * 
 * @package Remake WordPress Theme
 * @subpackage Framework
 * @version 1.0.0
 */

if ( ! class_exists( 'codeless_comment_walker' ) ) :

	class codeless_comment_walker extends Walker_Comment {

		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

		// constructor – wrapper for the comments list
		function __construct() { ?>

			<section class="comments-list">

		<?php }

		// start_lvl – wrapper for child comments list
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			<section class="child-comments comments-list">

		<?php }

		// end_lvl – closing wrapper for child comments list
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }

		// start_el – HTML for comment template
		function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

			if ( 'article' == $args['style'] ) {
				$tag = 'article';
				$add_below = 'comment';
			} else {
				$tag = 'article';
				$add_below = 'comment';
			} ?>

			<article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemscope itemtype="http://schema.org/Comment">
				<div class="comment-content post-content" itemprop="text">
					<figure class="gravatar"><?php echo get_avatar( $comment, 78 ); ?></figure>
					<div class="comment-meta post-meta" role="complementary">
						<div class="comment-author">
							<a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
							<div class="right-part">
								<time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><span><?php comment_date('d/m/Y') ?></span></time>
								<?php comment_reply_link(array_merge( $args, array('reply_text' => '<span><svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.5" d="M4.65625 3V0.34375L0 5L4.65625 9.65625V6.9375C6.34375 6.9375 7.78125 7.21875 8.96875 7.78125C10.1562 8.32292 11.1667 9.17708 12 10.3438C11.625 8.44792 10.9062 6.88542 9.84375 5.65625C8.55208 4.19792 6.82292 3.3125 4.65625 3Z" fill="black"/>
</svg>
'.esc_html__('Reply', 'remake' ).'</span>', 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
								<?php edit_comment_link( esc_html__('Edit this comment','remake' ),'',''); ?>
							</div>
						</div>
						
						
						<?php if ($comment->comment_approved == '0') : ?>
						<p class="comment-meta-item">Your comment is awaiting moderation.</p>
						<?php endif; ?>
						<?php comment_text() ?>
						
					</div>
				</div>

		<?php }

		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

			</article>

		<?php }

		// destructor – closing wrapper for the comments list
		function __destruct() { ?>

			</section>

		<?php }

	}
endif;
?>