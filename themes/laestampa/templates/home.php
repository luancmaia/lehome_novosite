<?php 


/*
	Template Name: Página Home
*/

get_header();

$imagem_banner = get_template_directory_uri().'/assets/images/banner-home.jpg';

?>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="banner-home" style="background: #ffafaf url('<?php echo $imagem_banner; ?>') no-repeat center center;background-size: cover;">
			
		</div>
	</div>	
</div>
<div class="col-full">
<div id="primary" class="content-area">
	<div class="banner-home">

		Home Page

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();

