<?php


class DestinatarioView extends View {

	function panel($destinatario_collection) {
		$gui = file_get_contents("static/modules/destinatario/panel.html");
		$gui_tbl_destinatario = file_get_contents("static/modules/destinatario/tbl_destinatario.html");
		$gui_tbl_destinatario = $this->render_regex('TBL_DESTINATARIO', $gui_tbl_destinatario, $destinatario_collection);
		$render = str_replace('{tbl_destinatario}', $gui_tbl_destinatario, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($destinatario_collection, $obj_destinatario) {
		$gui = file_get_contents("static/modules/destinatario/editar.html");
		$gui_tbl_destinatario = file_get_contents("static/modules/destinatario/tbl_destinatario.html");
		$gui_tbl_destinatario = $this->render_regex('TBL_DESTINATARIO', $gui_tbl_destinatario, $destinatario_collection);
		$obj_destinatario = $this->set_dict($obj_destinatario);
		$render = str_replace('{tbl_destinatario}', $gui_tbl_destinatario, $gui);
		$render = $this->render($obj_destinatario, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>