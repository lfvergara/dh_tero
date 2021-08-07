<?php
require_once 'modules/tipogestioncomercial/model.php';


class TipoGestionComercial extends StandardObject {
	
	function __construct() {
		$this->tipogestioncomercial_id = 0;
		$this->denominacion = '';
		$this->cantidadarchivo = 0;
		$this->codigo = '';
	}
}
?>