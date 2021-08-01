<?php
require_once 'modules/gerencia/model.php';


class CentroCosto extends StandardObject {
	
	function __construct(Gerencia $gerencia=NULL) {
		$this->centrocosto_id = 0;
		$this->codigo = 0;
		$this->denominacion = '';
		$this->gerencia = $gerencia;
	}
}
?>