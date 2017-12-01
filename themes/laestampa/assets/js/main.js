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
	var price_product = $('.price_product').val();
	var calculo_metro = $('.calculo-metro .calculo-metros');
	var result_calculo_metros = $('.result-calculo-metros');
	calculo_metro.on('keyup', function(){
		var valorDigitado = $(this).val();

		var total_valor = valorDigitado * price_product;

		result_calculo_metros.data('price', total_valor);
		result_calculo_metros.html(total_valor + ',00');
	});

	$('.quantity').ready(function(){
		$('input.qty').attr('oninvalid', 'this.setCustomValidity("A quantidade que você quer é maior do que temos disponível no momento!")');
	});

});