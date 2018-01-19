<?php
include_once('class.FormaPagamento.php');

	
$forma_pagamento = new FormaPagamento();
wp_deregister_script('wc-add-to-cart');
wp_register_script('wc-add-to-cart', get_bloginfo( 'stylesheet_directory' ). '/assets/js/add-to-cart.js' , array( 'jquery' ), WC_VERSION, TRUE);
wp_enqueue_script('wc-add-to-cart');

	add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

	function my_custom_checkout_field_process() {
	    // Check if set, if its not set add an error.

	    if ( ! $_POST['forma_pagamento'] )
	        wc_add_notice( __( 'Selecione uma forma de pagamento.' ), 'error' );
	}



	/**
	* Update the order meta with field value
	**/
	add_action('woocommerce_checkout_update_order_meta', 'my_club_checkout_field_update_order_meta');

	function my_club_checkout_field_update_order_meta( $order_id ) {

		if ($_POST['forma_pagamento']) {
			update_post_meta( $order_id, 'forma_pagamento', esc_attr($_POST['forma_pagamento']));
		}
	}

	/**
	 * Add the field to the checkout
	 */
	add_action( 'woocommerce_before_order_notes', 'my_custom_checkout_field' );

	function my_custom_checkout_field( $checkout ) {
		global $woocommerce, $forma_pagamento;
		$args = array( 'role__in' => 'vendedor' );
		$users = get_users( $args );
		$options = array();
		$options[''] = 'SELECIONE';
		$options['Nenhum'] = 'Nenhum';
	 
	   $forma_pagamento->set_forma_pagamento_sessao(null); // remove escolha anterior da sessao

	   $current_user = current_user();

	   if( $current_user != "pf" ){
		   	 woocommerce_form_field( 'forma_pagamento', array(
		      'type'          => 'select',
		      'options' => $forma_pagamento->get_options_parcelamento(),
		      'required' => true,
		      'class'         => array(''),
		      'label'         => __('Selecione uma forma de pagamento'),
		      ), $checkout->get_value( 'forma_pagamento' )
		   );
	   }	  
	}

	add_action( 'woocommerce_add_order_item_meta', function($item_id, $values, $cart_item_key) {
		global $woocommerce;
		$cart_items = $woocommerce->cart->get_cart();
		wc_add_order_item_meta($item_id, 'sku_', get_post_meta($cart_items[$cart_item_key]['product_id'], 'sku', true));
	}, 1, 4);


	function woocommerce_custom_discount(){
      		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
      			global $forma_pagamento;
      			if ( !$forma_pagamento->get_forma_pagamento_sessao() ) return;
      				$forma_pagamento->aplicar_regras_desconto();
      				aplicar_desconto_por_produto();
	}


	function aplicar_desconto_por_produto(){
	   	global $woocommerce;
	   	$produtos_carrinho = $woocommerce->cart->cart_contents;
      		$total_produtos = count($produtos_carrinho);
      		add_action('woocommerce_add_order_item_meta',function($item_id, $values, $cart_item_key){
         		global $woocommerce;
         		$cart_items = $woocommerce->cart->get_cart();
         		$valor = $cart_items[$cart_item_key]['data']->price * ( (100- (DESCONTO_PRODUTO + get_desconto_produto_estoque_restante($cart_items[$cart_item_key])) ) / 100);
         		wc_add_order_item_meta($item_id,'valor-metro-com-desconto',round($valor, 2));
      		},1,3);
      foreach ($produtos_carrinho as $k=>$p){
         $desconto_extra = get_desconto_produto_estoque_restante($p);
         if( (DESCONTO_PRODUTO + $desconto_extra) <1) continue;
         $valor_desconto = abs($p['line_total'] * ( (DESCONTO_PRODUTO+$desconto_extra) / 100)) * (-1);
         $woocommerce->cart->add_fee( '('.(DESCONTO_PRODUTO+$desconto_extra).'% '.$p['data']->post->post_title.')', $valor_desconto, true, '' );
      }
	}
   function get_desconto_produto_estoque_restante($item){
      $product_id = $item['product_id'];
      if($_SESSION['desconto-estoque'][$product_id]){
         $stock = get_post_meta($product_id, '_stock', true);
         if($stock == $item['quantity'])
            return $_SESSION['desconto-estoque'][$product_id];
      }
      return 0;
   }
   add_action( 'wp_ajax_le_promo_estoque_restante', function(){
      session_start();
      if(!$_SESSION['desconto-estoque'])
         $_SESSION['desconto-estoque'] = array();
      $_SESSION['desconto-estoque'][$_REQUEST['product_id']] = 5; // desconto que sera dado a esse produto
      wp_die();
   });


  add_action( 'wp_ajax_le_forma_pagamento', 'le_forma_pagamento' );
	add_action( 'wp_ajax_nopriv_le_forma_pagamento', 'le_forma_pagamento' );
	add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_discount' );
	function le_forma_pagamento() {
		$request = (object) $_POST;
		$response = (object) array(
			'message' => 'Houve um erro',
			'status' => false,
		);
      global $forma_pagamento;
		if ( empty( $request->pagamento ) || ! in_array( $request->pagamento, $forma_pagamento->get_parcelamentos_disponiveis() ) )
			return;

		$forma_pagamento->set_forma_pagamento_sessao( $request->pagamento );

		$response->status = true;
		$response->message = 'Session defined as ' . $forma_pagamento->get_forma_pagamento_sessao();

		exit( json_encode( $response ) );

	}
	add_action( 'wp_head', 'ga_home' );
	function ga_home() { ?>
		<script>

 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

 })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-97623485-1', 'auto');

 ga('send', 'pageview');

</script>	
	<?php }

