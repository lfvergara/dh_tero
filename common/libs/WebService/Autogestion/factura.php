<?php

Class wsFactura implements JsonSerializable {
	
	public $periodo;
	public $nis;
	public $numero;
	public $fechaEmision;
	public $fechaVencimiento;
	public $fechaPago;
	public $agentePago;
	public $total;
	public $pagada;
	
	public function __construct(){
		$this->periodo = "";
		$this->nis = 0;
		$this->numero = "";
		$this->fechaEmision = date('Y-m-d');
		$this->fechaVencimiento = date('Y-m-d');
		$this->fechaPago = date('Y-m-d');
		$this->agentePago = "";
		$this->total = 0.0;
		$this->pagada = false;
	}
	
	public function jsonSerialize() {
		return get_object_vars($this);
	}
	
	public static function CastStd($class){
		$factura = new wsFactura();
		$factura->setPeriodo($class->periodo);
		$factura->setAgentePago($class->agentePago);
		$factura->setFechaEmision($class->fechaEmision);
		$factura->setFechaPago($class->fechaPago);
		$factura->setFechaVencimiento($class->fechaVencimiento);
		$factura->setNis($class->nis);
		$factura->setNumero($class->numero);
		$factura->setPagada($class->pagada);
		$factura->setTotal($class->total);
		return $factura;
	}
	
	public function getPeriodo() {
		return $this->periodo;
	}

	public function setPeriodo($periodo) {
		$this->periodo = $periodo;
	}

	public function getNis() {
		return $this->nis;
	}

	public function setNis($nis) {
		$this->nis = $nis;
	}

	public function getNumero() {
		return $this->numero;
	}

	public function setNumero($numero) {
		$this->numero = $numero;
	}

	public function getFechaEmision() {
		return $this->fechaEmision;
	}

	public function setFechaEmision($fechaEmision) {
		$this->fechaEmision = $fechaEmision;
	}

	public function getFechaVencimiento() {
		return $this->fechaVencimiento;
	}

	public function setFechaVencimiento($fechaVencimiento) {
		$this->fechaVencimiento = $fechaVencimiento;
	}

	public function getFechaPago() {
		return $this->fechaPago;
	}

	public function setFechaPago($fechaPago) {
		$this->fechaPago = $fechaPago;
	}

	public function getAgentePago() {
		return $this->agentePago;
	}

	public function setAgentePago($agentePago) {
		$this->agentePago = $agentePago;
	}

	public function getTotal() {
		return $this->total;
	}

	public function setTotal($total) {
		$this->total = $total;
	}

	public function getPagada() {
		return $this->pagada;
	}

	public function setPagada($pagada) {
		$this->pagada = $pagada;
	}
}
?>