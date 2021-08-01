<?php


class MantenimientoCategoriaView extends View {

	function panel($mantenimientocategoria_collection) {
		$gui = file_get_contents("static/modules/mantenimientocategoria/panel.html");
		$gui_tbl_mantenimientocategoria = file_get_contents("static/modules/mantenimientocategoria/tbl_mantenimientocategoria.html");
		$gui_tbl_mantenimientocategoria = $this->render_regex('TBL_MANTENIMIENTOCATEGORIA', $gui_tbl_mantenimientocategoria, $mantenimientocategoria_collection);
		$render = str_replace('{tbl_mantenimientocategoria}', $gui_tbl_mantenimientocategoria, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($mantenimientocategoria_collection, $obj_mantenimientocategoria) {
		$gui = file_get_contents("static/modules/mantenimientocategoria/editar.html");
		$gui_tbl_mantenimientocategoria = file_get_contents("static/modules/mantenimientocategoria/tbl_mantenimientocategoria.html");
		$gui_tbl_mantenimientocategoria = $this->render_regex('TBL_MANTENIMIENTOCATEGORIA', $gui_tbl_mantenimientocategoria, $mantenimientocategoria_collection);
		$obj_mantenimientocategoria = $this->set_dict($obj_mantenimientocategoria);
		$render = str_replace('{tbl_mantenimientocategoria}', $gui_tbl_mantenimientocategoria, $gui);
		$render = $this->render($obj_mantenimientocategoria, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>