<?php

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );


// Build new PRODUCT (CONTENT-PRODUCT)
add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_loop_product_image_open' );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
    add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_loop_product_overlay_open' );
        add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_overlay_buttons' );
            add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart' );
            add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_view_details_link' );
        add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_close_overlay_buttons' ); // Overlay Buttons Close
    add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_close_product_overlay' ); // Overlay Close
add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_close_product_image' ); // Product Image Wrapper Close

add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_title_wrapper' );
	add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_title_wrapper_inner' );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open' );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close' );
		add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_category' );
	add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_close_title_wrapper_inner' );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price' );
add_action( 'woocommerce_before_shop_loop_item_title', 'codeless_woo_close_title_wrapper' ); // Title Wrapper Close

add_filter( 'woocommerce_product_loop_title_classes', 'codeless_woo_add_class_loop_title' );
function codeless_woo_add_class_loop_title( $class ){
    $class .= ' custom_font h4';
    return $class;
}

function codeless_woo_title_wrapper(){
    ?>
    <div class="cl-woo-product__title-wrapper">
    <?php
}
function codeless_woo_close_title_wrapper(){
    ?>
    </div>
    <?php
}


function codeless_woo_loop_product_image_open(){
    ?>
    <div class="cl-woo-product__wrapper">
		<a href="<?php echo get_permalink() ?>" class="image-link"></a>
    <?php
}
function codeless_woo_close_product_image(){
    ?>
    </div>
    <?php
}


function codeless_woo_loop_product_overlay_open(){
    ?>
    <div class="cl-woo-product__overlay">
    <?php
}
function codeless_woo_close_product_overlay(){
    ?>
    </div>
    <?php
}


function codeless_woo_overlay_buttons(){
    ?>
    <div class="cl-woo-product__overlay-buttons">
    <?php
}
function codeless_woo_close_overlay_buttons(){
    ?>
    </div>
    <?php
}

function codeless_woo_view_details_link(){
	$product = wc_get_product( get_the_ID() );
    ?>
	<a href="<?php echo get_permalink() ?>" class="cl-view-details">
		<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M6.98438 18V15.9844H3.42188L7.92188 11.4844L6.51562 10.0781L2.01562 14.5781V11.0156H0V18H6.98438ZM11.4844 7.92188L15.9844 3.42188V6.98438H18V0H11.0156V2.01562H14.5781L10.0781 6.51562L11.4844 7.92188Z" fill="black"/>
		</svg>
	</a>
	<?php if( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ): ?>
	<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', get_the_ID(), get_permalink( get_option('yith_wcwl_wishlist_page_id') ) ) ) ?>"  data-product-id="<?php echo get_the_ID() ?>" data-product-type="<?php echo esc_attr( $product->get_type() )  ?>" class="add_to_wishlist">
		<svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M10.0938 15.5625L10 15.6562L9.90625 15.5625C7.90625 13.75 6.51562 12.4531 5.73438 11.6719C4.48438 10.4219 3.5625 9.34375 2.96875 8.4375C2.3125 7.40625 1.98438 6.42188 1.98438 5.48438C1.98438 4.48438 2.3125 3.65625 2.96875 3C3.65625 2.34375 4.5 2.01562 5.5 2.01562C6.28125 2.01562 7 2.23438 7.65625 2.67188C8.34375 3.10937 8.8125 3.67187 9.0625 4.35938H10.9375C11.1875 3.67187 11.6406 3.10937 12.2969 2.67188C12.9844 2.23438 13.7188 2.01562 14.5 2.01562C15.5 2.01562 16.3281 2.34375 16.9844 3C17.6719 3.65625 18.0156 4.48438 18.0156 5.48438C18.0156 6.42188 17.6875 7.40625 17.0312 8.4375C16.4375 9.34375 15.5156 10.4219 14.2656 11.6719C13.4844 12.4531 12.0938 13.75 10.0938 15.5625ZM14.5 0C13.625 0 12.7969 0.1875 12.0156 0.5625C11.2344 0.9375 10.5625 1.4375 10 2.0625C9.4375 1.4375 8.76562 0.9375 7.98438 0.5625C7.20312 0.1875 6.375 0 5.5 0C4.5 0 3.57812 0.25 2.73438 0.75C1.89062 1.21875 1.21875 1.875 0.71875 2.71875C0.25 3.5625 0.015625 4.48438 0.015625 5.48438C0.015625 6.70312 0.375 7.92188 1.09375 9.14062C1.71875 10.2031 2.70312 11.4219 4.04688 12.7969C4.89062 13.6719 6.39062 15.0781 8.54688 17.0156L10 18.3281L11.4531 17.0156C13.6094 15.0781 15.1094 13.6719 15.9531 12.7969C17.2969 11.4219 18.2812 10.2031 18.9062 9.14062C19.625 7.92188 19.9844 6.70312 19.9844 5.48438C19.9844 4.48438 19.7344 3.5625 19.2344 2.71875C18.7656 1.875 18.1094 1.21875 17.2656 0.75C16.4219 0.25 15.5 0 14.5 0Z" fill="black"/>
		</svg>
	</a>
	<?php endif; ?>
    <?php
}

add_filter( 'woocommerce_format_sale_price', 'codeless_woo_format_sale_price', 999, 3 );
function codeless_woo_format_sale_price( $price, $regular_price, $sale_price ) {
	$price = '<del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del> <ins>' . esc_html__('NOW', 'remake') . ' ' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins>';
	return $price;
}

// function that generate woocommerce plugin content
function codeless_woocommerce_content(){
	woocommerce_content();
}


function codeless_woo_product_class($classes){

    if( codeless_get_mod( 'shop_animation', 'bottom-t-top' ) != 'none' && !is_single() ){
        $classes[] = 'animate_on_visible';
        $classes[] = codeless_get_mod( 'shop_animation', 'bottom-t-top' );
    }
    return $classes;
}
add_filter('woocommerce_post_class', 'codeless_woo_product_class');


if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'codeless_cart_update_count' );
} else {
	add_filter( 'add_to_cart_fragments', 'codeless_cart_update_count' );
}

function codeless_cart_update_count( $fragments ){
	ob_start();
	echo '<span class="cl-cart-total-fragment cart-total">' . WC()->cart->get_cart_contents_count() . ' '.esc_html__('Item(s)', 'remake').' - </span>';

    $fragments['.cl-cart-total-fragment'] = ob_get_clean();
    
    ob_start();
	echo '<span class="cl-cart-total-sum-fragment cart-total-sum">&nbsp;' . WC()->cart->get_cart_total() .'</span>'; 

    $fragments['.cl-cart-total-sum-fragment'] = ob_get_clean();


	return $fragments;
}


function codeless_woo_category(){
	$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

    if ( $product_cats && ! is_wp_error ( $product_cats ) ){

        $single_cat = array_shift( $product_cats ); ?>

        <h6 itemprop="name" class="product_category_title"><?php echo codeless_complex_esc( $single_cat->name ); ?></h6>

<?php }
}

function codeless_woo_title_wrapper_inner(){
	?>
	<div class="inner">
	<?php
}

function codeless_woo_close_title_wrapper_inner(){
	?>
	</div>
	<?php
}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'codeless_loop_columns', 999);
if (!function_exists('codeless_loop_columns')) {
	function codeless_loop_columns() {
        return codeless_get_mod( 'shop_columns', 3 ); // 3 products per row
	}
}

add_filter( 'woocommerce_product_loop_start', 'codeless_woo_product_loop_start' );
function codeless_woo_product_loop_start(){
	?>
	<ul class="products shop-products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> <?php echo codeless_extra_classes( 'shop_products' ) ?>" <?php echo codeless_extra_attr( 'shop_products' ) ?>>
	<?php
}


/**
 * Manage Classes of Shop Entries Div
 * @since 1.0.0
 */
function codeless_extra_classes_shop_products( $classes ) {
    if( codeless_get_mod( 'shop_carousel', false ) ){
		$classes[] .= 'owl-carousel';
		$classes[] = 'owl-theme';
		$classes[] = 'cl-carousel'; 
	}
    return $classes;
}

/**
 * Manage Attributes of Shop Entries
 * @since 1.0.0
 */
function codeless_extra_attr_shop_products( $attr ) {
	$attr[] = 'data-grid-cols="'.esc_attr( wc_get_loop_prop( 'columns' ) ).'"';
    return $attr;
}

// Shop Entries: Extra Classes
add_filter( 'codeless_extra_classes_shop_products', 'codeless_extra_classes_shop_products' );
// Shop Entries: Extra Attributes
add_filter( 'codeless_extra_attr_shop_products', 'codeless_extra_attr_shop_products' );

add_filter( 'woocommerce_loop_add_to_cart_link', 'codeless_woo_loop_add_to_cart', 99, 2 );
function codeless_woo_loop_add_to_cart( $args, $product ){
	return sprintf( '<a href="%s" data-quantity="%s" class="%s" %s><svg width="24" height="24" viewBox="2 3 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M11.0156 9H12.9844V6H15.9844V3.98438H12.9844V0.984375H11.0156V3.98438H8.01562V6H11.0156V9ZM6.98438 18C6.45312 18 5.98438 18.2031 5.57812 18.6094C5.20312 18.9844 5.01562 19.4531 5.01562 20.0156C5.01562 20.5469 5.20312 21 5.57812 21.375C5.98438 21.7812 6.45312 21.9844 6.98438 21.9844C7.54688 21.9844 8.01562 21.7812 8.39062 21.375C8.79688 21 9 20.5469 9 20.0156C9 19.4531 8.79688 18.9844 8.39062 18.6094C8.01562 18.2031 7.54688 18 6.98438 18ZM17.0156 18C16.4531 18 15.9688 18.2031 15.5625 18.6094C15.1875 18.9844 15 19.4531 15 20.0156C15 20.5469 15.1875 21 15.5625 21.375C15.9688 21.7812 16.4375 21.9844 16.9688 21.9844C17.5312 21.9844 18 21.7812 18.375 21.375C18.7812 21 18.9844 20.5469 18.9844 20.0156C18.9844 19.4531 18.7812 18.9844 18.375 18.6094C18 18.2031 17.5469 18 17.0156 18ZM7.17188 14.7656L7.21875 14.625L8.10938 12.9844H15.5625C15.9375 12.9844 16.2812 12.8906 16.5938 12.7031C16.9062 12.5156 17.1406 12.2656 17.2969 11.9531L21.1406 4.96875L19.4062 3.98438L15.5625 11.0156H8.53125L4.26562 2.01562H0.984375V3.98438H3L6.60938 11.5781L5.25 14.0625C5.09375 14.3438 5.01562 14.6562 5.01562 15C5.01562 15.5625 5.20312 16.0469 5.57812 16.4531C5.98438 16.8281 6.45312 17.0156 6.98438 17.0156H18.9844V15H7.40625C7.34375 15 7.28125 14.9844 7.21875 14.9531C7.1875 14.8906 7.17188 14.8281 7.17188 14.7656Z" fill="black"/>
	</svg>
	
	</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : ''
	);
}

add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb' );


add_filter( 'woocommerce_get_image_size_single', function( $size ) {
	return array(
		'width' => 600,
		'height' => 720,
		'crop' => 1,
	);
}, 999 );


add_filter( 'woocommerce_single_product_carousel_options', 'codeless_update_woo_flexslider_options' );

function codeless_update_woo_flexslider_options( $options ) {

    $options['directionNav'] = true;
	$options['prevText'] = '';
	$options['nextText'] = '';
    return $options;
}

add_action( 'woocommerce_before_quantity_input_field', 'codeless_woo_quantity_minus' );
function codeless_woo_quantity_minus(){
	?>
	<label>Qty:</label>
	<div class="qty_input">
		<a href="#" class="qty_button minus"><i class="feather feather-minus"></i></a>
	<?php
}

add_action( 'woocommerce_after_quantity_input_field', 'codeless_woo_quantity_plus' );
function codeless_woo_quantity_plus(){
	?>
		<a href="#" class="qty_button plus"><i class="feather feather-plus"></i></a>
	</div>
	<?php
}

add_action( 'woocommerce_after_add_to_cart_button', 'codeless_woo_add_wishlist' );
function codeless_woo_add_wishlist(){
	if( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) )
		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
}

add_filter( 'woocommerce_output_related_products_args', 'codeless_related_products_args', 20 );
  function codeless_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}


add_action( 'woocommerce_single_product_summary', 'codeless_woo_sharing', 31 );
function codeless_woo_sharing(){
	echo codeless_get_entry_tool_share('<span>'.esc_html__('Share this:', 'remake').'</span>');
}


/* Woocommerce Shop Loop */
add_action( 'woocommerce_before_shop_loop', 'codeless_before_shop_loop_wrapper', 19);
function codeless_before_shop_loop_wrapper(){
	?>
	<div class="results-wrapper">
	<?php
}

add_action( 'woocommerce_before_shop_loop', 'codeless_before_shop_loop_wrapper_end', 31);
function codeless_before_shop_loop_wrapper_end(){
	?>
	</div>
	<?php
}


function codeless_woo_product_extra_attr(){
	$attr = '';
	if( codeless_get_mod( 'shop_animation', 'bottom-t-top' ) != 'none' && !is_single() ){
		$attr .= 'data-speed="400"';
		$default_delay = 300;
		$counter = 1;

		if( codeless_loop_counter() != 0  ){

			$counter = codeless_loop_counter();

			if( $counter > codeless_get_mod( 'shop_columns', 3 ) )
				$counter = $counter % codeless_get_mod( 'shop_columns', 3 );

			if( $counter == 0 )
				$counter = codeless_get_mod( 'shop_columns', 3 );

			$default_delay = 100;
		}
		$attr .= ' data-delay="'. ( $default_delay * $counter ) .'"';
	}

	return $attr;
}

?>