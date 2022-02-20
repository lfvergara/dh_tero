<?php
require_once "modules/tramite/model.php";
require_once "modules/tramite/view.php";


class TramiteController {

	function __construct() {
		$this->model = new Tramite();
		$this->view = new TramiteView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$tramite_collection = Collector()->get('Tramite');
		$this->view->panel($tramite_collection);
	}

	function agregar() {
		SessionHandler()->check_session();
		$tramite_collection = Collector()->get('Tramite');
		$this->view->agregar($tramite_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$this->model->tramite_id = $arg;
		$this->model->get();
		$tramite_collection = Collector()->get('Tramite');
		$this->view->editar($tramite_collection, $this->model);
	}

	function consultar($arg) {
		SessionHandler()->check_session();
		$this->model->tramite_id = $arg;
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
		header("Location: " . URL_APP . "/tramite/panel");
	}

	function actualizar() {
		SessionHandler()->check_session();
		$this->model->tramite_id = filter_input(INPUT_POST, 'tramite_id');
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->nomenclatura = filter_input(INPUT_POST, 'nomenclatura');
		$this->model->online = filter_input(INPUT_POST, 'online');
		$this->model->requisito = filter_input(INPUT_POST, 'descr');
		$this->model->save();
		header("Location: " . URL_APP . "/tramite/panel");
	}
}
?>