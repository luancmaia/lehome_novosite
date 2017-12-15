<?php 


/*
	Template Name: Página Sobre
*/

get_header();
?>
</div></div></div>
<div class="container-fluid">
	<div class="row">
		<?php echo banner_page(get_the_ID()); ?>
	</div>
</div>
<div class="container-fluid noPadding">
	<div class="row originais">
		<div class="col-12 col-md-6">
			<div class="somos-originais">
				<h2> Somos Originais </h2>
					<h3> UMA NOVA FORMA DE EXPRESSÃO NA DECORAÇÃO </h3>
				<p>
					Entendemos que ambientes marcantes tem seu valor.
					Por isso, a linha Home apresenta papéis de parede e 
					tecidos em coleções criados com o DNA La Estampa.
					O resultado - inspirado em nossa experiência de 15 anos 
					dentro do universo da moda - não poderia ser melhor: 
					ambientes sofisticados, vivos e cheios de personalidade 
					que não passam despercebidos e são grandes fontes 
					de inspiração para projetos arquitetônicos, de
					decoração e visual merchandising.
				</p>
			</div>
			<div class="img-somosOriginais">
				<img src="<?php echo get_template_directory_uri().'/assets/images/poas_sobre.jpg'; ?>" title="">
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="box-imagesRightColunm1">
				<img src="<?php echo get_template_directory_uri().'/assets/images/imageRight1.jpg'; ?>" title="">
				<img src="<?php echo get_template_directory_uri().'/assets/images/imageRight2.jpg'; ?>" title="">
			</div>
		</div>
	</div>
</div>
<div class="container-fluid noPadding">
	<div class="row nossosProdutos">
		<div class="col-12 col-md-8">
			<div class="nossos-produtos">
				<h2> Nossos Produtos </h2>
					<h3> Tecido </h3>
				<p>Os tecidos La Estampa Home se diferenciam através da diversidade de desenhos e por 
					serem 100% naturais. Oferecidos em  diversas gramaturas, tramas  e acabamentos, 
					resistentes  a sujidade e absorção de líquidos. </p>
					<br/>
				<p>Próprios para estofados, almofadas, jogos americanos, toalhas de mesa, colchas e  acessórios para casa:</p>
				<br/>
				<div class="box_base">
					<div class="colunaBase col-6">
						ITALY <br/>
						SARJA - 100% ALGODÃO
					</div>
					<div class="colunaBase col-6">
						KIMBO <br/>
						LONA- 100% ALGODÃO
					</div>
				</div>

				<div class="box_base">
					<div class="colunaBase col-6">
						MILÃO<br/>
						TRAMA RÚSTICA - 100% ALGODÃO
					</div>
					<div class="colunaBase col-6">
						TWEED<br/>
						SARJA - 100% ALGODÃO
					</div>
				</div>

				<p>Próprios para cortinas, almofadas, guardanapos e produtos mais leves:</p>
				<br/>

				<div class="box_base">
					<div class="colunaBase col-6">
						NINETY <br/>
						LINHO LEVE COM OTIMO CAIMENTO <br/>
						LINHO 55% - VISCOSE 45%
					</div>
					<div class="colunaBase col-6 text-center">
						VITA <br/>
						TOQUE ULTRA SUAVE <br/>
						100% ALGODÃO
					</div>
				</div>


			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="box-imagesRightColunm2">
				<img src="<?php echo get_template_directory_uri().'/assets/images/imageRightcolum2.jpg'; ?>" title="">
			</div>
		</div>
	</div>
</div>
<div class="container-fluid noPadding">
	<div class="row rowpapeis">
		<div class="col-12 col-md-6">
			<div class="somos-originais">
					<h3> PAPEL DE PAREDE </h3>
				<p>
					Os papéis de parede La Estampa Home são inovadores 
					em largura e no processo de aplicação. Oferecidos em 
					diversas estampas autênticas, em grandes desenhos, 
					e painéis que expressam personalidade. 
					Seguem algumas características: </p>

					 <p class="marginLeft">  
					 	 Papel prático com cola ativada à água
					 	 <br/>
					   Papel com proteção de cor devido ao primer
					   <br/>
					   Pode ser aplicado em diversas superfícies
					   como metal, madeira, vidro e gesso
					   <br/>
					   Sua remoção não causa danos à parede
					 </p>  
					 <p>
					   Largura de 1,35 m, o que diminui o número
					   de emendas em sua superfície, resultando
					   em um melhor acabamento.
					 </p>  
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="box-imagesRightPapel">
				<img src="<?php echo get_template_directory_uri().'/assets/images/papelparedeSobre.jpg'; ?>" title="">
			</div>
		</div>
	</div>
</div>		
<?php
get_footer();