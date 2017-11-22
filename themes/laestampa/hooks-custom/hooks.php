<?php


/* HOOKS FUNCTIONS DISABLE */

function remove_searchHeader(){
	remove_action('storefront_header', 'storefront_product_search', 40);
}

add_action('init', 'remove_searchHeader');





