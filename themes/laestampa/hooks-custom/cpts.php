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


















