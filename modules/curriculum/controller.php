<?php
require_once "modules/curriculum/model.php";
require_once "modules/curriculum/view.php";


class CurriculumController {

	function __construct() {
		$this->model = new Curriculum();
		$this->view = new CurriculumView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$curriculum_collection = Collector()->get('Curriculum');
		$this->view->panel($curriculum_collection);
	}

	function exportar_cv() {
    	SessionHandler()->check_session();
		require_once 'tools/exportar_cv.php';
    	$fecha_desde = $_POST["fecha_desde"];
		$fecha_hasta = $_POST["fecha_hasta"];
		$query = file_get_contents("sql/exportar_cv.sql");
		$array_data = array("{fecha_desde}"=>$fecha_desde, "{fecha_hasta}"=>$fecha_hasta);
		ExportarReporte()->reporte_cv($query, $array_data);
	}
}
?>