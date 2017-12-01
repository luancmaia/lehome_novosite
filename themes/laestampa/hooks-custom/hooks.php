<?php


/* HOOKS FUNCTIONS DISABLE */

function remove_searchHeader(){
	remove_action('storefront_header', 'storefront_product_search', 40);
}

add_action('init', 'remove_searchHeader');


//funcao calculo do tecido

function calc_tecido(){
  global $product;

//echo '<pre>' . print_r($product,true) . '</pre>';
?>
<div class="tecido-calc">
	<span class="ask-calculator">
		<strong>De quantos metros você precisa?</strong> Faça o cálculo do valor.
	</span>
	<div class="calculo-metro">
    <input type="number" min="1" name="metros" title="Metros" value="" max="5" class="input-text qty text calculo-metros" placeholder="Metros (ex: 100)">
    <input class="price_product" type="hidden" name="priceProd" value="<?php echo $product->get_price(); ?>">
    <span>  =  R$</span>
    <span class="result-calculo-metros" data-price="">000,00</span>
	</div>
  <?php
    $user = current_user();
    $stock = get_variable_stock($product, $user);
  ?>
  <div class="metragem-disponivel">
    <span>Metragem disponível:</span>
    <input type="text" min="1" name="metros" title="Metros" max="5" class="input-text qty text input-metros" data-qty="" value="<?php echo $stock; ?>m" disabled>
  </div>
</div>
<?php
}
add_action( 'woocommerce_single_product_summary', 'calc_tecido', 10 );






