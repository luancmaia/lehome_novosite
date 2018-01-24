<?php 


/*
	Template Name: Página Colecões
*/

get_header();
?>
</div></div></div>
<div class="container-fluid noPadding">
	<div class="row banner_colecoes">
		<div class=".d-sm-none col-5">
			<div class="imageLeftcolecoes" style="background: url(<?php echo get_template_directory_uri().'/assets/images/colecoes/bannerLeftcolecoes.jpg'; ?>) no-repeat center; background-size: cover"></div>			
		</div>
		<div class=" col-12 col-md-3" style="z-index: 999;">
			<div class="contentCenter text-center"> 
					<h1> Lançamento </h1>
					<div class="textContent">
						
					</div>
					<div class="btn_colecoes">
						<a class="btnLeft" href="/colecoes/mood">Coleção Mood</a>
						<a class="btnRight" href="/colecoes/resort">Coleção Resort</a>
					</div>
			</div>			
		</div>
		<div class=".d-sm-none col-4" style="z-index: 9;">
			<div class="imageRighttcolecoes" style="background: url(<?php echo get_template_directory_uri().'/assets/images/colecoes/bannerRightcolecoes.jpg'; ?>) no-repeat center; background-size: cover"></div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row rowSubtitle">
		<div class="col-12">
			<p style="font-size: 18px;margin-bottom: 90px;">
				Aquarelas, texturas e degrades dão vida a novas formas de expressão para decorar ambientes. O abstrato marca presença em geométricos e a sobriedade da nova paleta de cores traz uma coleção ainda mais sofisticada e com inúmeras possibilidades de criação. 
				<br/><br/>
				Dividida em dois conceitos, nossas novas apostas em tecidos e papéis de parede passeiam pela <strong><a href="/colecoes/mood">Coleção Mood</a></strong> que explora seu mix de elementos e cores de forma inovadora e pela <strong><a href="/colecoes/resort">Coleção Resort</a></strong> que respira tropicalidade e inspira ambientes modernos e cheios de personalidade.
				<br/><br/>
				É tempo de ser leve, fluido e de abrir espaço para a harmonia. Que sua experiência seja norteada de boas sensações. Conheça nossas novas estampas.
			</p>
		</div>
		<div class="col-12">
			<div class="text-colecoes text-center">
				<h2> coleções la estampa home </h2>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid noPadding">
	<div class="row outrasColecoes">
			<div class="col-12 col-md-7">
				<div class="image1Colecao">
					<img src="<?php echo get_template_directory_uri().'/assets/images/colecoes/imagemColecao1.jpg'; ?>">
				</div>
			</div>
			<div class="col-12 col-md-3">
				<div class="contentBtnsColecoes">
					<div class="btnsColecoes">
						<div class="btnCinza">
							<a href="/colecoes/we-love-blue"> WE LOVE BLUE </a>
							<a href="/colecoes/loft"> LOFT </a>
							<a href="/colecoes/joy"> JOY </a>
						</div>
					</div>
					<div class="content_btns">
						<p>
							Um universo contemporâneo que traz simplicidade e personalidade em perfeita harmonia para a criação de ambientes leves e sofisticados. Também podendo ser divertido e cheio de alegria através de variações de desenhos e suas cores.
						</p>
						<div class="btn_colecoes">
							<a class="btnLeft" href="/categoria/tecido">Ver tudo</a>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>

<!-- SEGUNDA LINHA -->

<div class="container-fluid noPadding">
	<div class="row outrasColecoes">
			<div class="col-12 offset-md-2 col-md-3">
				<div class="contentBtnsColecoes">
					<div class="btnsColecoes">
						<div class="btnCinza">
							<a href="/colecoes/tropicalia"> TROPICALIA </a>
							<a href="/colecoes/flora"> FLORAL </a>
							<a href="/colecoes/colorful"> COLORFUL </a>
						</div>
					</div>
					<div class="content_btns">
						<p>
							Mix de cores em combinações encantadoras com estampas gráficas, florais e geométricas que ilustram ambientes com originalidade. Presença da brasilidade de estampas inspiradas nas folhagens da Amazônia e de diversas outras regiões do Brasil.
						</p>
						<div class="btn_colecoes">
							<a class="btnLeft" href="/categoria/tecido">Ver tudo</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-7">
				<div class="image1Colecao">
					<img src="<?php echo get_template_directory_uri().'/assets/images/colecoes/imagemColecao2.jpg'; ?>">
				</div>
			</div>
	</div>
</div>

<!-- PRIMEIRA LINHA INFANTIL -->
<div class="container-fluid noPadding">
	<div class="row outrasColecoes colecoesInfantil">
			<div class="col-12 col-md-7">
				<div class="image1Colecao">
					<img src="<?php echo get_template_directory_uri().'/assets/images/colecoes/imagemColecao3Infantil.jpg'; ?>">
				</div>
			</div>
			<div class="col-12 col-md-3">
				<div class="contentBtnsColecoes">
					<div class="btnsColecoes">
						<div class="btnRose">
							<a href="/colecoes/petit"> PETIT </a>
							<a href="/colecoes/historinhas"> HISTORINHAS </a>
						</div>
					</div>
					<div class="content_btns">
						<p>
							Historinhas tem floresta tropical, fundo do mar, circo, fazendinha e muito mais. Estampas que contam historinhas e estimulam a imaginação. Petit é inspirada nos primeiros anos de vida dos pequeninos, traz criações que colorem o ambiente e são um convite ao início de uma nova jornada cheia de novas descobertas.
						</p>
						<div class="btn_colecoes">
							<a class="btnLeft" href="#">Ver tudo</a>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>

<?php
get_footer();