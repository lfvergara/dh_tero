<?php

Class Peticion {

	private $parametro;
	private $valor;

	public function __construct(){
		$this->parametro = "";
		$this->valor = "";
	}

	public function getParametro(){
		return $this->parametro;
	}

	public function getValor(){
		return $this->valor;
	}

	public function setParametro($parametro){
		$this->parametro = $parametro;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}

}
?>