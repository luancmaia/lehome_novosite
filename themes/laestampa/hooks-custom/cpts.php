<?php

//CPT



//TAXONOMIA

	add_action( 'init', 'ct_composicao' );
	function ct_composicao()  {
		$labels = array(
			'name'                       => 'Composição',
			'singular_name'              => 'Composição',
			'menu_name'                  => 'Composição',
			'all_items'                  => 'Todas as Composições',
			'parent_item'                => 'Parent Composição',
			'parent_item_colon'          => 'Parent Composição:',
			'new_item_name'              => 'Nova Composição',
			'add_new_item'               => 'Adicionar Nova Composição',
			'edit_item'                  => 'Editar Composição',
			'update_item'                => 'Atualizar Composição',
			'search_items'               => 'Procurar Composições',
			'add_or_remove_items'        => 'Adicionar ou remover Composição',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'composicao', 'product', $args );
		register_taxonomy_for_object_type( 'composicao', 'product' );
	}

		add_action( 'init', 'ct_colecao' );
	function ct_colecao()  {
		$labels = array(
			'name'                       => 'Coleção',
			'singular_name'              => 'Coleção',
			'menu_name'                  => 'Coleção',
			'all_items'                  => 'Todas as Coleções',
			'parent_item'                => 'Parent Coleção',
			'parent_item_colon'          => 'Parent Coleção:',
			'new_item_name'              => 'Nova Coleção',
			'add_new_item'               => 'Adicionar Nova Coleção',
			'edit_item'                  => 'Editar Coleção',
			'update_item'                => 'Atualizar Coleção',
			'search_items'               => 'Procurar Coleções',
			'add_or_remove_items'        => 'Adicionar ou remover Coleção',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'colecao', 'product', $args );
		register_taxonomy_for_object_type( 'colecao', 'product' );
	}

			add_action( 'init', 'ct_tema' );
	function ct_tema()  {
		$labels = array(
			'name'                       => 'Tema',
			'singular_name'              => 'Tema',
			'menu_name'                  => 'Tema',
			'all_items'                  => 'Todas as Temas',
			'parent_item'                => 'Parent Tema',
			'parent_item_colon'          => 'Parent Tema:',
			'new_item_name'              => 'Nova Tema',
			'add_new_item'               => 'Adicionar Nova Tema',
			'edit_item'                  => 'Editar Tema',
			'update_item'                => 'Atualizar Tema',
			'search_items'               => 'Procurar Temas',
			'add_or_remove_items'        => 'Adicionar ou remover Tema',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'tema', 'product', $args );
		register_taxonomy_for_object_type( 'tema', 'product' );
	}


			add_action( 'init', 'ct_cor' );
	function ct_cor()  {
		$labels = array(
			'name'                       => 'Cor',
			'singular_name'              => 'Cor',
			'menu_name'                  => 'Cor',
			'all_items'                  => 'Todas as Cores',
			'parent_item'                => 'Parent Cor',
			'parent_item_colon'          => 'Parent Cor:',
			'new_item_name'              => 'Nova Cor',
			'add_new_item'               => 'Adicionar Nova Cor',
			'edit_item'                  => 'Editar Cor',
			'update_item'                => 'Atualizar Cor',
			'search_items'               => 'Procurar Cores',
			'add_or_remove_items'        => 'Adicionar ou remover Cor',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'cor', 'product', $args );
		register_taxonomy_for_object_type( 'cor', 'product' );
	}


// Register Custom Post Type
function parceiros() {

	$labels = array(
		'name'                  => _x( 'Parceiros', 'Post Type General Name', 'laestampa' ),
		'singular_name'         => _x( 'Parceiro', 'Post Type Singular Name', 'laestampa' ),
		'menu_name'             => __( 'Parceiros', 'laestampa' ),
		'name_admin_bar'        => __( 'Parceiros', 'laestampa' ),
		'archives'              => __( 'Item Archives', 'laestampa' ),
		'attributes'            => __( 'Item Attributes', 'laestampa' ),
		'parent_item_colon'     => __( 'Parent Item:', 'laestampa' ),
		'all_items'             => __( 'All Items', 'laestampa' ),
		'add_new_item'          => __( 'Add New Item', 'laestampa' ),
		'add_new'               => __( 'Add Novo', 'laestampa' ),
		'new_item'              => __( 'Add Parceiro', 'laestampa' ),
		'edit_item'             => __( 'Editar Parceiro', 'laestampa' ),
		'update_item'           => __( 'Atualizar Parceiro', 'laestampa' ),
		'view_item'             => __( 'Ver Parceiro', 'laestampa' ),
		'view_items'            => __( 'Ver Parceiros', 'laestampa' ),
		'search_items'          => __( 'Buscar Parceiro', 'laestampa' ),
		'not_found'             => __( 'Nada encontrado', 'laestampa' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'laestampa' ),
		'featured_image'        => __( 'Imagem logo', 'laestampa' ),
		'set_featured_image'    => __( 'Definir imagem de logo', 'laestampa' ),
		'remove_featured_image' => __( 'Remover logo', 'laestampa' ),
		'use_featured_image'    => __( 'Use esta imagem', 'laestampa' ),
		'insert_into_item'      => __( 'Inserir ao item', 'laestampa' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'laestampa' ),
		'items_list'            => __( 'Items list', 'laestampa' ),
		'items_list_navigation' => __( 'Items list navigation', 'laestampa' ),
		'filter_items_list'     => __( 'Filter items list', 'laestampa' ),
	);
	$args = array(
		'label'                 => __( 'Parceiro', 'laestampa' ),
		'description'           => __( 'Cadastro de Parceiros', 'laestampa' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'parceiros', $args );

}
add_action( 'init', 'parceiros', 0 );

// Register Custom Post Type
function revendas() {

	$labels = array(
		'name'                  => _x( 'Revendas', 'Post Type General Name', 'laestampa' ),
		'singular_name'         => _x( 'Revenda', 'Post Type Singular Name', 'laestampa' ),
		'menu_name'             => __( 'Lojas Revendas', 'laestampa' ),
		'name_admin_bar'        => __( 'Revendas', 'laestampa' ),
		'archives'              => __( 'Item Archives', 'laestampa' ),
		'attributes'            => __( 'Item Attributes', 'laestampa' ),
		'parent_item_colon'     => __( 'Parent Item:', 'laestampa' ),
		'all_items'             => __( 'Todas as Revendas', 'laestampa' ),
		'add_new_item'          => __( 'Add Nova Revenda', 'laestampa' ),
		'add_new'               => __( 'Add Nova', 'laestampa' ),
		'new_item'              => __( 'Add Revenda', 'laestampa' ),
		'edit_item'             => __( 'Editar Revenda', 'laestampa' ),
		'update_item'           => __( 'Atualizar Revenda', 'laestampa' ),
		'view_item'             => __( 'Ver Revenda', 'laestampa' ),
		'view_items'            => __( 'Ver Revendas', 'laestampa' ),
		'search_items'          => __( 'Buscar Revenda', 'laestampa' ),
		'not_found'             => __( 'Nada encontrado', 'laestampa' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'laestampa' ),
		'featured_image'        => __( 'Imagem fachada', 'laestampa' ),
		'set_featured_image'    => __( 'Definir imagem da fachada', 'laestampa' ),
		'remove_featured_image' => __( 'Remover logo', 'laestampa' ),
		'use_featured_image'    => __( 'Use esta imagem', 'laestampa' ),
		'insert_into_item'      => __( 'Inserir ao item', 'laestampa' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'laestampa' ),
		'items_list'            => __( 'Items list', 'laestampa' ),
		'items_list_navigation' => __( 'Items list navigation', 'laestampa' ),
		'filter_items_list'     => __( 'Filter items list', 'laestampa' ),
	);
	$rewrite = array(
		'slug'                  => 'lojas-revenda',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Revenda', 'laestampa' ),
		'description'           => __( 'Cadastro de Revendas', 'laestampa' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-store',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'revendas', $args );

}
add_action( 'init', 'revendas', 0 );
















