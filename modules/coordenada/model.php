<?php


class Coordenada extends StandardObject {
	
	function __construct() {
		$this->coordenada_id = 0;
		$this->latitud = '';
		$this->longitud = '';
		$this->altitud = 0;
		$this->etiqueta = '';
		$this->fillcolor = '';
		$this->strokecolor = '';
		$this->indice = 0;
	}
}
?>