<?php


class Banner extends StandardObject {
	
	function __construct() {
		$this->banner_id = 0;
		$this->detalle = '';
        $this->posicion = '';
		$this->activo = 0;
	}
}
?>