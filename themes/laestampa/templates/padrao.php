<?php 


/*
	Template Name: Página Padrão
*/

get_header();
?>
</div></div></div>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="faq">
				<h1> <?php the_title(); ?> </h1>
			</div>
		</div>
	</div>
	<div class="row row-perguntas">
		<div class="col-12">
			<?php
				if ( have_posts() ) {
					// Start the Loop.
					while ( have_posts() ) { the_post();
						the_content();
					}
				}else{
					echo 'Crie uma página';
				}

			?>
		</div>
	</div>
</div>
<?php
get_footer();