<?php


class Destinatario extends StandardObject {
	
	function __construct() {
		$this->destinatario_id = 0;
		$this->denominacion = '';
		$this->correoelectronico = '';
	}
}
?>