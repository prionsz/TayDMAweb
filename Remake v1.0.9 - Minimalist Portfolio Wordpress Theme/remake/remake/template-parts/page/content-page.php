<?php
/**
 * Template part for displaying page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Remake
 * @subpackage Templates
 * @since 1.0.0
 *
 */

$content 	= get_the_content();



$content    = str_replace(']]>', ']]&gt;', apply_filters( 'codeless_the_content' , $content ));
if( codeless_get_page_layout() != 'fullwidth' ){
	$page_header = codeless_extract_page_header($content);
	$content    = str_replace($page_header, '', $content );
}
echo apply_filters('the_content', $content ); 

wp_link_pages( array(
    'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'remake' ),
    'after'       => '</div>',
    'link_before' => '<span class="page-number">',
    'link_after'  => '</span>',
));    

?>
