<?php

namespace laestampa;

class Search {

	public function __construct() {
		add_filter( 'posts_join', array( $this, 'add_sql_join' ) );
		add_filter( 'posts_where', array( $this, 'add_sql_where' ) );
		add_action( 'pre_get_posts', array( $this, 'exclude_categories' ) );
		add_action( 'pre_get_posts', array( $this, 'add_min_stock' ) );
		add_filter( 'posts_distinct', array( $this, 'add_sql_distinct' ) );
	}

	public function exclude_categories( $q ) {
		if ( is_admin() || ! is_product_category( 'nossas-bases' ) ) return;
		$q->set( 'tax_query', array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => array( 'nossos-tecidos' ),
				'operator' => 'NOT IN'
			)
			)
		);
	}

	public function add_min_stock( $q ) {
		if ( is_admin() || $q->query_vars['post_type'] !== 'product' || !( defined( 'LS_SITE' ) && LS_SITE == 'laestampa' ) ) return;
		$meta_query = array(
			'relation' => 'OR',
			array(
				'key' => '_stock',
				'value' => 49,
				'compare' => '>',
				'type' => 'DECIMAL',
			),
			array(
				'key' => '_stock',
				'type' => 'DECIMAL',
				'value' => 0,
				'compare' => '=',
			),
		);
		$q->set('meta_query', $meta_query);
	}

	public function add_sql_join( $join ) {
		global $wpdb;
      	$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' lepm2 ON ' . $wpdb->posts . '.ID = lepm2.post_id AND (lepm2.meta_key = \'wc_productdata_options\' OR lepm2.meta_key = \'_sku\' OR lepm2.meta_key = \'sku\')';
      	return $join;
	}

	public function add_sql_distinct( $where ) {
		return "DISTINCT";
	}
	
	public function add_sql_where( $where ) {
		global $pagenow, $wpdb;
		$where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(".$wpdb->posts.".post_title LIKE $1) OR (lepm2.meta_value LIKE $1) ",
			$where
		);
		$where = str_replace( "AND le_posts.post_status = 'private'", '', $where );
		return $where;
	}

}

new Search;
