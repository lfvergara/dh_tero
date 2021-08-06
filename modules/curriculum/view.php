<?php


class CurriculumView extends View {
	
	function panel($curriculum_collection) {
		$gui = file_get_contents("static/modules/curriculum/panel.html");
		$gui_tbl_curriculum = file_get_contents("static/modules/curriculum/tbl_curriculum.html");
		$gui_tbl_curriculum = $this->render_regex('TBL_CURRICULUM', $gui_tbl_curriculum, $curriculum_collection);
		print_r($gui_tbl_curriculum);exit;
		$render = str_replace('{tbl_curriculum}', $gui_tbl_curriculum, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>