<?php
require_once "modules/curriculum/model.php";
require_once "modules/curriculum/view.php";


class CurriculumController {

	function __construct() {
		$this->model = new Curriculum();
		$this->view = new CurriculumView();
	}

	function panel() {
    	SessionHandler()->check_session();
		$curriculum_collection = Collector()->get('Curriculum');
		$this->view->panel($curriculum_collection);
	}
}
?>