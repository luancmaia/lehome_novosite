<?php
/**
Plugin Name: WooCommerce Update Cart On Quantity Change
Plugin URI: http://www.webnware.com
Description: WooCommerce Update Cart On Quantity Change plugin allows wooCommerce cart to get auto updated when user changes quantity of any product in cart. No more hassel to click on update cart button manually.
Version: 1.0.0
Author: Webnware
Author URI: http://www.webnware.com
*/

/*

*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'WCC_VERSION', '1.0.0' );
define( 'WCC__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WCC__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'wp_enqueue_scripts', 'wcc_enqueue_scripts' );
function wcc_enqueue_scripts() {
	if(is_cart()){
		wp_enqueue_script('wcc-custom',WCC__PLUGIN_URL.'/js/custom.js',array('jquery-core','jquery'),'',true);		
	}
}