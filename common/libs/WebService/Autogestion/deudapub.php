<?php
require_once dirname(__FILE__)."/suministro.php";

Class wsDeudaPublica extends wsDeuda {

	public $col_status;
	public $cod_barra;
	public $cod_barra_img;
	public $referencia;
	public $referencia_pago;
	public $pot_contratada;


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
		$this->col_status = "";
		$this->cod_barra = "";
		$this->cod_barra_img = "";
		$this->referencia = "";
		$this->referencia_pago = "";
		$this->pot_contratada = 0;
	}

public static function CastStd($class){
		$deuda = new wsDeudaPublica();
		$deuda->setId($class->id);
		$deuda->setIdCliente($class->id_cliente);
		$deuda->setIdFactura($class->id_factura);
		$deuda->setSuministro(wsSuministro::CastStd($class->suministroOj));
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
		$deuda->setCol_status($class->col_status);
		$deuda->setCod_barra($class->cod_barra);
		$deuda->setCod_barra_img($class->cod_barra_img);
		$deuda->setReferencia($class->referencia);
		$deuda->setReferencia_pago($class->referencia_pago);
		$deuda->setPot_contratada($class->pot_contratada);
		return $deuda;
	}

	public function getCol_status() {
		return $this->col_status;
	}

	public function setCol_status($col_status) {
		$this->col_status = $col_status;
	}

	public function getCod_barra() {
		return $this->cod_barra;
	}

	public function setCod_barra($cod_barra) {
		$this->cod_barra = $cod_barra;
	}

	public function getCod_barra_img() {
		return $this->cod_barra_img;
	}

	public function setCod_barra_img($cod_barra_img) {
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

	public function getPot_contratada() {
		return $this->pot_contratada;
	}

	public function setPot_contratada($pot_contratada) {
		$this->pot_contratada = $pot_contratada;
	}

}
?>