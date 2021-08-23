<?php
require_once "modules/cuadrotarifario/model.php";
require_once "modules/cuadrotarifario/view.php";


class CuadroTarifarioController {

	function __construct() {
		$this->model = new CuadroTarifario();
		$this->view = new CuadroTarifarioView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$cuadrotarifario_collection = Collector()->get('CuadroTarifario');
    	foreach ($cuadrotarifario_collection as $clave=>$valor) {
    		$cuadrotarifario_collection[$clave]->estado_icon = ($valor->activo == 0) ? 'close' : 'check';
    		$cuadrotarifario_collection[$clave]->estado_class = ($valor->activo == 0) ? 'danger' : 'success';
    		$cuadrotarifario_collection[$clave]->estado_title = ($valor->activo == 0) ? 'Inactivo' : 'Activo';
    		$cuadrotarifario_collection[$clave]->btn_estado_title = ($valor->activo == 0) ? '¿Activar?' : '¿Desactivar?';
    		$cuadrotarifario_collection[$clave]->btn_estado_icon = ($valor->activo == 0) ? 'arrow-circle-o-up' : 'arrow-circle-o-down';
    		$cuadrotarifario_collection[$clave]->btn_estado_class = ($valor->activo == 0) ? 'success' : 'danger';
    	}

		$this->view->panel($cuadrotarifario_collection);
	}

	
	function editar($arg) {
		SessionHandler()->check_session();		
		$cuadrotarifario_id = $arg;
		$this->model->cuadrotarifario_id = $cuadrotarifario_id;
		$this->model->get();

    	$cuadrotarifario_collection = Collector()->get('CuadroTarifario');
    	foreach ($cuadrotarifario_collection as $clave=>$valor) {
    		$cuadrotarifario_collection[$clave]->estado_icon = ($valor->activo == 0) ? 'close' : 'check';
    		$cuadrotarifario_collection[$clave]->estado_class = ($valor->activo == 0) ? 'danger' : 'success';
    		$cuadrotarifario_collection[$clave]->estado_title = ($valor->activo == 0) ? 'Inactivo' : 'Activo';
    		$cuadrotarifario_collection[$clave]->btn_estado_title = ($valor->activo == 0) ? '¿Activar?' : '¿Desactivar?';
    		$cuadrotarifario_collection[$clave]->btn_estado_icon = ($valor->activo == 0) ? 'arrow-circle-o-up' : 'arrow-circle-o-down';
    		$cuadrotarifario_collection[$clave]->btn_estado_class = ($valor->activo == 0) ? 'success' : 'danger';
    	}

		$this->view->editar($cuadrotarifario_collection, $this->model);
	}

	function guardar() {
		SessionHandler()->check_session();
		
		$detalle = filter_input(INPUT_POST, 'detalle');
		$fecha_carga = date('Y-m-d');

		$this->model->detalle = $detalle;
		$this->model->fecha_carga = $fecha_carga;
		$this->model->activo = 0;
		$this->model->save();
		$cuadrotarifario_id = $this->model->cuadrotarifario_id;

		$directorio = URL_PRIVATE . "cuadrotarifario/";
		$archivo = $_FILES["archivo"]["tmp_name"];
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->file($archivo);
		$formato = explode("/", $mime);

		$mimes_permitidos = array("application/pdf");
		$name = $cuadrotarifario_id;
		if(in_array($mime, $mimes_permitidos)) {
			if(!file_exists($directorio)) {
				mkdir($directorio);
				chmod($directorio, 0777);
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			} else {
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			}
		}

		header("Location: " . URL_APP . "/cuadrotarifario/panel");
	}

	function actualizar() {
		SessionHandler()->check_session();	
		$cuadrotarifario_id = filter_input(INPUT_POST, 'cuadrotarifario_id');
		$this->model->cuadrotarifario_id = $cuadrotarifario_id;
		$this->model->get();
		$this->model->detalle = filter_input(INPUT_POST, 'detalle');
		$this->model->fecha_carga = date('Y-m-d');
		$this->model->save();
		header("Location: " . URL_APP . "/cuadrotarifario/editar/{$cuadrotarifario_id}");
	}

	function cambiar_estado($arg) {
		SessionHandler()->check_session();	
		$this->model->desactivar();
		
		$cuadrotarifario_id = $arg;
		$this->model->cuadrotarifario_id = $cuadrotarifario_id;
		$this->model->get();
		$activo = $this->model->activo;
		$this->model->activo = ($activo == 0) ? 1 : 0;
		$this->model->save();
		header("Location: " . URL_APP . "/cuadrotarifario/panel");
	}

	function guardar_archivo() {
		SessionHandler()->check_session();
		$cuadrotarifario_id = filter_input(INPUT_POST, "cuadrotarifario_id");
		$directorio = URL_PRIVATE . "cuadrotarifario/";
		$archivo = $_FILES["archivo"]["tmp_name"];
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->file($archivo);
		$formato = explode("/", $mime);

		$mimes_permitidos = array("application/pdf");
		$name = $cuadrotarifario_id;
		if(in_array($mime, $mimes_permitidos)) {
			if(!file_exists($directorio)) {
				mkdir($directorio);
				chmod($directorio, 0777);
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			} else {
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			}
		}

		header("Location: " . URL_APP . "/cuadrotarifario/editar/{$cuadrotarifario_id}");
	}

	function eliminar($arg) {
		SessionHandler()->check_session();		
		$cuadrotarifario_id = $arg;
		$this->model->cuadrotarifario_id = $cuadrotarifario_id;
		$this->model->delete();

		$archivo = URL_PRIVATE . "cuadrotarifario/{$cuadrotarifario_id}";
		chmod($archivo, 0777);
		unlink($archivo);

		header("Location: " . URL_APP . "/cuadrotarifario/panel");
	}

	function ver_archivo(){
		SessionHandler()->check_session();
		require_once "core/helpers/file.php";
	}
}
?>