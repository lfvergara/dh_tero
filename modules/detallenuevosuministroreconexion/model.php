<?php
require_once 'modules/gestioncomercial/model.php';


class DetalleNuevoSuministroReconexion extends StandardObject {
	
	function __construct(GestionComercial $gestioncomercial=NULL) {
		$this->detallenuevosuministroreconexion_id = 0;
		$this->numero_tramite = 0;
		$this->nis = 0;
		$this->termino_condiciones = 0;
		$this->fecha_termino_condiciones = '';
		$this->ip = '';
		$this->so = '';
		$this->tipo = '';
		$this->tipo_titularidad = '';
		$this->tipo_persona = '';
		$this->detalle = '';
		$this->gestioncomercial = $gestioncomercial;
	}
}
?>