<?php
require_once dirname(__FILE__)."/suministro.php";

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
	public $fecha_factura_puestacobro;
	public $periodo_factura;
	public $tipo_rec;
	public $importe_energia;
	public $importe_agua;
	public $importe_total;
	public $col_status;
	public $estado_factura;
	public $fecha_pago;
	public $cod_barra;
	public $cod_barra_img;
	public $referencia;
	public $referencia_pago;
	public $consumo;
	public $pot_contratada;
	public $tarifa;
	
	public function __construct(){
		$this->id = 0;
		$this->id_cliente = 0;
		$this->id_factura = 0;
		$this->suministro = new wsSuministro();
		$this->fecha_factura = "";
		$this->fecha_factura_vencimiento = "";
		$this->fecha_factura_segundo_vencimiento = "";
		$this->fecha_factura_proximo_vencimiento = "";
		$this->fecha_factura_emision = "";
		$this->fecha_factura_puestacobro = "";
		$this->periodo_factura = "";
		$this->tipo_rec = "";
		$this->importe_energia = 0.0;
		$this->importe_agua = 0.0;
		$this->importe_total = 0.0;
		$this->col_status = "";
		$this->estado_factura = "";
		$this->fecha_pago = "";
		$this->cod_barra = "";
		$this->cod_barra_img = "";
		$this->referencia = "";
		$this->referencia_pago = "";
		$this->consumo = 0;
		$this->pot_contratada = 0;
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
		$deuda->setSuministro(wsSuministro::CastStd($class->suministro));
		$deuda->setFechaFactura($class->fecha_factura);
		$deuda->setFechaFacturaVenc($class->fecha_factura_vencimiento);
		$deuda->setFechaFacturaVenc2($class->fecha_factura_segundo_vencimiento);
		$deuda->setFechaFacturaProximo($class->fecha_factura_proximo_vencimiento);
		$deuda->setFechaFacturaEmision($class->fecha_factura_emision);
		$deuda->setFechaFacturaPuestaCobro($class->fecha_factura_puestacobro);
		$deuda->setPeriodo($class->periodo_factura);
		$deuda->setTipoRec($class->tipo_rec);
		$deuda->setImporteEnergia($class->importe_energia);
		$deuda->setImporteAgua($class->importe_agua);
		$deuda->setImporteTotal($class->importe_total);
		$deuda->setColEstado($class->col_status);
		$deuda->setEstadoFactura($class->estado_factura);
		$deuda->setCod_barra($class->cod_barra);
		$deuda->setCod_barra_img($class->cod_barra_img);
		$deuda->setReferencia($class->referencia);
		$deuda->setReferencia_pago($class->referencia_pago);
		$deuda->setConsumo($class->consumo);
		$deuda->setPot_contratada($class->pot_contratada);
		$deuda->setTarifa($class->tarifa);
		return $deuda;
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
	
	public function getFechaFacturaProximo(){
		return $this->fecha_factura_proximo_vencimiento;
	}
	
	public function setFechaFacturaProximo($fecha_factura_proximo_vencimiento){
		$this->fecha_factura_proximo_vencimiento = $fecha_factura_proximo_vencimiento;
	}
	
	public function getFechaFacturaEmision(){
		return $this->fecha_factura_emision;
	}
	
	public function setFechaFacturaEmision($fecha_factura_emision){
		$this->fecha_factura_emision = $fecha_factura_emision;
	}
	
	public function getFechaFacturaPuestaCobro(){
		return $this->fecha_factura_emision;
	}
	
	public function setFechaFacturaPuestaCobro($fecha_factura_puestacobro){
		$this->fecha_factura_puestacobro = $fecha_factura_puestacobro;
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
	
	public function getColEstado(){
		return $this->col_status;
	}
	
	public function setColEstado($col_status){
		$this->col_status = $col_status;
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
	
	public function getCod_barra(){
		return $this->cod_barra;
	}
	
	public function setCod_barra($cod_barra){
		$this->cod_barra = $cod_barra;
	}
	
	public function getCod_barra_img(){
		return $this->cod_barra_img;
	}
	
	public function setCod_barra_img($cod_barra_img){
		$this->cod_barra_img = $cod_barra_img;
	}
	
	public function getReferencia() {
		return $this->referencia;
	}

	public function setReferencia($referencia) {
		$this->referencia = $referencia;
	}

	public function getReferencia_pago() {
		return $this->referencia_pago;
	}

	public function setReferencia_pago($referencia_pago) {
		$this->referencia_pago = $referencia_pago;
	}
	
	public function getConsumo() {
		return $this->consumo;
	}

	public function setConsumo($consumo) {
		$this->consumo = $consumo;
	}

	public function getPot_contratada() {
		return $this->pot_contratada;
	}

	public function setPot_contratada($pot_contratada) {
		$this->pot_contratada = $pot_contratada;
	}

	public function getTarifa() {
		return $this->tarifa;
	}

	public function setTarifa($tarifa) {
		$this->tarifa = $tarifa;
	}
	
}
?>