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
		<div class=" col-12 col-md-3">
			<div class="contentCenter text-center"> 
					<h1> Lançamento </h1>
					<div class="textContent">
						Lorem ipsum dolor sit amet, conh nsectetur adipiscing elit, sedInh 
						do eiusmod tempor incididunt ut labore et dolore magna al adipiscing iqua.
					</div>
					<div class="btn_colecoes">
						<a class="btnLeft" href="/colecao/resort">Coleção Resort</a>
						<a class="btnRight" href="/colecao/mood">Coleção Mood</a>
					</div>
			</div>			
		</div>
		<div class=".d-sm-none col-4">
			<div class="imageRighttcolecoes" style="background: url(<?php echo get_template_directory_uri().'/assets/images/colecoes/bannerRightcolecoes.jpg'; ?>) no-repeat center; background-size: cover"></div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row rowSubtitle">
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
							Lorem ipsum dolor sit amet, coun
							nsectetur adipiscing elit, sedInh 
							do eiusmod tempor incididunt 
							ut labore et dolore magna al
							adipiscing iqua.
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
							Lorem ipsum dolor sit amet, coun
							nsectetur adipiscing elit, sedInh 
							do eiusmod tempor incididunt 
							ut labore et dolore magna al
							adipiscing iqua.
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
							Lorem ipsum dolor sit amet, coun
							nsectetur adipiscing elit, sedInh 
							do eiusmod tempor incididunt 
							ut labore et dolore magna al
							adipiscing iqua.
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