<?php
require_once 'modules/gestioncomercial/model.php';


class DetalleCambioVencimientoJubilado extends StandardObject {
	
	function __construct(GestionComercial $gestioncomercial=NULL) {
		$this->detallecambiovencimientojubilado_id = 0;
		$this->numero_tramite = 0;
		$this->dia_vencimiento = 0;
		$this->termino_condiciones = 0;
		$this->fecha_termino_condiciones = '';
		$this->ip = '';
		$this->so = '';
		$this->detalle = '';
		$this->gestioncomercial = $gestioncomercial;
	}
}
?>