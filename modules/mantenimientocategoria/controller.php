<?php
require_once "modules/mantenimientocategoria/model.php";
require_once "modules/mantenimientocategoria/view.php";


class MantenimientoCategoriaController {

	function __construct() {
		$this->model = new MantenimientoCategoria();
		$this->view = new MantenimientoCategoriaView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$mantenimientocategoria_collection = Collector()->get('MantenimientoCategoria');
		$this->view->panel($mantenimientocategoria_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
		$this->model->save();
		header("Location: " . URL_APP . "/mantenimientocategoria/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$this->model->mantenimientocategoria_id = $arg;
		$this->model->get();
		$mantenimientocategoria_collection = Collector()->get('MantenimientoCategoria');
		$this->view->editar($mantenimientocategoria_collection, $this->model);
	}

	function eliminar($arg) {
		SessionHandler()->check_session();
		$this->model->mantenimientocategoria_id = $arg;
		$this->model->delete();
		header("Location: " . URL_APP . "/mantenimientocategoria/panel");		
	}
}
?>