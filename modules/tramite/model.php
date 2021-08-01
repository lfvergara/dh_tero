<?php


class Tramite extends StandardObject {
	
	function __construct(Requisito $requisito=NULL) {
		$this->tramite_id = 0;
		$this->denominacion = '';
		$this->nomenclatura = '';
		$this->online = 0;
		$this->requisito = '';
	}
}
?>