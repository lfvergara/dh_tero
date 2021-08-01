<?php
require_once "modules/localidad/model.php";
require_once "modules/localidad/view.php";
require_once "modules/provincia/model.php";


class LocalidadController {

	function __construct() {
		$this->model = new Localidad();
		$this->view = new LocalidadView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$localidad_collection = Collector()->get('Localidad');
		$provincia_collection = Collector()->get('Provincia');
		$this->view->panel($localidad_collection, $provincia_collection);
	}

	function guardar() {
		SessionHandler()->check_session();	
		$provincia_id = filter_input(INPUT_POST, 'provincia');
		foreach ($_POST as $clave=>$valor) $this->model->$clave = $valor;
		$this->model->interior = ($provincia_id == 11) ? 1 : 0;
		$this->model->save();
		header("Location: " . URL_APP . "/localidad/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();		
		$this->model->localidad_id = $arg;
		$this->model->get();
		$localidad_collection = Collector()->get('Localidad');
		$provincia_collection = Collector()->get('Provincia');
		$this->view->editar($localidad_collection, $provincia_collection, $this->model);
	}
}
?>