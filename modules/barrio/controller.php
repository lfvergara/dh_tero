<?php
require_once "modules/barrio/model.php";
require_once "modules/barrio/view.php";
require_once "modules/departamento/model.php";
require_once "modules/coordenada/model.php";


class BarrioController {

	function __construct() {
		$this->model = new Barrio();
		$this->view = new BarrioView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$select = "b.barrio_id AS BARID, b.denominacion AS DENOMINACION, d.denominacion AS DEPARTAMENTO, u.denominacion AS UNICOM";
    	$from = "barrio b INNER JOIN departamento d ON b.departamento = d.departamento_id INNER JOIN unicom u ON d.unicom = u.unicom_id";
		$barrio_collection = CollectorCondition()->get('Barrio', NULL, 4, $from, $select);
		$this->view->panel($barrio_collection);
	}

	function agregar() {
		SessionHandler()->check_session();
		$departamento_collection = Collector()->get('Departamento');
		$this->view->agregar($departamento_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();		
		$barrio_id = $arg;
		$this->model->barrio_id = $barrio_id;
		$this->model->get();
		$departamento_collection = Collector()->get('Departamento');
		$this->view->editar($departamento_collection, $this->model);
	}

	function consultar_barrios() {
		SessionHandler()->check_session();
 		$barrio_collection = Collector()->get('Barrio');
		$this->view->consultar_barrios($barrio_collection);
	}

	function guardar() {
		SessionHandler()->check_session();
		$denominacion = filter_input(INPUT_POST, 'denominacion');
		$departamento = filter_input(INPUT_POST, 'departamento');
		$latitudcenter = filter_input(INPUT_POST, 'latitudcenter');
		$longitudcenter = filter_input(INPUT_POST, 'longitudcenter');
		$zoomcenter = filter_input(INPUT_POST, 'zoomcenter');
		$this->model->denominacion = $denominacion;
		$this->model->latitud = $latitudcenter;
		$this->model->longitud = $longitudcenter;
		$this->model->zoom = $zoomcenter;
		$this->model->departamento = $departamento;
		$this->model->save();
		$barrio_id = $this->model->barrio_id;

		$this->model->barrio_id = $barrio_id;
		$this->model->get();

		$poligonos = json_decode($_POST['array']);
		foreach ($poligonos as $key => $value) {
		  	$coordenadas = $value->coordenadas;
			foreach ($coordenadas as $keys => $values) {
				$cm = new Coordenada();
				$cm->latitud = $values->lat;
				$cm->longitud = $values->lng;
				$cm->altitud = 0;
				$cm->etiqueta = $value->nombre;
				$cm->fillcolor = $value->fillColor;
				$cm->strokecolor = $value->fillColor;
				$cm->indice = $keys;
				$cm->save();
				$coordenada_id = $cm->coordenada_id;

				$cm = new Coordenada();
				$cm->coordenada_id = $coordenada_id;
				$cm->get();

				$this->model->add_coordenada($cm);
				$cbm = new CoordenadaBarrio($this->model);
				$cbm->save();
			}
		}

		header("Location: " . URL_APP . "/barrio/editar/{$barrio_id}");
	}

	function actualizar() {
		SessionHandler()->check_session();			
		$barrio_id = filter_input(INPUT_POST, 'barrio_id');
		$denominacion = filter_input(INPUT_POST, 'denominacion');
		$departamento = filter_input(INPUT_POST, 'departamento');
		$etiqueta = filter_input(INPUT_POST, 'etiqueta');

		$this->model->barrio_id = $barrio_id;
		$this->model->get();
		$coordenada_collection = $this->model->coordenada_collection;

		$this->model->denominacion = $denominacion;
		$this->model->departamento = $departamento;
		$this->model->save();

		foreach ($coordenada_collection as $key => $value) {
			$cm = new Coordenada();
			$cm->coordenada_id = $value->coordenada_id;
			$cm->get();
			$cm->etiqueta = $etiqueta;
			$cm->save();
		}
		
		header("Location: " . URL_APP . "/barrio/editar/{$barrio_id}");
	}

	function actualizar_coordenadas() {
		SessionHandler()->check_session();

		$barrio_id = filter_input(INPUT_POST, 'barrio_id');
		$fillcolor = filter_input(INPUT_POST, 'fillColor');
		$latitudcenter = filter_input(INPUT_POST, 'latitudcenter');
		$longitudcenter = filter_input(INPUT_POST, 'longitudcenter');
		$zoomcenter = filter_input(INPUT_POST, 'zoomcenter');
		$coordenadas = json_decode($_POST['array']);

		$this->model->barrio_id = $barrio_id;
		$this->model->get();

		$this->model->latitud = $latitudcenter;
		$this->model->longitud = $longitudcenter;
		$this->model->zoom = $zoomcenter;
		$this->model->save();
		
		$this->model->barrio_id = $barrio_id;
		$this->model->get();

		$coordenada_collection = $this->model->coordenada_collection;
		$altitud = $coordenada_collection[0]->altitud;
		$etiqueta = $coordenada_collection[0]->etiqueta;
		
		if (!empty($coordenadas)) {
			foreach ($coordenada_collection as $clave=>$valor) {
				$cm = new Coordenada();
				$cm->coordenada_id = $valor->coordenada_id;
				$cm->delete();
			}

			$this->model->coordenada_collection = Array();
			foreach ($coordenadas as $clave=>$valor) {
				$cm = new Coordenada();
				$cm->latitud = $valor->lat;
				$cm->longitud = $valor->lng;
				$cm->altitud = $altitud;
				$cm->etiqueta = $etiqueta;
				$cm->fillcolor = $fillcolor;
				$cm->strokecolor = $fillcolor;
				$cm->indice = $clave;
				$cm->save();
				$coordenada_id = $cm->coordenada_id;

				$cm = new Coordenada();
				$cm->coordenada_id = $coordenada_id;
				$cm->get();

				$this->model->add_coordenada($cm);
			}
			
			$cbm = new CoordenadaBarrio($this->model);
			$cbm->save();
		}
		
		header("Location: " . URL_APP . "/barrio/editar/{$barrio_id}");
	}

	function eliminar($arg) {
		SessionHandler()->check_session();
		$barrio_id = $arg;

		$this->model->barrio_id = $barrio_id;
		$this->model->get();
		$coordenada_collection = $this->model->coordenada_collection;
		
		foreach ($coordenada_collection as $clave=>$valor) {
			$coordenada_id = $valor->coordenada_id;
			$cm = new Coordenada();
			$cm->coordenada_id = $coordenada_id;
			$cm->delete();
		}

		$this->model->delete();
		header("Location: " . URL_APP . "/barrio/panel");		
	}
}
?>