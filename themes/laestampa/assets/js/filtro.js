$(document).on('ready', function(){

		var check_img = 'http://petitpapier.com.br/wp-content/uploads/2017/12/square-check-x.png';
		var uncheck_img = 'http://petitpapier.com.br/wp-content/uploads/2017/12/square-x.png';

		$('a.remove-category-url').on('click', function(e){
			e.preventDefault();
			var url = $('.actual-url').val();
			url = url.replace('&tid[]=' + $(this).attr('data-id'), '');
			url = url.replace('?tid[]=' + $(this).attr('data-id'), '');
			url = url.replace('?tid%5B%5D=' + $(this).attr('data-id'), '');
			url = url.replace('/&tid%5B%5D', '/?tid');
			url = url.replace('/&tid', '/?tid');
			$(this).parent().fadeOut();
			window.location = url;
		});

		$('a.link-category').on('click', function(e){
			e.preventDefault();
			var url = $('.actual-url').val();
			if ( $(this).hasClass('active') ) {
				$(this).removeClass('active');
				$(this).find('img').attr('src', uncheck_img);
				url = url.replace('&tid[]=' + $(this).attr('data-id'), '');
				url = url.replace('?tid[]=' + $(this).attr('data-id'), '');
				url = url.replace('/&tid', '/?tid');
				window.location = url;
			} else {
				$(this).addClass('active');
				$(this).find('img').attr('src', check_img);
				url += ( url.match( /[\?]/g ) ? '&' : '?' ) + 'tid[]=' + $(this).attr('data-id');
				window.location = url;
			}
			
		})
 })