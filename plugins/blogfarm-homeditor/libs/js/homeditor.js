/*Homeditor*/
var homeditorCurrent;
jQuery(document).ready(function() {
	init_he();
	jQuery('.botao-reverter').click(function() {
		if (confirm('Deseja reverter suas mudanças e voltar com os boxes da home de produção?')) {
			jQuery.ajax({
				type: 'post',
				url: 'admin-ajax.php',
				data: {action: 'he_revert_home'},
				dataType: 'text',
				success: function(r) {
					atualiza_preview();
					setTimeout(function() {
						alert('Suas mudanças foram revertidas.');
					}, 1000);
				}
			});
		}
		return false;
	});
	jQuery('.button-primary').click(function() {
		if (confirm('Deseja publicar esta home?')) {
			jQuery.ajax({
				type: 'post',
				url: 'admin-ajax.php',
				data: {action: 'he_publish_home'},
				dataType: 'text',
				success: function(r) {
					if (r == '1') {
						alert('Sua home foi atualizada.');
					}
				}
			});
		}
		return false;
	});
});
function init_he() {
	jQuery('#homeditor-box').dialog({width: 500, height: 380, closeOnEscape: false, zIndex: 1, autoOpen: false, modal: true,
		buttons: {
			'Cancelar': function() {
				jQuery('#homeditor-box').dialog('close');
				jQuery('.homeditor').removeClass('editando');
				jQuery('.conteudo-box-homeditor').html(he_loader());
			},
			'Limpar': function() {
				limpar_campos(true);
			},
			'Salvar': function() {
				salvarBox();
				jQuery('#homeditor-box').dialog('close');
				jQuery('.homeditor').removeClass('editando');
				jQuery('.conteudo-box-homeditor').html(he_loader());
			}
		}});
	jQuery('.homeditor-box-open').click(function() {
		jQuery('#homeditor-box').dialog('open');
	});
	jQuery('.homeditor').each(function() {
		jQuery(this).click(function() {
			homeditorCurrent = homeditorBoxes[jQuery(this).attr('id')];
			openBox(jQuery(this).attr('id'));
			jQuery('#homeditor-box').dialog('open');
		});
	});
}
function urlPost() {
	jQuery.ajax({
		type: 'post',
		url: 'admin-ajax.php',
		data: {action: 'he_url_post', post_id: jQuery('#post_id').val()},
		dataType: 'text',
		success: function(r) {
			jQuery('#url').val(r);
		}
	});
}
function imagemPost() {
	jQuery.ajax({
		type: 'post',
		url: 'admin-ajax.php',
		data: {action: 'he_imagem_post', post_id: jQuery('#post_id').val()},
		dataType: 'text',
		success: function(r) {
			jQuery('#url_imagem').val(r);
		}
	});
}
function atualiza_preview() {
	jQuery.ajax({
		type: 'post',
		url: 'admin-ajax.php',
		data: {action: 'he_show_preview'},
		dataType: 'html',
		success: function(r) {
			jQuery('#he-preview').html(r);
			init_he();
		}
	});
}
function salvarBox() {
	args = jQuery('#dadosBox').serialize();
	jQuery.ajax({
		type: 'post',
		url: 'admin-ajax.php',
		data: args,
		dataType: 'html',
		success: function(r) {
			homeditorBoxes = r;
			atualiza_preview();
		}
	});
}
function he_loader() {
	return '<center style="margin-top:80px">Aguarde . . .<br /><img style="margin-top:20px" src="../wp-includes/js/thickbox/loadingAnimation.gif" /></center>';
}
function limpar_campos() {
	if (arguments.length > 0) {
		jQuery('#dadosBox select').val('');
	}
	jQuery('#dadosBox input').not('.dontchange').not('input[type=checkbox]').val('');
	jQuery('#dadosBox input[type=checkbox]').attr('checked', false);
}
var xhrBox;
function openBox(box) {
	jQuery('.homeditor').removeClass('editando');
	jQuery('.conteudo-box-homeditor').html(he_loader());
	try {
		xhrBox.abort();
	} catch (e) {
	}
	xhrBox = jQuery.ajax({
		type: 'post',
		url: 'admin-ajax.php',
		data: {action: 'he_open_box', box_name: box},
		dataType: 'html',
		success: function(r) {
			jQuery('.conteudo-box-homeditor').html(r);
		},
		error: function(r) {
			if (r.statusText != 'abort') {
				alert('Ocorreu um erro, tente novamente.');
				jQuery('#homeditor-box').dialog('close');
			}
		}
	});
}
window.send_to_editor = function(html) {
	jQuery('#url_imagem').val(jQuery('img', html).attr('src'));
	tb_remove();
}
