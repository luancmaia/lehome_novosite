<?php

//funcao da logo
if ( ! function_exists( 'storefront_site_title_or_logo' ) ) {
function storefront_site_title_or_logo( $echo = true ) {
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
	$logo = get_custom_logo();
	$html = is_home() || is_front_page() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
	} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
	// Copied from jetpack_the_site_logo() function.
	$logo    = site_logo()->logo;
	$logo_id = get_theme_mod( 'custom_logo' ); // Check for WP 4.5 Site Logo
	$logo_id = $logo_id ? $logo_id : $logo['id']; // Use WP Core logo if present, otherwise use Jetpack's.
	$size    = site_logo()->theme_size();
	$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( home_url( '/' ) ),
		wp_get_attachment_image(
			$logo_id,
			$size,
			false,
			array(
				'class'     => 'site-logo attachment-' . $size,
				'data-size' => $size,
				'itemprop'  => 'logo'
			)
		)
	);

	$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
	} else {
	$tag = is_home() ? 'h1' : 'div';

	$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

	if ( '' !== get_bloginfo( 'description' ) ) {
		$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
	}
	}

	if ( ! $echo ) {
	return $html;
	}

	echo $html;
	}
}
//funcao para pegar o preco do produto variavel
function get_variable_price( $product, $tipo ) {
	$variations = $product->get_available_variations();
	foreach($variations as $v) {
		$type = $v['attributes']['attribute_tipo-de-usuario'];
		if ( $type == $tipo ) {
			$variation = wc_get_product( $v['variation_id'] );
			return $variation->get_price_html();
		}
	}
}


function current_user(){
	$current_user = wp_get_current_user();
	if ( !is_user_logged_in() ) {
		$role = 'PF';
		return $role;
	}
	$id_user = $current_user->ID;

	$user_info = get_userdata($id_user);
	$role = implode(', ', $user_info->roles);



	if( $role == 'administrator' ){
		$role = 'PF';
	}elseif( $role == 'revenda' ){
		$role = 'PJ';
	}elseif( $role == 'customer' ){
		$role = 'PF';
	}
	return $role;
}

//funcao para pegar o preco do produto variavel
function get_variable_stock( $product, $tipo ) {
	$variations = $product->get_available_variations();
	foreach($variations as $v) {
		$type = $v['attributes']['attribute_tipo-de-usuario'];
		if ( $type == $tipo ) {
			$stock = get_post_meta( $v['variation_id'], '_stock', true );
			return $stock;
		}
	}
}

//funcao para criar user revenda
	add_role('revenda', 'Revenda', array(
		'read' => true, 
		'edit_posts' => false,
		'delete_posts' => false, 
	));

	function tipo_user( $type ){
		$current_user = wp_get_current_user();

		$caps = $current_user->caps;
		return array_key_exists( $type, $caps );
	}


	//funcao para exibir o preco do produto de acordo com o usuário logado
function price_type_user($product){
	$tipo = 'PF';
	if ( tipo_user( 'administrator') ) {
		$price = $product->get_price_html();
	} elseif( tipo_user( 'revenda')) {
		$tipo = 'PJ';
		$price = get_variable_price( $product, $tipo );
	}else{
		$price = get_variable_price( $product, $tipo );
	}
	return $price;
}	

//pegar o estoque do produto variavel
function stock_type_user($product){
	$tipo = 'PF';
	if ( tipo_user( 'administrator') ) {
		$stock = $product->get_available_variations();
	} elseif( tipo_user( 'revenda')) {
		$tipo = 'PJ';
		$stock = get_available_variations($product, $tipo);
	}else{
		$stock = get_available_variations($product, $tipo);
	}
	return $stock;
}	























