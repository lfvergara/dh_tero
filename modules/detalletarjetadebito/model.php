<?php
require_once 'modules/tarjetacredito/model.php';


class DetalleTarjetaDebito extends StandardObject {
	
	function __construct(TarjetaCredito $tarjetacredito=NULL) {
		$this->detalletarjetadebito_id = 0;
		$this->institucion_financiera = '';
		$this->cbu = '';
		$this->numero_tarjeta = 0;
		$this->fecha_vencimiento = '';
		$this->tarjetacredito = $tarjetacredito;
	}
}
?>