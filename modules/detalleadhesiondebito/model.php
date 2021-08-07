<?php
require_once 'modules/gestioncomercial/model.php';
require_once 'modules/detalletarjetadebito/model.php';


class DetalleAdhesionDebito extends StandardObject {
	
	function __construct(GestionComercial $gestioncomercial=NULL, DetalleTarjetaDebito $detalletarjetadebito=NULL) {
		$this->detalleadhesiondebito_id = 0;
		$this->numero_tramite = 0;
		$this->metodo_envio = 0;
		$this->termino_condiciones = 0;
		$this->fecha_termino_condiciones = '';
		$this->ip = '';
		$this->so = '';
		$this->detalle = '';
		$this->gestioncomercial = $gestioncomercial;
		$this->detalletarjetadebito = $detalletarjetadebito;
	}
}
?>