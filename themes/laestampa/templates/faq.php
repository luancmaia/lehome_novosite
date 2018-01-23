<?php 


/*
	Template Name: Página FAQ
*/

get_header();
?>
</div></div></div>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="faq">
				<h1> PERGUNTAS FREQUENTES </h1>
			</div>
		</div>
	</div>
	<div class="row row-perguntas">
		<div class="col-12">

			<?php
			if(have_rows('temas')){
				while( have_rows('temas') ){ the_row();
					// vars
					$titulo = get_sub_field('titulo');
					$perguntas_respostas = get_sub_field('perguntas_respostas');

					echo '<h2>' .$titulo. '</h2>';

					foreach ($perguntas_respostas as $pergunta_resposta) {
						
						$pergunta = $pergunta_resposta['pergunta'];
						$resposta = $pergunta_resposta['resposta'];
						
						echo '
							    <div class="accordion" data-accordion>
						        <div data-control><h3>'.$pergunta.'</h3></div> 
						        <div data-contents>
					            <div><p>'.$resposta.'</p></div>          
						        </div>
							    </div>
								';

					}
				}
			}else{
				echo 'Você precisa cadastrar Perguntas';
			}	

			?>
			
			

		</div>
	</div>
</div>
<?php
get_footer();