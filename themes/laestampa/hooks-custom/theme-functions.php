<?php

//functions tema
function banner_page($page_id){
$imagem = get_field('imagem_banner', $page_id);
$cor_fundo = get_field('cor_fundo_banner', $page_id);
$cor_title = get_field('cor_titulo_banner', $page_id);

?>
	<div class="banner-page" style="background: url('<?php echo $imagem; ?>') no-repeat;background-size: 100% auto;">
		<div class="title_page sr-only">
			<h1><?php echo get_the_title(); ?></h1>			
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



