
	 .select2-container--default .select2-results__option--highlighted[aria-selected]{ background-color: <?php echo codeless_get_mod('primary_color', '#1fb4cc') ?> !important; color:#fff !important } 


	 .woocommerce-page .shop-products{ margin-left: -<?php echo codeless_get_mod( 'shop_item_distance', 15 ); ?>px; margin-right: -<?php echo codeless_get_mod( 'shop_item_distance', 15 ); ?>px; }


	 <?php $terms = get_terms(); if( $terms ): foreach($terms as $term): ?>
		
		<?php $cat_data = get_option('category_'.$term->term_id); if( is_array( $cat_data ) && $cat_data['color'] ) : ?>
			.tag-link-<?php echo esc_attr( $term->term_id ) ?>{
				background-color:<?php echo esc_attr( $cat_data['color'] ); ?>;
			}
		<?php endif; ?>
	
	<?php endforeach; endif; ?>
  
<?php  echo codeless_get_mod('custom_css'); ?>

	