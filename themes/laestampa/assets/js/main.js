jQuery( function( $ ) {
	$('.bxsliderHome').bxSlider({
	  auto: true,
	  autoControls: false,
	  stopAutoOnClick: true,
	  pager: false,
	  responsive: true,
	  adaptiveHeight: true,
	});

	// on orienation change we need to reload the bxslider when the new image is done loading
    $(window).on("orientationchange",function(){
      imagesLoaded( document.querySelector('.js-full-width-slideshow'), function( instance ) {
        slider.reloadSlider();
      });
    });

	$('.modal-busca').hide();

	var acionaBusca = $('.lupa-busca');
	var fecharBusca = $('.fechar-modalBusca');

	// acionaBusca.on('click', function(){
	// 	$('.modal-busca').slideDown();
	// 	$('body').css('overflow', 'hidden');
	// });

	// fecharBusca.on('click', function(){
	// 	$('.modal-busca').slideUp();
	// 	$('body').css('overflow', 'auto');
	// });

	$( ".col-boxCompraHome" ).hover(
	  function() {
	    $( this ).addClass( "hover" );
	  }, function() {
	    $( this ).removeClass( "hover" );
	  }
	);

});