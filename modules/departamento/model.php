<?php
require_once 'modules/unicom/model.php';


class Departamento extends StandardObject {
	
	function __construct(Unicom $unicom=NULL) {
		$this->departamento_id = 0;
		$this->denominacion = '';
		$this->unicom = $unicom;
	}
}
?>