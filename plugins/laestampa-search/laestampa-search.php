<?php
/**
* Plugin Name: La Estampa Search
* Author: Luan Cuba
* Author URI: http://luancuba.com.br
* Description: Plugin that enable searchs by product SKU.
**/


define( 'LS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
$url = get_template_directory_uri();

if ( stripos( $url, 'tecidaria' ) ) {
	define( 'LS_SITE', 'tecidaria' );
} 
else if ( stripos( $url, 'laestampa' ) ) {
	define( 'LS_SITE', 'laestampa' );
}

$search = isset($_GET['s']) ? true : false;

if (!is_admin() && !$search) return;

require_once LS_PLUGIN_DIR . "/loader.php";

