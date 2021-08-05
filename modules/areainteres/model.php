<?php


class AreaInteres extends StandardObject {
	
	function __construct() {
		$this->areainteres_id = 0;
		$this->denominacion = '';
	}

	function actualizar1() {
		$sql = "update areainteres set denominacion = 'Administración' where areainteres_id = 1";
		execute_query($sql);
	}
}
?>