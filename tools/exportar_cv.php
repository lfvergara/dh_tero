<?php


class ExportarReporte {
	function reporte_cv($query, $array_data) {
		$query = str_replace(array_keys($array_data), array_values($array_data), $query);
		$rst = execute_query($query);

		$titulo = "Exportador CV";
		$array_encabezados = array("ID", "EDAD", "ESTUDIO", "TITULO", "ESTADOCIVIL", "LOCALIDAD", "DIRECCION", "CORREO", "TELEFONO", "MENSAJE",
									"AREA_INTERES", "PROVINCIA", "FECHA CARGA");
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
		$contador = 0;
		foreach ($rst as $clave=>$valor) {
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
		 
		ExcelReport()->extraer_informe($titulo,$array_exportacion);
	}
}
function ExportarReporte() { return new ExportarReporte(); }
?>