<?php
include_once('class.Post.php');
class Box extends Post {
   public $is_chamada_externa, $is_inverter_hover, $box_nome, $url_imagem, $inibir_titulo;
   public function __construct(){
      parent::__construct();
   }
}
