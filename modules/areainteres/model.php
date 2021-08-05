<?php


class AreaInteres extends StandardObject {
	
	function __construct() {
		$this->areainteres_id = 0;
		$this->denominacion = '';
	}

	function actualizar1() {
		$sql = "update areainteres set denominacion = 'Atención al Cliente' where areainteres_id = 2";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Compra y Abastecimiento de Energía' where areainteres_id = 4";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Facturación' where areainteres_id = 6";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Logística' where areainteres_id = 8";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Expedición' where areainteres_id = 9";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Proyectos/Ingeniería' where areainteres_id = 11";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Recepción' where areainteres_id = 13";
		execute_query($sql);

		$sql = "update areainteres set denominacion = 'Facturación' where areainteres_id = 6";
		execute_query($sql);

		$sql = "delete from areainteres where areainteres_id = 17";
		execute_query($sql);
	}
}
?>