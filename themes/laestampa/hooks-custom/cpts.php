<?php

//CPT

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