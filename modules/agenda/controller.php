<?php
require_once "modules/agenda/model.php";
require_once "modules/agenda/view.php";
require_once "modules/destinatario/model.php";


class AgendaController {

	function __construct() {
		$this->model = new Agenda();
		$this->view = new AgendaView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$select = "a.agenda_id AS AGEID, a.denominacion AS AGENDA, COUNT(da.compuesto) AS CANTDEST";
    	$from = "agenda a LEFT JOIN destinatarioagenda da ON a.agenda_id = da.compuesto GROUP BY da.compuesto ORDER BY a.denominacion";
		$agenda_collection = CollectorCondition()->get('Agenda', NULL, 4, $from, $select);
		$this->view->panel($agenda_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();		
		$agenda_id = $arg;
		$this->model->agenda_id = $agenda_id;
		$this->model->get();
		$destinatarioagenda_collection = $this->model->destinatario_collection;
		$array_ids = array();
		foreach ($destinatarioagenda_collection as $clave=>$valor) $array_ids[] = $valor->destinatario_id;

		$destinatario_collection = Collector()->get('Destinatario');
		foreach ($destinatario_collection as $clave=>$valor) {
			if (in_array($valor->destinatario_id, $array_ids)) unset($destinatario_collection[$clave]);
		}

		$this->view->editar($destinatario_collection, $this->model);
	}

	function guardar() {
		SessionHandler()->check_session();
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->save();
		$agenda_id = $this->model->agenda_id;
		header("Location: " . URL_APP . "/agenda/editar/{$agenda_id}");
	}

	function actualizar() {
		SessionHandler()->check_session();	
		$agenda_id = filter_input(INPUT_POST, 'agenda_id');
		$this->model->agenda_id = $agenda_id;
		$this->model->get();
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->save();
		header("Location: " . URL_APP . "/agenda/editar/{$agenda_id}");
	}

	function guardar_destinatario($arg) {
		SessionHandler()->check_session();
		$ids = explode('@', $arg);
		$agenda_id = $ids[0];
		$destinatario_id = $ids[1];
		
		$dm = new Destinatario();
		$dm->destinatario_id = $destinatario_id;
		$dm->get();

		$this->model->agenda_id = $agenda_id;
		$this->model->get();
		$this->model->add_destinatario($dm);

		$dam = new DestinatarioAgenda($this->model);
		$dam->save();

		header("Location: " . URL_APP . "/agenda/editar/{$agenda_id}");
	}

	function eliminar_destinatario($arg) {
		SessionHandler()->check_session();
		$ids = explode("@", $arg);
		$agenda_id = $ids[0];
		$destinatario_id = $ids[1];
		
		$this->model->agenda_id = $agenda_id;
		$this->model->get();
		$destinatario_collection = $this->model->destinatario_collection;
		$this->model->destinatario_collection = array();
		
		foreach ($destinatario_collection as $clave=>$valor) {
			if ($valor->destinatario_id == $destinatario_id) unset($destinatario_collection[$clave]);
		}

		$this->model->destinatario_collection = $destinatario_collection;
		$dam = new DestinatarioAgenda($this->model);
		$dam->save();
		
		header("Location: " . URL_APP . "/agenda/editar/{$agenda_id}");
	}
}
?>