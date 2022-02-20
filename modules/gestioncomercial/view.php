<?php


class GestionComercialView extends View {

	function panel($cantidad_gestioncomercial) {
		$gui = file_get_contents("static/modules/gestioncomercial/panel.html");
		$gui_tbl_cantidad_gestioncomercial = file_get_contents("static/modules/gestioncomercial/tbl_cantidad_gestioncomercial.html");
		$gui_lbl_piechart_gestioncomercial = file_get_contents("static/modules/gestioncomercial/lbl_piechart_gestioncomercial.html");
		$gui_valores_piechart_gestioncomercial = file_get_contents("static/modules/gestioncomercial/valores_piechart_gestioncomercial.html");

		$gui_tbl_cantidad_gestioncomercial = $this->render_regex_dict('TBL_GESTIONCOMERCIAL', $gui_tbl_cantidad_gestioncomercial, $cantidad_gestioncomercial);
		$gui_lbl_piechart_gestioncomercial = $this->render_regex_dict('LBL_PIECHART_TRAMITE', $gui_lbl_piechart_gestioncomercial, $cantidad_gestioncomercial);
		$gui_valores_piechart_gestioncomercial = $this->render_regex_dict('VALORES_PIECHART_TRAMITE', $gui_valores_piechart_gestioncomercial, $cantidad_gestioncomercial);
		$gui_lbl_piechart_gestioncomercial = str_replace('<!--LBL_PIECHART_TRAMITE-->', '', $gui_lbl_piechart_gestioncomercial);
		$gui_valores_piechart_gestioncomercial = str_replace('<!--VALORES_PIECHART_TRAMITE-->', '', $gui_valores_piechart_gestioncomercial);

		$render = str_replace('{tbl_cantidad_gestioncomercial}', $gui_tbl_cantidad_gestioncomercial, $gui);
		$render = str_replace('{lbl_piechart_gestioncomercial}', $gui_lbl_piechart_gestioncomercial, $render);
		$render = str_replace('{valores_piechart_gestioncomercial}', $gui_valores_piechart_gestioncomercial, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($gestioncomercial_collection, $obj_gestioncomercial) {
		$gui = file_get_contents("static/modules/gestioncomercial/editar.html");
		$gui_tbl_gestioncomercial = file_get_contents("static/modules/gestioncomercial/tbl_gestioncomercial.html");
		$gui_tbl_gestioncomercial = $this->render_regex('TBL_GESTIONCOMERCIAL', $gui_tbl_gestioncomercial, $gestioncomercial_collection);

		$obj_gestioncomercial->checked_si = ($obj_gestioncomercial->online == 0) ? '' : 'checked';
		$obj_gestioncomercial->checked_no = ($obj_gestioncomercial->online == 0) ? 'checked' : '';

		$obj_gestioncomercial = $this->set_dict($obj_gestioncomercial);
		$render = str_replace('{tbl_gestioncomercial}', $gui_tbl_gestioncomercial, $gui);
		$render = $this->render($obj_gestioncomercial, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>