<?php
require_once "modules/mantenimientoinstitucion/model.php";
require_once "modules/mantenimientoinstitucion/view.php";


class MantenimientoInstitucionController {

	function __construct() {
		$this->model = new MantenimientoInstitucion();
		$this->view = new MantenimientoInstitucionView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$mantenimientoinstitucion_collection = Collector()->get('MantenimientoInstitucion');
		$this->view->panel($mantenimientoinstitucion_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
		$this->model->save();
		header("Location: " . URL_APP . "/mantenimientoinstitucion/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$this->model->mantenimientoinstitucion_id = $arg;
		$this->model->get();
		$mantenimientoinstitucion_collection = Collector()->get('MantenimientoInstitucion');
		$this->view->editar($mantenimientoinstitucion_collection, $this->model);
	}

	function eliminar($arg) {
		SessionHandler()->check_session();
		$this->model->mantenimientoinstitucion_id = $arg;
		$this->model->delete();
		header("Location: " . URL_APP . "/mantenimientoinstitucion/panel");		
	}
}
?>