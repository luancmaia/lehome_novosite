<?php
/**
 * Plugin Name: Blogfarm Homeditor
 * Version: 2.0
 * Author: Blogfarm
 */

if(function_exists('add_action'))
	add_action('admin_menu', 'bf_homeditor_init');
	
define('HE_PLUGIN_URL', plugin_dir_url(__FILE__));	
global $he_video_fontes;
$he_video_fontes = array(1=>'You Tube', 2=>'Vimeo');
include_once(dirname(__FILE__).'/classes/class.BoxPadrao.php');
include_once(dirname(__FILE__).'/classes/class.AdminWindow.php');
include_once(dirname(__FILE__).'/boxes/class.DS1.php');
function bf_homeditor_init(){
  $handle = 'blogfarm';
  
  if (function_exists('add_menu_page')) {
      add_menu_page('Blogfarm', 'Blogfarm', 'manage_options', $handle);
  }
  add_submenu_page($handle, 'Home Editor', 'Home Editor', 'manage_options', 'blogfarm_homeditor', 'bf_homeditor_r');
  if(!stristr($_SERVER['REQUEST_URI'], 'blogfarm_homeditor')) return;
  wp_deregister_script('jquery');
  wp_deregister_script('jquery-ui');
wp_register_script('jquery', plugin_dir_url(__FILE__).'libs/jquery-ui/js/jquery-1.8.0.min.js' );
//  wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js' );
wp_register_script('jquery-ui', plugin_dir_url(__FILE__).'libs/jquery-ui/js/jquery-ui-1.8.23.custom.min.js' );
 // wp_register_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js' );
  wp_register_script('bf-homeditor-js', plugin_dir_url(__FILE__).'libs/js/homeditor.js' );
  wp_register_style('bf-homeditor-ui-css', plugin_dir_url(__FILE__).'libs/jquery-ui/css/eggplant/jquery-ui-1.8.23.custom.css' );
  wp_register_style('bf-homeditor-css', plugin_dir_url(__FILE__).'libs/css/homeditor.css' );
//wp_register_script('he-prefixfree', plugin_dir_url(__FILE__).'libs/js/prefixfree.min.js' );
  wp_register_script('he-prefixfree', 'http://cdn.jsdelivr.net/prefixfree/1.0.7/prefixfree.dynamic-dom.min.js' );
//wp_register_script('he-html5shiv', plugin_dir_url(__FILE__).'libs/js/html5shiv.js' );
  wp_register_script('he-html5shiv', 'http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv-printshiv.js/' );
  wp_register_script('he-respond', plugin_dir_url(__FILE__).'libs/js/respond.min.js', array(), false, true );
  
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui');
  wp_enqueue_script('bf-homeditor-js');
  wp_enqueue_script('swfobject');
  
  wp_enqueue_script('he-prefixfree');
  wp_register_style('bf-homeditor-principal-css', plugin_dir_url(__FILE__).'libs/css/style.css' );
  
  wp_enqueue_style('bf-homeditor-ui-css');
  wp_enqueue_style('bf-homeditor-css');
  add_thickbox();
}

add_action('wp_ajax_he_imagem_post', 'he_imagem_post');
add_action('wp_ajax_he_url_post', 'he_url_post');
add_action('wp_ajax_he_open_box', 'he_open_box');
add_action('wp_ajax_he_save_box', 'he_save_box');
add_action('wp_ajax_he_read_posts', 'he_read_posts');
add_action('wp_ajax_he_show_preview', 'he_show_preview');
add_action('wp_ajax_he_publish_home', 'he_publish_home');
add_action('wp_ajax_he_revert_home', 'he_revert_home');

function he_publish_home(){
	update_option('homeditor_published', get_option('homeditor_preview'));
	update_option('homeditor_last_update', array( get_current_user_id(), date('c') ) );
	if( class_exists('W3_Plugin_TotalCacheAdmin') ){
		@$cache = &new W3_Plugin_TotalCacheAdmin();
		@$cache->flush_all();
	}
	echo 1;
	exit();
}

function he_revert_home(){
  update_option('homeditor_preview', get_option('homeditor_published'));
  echo 1;
  exit();
}

function he_url_post(){
  $post_id = $_REQUEST['post_id'];
  echo get_post_permalink($post_id);
  exit();
}
function he_imagem_post(){
  $post_id = $_REQUEST['post_id'];
  $post_thumbnail_id = get_post_thumbnail_id( $post_id );
  do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, 'post-thumbnail' );
  list($url_imagem) = wp_get_attachment_image_src( $post_thumbnail_id, $size, false, $attr );
  exit($url_imagem);
}

function he_read_posts(){
  global $wpdb;
  $categoria = $wpdb->escape($_REQUEST['category_id']);
  $query = $wpdb->escape($_REQUEST['query']);
  if($categoria){
    $querystr = "
    	SELECT DISTINCT($wpdb->posts.ID), $wpdb->posts.* FROM $wpdb->posts
    	LEFT JOIN $wpdb->postmeta ON($wpdb->posts.ID = $wpdb->postmeta.post_id)
    	LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
    	LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
    	LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
    	WHERE $wpdb->terms.term_id = '$categoria'
    	AND $wpdb->term_taxonomy.taxonomy = 'category'
    	AND $wpdb->posts.post_status = 'publish'
    	AND $wpdb->posts.post_type = 'post'
    	AND $wpdb->posts.post_title LIKE '%$query%'
    	ORDER BY $wpdb->postmeta.meta_value ASC LIMIT 10
    ";
  } else {
    $querystr = "
    	SELECT * FROM $wpdb->posts WHERE post_title LIKE '%$query%' AND post_type = 'post' AND post_status = 'publish' LIMIT 10
    ";
  }
  $posts = $wpdb->get_results($querystr);
  exit(json_encode($posts));
}

function he_save_box(){
  unset($_POST['action']);
  extract($_POST);
  $homeditorBoxes = bf_homeditor_boxes();
  $homeditorBoxes[$box_name] = $_POST;
  $homeditorBoxes[$box_name]['destaque_video'] = $_POST['destaque_video'];
  $homeditorBoxes[$box_name]['is_chamada_externa'] = $_POST['is_chamada_externa'];
  $homeditorBoxes[$box_name]['inibir_titulo'] = $_POST['inibir_titulo'];
  $homeditorBoxes[$box_name]['is_inverter_hover'] = $_POST['is_inverter_hover'];
  $homeditorBoxes[$box_name]['video_autoplay'] = $_POST['video_autoplay'];
  if($homeditorBoxes[$box_name]['post_id']){
    $post = get_post($homeditorBoxes[$box_name]['post_id']);
    $homeditorBoxes[$box_name]['data_publicacao'] = $post->post_date;
  } else {
    $homeditorBoxes[$box_name]['data_publicacao'] = date('Y-m-d\Th:i:s');
  }
  if($destaque_video && $video_fonte==2){
  	$info_video = file_get_contents('http://vimeo.com/api/v2/video/'.$url_video.'.php');
  	if($info_video){
		$info_video = unserialize($info_video);
		if(is_array($info_video) && is_array($info_video[0])){
			$homeditorBoxes[$box_name]['info_video'] = $info_video[0];
		}
	}
  }
  
  he_updatePreview($homeditorBoxes);
  echo json_encode($homeditorBoxes);
  die();
}

function he_open_box(){
  $box = $_POST['box_name'];
  $homeditorBoxes = bf_homeditor_boxes($box);
  new AdminWindow($homeditorBoxes,$box);
  exit();
}

function bf_homeditor_boxes($box_name = null){
  global $homeditorBoxes;
	if(!$homeditorBoxes)
		$homeditorBoxes = he_getPreview();
	if($box_name){
    if(!file_exists(he_class_box($box_name))){
      $ob = (array)(new BoxPadrao());
    } else {
      $ob = (array)(new $box_name());
    }
    if(!$homeditorBoxes[$box_name]){
      $homeditorBoxes[$box_name] = &$ob;
    } else {
      $homeditorBoxes[$box_name] = array_merge($ob, $homeditorBoxes[$box_name]);
    }
	}
	return $homeditorBoxes;
}

function bf_homeditor_r(){
  bf_homeditor_header();
  include_once('views/index.php');
  bf_homeditor_footer();
}
function he_last_info(){
  return get_option('homeditor_last_update');
}
function he_show_preview($exit=true){
  $homeditorBoxes = bf_homeditor_boxes();
  bf_homeditor_jsbox($homeditorBoxes);
  wp_enqueue_script('froogaloop');
  include_once('views/index-principal.php');
  if($exit)
    die();
}

function he_updatePreview($boxes){
  update_option('homeditor_preview', $boxes);
}
function he_getPreview(){
  return get_option('homeditor_preview');
}
function he_getPublished() {
    return get_option('homeditor_published');
}

function bf_homeditor_jsbox($v){
	?><script>
	var homeditorBoxes = <?php echo json_encode($v); ?>;
	</script><?php
}

function bf_homeditor_footer(){
    ?></div><?php
}
function bf_homeditor_header(){
    ?><div class="wrap">
<?php screen_icon(); ?>
<br /><h2>Blogfarm Homeditor</h2>
<?php
}
function bf_homeditor_mediaupload($post_id=null){
	?>
	<a href="javascript:;" id="add_media" class="thickbox media-uploader" title="Enviar">Enviar Mídia</a>
	<script>
	jQuery(".media-uploader").attr('href','media-upload.php?post_id=<?php echo $post_id; ?>&type=image&TB_iframe=true&width=700');
	</script>
	<?php
}

function he_class_box($class_name){
  $filename = dirname(__FILE__).'/boxes/class.'.$class_name.'.php';
  return $filename;
}
function __autoload($class_name){
  $filename = he_class_box($class_name);
	file_exists($filename) &&
		include_once($filename);
  $filename = dirname(__FILE__).'/classes/class.'.$class_name.'.php';  
	file_exists($filename) &&
		include_once($filename);
}
function he_box_admin($box_name){
  $box = bf_homeditor_boxes($box_name);
  $is_chamada_externa = '';
  $is_inverter_hover = '';
  $inibir_titulo = '';
  $destaque_video = '';
  $categoria_id = '';
  $url_imagem = '';
  $url_video = '';
  $categoria = '';
  $descricao = '';
  $box_nome = '';
  $post_id = '';
  $titulo = '';
  $post = '';
  $url = '';
  extract($box[$box_name]);
  
  if(!$destaque_video && !$is_inverter_hover):
  ?>
    <div class="hover-admin">
      <?php if(!$inibir_titulo):?>
      <h2><?php echo $titulo; ?></h2>
      <h3><?php echo $descricao; ?></h3>
      <?php endif; ?>
    </div>
  <?php elseif(!$destaque_video && $is_inverter_hover): ?>
    <div class="hover-admin-invertido">
      <?php if(!$inibir_titulo):?>
      <h2><?php echo $titulo; ?></h2>
      <h3><?php echo $descricao; ?></h3>
      <?php endif; ?>
    </div>
  <?php endif;
  
  if($is_chamada_externa):?>
  <div title="Chamada Externa: <?php echo $url; ?>" class="chamada-externa"></div>
  <?php endif;
  
  switch ($box_name):
  case 'DP1':
  ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="310" alt="<?php echo $box_name; ?>" />
    </span>
  <?php
  break;
  case 'DP2':
  ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="201" alt="<?php echo $box_name; ?>" />
    </span>
  <?php
  break;
  case 'DP3':
  ?>
    <article itemscope itemtype="http://schema.org/CollectionPage">
    <span>
    <img itemprop="image" src="<?php echo $url_imagem; ?>" width="201" alt="<?php echo $box_name; ?>" />
    </span>
    </article>
  <?php
  break;
  case 'DS2':
  ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="270" alt="ds2" />
    </span>
  <?php
  break;
  case 'DS3':
  ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="50%" alt="ds3" />
    </span>
  <?php
  break;
  case 'SI1':
  case 'SI2':
  case 'SI3':
  ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="50%" alt="s1" />
    </span>
  <?php
  break;
  case 'DT1':
  case 'DT2':
  case 'DT3':
  case 'DT4':
  ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="50%" alt="<?php echo $box_name; ?>" />
    </span>
  <?php
  break;
  case 'DS1':
    if($destaque_video && $video_fonte!=2):
  ?>
    <div class="homeditor-video">
      Editar Destaque
    </div>
    <article itemprop="video" itemscope itemtype="http://schema.org/VideoObject" class="hvideo">
    <meta itemprop="contentUrl" content="http://www.youtube.com/v/<?php echo $url_video; ?>" />
    <meta itemprop="embedUrl" content="http://www.animale.com.br/video/" />
    
    <div id="<?php echo $box_name; ?>-video">
      You need Flash player 8+ and JavaScript enabled to view this video.
    </div>
    
    <script type="text/javascript">
      var params = { allowScriptAccess: "always" };
      var atts = { id: "myytplayer" };
      swfobject.embedSWF("http://www.youtube.com/v/<?php echo $url_video; ?>?enablejsapi=1&playerapiid=ytplayer&version=3",
                      // "<?php echo $box_name; ?>-video", "227", "231", "8", null, null, params, atts);
    </script>
    </article>
  <?php elseif ($destaque_video && $video_fonte==2): ?>
    <div class="homeditor-video">
      Editar Destaque
    </div>
        <article itemprop="video" itemscope itemtype="http://schema.org/VideoObject" class="hvideo">
        	<iframe id="player_vimeo" src="http://player.vimeo.com/video/<?php echo $url_video; ?>?autoplay=<?php echo $video_autoplay?'1':'0'; ?>&loop=<?php echo $video_loop?'1':'0'; ?>&api=1&player_id=player_vimeo" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        	<script>
        	jQuery(document).ready(function(){
        		try {
				if (window.addEventListener){
				    window.addEventListener('message', onMessageReceived, false);
				}
				else {
				    window.attachEvent('onmessage', onMessageReceived, false);
				}
        		} catch(e){}
				function onMessageReceived(e) {
					try{
				    var data = JSON.parse(e.data);
					} catch(e){}
					try {
				    switch (data.event) {
				        case 'ready':
							var iframe = jQuery('#player_vimeo')[0],
							    player = $f(iframe),
							    status = jQuery('.status');
							player.api('setVolume','<?php echo $video_sem_som?0:1; ?>');
	    			        break;
				    }
		        	} catch(e){}
				}
        	});
        	</script>
        </article>
  <?php else: ?>
    <span>
    <img src="<?php echo $url_imagem; ?>" width="50%" alt="ds1" />
    </span>
  <?php endif;
  break;
	endswitch;
}
