<?php
require_once "modules/destinatario/model.php";
require_once "modules/destinatario/view.php";


class DestinatarioController {

	function __construct() {
		$this->model = new Destinatario();
		$this->view = new DestinatarioView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$destinatario_collection = Collector()->get('Destinatario');
		$this->view->panel($destinatario_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		foreach ($_POST as $key=>$value) $this->model->$key = $value;
		$this->model->save();
		header("Location: " . URL_APP . "/destinatario/panel");
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$this->model->destinatario_id = $arg;
		$this->model->get();
		$destinatario_collection = Collector()->get('Destinatario');
		$this->view->editar($destinatario_collection, $this->model);
	}

	function eliminar($arg) {
		SessionHandler()->check_session();
		$this->model->destinatario_id = $arg;
		$this->model->delete();
		header("Location: " . URL_APP . "/destinatario/panel");		
	}
}
?>