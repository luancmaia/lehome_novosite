<?php

//functions tema
function banner_page($page_id){
$imagem = get_field('imagem_banner', $page_id);
$cor_fundo = get_field('cor_fundo_banner', $page_id);
$cor_title = get_field('cor_titulo_banner', $page_id);
	
	if( $imagem ){
		echo '<div class="banner-page" style="background: url('.$imagem.') no-repeat;background-size: 100% auto;">';
		echo '<div class="title_page sr-only">';
	}else{
		echo '<div class="banner-page" style="background-color: '.$cor_fundo.'">';
		echo '<div class="title_page text-center">';	
	}
?>	
	<h1 style="color:<?php echo $cor_title; ?>"><?php echo get_the_title(); ?></h1>		
		</div>	
	</div>
<?php
	return;	
}


function my_custom_add_to_cart_redirect( $url ) {
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url .= '?add_to_cart=true';
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect' );



function nova_ordem_catalogo( $orderby ) {
    unset($orderby["popularity"]);
    unset($orderby["rating"]);
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "nova_ordem_catalogo", 20 );



