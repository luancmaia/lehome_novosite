      var posts;
      jQuery('#post').autocomplete({
        source: function(req,resp){
          jQuery.ajax({
            type:'post',
            url:'admin-ajax.php',
            data: {
              action: 'he_read_posts',
              query: req.term,
              category_id: jQuery('#categoria_id').val()
            },
            dataType: 'json',
            success: function(r){
              posts = [];
              resp( jQuery.map( r, function(item){
                posts[item.ID] = item;
                return {
                  label: item.post_title,
                  value: item.ID
                }
              }));
            }
          });
        },
        minLength: 2,
        select: function(event, ui){
          this.value = ui.item.label;
          jQuery('#post').val(ui.item.label);
          if(jQuery('#titulo').val()==''){
            jQuery('#titulo').val(ui.item.label);
          }
          jQuery('#post_id').val(ui.item.value);
          if(jQuery('#descricao').val()==''){
            jQuery('#descricao').val(posts[ui.item.value].post_excerpt);
          }
          jQuery('#content-add_media').attr('href','media-upload.php?post_id='+ui.item.value+'&TB_iframe=1');
          imagemPost();
          urlPost();
          return false;
        }
      });
      jQuery('#categoria_id').bind('change', function(){
        limpar_campos();
      });
