jQuery( function( $ ) {
	//FILTRO SIDEBAR
	var check_img = 'http://petitpapier.com.br/wp-content/uploads/2017/12/square-check-x.png';
		var uncheck_img = 'http://petitpapier.com.br/wp-content/uploads/2017/12/square-x.png';

		$('a.remove-category-url').on('click', function(e){
			e.preventDefault();
			var url = $('.actual-url').val();
			var slug = $(this).attr('data-slug');
			url = url.replace('&'+slug+'[]=' + $(this).attr('data-id'), '');
			url = url.replace('?'+slug+'[]=' + $(this).attr('data-id'), '');
			url = url.replace('?'+slug+'%5B%5D=' + $(this).attr('data-id'), '');
			url = url.replace('/&'+slug+'%5B%5D', '/?'+slug+'');
			url = url.replace('/&'+slug+'', '/?'+slug+'');
			$(this).parent().fadeOut();
			window.location = url;
		});

		$('.product-categories li a.link-category').on('click', function(e){

			console.log('foi');
			e.preventDefault();
			var url = $('.actual-url').val();
			var slug = $(this).attr('data-slug');
			
			if ( $(this).hasClass('active') ) {
				$(this).removeClass('active');
				$(this).find('img').attr('src', uncheck_img);
				url = url.replace('&'+slug+'[]=' + $(this).attr('data-id'), '');
				url = url.replace('?'+slug+'[]=' + $(this).attr('data-id'), '');
				url = url.replace('/&'+slug+'', '/?'+slug+'');
				window.location = url;
			} else {
				$(this).addClass('active');
				$(this).find('img').attr('src', check_img);
				url += ( url.match( /[\?]/g ) ? '&' : '?' ) + ''+slug+'[]=' + $(this).attr('data-id');
				window.location = url;
			}
			
		});
		
 });