<?php
require_once 'modules/archivo/model.php';
require_once 'modules/video/model.php';


class RSE extends StandardObject {
	
	function __construct() {
		$this->rse_id = 0;
		$this->denominacion = '';
		$this->epigrafe = '';
		$this->contenido = '';
		$this->fecha = '';
		$this->hora = '';
		$this->activo = 0;
		$this->archivo_collection = array();
		$this->video_collection = array();
	}

	function add_archivo(Archivo $archivo) {
		$this->archivo_collection[] = $archivo;
    }

    function add_video(Video $video) {
		$this->video_collection[] = $video;
    }
}

class ArchivoRSE {

	function __construct(RSE $rse=null) {
        $this->archivorse_id = 0;
        $this->compuesto = $rse;
        $this->compositor = $rse->archivo_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM archivorse WHERE compuesto=?";
        $datos = array($this->compuesto->rse_id);
        $resultados = execute_query($sql, $datos);
        if($resultados){
			foreach($resultados as $array) {
				$obj = new Archivo();
				$obj->archivo_id = $array['compositor'];
				$obj->get();
				$this->compuesto->add_archivo($obj);
			}
		}
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO archivorse (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $archivo) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->rse_id;
            $datos[] = $archivo->archivo_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM archivorse WHERE compuesto=?";
        $datos = array($this->compuesto->rse_id);
        execute_query($sql, $datos);
    }
}

class VideoRSE {

	function __construct(RSE $rse=null) {
        $this->videorse_id = 0;
        $this->compuesto = $rse;
        $this->compositor = $rse->video_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM videorse WHERE compuesto=?";
        $datos = array($this->compuesto->rse_id);
        $resultados = execute_query($sql, $datos);
        if($resultados){
			foreach($resultados as $array) {
				$obj = new Video();
				$obj->video_id = $array['compositor'];
				$obj->get();
				$this->compuesto->add_video($obj);
			}
		}
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO videorse (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $video) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->rse_id;
            $datos[] = $video->video_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM videorse WHERE compuesto=?";
        $datos = array($this->compuesto->rse_id);
        execute_query($sql, $datos);
    }
}
?>