<?php
/*
Plugin Name: Woocommerce Variação de Cor
Description: Variação de Cor com produto simples
Version:     1.0
Plugin URI:  http://luancuba.github.io
Author:      Luan Cuba
Author URI:  http://luancuba.github.io
*/

// add related products selector to product edit screen
function wvc_select_related_products() {
	global $post, $woocommerce;
	$product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $post->ID, '_variacao_cor', true ) ) );
	var_dump($product_ids);

	?>
	<div class="options_group">
		<?php if ( $woocommerce->version >= '2.3' ) : ?> 
			<p class="form-field"><label for="variacao_cor"><?php _e( 'Variação de Cor', 'woocommerce' ); ?></label>
				<input type="hidden" class="wc-product-search" style="width: 50%;" id="variacao_cor" name="variacao_cor" data-placeholder="<?php _e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products" data-multiple="true" data-selected="<?php
					$json_ids = array();
					foreach ( $product_ids as $product_id ) {						
						$product = wc_get_product( $product_id );
						$json_ids[ $product_id ] = wp_kses_post( $product->get_formatted_name() );


					}

					echo esc_attr( json_encode( $json_ids ) );
				?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" /> <img class="help_tip" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
			</p>
		<?php else: ?>
			<p class="form-field"><label for="variacao_cor"><?php _e( 'Variação de Cor', 'woocommerce' ); ?></label>
				<select id="variacao_cor" name="variacao_cor[]" class="ajax_chosen_select_products" multiple="multiple" data-placeholder="<?php _e( 'Search for a product&hellip;', 'woocommerce' ); ?>">
					<?php
						foreach ( $product_ids as $product_id ) {

							$product = get_product( $product_id );

							if ( $product )
								echo '<option value="' . esc_attr( $product_id ) . '" selected="selected">' . esc_html( $product->get_formatted_name() ) . '</option>';
						}
					?>
				</select> 
			</p>
		<?php endif; ?>
	</div>
	<?php
}
add_action('woocommerce_product_options_general_product_data', 'wvc_select_related_products');

// save related products selector on product edit screen
function wvc_save_related_products( $post_id, $post ) {
	global $woocommerce;
	if ( isset( $_POST['variacao_cor'] ) ) {
		if ( $woocommerce->version >= '2.3' ) {
		$related = isset( $_POST['variacao_cor'] ) ? array_filter( array_map( 'intval', explode( ',', $_POST['variacao_cor'] ) ) ) : array();
		} else {
			$related = array();
			$ids = $_POST['variacao_cor'];
			foreach ( $ids as $id ) {
				if ( $id && $id > 0 ) { $related[] = $id; }
			}
		}
		update_post_meta( $post_id, '_variacao_cor', $related );
	} else {
		delete_post_meta( $post_id, '_variacao_cor' );
	}
}
add_action( 'woocommerce_process_product_meta', 'wvc_save_related_products', 10, 2 );