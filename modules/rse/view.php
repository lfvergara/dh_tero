<?php


class RSEView extends View {
	
	function panel($rse_collection) {
		$gui = file_get_contents("static/modules/rse/panel.html");
		$gui_tbl_rse = file_get_contents("static/modules/rse/tbl_rse.html");
		$gui_tbl_rse = $this->render_regex_dict('TBL_RSE', $gui_tbl_rse, $rse_collection);
		$render = str_replace('{tbl_rse}', $gui_tbl_rse, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function agregar() {
		$gui = file_get_contents("static/modules/rse/agregar.html");
		$render = $this->render_breadcrumb($gui);
		$template = $this->render_template($render);
		print $template;	
	}

	function editar($obj_rse) {
		$gui = file_get_contents("static/modules/rse/editar.html");
		$gui_tbl_archivo = file_get_contents("static/modules/rse/tbl_archivo.html");
		$gui_tbl_video = file_get_contents("static/modules/rse/tbl_video.html");

		$archivo_collection = $obj_rse->archivo_collection;
		$video_collection = $obj_rse->video_collection;
		unset($obj_rse->archivo_collection, $obj_rse->video_collection);

		$gui_tbl_archivo = $this->render_regex('TBL_ARCHIVO', $gui_tbl_archivo, $archivo_collection);
		$gui_tbl_video = $this->render_regex('TBL_VIDEO', $gui_tbl_video, $video_collection);

		$obj_rse = $this->set_dict($obj_rse);
		$render = str_replace('{tbl_archivo}', $gui_tbl_archivo, $gui);
		$render = str_replace('{tbl_video}', $gui_tbl_video, $render);
		$render = $this->render($obj_rse, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}

	function consultar($obj_rse) {
		$gui = file_get_contents("static/modules/rse/consultar.html");
		$gui_lst_archivo = file_get_contents("static/modules/rse/lst_archivo.html");
		$gui_lst_video = file_get_contents("static/modules/rse/lst_video.html");

		$archivo_collection = $obj_rse->archivo_collection;
		$video_collection = $obj_rse->video_collection;
		unset($obj_rse->archivo_collection, $obj_rse->video_collection);

		if (!empty($archivo_collection)) {
			$gui_lst_archivo = $this->render_regex('LST_ARCHIVO', $gui_lst_archivo, $archivo_collection);
		} else {
			$gui_lst_archivo = "<h2>El artículo no posee archivos cargados!</h2>";
		}

		if (!empty($video_collection)) {
			$gui_lst_video = $this->render_regex('LST_VIDEO', $gui_lst_video, $video_collection);
		} else {
			$gui_lst_video = "<h2>El artículo no posee videos cargados!</h2>";
		}

		$obj_rse = $this->set_dict($obj_rse);
		$render = str_replace('{lst_archivo}', $gui_lst_archivo, $gui);
		$render = str_replace('{lst_video}', $gui_lst_video, $render);
		$render = $this->render($obj_rse, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>