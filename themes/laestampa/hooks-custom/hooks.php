<?php


/* HOOKS FUNCTIONS DISABLE */

function remove_searchHeader(){
	remove_action('storefront_header', 'storefront_product_search', 40);
}

add_action('init', 'remove_searchHeader');

function remove_meta_product(){
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
}
add_action('init', 'remove_meta_product');

function remove_result_product(){
  remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
}
add_action('init', 'remove_result_product');

function remove_order_product(){
  remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
}
add_action('init', 'remove_order_product');


function add_result_product(){
   
   global $wp_query;

if ( ! woocommerce_products_will_display() ) {
  return;
}
?>
<div class="headerProduct">
<p class="woocommerce-result-count">
  <?php
  $paged    = max( 1, $wp_query->get( 'paged' ) );
  $per_page = $wp_query->get( 'posts_per_page' );
  $total    = $wp_query->found_posts;
  $first    = ( $per_page * $paged ) - $per_page + 1;
  $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

  if ( $total <= $per_page || -1 === $per_page ) {
    /* translators: %d: total results */
    printf( _n( 'Showing the single result', 'Showing all %d results', $total, 'woocommerce' ), $total );
  } else {
    /* translators: 1: first result 2: last result 3: total results */
    printf( _nx( 'Showing the single result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );
  }
  ?>
</p>
<?php
  storefront_sorting_wrapper();

    woocommerce_catalog_ordering();

  storefront_sorting_wrapper_close();
?>

</div>
<?php
        return;
}
add_action( 'woocommerce_after_main_content', 'add_result_product', 20 );




function remove_experct_product(){
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
}
add_action('init', 'remove_experct_product');




function sidebar_petit() {
  get_sidebar();

    if( is_shop() || is_product_category() || is_product_taxonomy() ){
      echo '<div id="primary" class="content-areaArchive col-12 col-md-9">';
    }else{
      echo '<div id="primary" class="content-area_Single">';
    }
  ?>  
    <main id="main" class="site-main" role="main">
  <?php
}
add_action( 'woocommerce_before_main_content','sidebar_petit',10 );


function sidebar_petit_after() {
    ?>
    </main><!-- #main -->
  </div><!-- #primary -->

  <?php 
}
add_action( 'woocommerce_after_main_content','sidebar_petit_after',10 );


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
    $stock = is_papel() ? 100000 : $stock;

     $preco_variable = get_variable_price2($product, $user);

    
  ?>

	<div class="calculo-metro">
    <input type="number" min="1" name="quantity" value="" max="<?php echo $stock; ?>" data-stockProduct="<?php echo $stock; ?>" class="input-text quantidade_necessario text calculo-metros" placeholder="Metros (ex: 100)" title="A quantidade que você digitou é maior do que temos em estoque! No momento só temos <?php echo $stock; ?> metros disponíveis.">

    <input class="price_product" type="hidden" name="priceProd" value="<?php echo $preco_variable; ?>">
    <span>  =  R$</span>
    <span class="result-calculo-metros" data-price="">000,00</span>
	</div>
  
  <?php if( is_papel() != 1 ){ ?>
  <div class="metragem-disponivel">
    <span>Metragem disponível:</span>
    <input type="text" min="1" name="metros" title="Metros" max="5" class="input-text qty_disponivel text input-metros" data-qty="" value="<?php echo $stock; ?>m" disabled>
  </div>
  <?php } ?>
</div>
<?php
}
add_action( 'woocommerce_single_product_summary', 'calc_tecido', 10 );



/* TAB ADICIONAL PARA PRODUTOS */
function cwp_register_woocommerce_product_tab_adicional( $tabs ) {
             
      $tabs['visao_geral'] = array(
            'title'    => __( 'Visao Geral', 'laestampa' ),
            'priority' => 10,
            'callback' => 'cwp_woocommerce_custom_tab_view_visao_geral'
      );
       
      return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'cwp_register_woocommerce_product_tab_adicional' );

//composicao after title loop product
function composicao_afterTitle(){
  global $product;
  $sku = get_post_meta($product->get_id(), 'composicao_descricao', true);
  echo '<p class="composicao_loopTitle">'.$sku.'</p>';
}
add_action( 'woocommerce_shop_loop_item_title', 'composicao_afterTitle', 10 );


