<?php

//funcao da logo
if ( ! function_exists( 'storefront_site_title_or_logo' ) ) {
function storefront_site_title_or_logo( $echo = true ) {
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
	$logo = get_custom_logo();
	$html = is_home() || is_front_page() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
	} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
	// Copied from jetpack_the_site_logo() function.
	$logo    = site_logo()->logo;
	$logo_id = get_theme_mod( 'custom_logo' ); // Check for WP 4.5 Site Logo
	$logo_id = $logo_id ? $logo_id : $logo['id']; // Use WP Core logo if present, otherwise use Jetpack's.
	$size    = site_logo()->theme_size();
	$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( home_url( '/' ) ),
		wp_get_attachment_image(
			$logo_id,
			$size,
			false,
			array(
				'class'     => 'site-logo attachment-' . $size,
				'data-size' => $size,
				'itemprop'  => 'logo'
			)
		)
	);

	$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
	} else {
	$tag = is_home() ? 'h1' : 'div';

	$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

	if ( '' !== get_bloginfo( 'description' ) ) {
		$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
	}
	}

	if ( ! $echo ) {
	return $html;
	}

	echo $html;
	}
}
//funcao para pegar o preco do produto variavel
function get_variable_price( $product, $tipo ) {
	$variations = $product->get_available_variations();
	foreach($variations as $v) {
		
		$type = $v['attributes']['attribute_pa_tipo-de-usuario'];
		$tipo = strtolower($tipo);
		if ( $type == $tipo ) {
			$variation = wc_get_product( $v['variation_id'] );

			//var_dump($variation);

			return $variation->get_price_html();
		}
	}
}

//funcao para pegar o preco do produto variavel
function get_variable_price2( $product, $tipo ) {
	$variations = $product->get_available_variations();
	foreach($variations as $v) {
		
		$type = $v['attributes']['attribute_pa_tipo-de-usuario'];
		$tipo = strtolower($tipo);
		if ( $type == $tipo ) {
			$variation = wc_get_product( $v['variation_id'] );

			//var_dump($variation);

			return $variation->get_price();
		}
	}
}

function current_user(){
	$current_user = wp_get_current_user();
	if ( !is_user_logged_in() ) {
		$role = 'pf';
		return $role;
	}
	$id_user = $current_user->ID;

	$user_info = get_userdata($id_user);
	$role = implode(', ', $user_info->roles);

	if( $role == 'administrator' ){
		$role = 'pf';
	}elseif( $role == 'revenda' ){
		$role = 'pj';
	}elseif( $role == 'customer' ){
		$role = 'pf';
	}
	return $role;
}

//funcao para pegar o preco do produto variavel
function get_variable_stock( $product, $tipo ) {
	$variations = $product->get_available_variations();
	foreach($variations as $v) {
		$type = $v['attributes']['attribute_pa_tipo-de-usuario'];
		if ( $type == $tipo ) {
			$stock = get_post_meta( $v['variation_id'], '_stock', true );
			return $stock;
		}
	}
}

//funcao para criar user revenda
	add_role('revenda', 'Revenda', array(
		'read' => true, 
		'edit_posts' => false,
		'delete_posts' => false, 
	));

	function tipo_user( $type ){
		$current_user = wp_get_current_user();

		$caps = $current_user->caps;
		return array_key_exists( $type, $caps );
	}


	//funcao para exibir o preco do produto de acordo com o usuário logado
function price_type_user($product){
	$tipo = 'PF';
	if ( tipo_user( 'administrator') ) {
		$tipo = 'PF';
		$price = get_variable_price( $product, $tipo );
	} elseif( tipo_user( 'revenda')) {
		$tipo = 'PJ';
		$price = get_variable_price( $product, $tipo );
	}else{
		$price = get_variable_price( $product, $tipo );
	}
	return $price;


}	

//pegar o estoque do produto variavel
function stock_type_user($product){
	$tipo = 'PF';
	if ( tipo_user( 'administrator') ) {
		$stock = $product->get_available_variations();
	} elseif( tipo_user( 'revenda')) {
		$tipo = 'PJ';
		$stock = get_available_variations($product, $tipo);
	}else{
		$stock = get_available_variations($product, $tipo);
	}
	return $stock;
}	

function is_papel(){
	global $product;
		$product_id = $product->get_id();
		$sku = get_post_meta($product_id, 'sku', true);
		$is_papel = is_int(stripos( $sku, 'PAPEL DE PAREDE' ) );
		if( $is_papel == 1 ){
			return true;
		}	
}

function is_papel_ID($id_product){
	global $product;
		$product_id = $id_product;
		$sku = get_post_meta($product_id, 'sku', true);
		$is_papel = is_int(stripos( $sku, 'PAPEL DE PAREDE' ) );
		if( $is_papel == 1 ){
			return true;
		}	
}

//add_action( 'woocommerce_after_single_product_summary', 'calculator_papel', 10 );
function calculator_papel(){

	$html = '<div class="calculadora_largura">
							<p class="title_calculator">Calcule quantos metros você irá precisar <i class="fa fa-arrow-right" aria-hidden="true"></i></p>
					</div>
							<div class="box_selec">
								<div class="box_input">
									<label>Altura <span>*em metros</span></label>
									<input id="altura" type="number" step=1 name="altura" value=""/>
								</div>
								<div class="box_input">
									<label>Largura<span>*em metros</span></label>
									<input id="largura" type="number" name="largura" value=""/>
								</div>
								<div class="msgAltura">
									O nosso rolo de papel de parede tem a altura de 3m, caso sua parede tenha uma altura maior que 3m, seu pedido será tratado de forma especial, por favor entre em contato com a gente, <strong><a href="/contato" title="Contato">Clicando aqui</strong></a>.
									Ficaremos felizes em atende-lo.
								</div>
								<div class="recebe_valRolo"> Voce vai precisar de: <p class="quant_rolo"> </p></div>
							</div>';

	return $html;
}


/* METABOXES PARA INDICAÇÃO/CONTRA, MODO DE USO E ADVERTÊNCIAS */
function cwp_add_meta_box_visaoGeral(){
       
      add_meta_box(
            'visao_geral',
            'Visão Geral',
            'cwp_visao_geral_box', // chama a função que cria o Meta Dado e possui o elemento textarea
            'product',
            'normal'
      );
       
}
add_action('add_meta_boxes', 'cwp_add_meta_box_visaoGeral');
 
/* Conteudo para Meta Box Modo de Uso  */
function cwp_visao_geral_box($post){

	$post_type = get_post_type();

	if( $post_type == 'product' ){

 
		// Define Meta Dado
		$txt_indicado = get_post_meta($post->ID, '_cwp_txt_indicado', true);
		$txt_lavagem = get_post_meta($post->ID, '_cwp_txt_lavagem', true);

		$sku = get_post_meta($post->ID, 'sku', true);

		$is_papel = is_int(stripos( $sku, 'PAPEL DE PAREDE' ) );
			
			//verifica se e papel e distribui as imagens de acordo com o tipo
			if($is_papel){
				$tipo = 'PAPEL';
				$imagem = get_template_directory_uri().'/assets/images/papel.png';
			}else{
				$tipo = 'TECIDO';
				$imagem = get_template_directory_uri().'/assets/images/tecidos.png';
			}


				//verifica a base e distribui os métodos de lavagem.
				$base = explode(" ", $sku); //pega a primeira palavra da frase ( Havana, Italyprint, Kimboprint, Milaoprint, Ninetyprint, Petitprint, Tweedprint, Vitaprint )
				$base = $base[0];
			
				if( $base == 'HAVANA' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Havana.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'ITALYPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Italyprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'KIMBOPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Kimboprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'MILAOPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Milaoprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'NINETYPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Ninetyprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'PETITPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Petitprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'TWEEDPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Tweedprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}elseif ( $base == 'VITAPRINT' ){
					$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Vitaprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; width:90%; display: block;">';
				}else{
					$lavagem = 'NÃO DEVE SER LAVADO';
				}

		?>
		<div class="row_visaoGeral" style="display: flex;"> 
			<div class="col-md-6" style="width:30%; display: inline-block;">
			  <label style="display: block;margin-bottom: 10px;text-align: center;"> Indicado Para: </label>
			  <img src="<?php echo $imagem; ?>" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">
			  <textarea name="txt_indicado" id="txt_indicado" style="width: 20%;display: none;"><?php echo esc_attr($tipo); ?></textarea>
			</div>

			<div class="col-md-6" style="width:30%;display: inline-block;">
				<label style="display: block;margin-bottom: 10px;text-align: center;"> Instruções de Lavagem: </label>
				<?php echo $lavagem; ?>
			  <textarea name="txt_lavagem" id="txt_lavagem" style="width: 20%;display: none;"><?php echo esc_attr($base); ?></textarea>
			</div>
		</div>
		 
		<?php
	}//fim if product
}

/* Função para Salvar Meta Dado Indicado Para */
function cwp_metadado_visao_geral_save_post($post_id){

	$post_type = get_post_type();

	if( $post_type == 'product' ){
 
	//Verifico o AutoSave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return $post_id;
	}
	 
	// Verifico as permissões de usuário
	if( 'product' == $_POST['post_type'] ){
	 
		if( !current_user_can('edit_page', $post_id) )
		return $post_id;
	}
	else{
		if( !current_user_can('edit_post', $post_id) )
		return $post_id;
	}


	//Salva/Atualiza Meta Dados
	$indicado = explode(" ", $_POST['txt_indicado']);
	$lavagem = $_POST['txt_lavagem'];

	update_post_meta($post_id, '_cwp_txt_indicado', $indicado[0]);
	update_post_meta($post_id, '_cwp_txt_lavagem', $lavagem);

}

}
add_action('save_post', 'cwp_metadado_visao_geral_save_post');


/* FUNÇÃO QUE EXIBE O CONTEÚDO DO META DADO _cwp_txt_modo_uso */
function cwp_woocommerce_custom_tab_view_visao_geral() {
             
  $sku = get_post_meta( get_the_ID(), '_cwp_txt_indicado', 1);
  $base = get_post_meta( get_the_ID(), '_cwp_txt_lavagem', 1);

  if($sku == 'TECIDO'){
  	$imagem = get_template_directory_uri().'/assets/images/tecidos.png';
  }

  if($sku == 'PAPEL'){
  	$imagem = get_template_directory_uri().'/assets/images/papel.png';
  }


  if( $base == 'HAVANA' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Havana.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'ITALYPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Italyprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'KIMBOPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Kimboprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'MILAOPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Milaoprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'NINETYPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Ninetyprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'PETITPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Petitprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'TWEEDPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Tweedprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}elseif ( $base == 'VITAPRINT' ){
		$lavagem = '<img src="'.get_template_directory_uri().'/assets/images/icon_lavagem/Vitaprint.png" class="rounded mx-auto d-block" style="margin-right: auto;margin-left: auto; display: block;">';
	}else{
		$lavagem = 'NÃO DEVE SER LAVADO';
	}

	echo '<div class="text-center" style="margin-bottom:40px;">
  				<p class="text-center"> Instruções de Lavagem </p>
				 		'.$lavagem.'
				</div>';

  echo '<div class="text-center">
  				<p class="text-center"> Indicado para </p>
				  <img src="'.$imagem.'" class="rounded mx-auto d-block" alt="...">
				</div>';

}

add_action( 'add_attachment', 'verificar_imagens' );

function verificar_imagens( $attach_id ) {
	$post = get_post( $attach_id );
	$explode = explode('_', $post->post_title);
	$title = implode( ' ', $explode );
	
	if( in_array("RAPPORT", $explode) ){
		$gallery_search = array_search('RAPPORT',$explode,true);
		unset($explode[$gallery_search]);
		$title = implode( ' ', $explode );
			global $wpdb;	
			$result = $wpdb->get_results( sprintf( "SELECT post_id FROM %spostmeta WHERE meta_key = 'sku' AND meta_value = '%s' ", $wpdb->prefix, $title ) );
			$meta = '_product_image_gallery';
			if( empty($result) ){
				return;
			}
			$post_meta = get_post_meta($result[0]->post_id, $meta, true);

				if(empty($post_meta) ){
					$meta_id = $post_meta.','.$attach_id;
				}else{
					$meta_id = $attach_id;
				}
	}else{
		global $wpdb;	
		$result = $wpdb->get_results( sprintf( "SELECT post_id FROM %spostmeta WHERE meta_key = 'sku' AND meta_value = '%s' ", $wpdb->prefix, $title ) );
		$meta = '_thumbnail_id';
			if( empty($result) ){
				return;
			}
		$meta_id = $attach_id;
	}
	$thumbnail = update_post_meta($result[0]->post_id, $meta, $meta_id);
}


add_action( 'pre_get_posts', 'query_filter_category' );
function query_filter_category( $query ) {
	if ( $_GET && isset( $_GET['tid'] ) && $query->is_main_query() ) {
		$tid = $_GET['tid'];
		$tids = [];
		$tax_query = ['relation' => 'OR'];
		global $wpdb;
		foreach($tid as $t):
			$result = $wpdb->get_results( 'SELECT object_id FROM ' . $wpdb->prefix . 'term_relationships WHERE term_taxonomy_id = ' . $t );
			if ( $result ) {
				
				foreach($result as $r):
					$tids[] = $r->object_id;
				endforeach;
			}else{
				$tids = $tid;
			}
			//$tax_query[] = [ 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $t ];
		endforeach;
		$query->set('post__in', $tids);
	}
	return $query;
}

/* Remover Tab Avaliações */
add_filter( 'woocommerce_product_tabs', 'cwp_woocommerce_remove_default_tabs' );
function cwp_woocommerce_remove_default_tabs( $tabs ) {
             
      if ( isset( $tabs['additional_information'] ) ) {
            unset( $tabs['additional_information'] );          
      }
       
      return $tabs;
}











