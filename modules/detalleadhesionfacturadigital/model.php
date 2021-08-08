<?php
require_once 'modules/gestioncomercial/model.php';


class DetalleAdhesionFacturaDigital extends StandardObject {
	
	function __construct(GestionComercial $gestioncomercial=NULL) {
		$this->detalleadhesionfacturadigital_id = 0;
		$this->numero_tramite = 0;
		$this->termino_condiciones = 0;
		$this->fecha_termino_condiciones = '';
		$this->ip = '';
		$this->so = '';
		$this->tipo = '';
		$this->detalle = '';
		$this->gestioncomercial = $gestioncomercial;
	}
}
?>