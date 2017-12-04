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
  <?php 
    if( is_papel() == 1 ){

      echo '<span class="ask-calculator">
              <strong>De quantos metros você precisa?</strong> Use a calculadora e Faça o cálculo.
            </span>';

      echo '<div class="box_calculator">' .calculator_papel(). '</div>'; 
    }else{
      echo '<span class="ask-calculator">
              <strong>De quantos metros você precisa?</strong> Faça o cálculo do valor.
            </span>';
    }
  ?>
<?php
    $user = current_user();
    $stock = get_variable_stock($product, $user);
  ?>

	<div class="calculo-metro">
    <input type="number" min="1" name="quantity" value="" max="<?php echo $stock; ?>" data-stockProduct="<?php echo $stock; ?>" class="input-text quantidade_necessario text calculo-metros" placeholder="Metros (ex: 100)" title="A quantidade que você digitou é maior do que temos em estoque! No momento só temos <?php echo $stock; ?> metros disponíveis.">

    <input class="price_product" type="hidden" name="priceProd" value="<?php echo $product->get_price(); ?>">
    <span>  =  R$</span>
    <span class="result-calculo-metros" data-price="">000,00</span>
	</div>
  
  <div class="metragem-disponivel">
    <span>Metragem disponível:</span>
    <input type="text" min="1" name="metros" title="Metros" max="5" class="input-text qty_disponivel text input-metros" data-qty="" value="<?php echo $stock; ?>m" disabled>
  </div>
</div>
<?php
}
add_action( 'woocommerce_single_product_summary', 'calc_tecido', 10 );







