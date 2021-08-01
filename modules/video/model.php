<?php


class Video extends StandardObject {
	
	function __construct() {
		$this->video_id = 0;
		$this->denominacion = '';
		$this->url = '';
		$this->fecha_carga = '';
	}
}
?>