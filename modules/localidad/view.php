<?php


class LocalidadView extends View {
	
	function panel($localidad_collection, $provincia_collection) {
		$gui = file_get_contents("static/modules/localidad/panel.html");
		$gui_slt_provincia = file_get_contents("static/common/slt_provincia.html");
		$gui_slt_provincia = $this->render_regex('SLT_PROVINCIA', $gui_slt_provincia, $provincia_collection);
		
		$render = $this->render_regex('TBL_LOCALIDAD', $gui, $localidad_collection);
		$render = str_replace('{slt_provincia}', $gui_slt_provincia, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($localidad_collection, $provincia_collection, $obj_localidad) {
		$gui = file_get_contents("static/modules/localidad/editar.html");
		$gui_slt_provincia = file_get_contents("static/common/slt_provincia.html");
		$gui_slt_provincia = $this->render_regex('SLT_PROVINCIA', $gui_slt_provincia, $provincia_collection);
		
		$obj_localidad = $this->set_dict($obj_localidad);
		$render = $this->render_regex('TBL_LOCALIDAD', $gui, $localidad_collection);
		$render = str_replace('{slt_provincia}', $gui_slt_provincia, $render);
		$render = $this->render($obj_localidad, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>