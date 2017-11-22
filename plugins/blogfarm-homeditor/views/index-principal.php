<div id="global" class="feed box_bgsize">
	<div id="content" class="box_bgsize">
		<section id="DP1" class="box_bgsize homeditor box-30-vertical box-divisor">
			<?php he_box_admin('DP1'); ?>
		</section>
		<section id="DS1" class="box_bgsize homeditor box-70">
			<?php he_box_admin('DS1'); ?>
		</section>
		<section id="DT1" class="box_bgsize homeditor box-30 box-divisor">
			<?php he_box_admin('DT1'); ?>
		</section>
		<section id="DS2" class="box_bgsize homeditor box-30">
			<?php he_box_admin('DS2'); ?>
		</section>
		<section id="DS3" class="box_bgsize homeditor box-100">
			<?php he_box_admin('DS3'); ?>
		</section>
		<section id="DP3" class="box_bgsize homeditor box-30 box-divisor apagaIpad mostraMobile">
			<?php he_box_admin('DP3'); ?>
		</section>
		<section id="DP2" class="box_bgsize homeditor box-30 box-divisor apagaIpad">
			<?php he_box_admin('DP2'); ?>
		</section>
		<section id="DT2" class="box_bgsize homeditor box-30 apagaIpad">
			<?php he_box_admin('DT2'); ?>
		</section>
		<!-- BOX COM 50% DE LARGURA. NÃO FOI PLANEJADO PELO CLIENTE. FICA COMO OPCIONAL -->
		<!--
		<section class="box-50 box-divisor">
			<header class="linkbox">
				<h2 class="textoOver">VERÃO 2016</h2>
				<h3 class="textoOver">LOOKBOOK<br /><br />
					<span class="textoOver">DESCUBRA</span>
				</h3>
			</header>
			<figure>
				<img src="<?php echo get_bloginfo('template_directory');?>/images/box-50.jpg">
			</figure>
		</section>
		<section class="box-50">
			<header class="linkbox">
				<h2 class="textoOver">VERÃO 2016</h2>
				<h3 class="textoOver">LOOKBOOK<br /><br />
					<span class="textoOver">DESCUBRA</span>
				</h3>
			</header>
			<figure>
				<img src="<?php echo get_bloginfo('template_directory');?>/images/box-50-02.jpg">
			</figure>
		</section>
		-->
	</div>
</div>
		<style>

	@font-face {
		font-family: 'FuturaMdBt';
		src: url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futumd__-webfont.eot');
		src: url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futumd__-webfont.eot?#iefix') format('embedded-opentype'),
			url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futumd__-webfont.woff') format('woff'),
			url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futumd__-webfont.ttf') format('truetype'),
			url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futumd__-webfont.svg#FuturaMdBt') format('svg');
		font-weight: normal;
		font-style: normal;
	}
	@font-face {
		font-family: 'FuturaLtBT';
		src: url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futult__-webfont.eot');
		src: url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futult__-webfont.eot?#iefix') format('embedded-opentype'),
			url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futult__-webfont.woff') format('woff'),
			url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futult__-webfont.ttf') format('truetype'),
			url('<?php echo HE_PLUGIN_URL; ?>libs/fonts/futult__-webfont.svg#FuturaLtBT') format('svg');
		font-weight: normal;
		font-style: normal;
	}

	* {
	  -webkit-box-sizing: border-box; /* Android ≤ 2.3, iOS ≤ 4 */
	     -moz-box-sizing: border-box; /* Firefox ≤ 28 */
	          box-sizing: border-box; /* Chrome, Firefox 29+, IE 8+, Opera, Safari 5.1 */
	}

	#global {
		position: relative;
		overflow-x: hidden;
		transition: all 0.25s ease 0s;
	}

	#global, #barra-footer {
		width: 100%;
	}

	#global #content {
		width: 70%;
		margin: 0 auto;
		margin-top: 65px;
		max-width: 1500px;
	}

	#global #content .box-30 {
		width: 32.8%;
		max-width: 492px;
		height: auto;
	}

	#global #content .box-30-vertical {
		width: 32.8%;
		max-width: 492px;
		height: auto;
	}

	#global #content .box-50 {
		width: 49.6%;
		max-width: 744px;
		height: auto;
	}

	#global #content .box-70 {
		width: 66.4%;
		max-width: 996px;
		height: auto;
	}

	.box_bgsize {
	  -webkit-background-size: 100% 100%; /* Safari 3-4 */
	   background-size: 100% 100%; /* Chrome, Firefox 4+, IE 9+, Opera, Safari 5+ */
	}

	#global #content .box-100 {
		width: 100%;
		max-width: 1500px;
		height: auto;
	}

	#global #content section:hover > header {
		display: block;
		opacity: 1.0;
		cursor: pointer;
	}

	#global #content header.linkbox {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 100%;
		height: 100%;
		background: rgba(0,0,0,0.3);
		text-align: center;
		z-index: 2;
		opacity: 0.0;
		transition: opacity 0.5s ease 0s;
	}

	#global #content header.linkbox h2, #global #content header.linkbox h3, 
	#global #content header.linkbox span {
		position: relative;
	}

	#global #content section header.linkbox h2 {
		font-size: 20px;
	}

	#global #content section header.linkbox h3 {
		font-size: 42px;
	}

	#global #content section.box-30-vertical header.linkbox h2 {
		top: 40%;
	}

	#global #content section.box-30-vertical header.linkbox h3 {
		top: 40%;
	}

	#global #content section.box-30 header.linkbox h2, #global #content section.box-50 header.linkbox h2,
	#global #content section.box-70 header.linkbox h2, #global #content section.box-100 header.linkbox h2 {
		top: 40%;
	}

	#global #content section.box-30 header.linkbox h3, #global #content section.box-50 header.linkbox h3,
	#global #content section.box-70 header.linkbox h3 {
		top: 40%;
	}

	#global #content section.box-100 header.linkbox h3 {
		top: 42%;
	}

	#global #content header.linkbox span {
		font-size:18px;
		color: #FFFFFF;
		background: rgba(0,0,0,0.5);
		border:2px solid #FFFFFF;
		padding:16px 40px 16px 40px;
		transition: background-color 0.5s ease 0s;
	}

	#global #content header.linkbox span:hover {
		background: #FFFFFF;
		color: #000000;
	}

	#global #content section {
		position: relative;
		float: left;
		margin-top: 0.8%;
		overflow: hidden;
	}

	#global #content figure {
		position: absolute;
		/* width: inherit; */
		z-index: 1;
	}

	#global #content section img {
		min-height: 100%;
		min-width: 100%;
		height: auto;
		max-width: 100%;
	}

	#global #content .box-divisor {
		/* margin:12px 12px 0 0; */
		margin:0.8% 0.8% 0 0;
	}

	figure {
		position: absolute;
		z-index: 1;
		padding:0;
		margin:0;
		float:left;
	}

	/* =Video Responsive
	-------------------------------------------------------------- */

	.hvideo {
		height: 206px;
	}

	.hvideo iframe, .hvideo object, .hvideo embed {
		width: 100%;
		height: 206px;
	}

	.mvideo {
		height: 0;
		overflow: hidden;
		padding-bottom: 28.125%;
		padding-top: 12px;
		position: relative;
	}

	.mvideo iframe, .mvideo object, .mvideo embed {
		width: 100%;
		height: 100%;
		left: 0;
		top: 0;
		position: absolute;
	}
	.homeditor-video {
		background-color: black;
		color:white;
		font-weight: bold;
		height: 17px;
		width: 227px;

	}
	.hover-admin-invertido {
		background: url("<?php echo HE_PLUGIN_URL; ?>libs/images/bg-hover-layer.png") repeat 0 0 transparent;
		position:absolute;
		width:inherit;
		height:inherit;
		display:block;
	}
	.hover-admin-invertido h3, .hover-admin h3 {
		color: #382F2A;
		font-family: 'FuturaLtBT';		
		font-size: 8px;
		letter-spacing: -0.06em;
		line-height: 8px;	
		padding: 0 4%;
		text-align: right;
		text-shadow: 2px 1px 2px #f7f7f7;
		width: 92%;
	}
	.hover-admin-invertido h2, .hover-admin h2 {
		color: #382F2A;
		float: right;	
		font-family: 'FuturaMdBt';			
		font-size: 16px;
		letter-spacing: -0.06em;
		padding: 2% 2% 1%;
		text-align: right;
		text-shadow: 2px 1px 2px #f7f7f7;
		text-transform: uppercase;
		width: 92%;
	}
	.hover-admin {
		background: url("<?php echo HE_PLUGIN_URL; ?>libs/images/bg-hover-layer.png") repeat 0 0 transparent;	
		display:none;
		position:absolute;
		width:100%;
		height:100%;
	}
	.chamada-externa {
		width:16px;
		height:16px;
		background: url("<?php echo HE_PLUGIN_URL; ?>libs/images/arrow_turn_right.png") repeat 0 0 transparent;	
		position:absolute;
		right:0;
	}
</style>
<script>
	jQuery('.homeditor').mouseenter(function(e) {
		jQuery(this).find('.hover-admin').fadeIn('fast');
		jQuery(this).find('.hover-admin-invertido').fadeOut('fast');
	});
	jQuery('.homeditor').mouseleave(function(e) {
		jQuery(this).find('.hover-admin').fadeOut('fast');
		jQuery(this).find('.hover-admin-invertido').fadeIn('fast');
	});
</script>
