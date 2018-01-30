<?php 


/*
	Template Name: Página Home
*/

get_header('banner');


$imagem_banner1 = get_template_directory_uri().'/assets/images/banner_1.jpg';
$imagem_banner2 = get_template_directory_uri().'/assets/images/banner-home.jpg';

?>
</div>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="chamada-home text-center">
				<h2> Estimulamos novas formas de expressão e comportamento na decoração.</h2>
			</div>
		</div>
	</div>
</div>	
<div class="container-fluid limit-width">
	<div class="row rowBtn-compra-home">
			<div class="col-12 col-md-6 noPadding-left col-boxCompraHome">
				<a href="/categoria/tecido" class="box_bannerBtn" title="Compre Agora">
					<div class="col-estampados">
							<img src="<?php echo get_template_directory_uri().'/assets/images/home/compra_tecidos.jpg' ?>" alt="" />									
					</div>
				</a>
			</div>
			<div class="col-12 col-md-6 noPadding-right col-boxCompraHome">
				<a href="/categoria/papel-de-parede" class="box_bannerBtn" title="Compre Agora">
					<div class="col-papel">						
						<img src="<?php echo get_template_directory_uri().'/assets/images/home/compra_papel.jpg' ?>" alt="" />
					</div>
				</a>
			</div>
	</div>
</div>

<div class="container-fluid primeira_linha limit-width">
	<div class="row rowLine1-desenhos">
			<div class="col-12 col-md-6 noPadding-left">
				<div class="item_categoriaHome">
				<a href="/parceiros" class="line_linkBox" title="Tecido Estampados Parcerias">
					<div class="mascara_banner">
						<h3 class="text-center"> Tecido Estampados <br/> Parcerias </h3>
					</div>
				</a>
					<img src="<?php echo get_template_directory_uri().'/assets/images/home/line1_colun1.jpg' ?>" alt="" />
				</div>	
			</div>
			<div class="col-12 col-md-6 noPadding-right">
				<div class="item_categoriaHome">
					<a href="/tema/animal-print?tipo=tecido" class="line_linkBox" title="Papel de Parede Animal Print">
						<div class="mascara_banner">
							<h3 class="text-center"> Tecidos <br/> Animal Print</h3>
						</div>
					</a>
						<img src="<?php echo get_template_directory_uri().'/assets/images/home/linha2_lateral_direita.jpg' ?>" alt="" />
				</div>
				<div class="item_categoriaHome no-click d-flex">
					<h4>
						Ambientes marcantes tem seu valor. Por isso, <strong>a linha Home apresenta papéis de parede e tecidos em coleções com personalidade</strong> sendo grande fonte de inspiração para diversos projetos.
					</h4>
				</div>
			</div>
	</div>
</div>

<div class="container-fluid segunda_linha limit-width">
	<div class="row rowLine1-desenhos">
			<div class="col-12 col-md-6 noPadding-left">
				<div class="item_categoriaHome">
				<a href="/tema/tropical?tipo=papel-de-parede" class="line_linkBox" title="Papel de Parede Tropical">
					<div class="mascara_banner">
						<h3 class="text-center"> Papel de Parede <br/> Tropical </h3>
					</div>
				</a>
					<img src="<?php echo get_template_directory_uri().'/assets/images/home/linha3_.jpg' ?>" alt="" />
				</div>	
			</div>
			<div class="col-12 col-md-6 noPadding-right">
				<div class="item_categoriaHome">
					<a href="/tema/abstrato?tipo=papel-de-parede" class="line_linkBox" title="Papel de Parede Abstratos">
						<div class="mascara_banner">
							<h3 class="text-center"> Papel de Parede <br/> Abstrato </h3>
						</div>
					</a>
						<img src="<?php echo get_template_directory_uri().'/assets/images/home/line2_colun2.jpg' ?>" alt="" />
				</div>
			</div>
	</div>
</div>
<div class="container-fluid">
	<div class="container">
		<div class="col-12">
			<div class="subtitlePage">
				<h2 class="text-center"> Instagram </h2>
			</div>
		</div>
	</div>
	<div class="row row-instagramHome">
			<!-- LightWidget WIDGET --><script src="//lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/2c59c6533e0c510d952283ab284a2c98.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>

	</div>
</div>

<div class="container">
<?php
get_footer();

