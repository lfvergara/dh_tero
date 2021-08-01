<?php


class MantenimientoInstitucionView extends View {

	function panel($mantenimientoinstitucion_collection) {
		$gui = file_get_contents("static/modules/mantenimientoinstitucion/panel.html");
		$gui_tbl_mantenimientoinstitucion = file_get_contents("static/modules/mantenimientoinstitucion/tbl_mantenimientoinstitucion.html");
		$gui_tbl_mantenimientoinstitucion = $this->render_regex('TBL_MANTENIMIENTOINSTITUCION', $gui_tbl_mantenimientoinstitucion, $mantenimientoinstitucion_collection);
		$render = str_replace('{tbl_mantenimientoinstitucion}', $gui_tbl_mantenimientoinstitucion, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($mantenimientoinstitucion_collection, $obj_mantenimientoinstitucion) {
		$gui = file_get_contents("static/modules/mantenimientoinstitucion/editar.html");
		$gui_tbl_mantenimientoinstitucion = file_get_contents("static/modules/mantenimientoinstitucion/tbl_mantenimientoinstitucion.html");
		$gui_tbl_mantenimientoinstitucion = $this->render_regex('TBL_MANTENIMIENTOINSTITUCION', $gui_tbl_mantenimientoinstitucion, $mantenimientoinstitucion_collection);
		$obj_mantenimientoinstitucion = $this->set_dict($obj_mantenimientoinstitucion);
		$render = str_replace('{tbl_mantenimientoinstitucion}', $gui_tbl_mantenimientoinstitucion, $gui);
		$render = $this->render($obj_mantenimientoinstitucion, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>