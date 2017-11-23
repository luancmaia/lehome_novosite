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
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="chamada-home text-center">
				<h2> Nisl viverra eros diam nulla elementum, fringilla fermentum donec cubilia a, libero habitasse interdum torquent.</h2>
			</div>
		</div>
	</div>
</div>	
<div class="container-fluid">
	<div class="row row-bottom-separete">
			teste
	</div>
</div>

<div class="container">
<?php
get_footer();

