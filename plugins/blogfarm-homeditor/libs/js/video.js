jQuery('#destaque_video').bind('change', function(){
  var checked = jQuery(this).attr('checked');
  if(checked){
    jQuery('.campo_video').slideDown();
    jQuery('#dadosBox div').not('.campo_video').not('.destaque').slideUp();
  } else {
    jQuery('.campo_video').slideUp();
    jQuery('#dadosBox div').not('.campo_video').not('.destaque').slideDown();
  }
});

if(jQuery('#destaque_video').attr('checked')){
    jQuery('.campo_video').show();
    jQuery('#dadosBox div').not('.campo_video').not('.destaque').hide();
}
