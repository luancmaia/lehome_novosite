<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

?>
<?php
	if( is_shop() || is_product_category() ||  is_product_taxonomy() ){
?>
<div id="secondary" class="widget-areaSidebar col-12 col-md-3" role="complementary">
	<?php get_sidebar( 'petit' ); ?>
</div><!-- #secondary -->

<?php } ?>
