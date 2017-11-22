jQuery(document).ready(function(){
  jQuery('#is_chamada_externa').live('change', function(){
    var checked=jQuery(this).attr('checked');
    if(checked){
      jQuery('.busca-post').slideUp();
      jQuery('.categoria').slideUp();
    } else {
      jQuery('.busca-post').slideDown();
      jQuery('.categoria').slideDown();
    }
  });
});
if( jQuery('#is_chamada_externa').attr('checked') ){
  jQuery('.busca-post').hide();
  jQuery('.categoria').hide();  
}
