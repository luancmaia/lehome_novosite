
function click_update_cart_btn(upd_cart_btn) {
	 var upd_cart_btn = jQuery(".cart_item").parents('form').find('[type="submit"]');
	 upd_cart_btn.trigger('click');
}

jQuery(document).ready(function($) {
	var update_cart;
	jQuery('body').delegate(".cart_item .qty").on("change", function(){
		
		if(update_cart != null){
			clearTimeout(update_cart);
		}
		update_cart = setTimeout(click_update_cart_btn, 1000);
	});
});