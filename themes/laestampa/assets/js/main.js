jQuery( function( $ ) {
	$('.bxsliderHome').bxSlider({
	  auto: true,
	  autoControls: false,
	  stopAutoOnClick: true,
	  pager: true,
	  responsive: true,
	  adaptiveHeight: true,
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