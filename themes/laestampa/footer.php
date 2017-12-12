<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
				</div> <!-- .row -->
		</div> <!-- .container -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="newsletter-footer">
			<div class="container">
				<div class="col-12">
					<div class="title_newsletterFooter">
						<h3 class="text-center"> receba nossas novidades </h3>
					</div>
				</div>
					<div class="col-12">
						<?php echo do_shortcode('[mc4wp_form id="161"]'); ?>
					</div>
					<div class="col-12">
						<div class="redesSociaisFooter">
							<ul class="list-inline text-center">
								<li class="list-inline-item"><a href=""><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
								<li class="list-inline-item"><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
			</div>
		</div>
		<div class="container">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 */
			do_action( 'storefront_footer' ); ?>

			<div class="securitySelo">
				<h4 class="text-center"> Site protegido por: </h4>
				<a href="https://letsencrypt.org/" target="_blank"><img src="<?php echo get_template_directory_uri().'/assets/images/securitySelo.png' ?>" class="mx-auto d-block" alt="Lest Encrypt"></a>
			</div>

		</div><!-- .col-full -->

	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
