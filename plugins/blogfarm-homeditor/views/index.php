<script type="text/javascript" src="<?php bloginfo('wpurl') ?>/wp-content/plugins/blogfarm-homeditor/js/mColorPicker.js"></script>
<div id="he-preview">
  <?php he_show_preview(false); ?>
</div>
<div id="homeditor-box" class="escondido">
	<div class="conteudo-box-homeditor"></div>
</div>
<p class="submit">
<?php submit_button('Publicar', 'primary', null, false, array('class'=>'botao-publicar')); ?>
<?php submit_button('Reverter', 'botao-reverter', 'botao-reverter', false, array('class'=>'botao-reverter', 'id'=>'botao-reverter')); ?>
</p>
<?php if($info = he_last_info()): ?>
  <div style="float:right">Em <b><?php echo $info[1]; ?></b> por <b><?php echo get_user_by('id',$info[0])->user_login; ?></b></div>
<?php endif; ?>
