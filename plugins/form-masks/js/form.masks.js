(function($, window) {
	$(document).on({
		'ready': function(e) {
//$(document).ready(function(){

	$('.form-masks-data').mask('00/00/0000');
	$('.form-masks-hora').mask('00:00:00');
	$('.form-masks-data-hora').mask('00/00/0000 00:00:00');
	$('.form-masks-cep').mask('00000-000');
	$('.form-masks-cpf').mask('000.000.000-00');
	$('.form-masks-cnpj').mask('00.000.000/0000-00');
	$('.form-masks-dinheiro').mask('000.000.000.000.000,00', {reverse: true});
	$('.form-masks-dinheiro2').mask("#.##0,00", {reverse: true});
	$('.form-masks-percent').mask('##0,00%', {reverse: true});

	// Telefone
	var options =  {
		onKeyPress: function(telefone, e, field, options){
			var masks = ['0000-0000Z', '00000-0000'];
			mask = ( telefone.length >= 10 ) ? masks[1] : masks[0];
			$('.form-masks-telefone').mask(mask, options);
		},
		translation: {
	      'Z': {
	        pattern: /[0-9]/, optional: true
	      }
	    },
	    clearIfNotMatch: true

	};
	$('.form-masks-telefone').mask('0000-0000', options);

	// Telefone com DDD
	var options =  {
		onKeyPress: function(telefone, e, field, options){
			var masks = ['(00) 0000-0000Z', '(00) 00000-0000'];
			mask = ( telefone.length > 14 ) ? masks[1] : masks[0];
			$('.form-masks-telefone-ddd').mask(mask, options);
		},
		translation: {
	      'Z': {
	        pattern: /[0-9]/, optional: true
	      }
	    },
	    clearIfNotMatch: true
	};
	$('.form-masks-telefone-ddd').mask('(00) 00000-0000', options);

	// CPF ou CNPJ
	var options =  {
		onKeyPress: function(cpf, e, field, options){
			var masks = ['000.000.000-000Z', '00.000.000/0000-00'];
			mask = ( cpf.length > 14 ) ? masks[1] : masks[0];
			$('.form-masks-cpf-cnpj').mask(mask, options);
		}
	};
	$('.form-masks-cpf-cnpj').mask('000.000.000-000', options);


	// IP

	$('.form-masks-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
		translation: {
			'Z': {
				pattern: /[0-9]/, optional: true
			}
		}
	});

//});
		} // Document Ready
	});
})(jQuery);