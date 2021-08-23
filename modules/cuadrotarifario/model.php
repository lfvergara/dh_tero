<?php


class CuadroTarifario extends StandardObject {
	
	function __construct() {
		$this->cuadrotarifario_id = 0;
		$this->detalle = '';
        $this->fecha_carga = '';
		$this->activo = 0;
	}

	function desactivar() {
		$sql = "UPDATE cuadrotarifario SET activo = 0";
		execute_query($sql);
	}
}
?>