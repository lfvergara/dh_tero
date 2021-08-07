<?php
require_once 'modules/estadogestioncomercial/model.php';


class GestionComercialHistorico extends StandardObject {
	
	function __construct(EstadoGestionComercial $estadogestioncomercial=NULL) {
		$this->gestioncomercialhistorico_id = 0;
		$this->fecha = '';
		$this->hora = '';
		$this->detalle = '';
		$this->estadogestioncomercial = $estadogestioncomercial;
	}
}
?>