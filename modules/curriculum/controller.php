<?php
require_once "modules/curriculum/model.php";
require_once "modules/curriculum/view.php";
require_once "core/helpers/appfiles.php";


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
    	require_once "tools/excelreport.php";
		$fecha_desde = filter_input(INPUT_POST, "fecha_desde");
		$fecha_hasta = filter_input(INPUT_POST, "fecha_hasta");
		$select = "CONCAT(cv.apellido, ' ', cv.nombre) AS DENOMINACION, cv.estudio AS ESTUDIO, cv.titulo AS TITULO, cv.estadocivil AS ESTADOCIVIL, cv.localidad AS LOCALIDAD, cv.direccion AS DIRECCION, cv.correo AS CORREO, cv.telefono AS TELEFONO, cv.mensaje AS MENSAJE, ai.denominacion AS AREA_INTERES, pr.denominacion AS PROVINCIA, cv.fecha_carga AS FECHA, date_format('{$fecha_desde}', '%y') as ANO, (SELECT count(cva.curriculum_id) FROM curriculum cva WHERE cva.fecha_carga BETWEEN '2019-01-01' AND '{$fecha_hasta}') AS CONTADOR";
		$from = "curriculum cv INNER JOIN areainteres ai ON cv.areainteres = ai.areainteres_id INNER JOIN provincia pr ON cv.provincia = pr.provincia_id";
		$where = "cv.fecha_carga BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}' ORDER BY cv.fecha_carga DESC";
		$curriculum_collection = CollectorCondition()->get('Curriculum', $where, 4, $from, $select);

		$titulo = "Exportador CV";
		$array_encabezados = array("ID", "EDAD", "ESTUDIO", "TITULO", "ESTADOCIVIL", "LOCALIDAD", "DIRECCION", "CORREO", "TELEFONO", "MENSAJE",
									"AREA_INTERES", "PROVINCIA", "FECHA CARGA");
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
		$contador = 0;
		foreach ($curriculum_collection as $clave=>$valor) {
			if ($clave == 0) $contador = $valor["CONTADOR"];
			$array_temp = array(
				  $contador
				, $valor["DENOMINACION"]
				, $valor["ESTUDIO"]
				, $valor["TITULO"]
				, $valor["ESTADOCIVIL"]
				, $valor["LOCALIDAD"]
				, $valor["DIRECCION"]
				, $valor["CORREO"]
				, $valor["TELEFONO"]
				, $valor["MENSAJE"]
				, $valor["AREA_INTERES"]
        		, $valor["PROVINCIA"]
				, $valor["FECHA"]);
			$array_exportacion[] = $array_temp;
			$contador = $contador - 1;
		}
		 
		ExcelReport()->extraer_informe_conjunto($titulo,$array_exportacion);
	}
}
?>