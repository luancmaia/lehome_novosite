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
