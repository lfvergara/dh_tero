<?php
require_once "modules/gestioncomercial/model.php";
require_once "modules/gestioncomercial/view.php";


class GestionComercialController {

	function __construct() {
		$this->model = new GestionComercial();
		$this->view = new GestionComercialView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$mes = date('Y-m');
    	$fecha_sys = date('Y-m-d');
    	$select = "tgc.tipogestioncomercial_id AS TIPGESCOMID, tgc.denominacion AS GESTION, COUNT(gc.tipogestioncomercial) AS CANT";
    	$from = "gestioncomercial gc INNER JOIN tipogestioncomercial tgc ON gc.tipogestioncomercial = tgc.tipogestioncomercial_id";
    	//$where = "gc.fecha BETWEEN '{$mes}-01' AND '{$fecha_sys}'";
    	$where = "gc.fecha BETWEEN '2021-01-01' AND '{$fecha_sys}'";
    	
    	$group_by = "gc.tipogestioncomercial";
    	$cantidad_gestioncomercial = CollectorCondition('GestionComercial', $where, 4, $from, $select, $group_by);
		print_r($cantidad_gestioncomercial);exit;
		$this->view->panel($gestioncomercial_collection);
	}

	function agregar() {
		SessionHandler()->check_session();
		$gestioncomercial_collection = Collector()->get('GestionComercial');
		$this->view->agregar($gestioncomercial_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$this->model->gestioncomercial_id = $arg;
		$this->model->get();
		$gestioncomercial_collection = Collector()->get('GestionComercial');
		$this->view->editar($gestioncomercial_collection, $this->model);
	}

	function consultar($arg) {
		SessionHandler()->check_session();
		$this->model->gestioncomercial_id = $arg;
		$this->model->get();
		$this->view->editar($this->model);
	}

	function guardar() {
		SessionHandler()->check_session();
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->nomenclatura = filter_input(INPUT_POST, 'nomenclatura');
		$this->model->online = 0;
		$this->model->requisito = '';
		$this->model->save();
		header("Location: " . URL_APP . "/gestioncomercial/panel");
	}

	function actualizar() {
		SessionHandler()->check_session();
		$this->model->gestioncomercial_id = filter_input(INPUT_POST, 'gestioncomercial_id');
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->nomenclatura = filter_input(INPUT_POST, 'nomenclatura');
		$this->model->online = filter_input(INPUT_POST, 'online');
		$this->model->requisito = filter_input(INPUT_POST, 'descr');
		$this->model->save();
		header("Location: " . URL_APP . "/gestioncomercial/panel");
	}
}
?>