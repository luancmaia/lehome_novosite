<?php 

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_slide-home',
		'title' => 'Slide Home',
		'fields' => array (
			array (
				'key' => 'field_5a1eba23bfe59',
				'label' => 'Banner Home',
				'name' => 'banner_home',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_5a1eba39bfe5a',
						'label' => 'Imagem do Banner',
						'name' => 'imagem_banner',
						'type' => 'image',
						'column_width' => 30,
						'save_format' => 'url',
						'preview_size' => 'medium',
						'library' => 'all',
					),
					array (
						'key' => 'field_5a1eba52bfe5b',
						'label' => 'Terá Tarja?',
						'name' => 'tarja',
						'type' => 'true_false',
						'instructions' => 'Marque caso o banner tenha a faixa',
						'column_width' => 10,
						'message' => '',
						'default_value' => 0,
					),
					array (
						'key' => 'field_5a1eba7bbfe5c',
						'label' => 'Cor da Tarja',
						'name' => 'cor_tarja',
						'type' => 'color_picker',
						'instructions' => 'Selecione a cor',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_5a1eba52bfe5b',
									'operator' => '==',
									'value' => '1',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => 10,
						'default_value' => '#c0c0c080',
					),
					array (
						'key' => 'field_5a1ebb5e07b39',
						'label' => 'Opacidade',
						'name' => 'opacidade_banner',
						'type' => 'text',
						'instructions' => 'Digite a opacidade',
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_5a1eba52bfe5b',
									'operator' => '==',
									'value' => '1',
								),
							),
							'allorany' => 'all',
						),
						'column_width' => 8,
						'default_value' => '',
						'placeholder' => 'Ex.: 85',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					//text do banner
					array (
						'key' => 'field_5a1ebb5e07c490',
						'label' => 'Texto do banner',
						'name' => 'text_banner',
						'type' => 'wysiwyg',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'no',
						'instructions' => 'Digite o texto do Banner',

						'column_width' => 20,
						'default_value' => '',
						'placeholder' => 'Ex.: Coleção 2018',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					//link do banner
					array (
						'key' => 'field_5a1ebb5e07c590',
						'label' => 'Link do Banner',
						'name' => 'link_banner',
						'type' => 'text',
						'instructions' => 'Cole o link do banner',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
						'column_width' => 20,
						'default_value' => '',
						'placeholder' => 'Ex.: http://laestampahome.com.br/product',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5a1eba7bbfr7v',
						'label' => 'Cor do texto',
						'name' => 'cor_texto',
						'type' => 'color_picker',
						'instructions' => 'Selecione a cor',
						'column_width' => 10,
						'default_value' => '#8e9699',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Banner',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '9',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_parceiros',
		'title' => 'Parceiros',
		'fields' => array (
			array (
				'key' => 'field_5a32a84600c12',
				'label' => 'Galeria Parceiros',
				'name' => 'galeria_parceiros',
				'type' => 'gallery',
				'instructions' => 'Selecione as imagens para galeria.',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'parceiros',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

