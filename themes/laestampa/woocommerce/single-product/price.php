<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

add_filter( 'wc_rbp_product_get_price', 'nome_da_sua_funcao' );
function nome_da_sua_funcao( $wcrbp_price, $product ) {
	$wcrbp_price = 10;
	return $wcrbp_price;
}


?>
<div class="price-sigle">
<p class="price"><?php echo price_type_user($product).'*'; ?></p>
<p class="price-metro">*preço por metro</p>
</div>
