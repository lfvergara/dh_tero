<?php
require_once 'modules/provincia/model.php';


class Localidad extends StandardObject {
	
	function __construct(Provincia $provincia=NULL) {
		$this->localidad_id = 0;
		$this->denominacion = '';
		$this->valor_agregado = 0.00;
		$this->interior = 0;
		$this->provincia = $provincia;
	}
}
?>