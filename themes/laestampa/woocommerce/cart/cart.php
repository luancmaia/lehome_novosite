<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="row">
	<div class="col-12 col-md-12 col-lg-8">
		<?php
			global $woocommerce;
			$itens = $woocommerce->cart->get_cart();
			$count = count($itens);
				
				if ($count > 0) {
				echo '';
				if( $count <=1 ){
					$item = 'item';
				}else{
					$item = 'itens';
				}
				echo '<h1 class="titleCarrinho">Carrinho <span>('.$count.' '.$item.')</span></h1>';
				echo '';
				}
		?>
		
<form class="wc-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<!-- <th class="product-remove" ></th> -->
				 <th class="product-thumbnail">Item</th>
				<th class="product-name" colspan="2"><?php _e( 'Description', 'woocommerce' ); ?></th>
				<!--<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th> -->
				<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<!-- <td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td> -->

						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo $thumbnail;
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
								}
							?>
						</td>

						<td class="product-name" colspan="2" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<?php
								
								$sku = get_post_meta($cart_item['product_id'], 'sku', true);
								$user = current_user();

								$product_id = $cart_item['product_id'];
								$is_papel = is_int(stripos( $sku, 'PAPEL DE PAREDE' ) );
								if( $is_papel == 1 ){
									return true;
								}
								if( $is_papel != 1 ){
									$base = "tecido";
								}else{
									$base = "papel";
								}

								$variationID = $cart_item['variation_id'];
								$stock = get_post_meta( $variationID, '_stock', true );

								if( $base == 'papel'){
											$prazo = '5';
									}else if ($base == 'tecido' && $stock > 0){
											$prazo = '3';
									}else if ($base == 'tecido' && $stock <= 0) {
											$prazo = '30';
									}

									if ( ! $product_permalink ) {
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
									} else {
									
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
									echo '<p class="sku_cart">'.$sku.'</p>';

									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"> </a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );

									echo '<p class="prazo_entrega">Prazo de entrega deste produto é de: <strong>'.$prazo.' dias + Prazo Correios </strong></p>';
								}

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
								}
							?>
						</td>

						<!-- <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td> -->

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							<?php
								 
								 $is_papel = is_papel_ID($product_id);								 
								 if( $is_papel == 1 ){
								 	$tipo = 'papel';
								 	$step = 3;
								 }else{
								 		$tipo = 'tecido';
								 		$step = 1;
								 }
								 
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => '100000',
										'min_value'   => '0',
										'data-tipo'		=> $tipo,
										'step' => apply_filters( 'woocommerce_quantity_input_step', $step, $product ),
									), $_product, false );

								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" />
						
						<div class="box-freteCupom">
						<div class="frete-calcuator">							
							<label class="labelfrete"><?php _e( 'Calcular Frete:', 'woocommerce' ); ?></label> 
								<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
									<p class="form-row form-row-wide" id="calc_shipping_country_field">
										<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
											<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
											<?php
												foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
													echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
												}
											?>
										</select>
									</p>

									<p class="form-row form-row-wide" id="calc_shipping_state_field">
										<?php
											$current_cc = WC()->customer->get_shipping_country();
											$current_r  = WC()->customer->get_shipping_state();
											$states     = WC()->countries->get_states( $current_cc );

											// Hidden Input
											if ( is_array( $states ) && empty( $states ) ) {

												?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'woocommerce' ); ?>" /><?php

											// Dropdown Input
											} elseif ( is_array( $states ) ) {

												?><span>
													<select name="calc_shipping_state" class="state_select" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'woocommerce' ); ?>">
														<option value=""><?php esc_html_e( 'Select a state&hellip;', 'woocommerce' ); ?></option>
														<?php
															foreach ( $states as $ckey => $cvalue ) {
																echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
															}
														?>
													</select>
												</span><?php

											// Standard Input
											} else {

												?><input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / County', 'woocommerce' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

											}
										?>
									</p>

										<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

											<p class="form-row form-row-wide" id="calc_shipping_city_field">
												<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'woocommerce' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
											</p>

										<?php endif; ?>

										<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

											<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
												<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
											</p>

										<?php endif; ?>

										<p><button type="submit" name="calc_shipping" value="1" class="button"><?php _e( 'Update totals', 'woocommerce' ); ?></button></p>

										<?php wp_nonce_field( 'woocommerce-cart' ); ?>
								</form>

						</div>
						<div class="coupon">
							<label class="labelCupom" for="coupon_code"><?php _e( 'Cupom Promocional:', 'woocommerce' ); ?></label> 
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> 
							<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					</div>
					<?php } ?>

					

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
</div>
	<div class="col-12 col-md-12 col-lg-4">
	<div class="cart-collaterals">
		<?php
			/**
			 * woocommerce_cart_collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
		 	do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
