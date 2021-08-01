<?php

Class wsDeuda implements JsonSerializable {
	
	public $id;
	public $id_cliente;
	public $id_factura;
	public $suministro;
	public $fecha_factura;
	public $fecha_factura_vencimiento;
	public $fecha_factura_segundo_vencimiento;
	public $fecha_factura_proximo_vencimiento;
	public $fecha_factura_emision;
	public $fecha_factura_puesta_cobro;
	public $periodo_factura;
	public $tipo_rec;
	public $importe_energia;
	public $importe_agua;
	public $importe_total;
	public $estado_factura;
	public $fecha_pago;
	public $consumo;
	public $tarifa;
	
	public function __construct(){
		$this->id = 0;
		$this->id_cliente = 0;
		$this->id_factura = 0;
		$this->suministro = 0;
		$this->fecha_factura = "";
		$this->fecha_factura_vencimiento = "";
		$this->fecha_factura_segundo_vencimiento = "";
		$this->fecha_factura_proximo_vencimiento = "";
		$this->fecha_factura_emision = "";
		$this->fecha_factura_puesta_cobro = "";
		$this->periodo_factura = "";
		$this->tipo_rec = "";
		$this->importe_energia = 0.0;
		$this->importe_agua = 0.0;
		$this->importe_total = 0.0;
		$this->estado_factura = "";
		$this->fecha_pago = "";
		$this->consumo = 0;
		$this->tarifa = "";
	}
	
	public function jsonSerialize() {
		return get_object_vars($this);
	}
	
	public static function CastStd($class){
		$deuda = new wsDeuda();
		$deuda->setId($class->id);
		$deuda->setIdCliente($class->id_cliente);
		$deuda->setIdFactura($class->id_factura);
		$deuda->setSuministro($class->suministro);
		$deuda->setFechaFactura($class->fecha_factura);
		$deuda->setFechaFacturaVenc($class->fecha_factura_vencimiento);
		$deuda->setFechaFacturaVenc2($class->fecha_factura_segundo_vencimiento);
		$deuda->setFechaFacturaProximoVencimiento($class->fecha_factura_proximo_vencimiento);
		$deuda->setFechaFacturaEmision($class->fecha_factura_emision);
		$deuda->setFechaFacturaPuestaCobro($class->fecha_factura_puesta_cobro);
		$deuda->setPeriodo($class->periodo_factura);
		$deuda->setTipoRec($class->tipo_rec);
		$deuda->setImporteEnergia($class->importe_energia);
		$deuda->setImporteAgua($class->importe_agua);
		$deuda->setImporteTotal($class->importe_total);
		$deuda->setEstadoFactura($class->estado_factura);
		$deuda->setConsumo($class->consumo);
		$deuda->setTarifa($class->tarifa);
		return $deuda;
	}
	
	public function getFechaFacturaProximoVencimiento() {
		return $this->fecha_factura_proximo_vencimiento;
	}

	public function setFechaFacturaProximoVencimiento($fecha_factura_proximo_vencimiento) {
		$this->fecha_factura_proximo_vencimiento = $fecha_factura_proximo_vencimiento;
	}

	public function getFechaFacturaPuestaCobro() {
		return $this->fecha_factura_puesta_cobro;
	}

	public function setFechaFacturaPuestaCobro($fecha_factura_puesta_cobro) {
		$this->fecha_factura_puesta_cobro = $fecha_factura_puesta_cobro;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getIdCliente(){
		return $this->id_cliente;
	}
	
	public function setIdCliente($id_cliente){
		$this->id_cliente = $id_cliente;
	}
	
	public function getIdFactura(){
		return $this->id_factura;
	}
	
	public function setIdFactura($id_factura){
		$this->id_factura = $id_factura;
	}
	
	public function getSuministro(){
		return $this->suministro;
	}
	
	public function setSuministro($suministro){
		$this->suministro = $suministro;
	}
	
	public function getFechaFactura(){
		return $this->fecha_factura;
	}
	
	public function setFechaFactura($fecha_factura){
		$this->fecha_factura = $fecha_factura;
	}
	
	public function getFechaFacturaVenc(){
		return $this->fecha_factura_vencimiento;
	}
	
	public function setFechaFacturaVenc($fecha_factura_vencimiento){
		$this->fecha_factura_vencimiento = $fecha_factura_vencimiento;
	}
	
	public function getFechaFacturaVenc2(){
		return $this->fecha_factura_segundo_vencimiento;
	}
	
	public function setFechaFacturaVenc2($fecha_factura_segundo_vencimiento){
		$this->fecha_factura_segundo_vencimiento = $fecha_factura_segundo_vencimiento;
	}
	
	public function getFechaFacturaEmision(){
		return $this->fecha_factura_emision;
	}
	
	public function setFechaFacturaEmision($fecha_factura_emision){
		$this->fecha_factura_emision = $fecha_factura_emision;
	}
	
	public function getPeriodo(){
		return $this->periodo_factura;
	}
	
	public function setPeriodo($periodo_factura){
		$explode_periodo = explode('/', $periodo_factura); 
		$this->periodo_factura = $explode_periodo[1].$explode_periodo[0];
	}
	
	public function getTipoRec(){
		return $this->tipo_rec;
	}
	
	public function setTipoRec($tipo_rec){
		$this->tipo_rec = $tipo_rec;
	}
	
	public function getImporteEnergia(){
		return $this->importe_energia;
	}
	
	public function setImporteEnergia($importe_energia){
		$this->importe_energia = $importe_energia;
	}
	
	public function getImporteAgua(){
		return $this->importe_agua;
	}
	
	public function setImporteAgua($importe_agua){
		$this->importe_agua = $importe_agua;
	}
	
	public function getImporteTotal(){
		return $this->importe_total;
	}
	
	public function setImporteTotal($importe_total){
		$this->importe_total = $importe_total;
	}
	
	public function getEstadoFactura(){
		return $this->estado_factura;
	}
	
	public function setEstadoFactura($estado_factura){
		$this->estado_factura = $estado_factura;
	}
	
	public function getFechaPago(){
		return $this->fecha_pago;
	}
	
	public function setFechaPago($fecha_pago){
		$this->fecha_pago = $fecha_pago;
	}
	
	public function getConsumo() {
		return $this->consumo;
	}

	public function setConsumo($consumo) {
		$this->consumo = $consumo;
	}

	public function getTarifa() {
		return $this->tarifa;
	}

	public function setTarifa($tarifa) {
		$this->tarifa = $tarifa;
	}
	
}
?>