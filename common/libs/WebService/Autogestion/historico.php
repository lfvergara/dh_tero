<?php

Class wsHistorico {
	
	public $periodo;
	public $dias;
	public $consumo;
	
	public function __construct(){
		$this->periodo = "";
		$this->dias = 0;
		$this->consumo = 0;
	}
	
	public static function CastStd($class){
		$historico = new wsHistorico();
		$historico->setPeriodo($class->periodo);
		$historico->setConsumo($class->consumo);
		$historico->setDias($class->dias);
		return $historico;
	}

	public function getConsumo() {
		return $this->consumo;
	}

	public function setConsumo($consumo) {
		$this->consumo = $consumo;
	}

	public function getDias() {
		return $this->dias;
	}

	public function setDias($dias) {
		$this->dias = $dias;
	}

	public function getPeriodo() {
		return $this->periodo;
	}

	public function setPeriodo($periodo) {
		$this->periodo = $periodo;
	}
	
}
?>