<?php


class AgendaView extends View {
	
	function panel($agenda_collection) {
		$gui = file_get_contents("static/modules/agenda/panel.html");
		$gui_tbl_agenda = file_get_contents("static/modules/agenda/tbl_agenda.html");
		$gui_tbl_agenda = $this->render_regex_dict('TBL_AGENDA', $gui_tbl_agenda, $agenda_collection);
		$render = str_replace('{tbl_agenda}', $gui_tbl_agenda, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($destinatario_collection, $obj_agenda) {
		$gui = file_get_contents("static/modules/agenda/editar.html");
		$gui_tbl_destinatario = file_get_contents("static/modules/agenda/tbl_destinatario.html");
		$gui_tbl_destinatarioagenda = file_get_contents("static/modules/agenda/tbl_destinatarioagenda.html");

		$destinatarioagenda_collection = $obj_agenda->destinatario_collection;
		unset($obj_agenda->destinatario_collection);

		$gui_tbl_destinatario = $this->render_regex('TBL_DESTINATARIO', $gui_tbl_destinatario, $destinatario_collection);
		$gui_tbl_destinatarioagenda = $this->render_regex('TBL_DESTINATARIO', $gui_tbl_destinatarioagenda, $destinatarioagenda_collection);

		$obj_agenda = $this->set_dict($obj_agenda);
		$render = str_replace('{tbl_destinatario}', $gui_tbl_destinatario, $gui);
		$render = str_replace('{tbl_destinatarioagenda}', $gui_tbl_destinatarioagenda, $render);
		$render = $this->render($obj_agenda, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>