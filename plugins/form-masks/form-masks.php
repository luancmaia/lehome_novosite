<?php
/**
 * Plugin Name: Form Masks
 * Plugin URI:
 * Description: Uses jquery mask plugin to create default masks classes
 * Version: 2.1
 * Author: Raphael Freitas
 * Author URI: topwebrj.com.br
 * 
 */

function form_masks(){

	$folder = plugins_url('form-masks');

	wp_deregister_script('jquery');
    wp_register_script('jquery', $folder . '/js/jquery-2.1.4.min.js', false, '2.1.4');
    wp_enqueue_script( 'jquery-mask-min-js', $folder . '/js/jquery.mask.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'form-masks-min-js', $folder . '/js/form.masks.min.js', array('jquery'), '1.0.0', true );

}
add_action('wp_head', 'form_masks');
