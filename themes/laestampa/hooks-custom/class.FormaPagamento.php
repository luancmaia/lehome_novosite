<?php
   

if ( ! class_exists('FormaPagamento') ){
   
   class FormaPagamento {
      private $parcelamentos = array();
      const parcela_minima = 500;
      private $desconto;
      public function __construct(){
         session_start();
         global $woocommerce;
         $this->parcelamentos['avista'] = new Parcelamento( 'À Vista', 1 );
         $this->parcelamentos['15'] = new Parcelamento( '15 dias', 2 );

         $userCurrency = get_current_user_id();
         $pagamento_diferenciado = get_field('pagamento_diferenciado', 'user_'.$userCurrency);

         if( $pagamento_diferenciado == "sim" ){
             $prazoPagamento = get_field('prazo_pagamento_diferenciado', 'user_'.$userCurrency);
            foreach ($prazoPagamento as $prazo) {
               $this->parcelamentos[$prazo] = new Parcelamento($prazo.' dias', 3);
            }
         }

      }
      public function aplicar_regras_desconto(){ // isso processa no checkout
         global $woocommerce;
   		if ( $this->get_forma_pagamento_sessao() == 'avista' ) {
   			if(!defined('DESCONTO_PRODUTO')) define('DESCONTO_PRODUTO', 5);
   		}
         error_log($total_compra . ' - ' . $this->get_forma_pagamento_sessao() . ' - ' . DESCONTO_PRODUTO , 0);
   		if(!defined('DESCONTO_PRODUTO')) define('DESCONTO_PRODUTO', 0);
      } // poderia ter incluido os defines de cima mas ia complicar na leitura
      public function get_options_parcelamento(){ // para exibicao da combo de parcelamento
         global $woocommerce;
         $total_compra = intval( $woocommerce->cart->cart_contents_total );
         $options = array( 
         'avista' => $this->parcelamentos['avista']->nome . ' - 5% de desconto',
         '15' => $this->parcelamentos['15']->nome



         );
         $aux[''] = 'SELECIONE';
         $aux['avista'] = $options['avista']; // esta sempre havera
         $aux['15'] = $options['15'];

         $userCurrency = get_current_user_id();
         $pagamento_diferenciado = get_field('pagamento_diferenciado', 'user_'.$userCurrency);
         if( $pagamento_diferenciado == "sim" ){
             $prazoPagamento = get_field('prazo_pagamento_diferenciado', 'user_'.$userCurrency);
            foreach ($prazoPagamento as $prazo) {
               $options[$prazo] = $this->parcelamentos[$prazo]->nome;
               $aux[$prazo] = $options[$prazo];
            }
         }    
         
         return $aux;
      }
      public function get_parcelamentos_disponiveis(){
         $options = $this->get_options_parcelamento();
         return ['avista', '15'];
      }
      public function set_forma_pagamento_sessao($val){
         $_SESSION['payment'] = $val;
      }
      public function get_forma_pagamento_sessao(){
         return $_SESSION['payment'];
      }
   }
}

class Parcelamento {
   function __construct( $nome, $parcelas ){
      $this->nome = $nome;
      $this->parcelas = $parcelas;
   }
}
