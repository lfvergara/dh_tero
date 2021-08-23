<?php


class CuadroTarifarioView extends View {
	
	function panel($cuadrotarifario_collection) {
		$gui = file_get_contents("static/modules/cuadrotarifario/panel.html");
		$gui_tbl_cuadrotarifario = file_get_contents("static/modules/cuadrotarifario/tbl_cuadrotarifario.html");
		$gui_tbl_cuadrotarifario = $this->render_regex('TBL_CUADROTARIFARIO', $gui_tbl_cuadrotarifario, $cuadrotarifario_collection);
		$render = str_replace('{tbl_cuadrotarifario}', $gui_tbl_cuadrotarifario, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($cuadrotarifario_collection, $obj_cuadrotarifario) {
		$gui = file_get_contents("static/modules/cuadrotarifario/editar.html");
		$gui_tbl_cuadrotarifario = file_get_contents("static/modules/cuadrotarifario/tbl_cuadrotarifario.html");
		$gui_tbl_cuadrotarifario = $this->render_regex('TBL_CUADROTARIFARIO', $gui_tbl_cuadrotarifario, $cuadrotarifario_collection);
		$obj_cuadrotarifario = $this->set_dict($obj_cuadrotarifario);
		$render = str_replace('{tbl_cuadrotarifario}', $gui_tbl_cuadrotarifario, $gui);
		$render = $this->render($obj_cuadrotarifario, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>