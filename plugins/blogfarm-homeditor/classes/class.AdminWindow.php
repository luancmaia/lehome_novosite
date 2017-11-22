<?php
class AdminWindow {
  private $box, $box_name, $arquivos_extras = array(), $opcoes_box = array();
  public function __construct($boxes, $box){
    $this->box = $boxes[$box];
    $this->box_name = $box;
    
    $this->opcoes_box = array(
      array('name' => 'is_chamada_externa', 'label' => 'Chamada Externa' ),
      array('name' => 'is_inverter_hover', 'label' => 'Inverter Hover' ),
      array('name' => 'inibir_titulo', 'label' => 'Inibir Titulo' ),
    );
    $this->arquivos_extras['js'][] = HE_PLUGIN_URL.'libs/js/chamada-externa.js';
    
    echo '<form id="dadosBox"><input class="dontchange" type="hidden" name="action" value="he_save_box" />
      <input type="hidden"  class="dontchange" name="box_name" value="'.$box.'" />';
    if(!$this->box || array_key_exists('post_id',$this->box)){
      $this->post();
    }
    if(!$this->box || array_key_exists('url_imagem',$this->box)){
      $this->imagem();
    }
    if(!$this->box || array_key_exists('url_video',$this->box)){
      $this->video();
    }
    $this->url();
    $this->box();
    $this->arquivos_extras();
    echo "
    <script>
    $('#ui-dialog-title-homeditor-box').html('$box');
    $('#$box').addClass('editando');
     $(document).ready(function () {

    if ($.fn.mColorPicker.init.replace) {

      $('input[data-mcolorpicker!=\"true\"]').filter(function() {
    
        return ($.fn.mColorPicker.init.replace == '[type=color]')? this.getAttribute(\"type\") == 'color': $(this).is($.fn.mColorPicker.init.replace);
      }).mColorPicker();

      $.fn.mColorPicker.liveEvents();
    }

    $('.mColorPicker').live('keyup', function () {

      try {
  
        $(this).css({
          'background-color': $(this).val()
        }).css({
          'color': $.fn.mColorPicker.textColor($(this).css('background-color'))
        }).trigger('change');
      } catch (r) {}
    });

    $('.mColorPickerTrigger').live('click', function () {

      $.fn.mColorPicker.colorShow($(this).attr('id').replace('icp_', ''));
    });
  });
    </script>
    </form>";
  }
  private function tamanho_imagem($template){
    $formatos = array(
      'DP1' => '724x519',
      'DP2' => '576x412',
      'DP3' => '724x307',
      'DS1' => '576x326',
      'DS2' => '576x457',
      'DS3' => '724x369',
      'DT1' => '433x400',
      'DT2' => '533x400',
      'DT3' => '334x400',
      'DT4' => '300x233',
      'SI1' => '278x273',
      'SI2' => '278x273',
      'SI3' => '278x462',
      'FIXO' => '278x366',
    );
    if(array_key_exists($this->box_name, $formatos)){
      return sprintf($template, $formatos[$this->box_name]);
    }
  }
  public function arquivos_extras(){
    foreach ($this->arquivos_extras as $tipo => $arquivos){
      foreach ( $arquivos as $arquivo ){
        if($tipo=='js'){
          printf("<script src=\"%s\"></script>\n", $arquivo);
        }
      }
    }
  }
  public function box(){
      ?>
      <div class="destaque updated">
         <strong>Opções do Box</strong>
         <?php foreach ( $this->opcoes_box as $opcao ): ?>
           <input type="checkbox" name="<?php echo $opcao['name'] ?>" id="<?php echo $opcao['name'] ?>" value="1" <?php echo $this->box[$opcao['name']]?'checked="checked"':''; ?> />
           <label for="<?php echo $opcao['name'] ?>"><?php echo $opcao['label'] ?></label>
         <?php endforeach; ?>
      </div>
      <?php
  }

  public function categoria(){
      ?>
      <div class="categoria">
         <label for="categoria_id">Categoria</label>
         <?php wp_dropdown_categories(array(
           'selected' => $this->box['categoria_id'],
           'name' => 'categoria_id',
           'id' => 'categoria_id',
           'hide_if_empty' => true,
           'show_option_all' => 'Todas',
         )); ?>
      </div>
      <?php
  }

  public function post(){
    $this->categoria();
    $this->arquivos_extras['js'][] = HE_PLUGIN_URL.'libs/js/autocomplete.js';
      ?>
      <div class="busca-post">
         <label for="post">Post</label>
         <input type="hidden" id="post_id" name="post_id" value="<?php echo esc_attr($this->box['post_id']); ?>" />
         <input type="text" id="post" name="post" value="<?php echo esc_attr(get_the_title($this->box['post_id'])); ?>" />
      </div>
      <div>
         <label for="titulo">Título</label>
         <input type="text" id="titulo" name="titulo" value="<?php echo stripslashes(esc_attr($this->box['titulo'])); ?>" />
      </div>
      <div>
         <label for="custom_titulo_tamanho">Tamanho: </label><input style="width:70px" size="2" type="text" id="custom_titulo_tamanho" name="custom_titulo_tamanho" value="<?php echo stripslashes(esc_attr($this->box['custom_titulo_tamanho'])) ?>" />% (opcional)
      </div>
      <div> 
         <label for="custom_titulo_cor">Cor:</label><input  data-hex="true"  class="color" style="width:70px" size="6" type="color" id="custom_titulo_cor" name="custom_titulo_cor" value="<?php echo stripslashes(esc_attr($this->box['custom_titulo_cor']))  == '' ? '#FFFFFF' : stripslashes(esc_attr($this->box['custom_titulo_cor'])) ?>" />
      </div>
      <div> 
         <label for="custom_fundo_cor">Cor Fundo:</label><input  data-hex="false"  class="color" style="width:70px" size="6" type="color" id="custom_fundo_cor" name="custom_fundo_cor" value="<?php echo stripslashes(esc_attr($this->box['custom_fundo_cor']))  == '' ? '#FFFFFF' : stripslashes(esc_attr($this->box['custom_fundo_cor'])) ?>" />
      </div>
<!--      <div>
            <label for="custom_titulo_preenchimento">Preenchimento: </label><label><input type="radio" name="custom_titulo_preenchimento" value="white" <?php echo stripslashes(esc_attr($this->box['custom_titulo_preenchimento']))  == 'white' ? 'checked' : ''; ?> />Branco</label>&nbsp;<label><input type="radio" name="custom_titulo_preenchimento" value="black" <?php echo stripslashes(esc_attr($this->box['custom_titulo_preenchimento']))  == 'black' ? 'checked' : ''; ?> />Preto</label>
      </div>-->
      <?php
  }
  public function url(){
    ?>
    <div>
      <label for="url_imagem">URL Destino</label>
      <input type="text" name="url" id="url" value="<?php echo stripslashes(esc_attr($this->box['url'])); ?>" />
    </div>
    <?php
  }

  public function imagem(){
      ?>
      <div>
         <label for="url_imagem">Imagem<?php echo $this->tamanho_imagem(" <br /><small>(Tamanho %s)</small>"); ?></label>
         <input type="text" id="url_imagem" name="url_imagem" value="<?php echo stripslashes(esc_attr($this->box['url_imagem'])); ?>" />
         <a href="<?php echo site_url(); ?>/wp-admin/media-upload.php?post_id=<?php echo esc_attr($this->box['post_id']); ?>&TB_iframe=1" class="thickbox add_media" id="content-add_media" title="Incluir Foto" onclick="return false;">
          <img src="<?php echo site_url(); ?>/wp-admin/images/media-button.png?ver=20111005" width="15" height="15" />
         </a>
      </div>
      <div>
         <label for="descricao">Descrição</label>
         <input type="text" id="descricao" name="descricao" value="<?php echo stripslashes(esc_attr($this->box['descricao'])); ?>" />
      </div>
      <div>
         <label for="custom_descricao_tamanho">Tamanho: </label><input style="width:70px" size="2" type="text" id="custom_descricao_tamanho" name="custom_descricao_tamanho" value="<?php echo stripslashes(esc_attr($this->box['custom_descricao_tamanho'])); ?>" />px  (opcional)
      </div>
      <div> 
         <label for="custom_descricao_cor">Cor: </label><input  data-hex="true" style="width:70px"  class="color" size="6" type="color" id="custom_descricao_cor" name="custom_descricao_cor" value="<?php echo stripslashes(esc_attr($this->box['custom_descricao_cor']))  == '' ? '#FFFFFF' : stripslashes(esc_attr($this->box['custom_descricao_cor']))  ?>" />
      </div>
      <?php
  }
  public function video(){
    $this->opcoes_box[] = array(
      'label' => 'Destaque Vídeo', 'name' => 'destaque_video'
    );
    $this->arquivos_extras['js'][] = HE_PLUGIN_URL.'libs/js/video.js';
    global $he_video_fontes;
      ?>
      <div class="campo_video" style="display:none">
         <label for="url_video">Vídeo</label>
         <input type="text" id="url_video" name="url_video" value="<?php echo stripslashes(esc_attr($this->box['url_video'])); ?>" />
      </div>
      <div class="campo_video" style="display:none">
           <label for="video_autoplay">Autoplay</label>
           <input type="checkbox" name="video_autoplay" id="video_autoplay" value="1" <?php echo $this->box['video_autoplay']?'checked="checked"':''; ?> />
      </div>
      <div class="campo_video" style="display:none">
           <label for="video_loop">Loop</label>
           <input type="checkbox" name="video_loop" id="video_loop" value="1" <?php echo $this->box['video_loop']?'checked="checked"':''; ?> />
      </div>
      <div class="campo_video" style="display:none">
           <label for="video_sem_som">Sem Som</label>
           <input type="checkbox" name="video_sem_som" id="video_sem_som" value="1" <?php echo $this->box['video_sem_som']?'checked="checked"':''; ?> />
      </div>
      <div class="campo_video" style="display:none">
           <label for="video_fonte">Fonte</label>
           <select id="video_fonte" name="video_fonte">
           	  <?php foreach ($he_video_fontes as $id=>$f): ?>
           	  <option <?php if($this->box['video_fonte']==$id){ echo 'selected="selected"'; } ?> value="<?php echo $id; ?>"><?php echo $f; ?></option>
           	  <?php endforeach; ?>
           </select>
      </div>
      <?php
  }
}
