<?php
require_once 'modules/rangoturnero/model.php';


class ConfiguracionTurnero extends StandardObject {
	
	function __construct(RangoTurnero $rangoturnero=NULL) {
		$this->configuracionturnero_id = 0;
		$this->cantidad_gestores = 0;
		$this->duracion_turno = 0;
		$this->rangoturnero = $rangoturnero;
	}
}
?>