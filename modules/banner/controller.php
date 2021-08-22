<?php
require_once "modules/banner/model.php";
require_once "modules/banner/view.php";


class BannerController {

	function __construct() {
		$this->model = new Banner();
		$this->view = new BannerView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$banner_collection = Collector()->get('Banner');
    	foreach ($banner_collection as $clave=>$valor) {
    		$banner_collection[$clave]->estado_icon = ($valor->activo == 0) ? 'close' : 'check';
    		$banner_collection[$clave]->estado_class = ($valor->activo == 0) ? 'danger' : 'success';
    		$banner_collection[$clave]->estado_title = ($valor->activo == 0) ? 'Inactivo' : 'Activo';
    		$banner_collection[$clave]->btn_estado_title = ($valor->activo == 0) ? '¿Activar?' : '¿Desactivar?';
    		$banner_collection[$clave]->btn_estado_icon = ($valor->activo == 0) ? 'arrow-up' : 'arrow-down';
    		$banner_collection[$clave]->btn_estado_class = ($valor->activo == 0) ? 'success' : 'danger';
    	}

		$this->view->panel($banner_collection);
	}

	
	function editar($arg) {
		SessionHandler()->check_session();		
		$banner_id = $arg;
		$this->model->banner_id = $banner_id;
		$this->model->get();
    	$banner_collection = Collector()->get('Banner');
		$this->view->editar($banner_collection, $this->model);
	}

	function consultar($arg) {
		SessionHandler()->check_session();	
		$banner_id = $arg;
		$this->model->banner_id = $banner_id;
		$this->model->get();
		$this->view->consultar($this->model);
	}

	function guardar() {
		SessionHandler()->check_session();
		
		$detalle = filter_input(INPUT_POST, 'detalle');
		$posicion = filter_input(INPUT_POST, 'posicion');

		$this->model->detalle = $detalle;
		$this->model->posicion = $posicion;
		$this->model->activo = 1;
		$this->model->save();
		$banner_id = $this->model->banner_id;

		$directorio = URL_PRIVATE . "banner/";
		$archivo = $_FILES["archivo"]["tmp_name"];
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->file($archivo);
		$formato = explode("/", $mime);

		$mimes_permitidos = array("image/png", "image/jpg", "image/jpeg");
		$name = $banner_id;
		if(in_array($mime, $mimes_permitidos)) {
			if(!file_exists($directorio)) {
				mkdir($directorio);
				chmod($directorio, 0777);
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			} else {
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			}
		}

		header("Location: " . URL_APP . "/banner/panel");
	}

	function actualizar() {
		SessionHandler()->check_session();	
		$banner_id = filter_input(INPUT_POST, 'banner_id');
		$this->model->banner_id = $banner_id;
		$this->model->get();
		$this->model->posicion = filter_input(INPUT_POST, 'posicion');
		$this->model->save();
		header("Location: " . URL_APP . "/banner/consultar/{$banner_id}");
	}

	function cambiar_estado($arg) {
		SessionHandler()->check_session();	
		$banner_id = $arg;
		$this->model->banner_id = $banner_id;
		$this->model->get();
		$activo = $this->model->activo;
		$this->model->activo = ($activo == 0) ? 1 : 0;
		$this->model->save();
		header("Location: " . URL_APP . "/banner/panel");
	}

	function guardar_archivo() {
		SessionHandler()->check_session();
		$banner_id = filter_input(INPUT_POST, "banner_id");
		$denominacion = filter_input(INPUT_POST, "denominacion");
		
		$directorio = URL_PRIVATE . "banner/";
		$archivo = $_FILES["archivo"]["tmp_name"];
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->file($archivo);
		$formato = explode("/", $mime);

		$mimes_permitidos = array("image/png", "image/jpg", "image/jpeg");
		$name = $banner_id;
		if(in_array($mime, $mimes_permitidos)) {
			if(!file_exists($directorio)) {
				mkdir($directorio);
				chmod($directorio, 0777);
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			} else {
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			}
		}

		header("Location: " . URL_APP . "/banner/consultar/{$banner_id}");
	}

	function eliminar_archivo($arg) {
		SessionHandler()->check_session();
		$banner_id = $ids[0];
		$archivo = URL_PRIVATE . "banner/{$banner_id}";
		chmod($archivo, 0777);
		unlink($archivo);

		header("Location: " . URL_APP . "/banner/editar/{$banner_id}");
	}

	function ver_archivo(){
		SessionHandler()->check_session();
		require_once "core/helpers/files.php";
	}
}
?>