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
						'column_width' => 50,
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
						'column_width' => 30,
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
						'column_width' => 15,
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
						'column_width' => 15,
						'default_value' => '',
						'placeholder' => 'Ex.: 85',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
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
