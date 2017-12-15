<?php 
get_header();
?>
</div></div></div>
<div class="container-fluid">
	<div class="row">
		<div class="banner-page" style="background: url('<?php echo get_template_directory_uri(). "/assets/images/banner_parceiros.jpg" ?>') no-repeat;background-size: 100% auto;">
		<div class="title_page sr-only">
			<h1><?php echo get_the_title(); ?></h1>			
		</div>	
	</div>
	</div>
</div>
<div class="container">
	<div class="row-parceiros">
		<div class="row  gridBox-parceiros">
			<div class="col-12">
				<h2 class="text-center subTitleArchive"> 
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt Lorem ipsum dolor sit amet, consectetur adipiscing elit, se. 
				</h2>
			</div>
		<?php
			$args = array(
			  'numberposts' => -1,
			  'post_type'   => 'parceiros',
			  'order'				=> 'DESC',
			  
			); 
			$parceiros = get_posts( $args );
			if ( $parceiros ) {
			    foreach ( $parceiros as $parceiro ) {
			        setup_postdata( $parceiro ); 
			        $thumb = get_the_post_thumbnail_url($parceiro->ID, 'full');
			        $imagens = get_field('galeria_parceiros', $parceiro->ID);
			        $content = $parceiro->post_content;

			        var_dump($imagens);
			       
		?>				        
			        <div class="col-12 col-md-6">
				        <div class="gridItem-parceiros" id="<? echo $parceiro->ID; ?>" data-content='<? echo json_encode( $content );?>' data-imagens='<? echo json_encode( $imagens ); ?>' data-toggle="modal" data-target=".bd-example-modal-lg">
									<?php echo the_post_thumbnail( 'full', array( 'class' => 'aligncenter', 'title' => $parceiro->post_title ) ); ?>
								</div>
							</div>				        
			    <?php
			    } wp_reset_postdata();
			}
		?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg parceirosModal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="contentParceiro"></div>
        <div class="box_galeria">
        	<div class="bxslider"></div>        	
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();