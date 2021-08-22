<?php


class BannerView extends View {
	
	function panel($banner_collection) {
		$gui = file_get_contents("static/modules/banner/panel.html");
		$gui_tbl_banner = file_get_contents("static/modules/banner/tbl_banner.html");
		$gui_tbl_banner = $this->render_regex('TBL_BANNER', $gui_tbl_banner, $banner_collection);
		$render = str_replace('{tbl_banner}', $gui_tbl_banner, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($obj_banner) {
		$gui = file_get_contents("static/modules/banner/editar.html");
		$gui_tbl_banner = file_get_contents("static/modules/banner/tbl_banner.html");
		$gui_tbl_banner = $this->render_regex('TBL_BANNER', $gui_tbl_banner, $banner_collection);
		$obj_banner = $this->set_dict($obj_banner);
		$render = str_replace('{tbl_banner}', $gui_tbl_banner, $gui);
		$render = $this->render($obj_banner, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}
}
?>