<?php


class CoordenadaMantenimientoPreventivo extends StandardObject {
	
	function __construct(Unicom $unicom=NULL) {
		$this->coordenadamantenimientopreventivo_id = 0;
		$this->latitud = '';
		$this->longitud = '';
		$this->altitud = 0;
		$this->etiqueta = '';
		$this->fillcolor = '';
		$this->strokecolor = '';
		$this->indice = 0;
		$this->mantenimientopreventivo_id = 0;
	}
}
?>