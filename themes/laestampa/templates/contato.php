<?php 


/*
	Template Name: Página Contato
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
	<div class="row row-contato">
		<div class="col-12 col-md-6">
			<div class="box_form">
				<h2> Entre em Contato </h2>
				<?php echo do_shortcode('[contact-form-7 id="160" title="Contato"]'); ?>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="text-contato">
				<h2> informações </h2>
				<?php echo $post->post_content; ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();