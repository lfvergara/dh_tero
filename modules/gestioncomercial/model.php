<?php
require_once 'modules/tipogestioncomercial/model.php';


class GestionComercial extends StandardObject {
	
	function __construct(TipoGestionComercial $tipogestioncomercial=NULL) {
		$this->gestioncomercial_id = 0;
		$this->suministro = 0;
		$this->fecha = '';
		$this->dni = 0;
		$this->apellido = '';
		$this->nombre = '';
		$this->correoelectronico = '';
		$this->telefono = 0;
		$this->tipogestioncomercial = $tipogestioncomercial;
	}
}
?>