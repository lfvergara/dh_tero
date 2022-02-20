<?php


class TramiteView extends View {

	function panel($tramite_collection) {
		$gui = file_get_contents("static/modules/tramite/panel.html");
		$gui_tbl_tramite = file_get_contents("static/modules/tramite/tbl_tramite.html");
		$gui_tbl_tramite = $this->render_regex('TBL_TRAMITE', $gui_tbl_tramite, $tramite_collection);
		$render = str_replace('{tbl_tramite}', $gui_tbl_tramite, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($tramite_collection, $obj_tramite) {
		$gui = file_get_contents("static/modules/tramite/editar.html");
		$gui_tbl_tramite = file_get_contents("static/modules/tramite/tbl_tramite.html");
		$gui_tbl_tramite = $this->render_regex('TBL_TRAMITE', $gui_tbl_tramite, $tramite_collection);

		$obj_tramite->checked_si = ($obj_tramite->online == 0) ? '' : 'checked';
		$obj_tramite->checked_no = ($obj_tramite->online == 0) ? 'checked' : '';

		$obj_tramite = $this->set_dict($obj_tramite);
		$render = str_replace('{tbl_tramite}', $gui_tbl_tramite, $gui);
		$render = $this->render($obj_tramite, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>