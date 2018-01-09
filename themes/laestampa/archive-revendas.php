<?php 
get_header();
?>
</div></div></div>
<div class="container-fluid">
	<div class="row">
		<div class="banner-page" style="background: url('<?php echo get_template_directory_uri(). "/assets/images/banner_revenda.jpg" ?>') no-repeat;background-size: 100% auto;">
		<div class="title_page sr-only">
			<h1><?php echo get_the_title(); ?></h1>			
		</div>	
	</div>
	</div>
</div>
<div class="container">
	<div class="row-revendas">
		<div class="row gridBox-revendas">
			<div class="col-12">
				<h1> Coleções La Estampa Home pronta entrega </h1>
				<h2> Revendas </h2>
				<p>
					Papel de parede e tecidos para decoração em coleções com nosso dna impresso em estampas originais, em tecnologia digital. 
					Disponível em pronta entrega através de revendas especializadas no atendimento a design de interiores inovadores e referenciais na arquitetura brasileira.
				</p>
			</div>
		</div>

		<div class="row listaBairros">
			<div class="col-12">
				<div class="bairros">
					<strong> Filtrar por: </strong>
					<?php
						$bairros = array();
							while(have_posts()){
								the_post();
								$bairros[] = get_field("bairro");
								//echo '<pre>' . print_r($bairro,true) . '</pre>';
						}
						foreach ($bairros as $bairro) {

							$bairro_classe = str_replace(" ","_", $bairro);
							echo '<span class="filtrar-revenda '.$bairro_classe.'" data-filter="'.$bairro_classe.'">'. $bairro .'</span>';
						}

						
					?>
				</div>
			</div>
		</div>

		<div class="row row-lojas">
				<?php
				if( have_posts() ){

					$bairro = array();

					while(have_posts()){
						the_post();

						$postID = get_the_ID();
						$featured_img_url = get_the_post_thumbnail_url($postID, 'full');
						$bairro = get_field("bairro", $postID);
						$bairro_classe = str_replace(" ","_", $bairro);						
					
				?>

				<div class="col-12 col-md-4 item-loja <?php echo $bairro_classe; ?>">
					<div class="card" style="width: 21rem;">
						<img lass="card-img-top" src="<?php echo $featured_img_url; ?>">
					  <div class="card-body">
					  	<h3 class="bairro-title"> <?php echo get_field("bairro", $postID); ?> </h3>
					  	<h4 class="nome-revenda"> <?php the_title(); ?> </h4>
					    <p class="card-textAdress"> <?php echo get_field("endereco", $postID); ?> </p>
					    <p class="card-textHour"><strong> Horário de funcionamento: </strong></p>
					    <p class="card-textHour"> <?php echo get_field("horario_funcionamento", $postID); ?> </p>
					  </div>
					</div>
				</div>
			<?php } } ?>

			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row row-faixaRevenda text-center">
		<div class="container">
			<h3> Quer se tornar uma revenda? </h3>
			<p> <a href="#">Clique aqui e saiba como</a></p>
		</div>
	</div>
</div>
<?php
get_footer();