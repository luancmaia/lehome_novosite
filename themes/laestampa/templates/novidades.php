<?php 


/*
	Template Name: Página Novidades
*/

get_header();
?>
</div></div></div>
<div class="container-fluid">
	<div class="row">
		<?php echo banner_page(get_the_ID()); ?>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="text-novidades">
				<h2> <?php echo $post->post_content; ?> </h2>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<?php
		$novidades = get_field('cadastro_novidades');
		if($novidades){
			foreach($novidades as $novidade) {
				$html = '<div class="row boxNovidade">
								<div class="col-12 col-md-12 noPadding">
									<div class="novdade_image">';

				if( $novidade['link_da_imagem'] ){
					$html .= '<a href="" title="Comprar essa estampa"><img src="'.$novidade['imagem_novidade'].'" alt="Comprar esta estampa"></a>';
				}else{
					$html .= '<img src="'.$novidade['imagem_novidade'].'" alt="Comprar esta estampa">';
				}									

				$html .= '</div>
								</div>
							</div>';

				echo $html;
			}
		}
	?>	
</div>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="text-novidades">
				<h2> CONFIRA MAIS ESTAMPAS QUE ACABARAM DE CHEGAR: </h2>
			</div>
		</div>
	</div>
	<div class="row site-main">
		<div class="col-12">
			<div class="columns-3 box_produtosNovidades">
				<ul class="products">
					<?php
						$args = array(
							'post_type' => 'product',
							'posts_per_page' => -1,
							'product_cat' => 'novidades'
							);
						$loop = new WP_Query( $args );
						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) : $loop->the_post();
								wc_get_template_part( 'content', 'product' );
							endwhile;
						} else {
							echo __( 'No products found' );
						}
						wp_reset_postdata();
					?>
				</ul><!--/.products-->
			</div>
		</div>
	</div>
</div>
<?php
get_footer();