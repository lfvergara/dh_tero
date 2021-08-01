<?php
require_once "modules/rse/model.php";
require_once "modules/rse/view.php";
require_once "modules/archivo/model.php";
require_once "modules/video/model.php";


class RSEController {

	function __construct() {
		$this->model = new RSE();
		$this->view = new RSEView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$select = "rs.rse_id AS RSEID, rs.fecha AS FECHA, date_format(rs.fecha, '%d/%m/%Y') AS FMOD, rs.denominacion AS DENOMINACION, CONCAT(LEFT(rs.epigrafe, 100), '...') AS EPIGRAFE, CASE rs.activo WHEN 0 THEN 'danger' ELSE 'success' END AS ESTCOLOR, CASE rs.activo WHEN 0 THEN 'close' ELSE 'check' END AS ESTICON, CASE rs.activo WHEN 0 THEN 'Inactiva' ELSE 'Activa' END AS ESTTITULO, CASE rs.activo WHEN 0 THEN 'success' ELSE 'danger' END AS ESTACCCOLOR, CASE rs.activo WHEN 0 THEN 'arrow-circle-o-up' ELSE 'arrow-circle-o-down' END AS ESTACCICON, CASE rs.activo WHEN 0 THEN '¿Activar?' ELSE '¿Desactivar?' END AS ESTACCTITULO";
    	$from = "rse rs";
		$rse_collection = CollectorCondition()->get('RSE', NULL, 4, $from, $select);
		$this->view->panel($rse_collection);
	}

	function agregar() {
    	SessionHandler()->check_session();
		$this->view->agregar();
	}

	function editar($arg) {
		SessionHandler()->check_session();		
		$rse_id = $arg;
		$this->model->rse_id = $rse_id;
		$this->model->get();
		$this->view->editar($this->model);
	}

	function consultar($arg) {
		SessionHandler()->check_session();	
		$rse_id = $arg;
		$this->model->rse_id = $rse_id;
		$this->model->get();
		$this->view->consultar($this->model);
	}

	function guardar() {
		SessionHandler()->check_session();
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->epigrafe = filter_input(INPUT_POST, 'epigrafe');
		$this->model->contenido = filter_input(INPUT_POST, 'descr');
		$this->model->fecha = date('Y-m-d');
		$this->model->hora = date('H:i:s');
		$this->model->activo = 1;
		$this->model->save();
		$rse_id = $this->model->rse_id;
		header("Location: " . URL_APP . "/rse/editar/{$rse_id}");
	}

	function actualizar() {
		SessionHandler()->check_session();	
		$rse_id = filter_input(INPUT_POST, 'rse_id');
		$this->model->rse_id = $rse_id;
		$this->model->get();
		$this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
		$this->model->epigrafe = filter_input(INPUT_POST, 'epigrafe');
		$this->model->contenido = filter_input(INPUT_POST, 'contenido');
		$this->model->fecha = date('Y-m-d');
		$this->model->hora = date('H:i:s');
		$this->model->save();
		header("Location: " . URL_APP . "/rse/editar/{$rse_id}");
	}

	function cambiar_estado($arg) {
		SessionHandler()->check_session();	
		$rse_id = $arg;
		$this->model->rse_id = $rse_id;
		$this->model->get();
		$activo = $this->model->activo;
		$this->model->activo = ($activo == 0) ? 1 : 0;
		$this->model->save();
		header("Location: " . URL_APP . "/rse/panel");
	}

	function guardar_archivo() {
		SessionHandler()->check_session();
		$rse_id = filter_input(INPUT_POST, "rse_id");
		$denominacion = filter_input(INPUT_POST, "denominacion");
		
		$directorio = URL_PRIVATE . "rse/{$rse_id}/";
		$archivo = $_FILES["archivo"]["tmp_name"];
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->file($archivo);
		$formato = explode("/", $mime);

		$mimes_permitidos = array("image/png", "image/jpg", "image/jpeg","application/pdf");
		$name = $rse_id . date("Ymd") . rand();
		if(in_array($mime, $mimes_permitidos)) {
			if(!file_exists($directorio)) {
				mkdir($directorio);
				chmod($directorio, 0777);
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			} else {
				move_uploaded_file($archivo, "{$directorio}/{$name}");
			}

			$am = new Archivo();
			$am->denominacion = $denominacion;
			$am->url = $name;
			$am->fecha_carga = date('Y-m-d');
			$am->formato = $formato[1];
			$am->save();

			$archivo_id = $am->archivo_id;
			$am = new Archivo();
			$am->archivo_id = $archivo_id;
			$am->get();

			$this->model->rse_id = $rse_id;
			$this->model->get();
			$this->model->add_archivo($am);

			$avm = new ArchivoRSE($this->model);
			$avm->save();
		}

		header("Location: " . URL_APP . "/rse/editar/{$rse_id}");
	}

	function guardar_video() {
		SessionHandler()->check_session();
		$rse_id = filter_input(INPUT_POST, "rse_id");
		$denominacion = filter_input(INPUT_POST, "denominacion");
		$url = filter_input(INPUT_POST, "url");
		
		$vm = new Video();
		$vm->denominacion = $denominacion;
		$vm->url = $url;
		$vm->fecha_carga = date('Y-m-d');
		$vm->save();

		$video_id = $vm->video_id;
		$vm = new Video();
		$vm->video_id = $video_id;
		$vm->get();

		$this->model->rse_id = $rse_id;
		$this->model->get();
		$this->model->add_video($vm);

		$vrm = new VideoRSE($this->model);
		$vrm->save();

		header("Location: " . URL_APP . "/rse/editar/{$rse_id}");
	}

	function eliminar_archivo($arg) {
		SessionHandler()->check_session();
		$ids = explode("@", $arg);
		$rse_id = $ids[0];
		$archivo_id = $ids[1];
		$am = new Archivo();
		$am->archivo_id = $archivo_id;
		$am->get();
		$url = $am->url;
		$am->delete();

		$archivo = URL_PRIVATE . "rse/{$rse_id}/{$url}";
		chmod($archivo, 0777);
		unlink($archivo);

		header("Location: " . URL_APP . "/rse/editar/{$rse_id}");
	}

	function eliminar_video($arg) {
		SessionHandler()->check_session();
		$ids = explode("@", $arg);
		$rse_id = $ids[0];
		$video_id = $ids[1];
		$vm = new Video();
		$vm->video_id = $video_id;
		$vm->delete();
		header("Location: " . URL_APP . "/rse/editar/{$rse_id}");
	}

	function ver_archivo(){
		SessionHandler()->check_session();
		require_once "core/helpers/files.php";
	}
}
?>