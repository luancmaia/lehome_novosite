<?php
/*
Plugin Name: Blogfarm - Imagem do Produto
Plugin URI:  https://www.blogfarm.com.br
Description: Associação automática da imagem ao produto ao fazer upload
Version:     0.1
Author:      Yuri Correa
Author URI:  https://yuricorrea.com
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
function attach_image_to_product($img_id){
    $attach = get_post($img_id);
    $name = $attach->post_title;
	global $wpdb;
	$foundSku = $wpdb->get_var( $wpdb->prepare( 'SELECT pm.post_id, p.post_title FROM wp_postmeta as pm INNER JOIN wp_posts as p ON pm.post_id = p.ID where p.post_title NOT LIKE "%s" AND p.post_type = "%s" AND pm.meta_value = "%s"','PP%', 'product' ,$name ) );
	if ( $foundSku ):
		update_post_meta( $foundSku, '_sku_image', $attach->ID );
	endif; 
    return $img_id;
}

add_filter('add_attachment', 'attach_image_to_product' );
