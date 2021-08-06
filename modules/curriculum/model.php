<?php
require_once 'modules/areainteres/model.php';
require_once 'modules/provincia/model.php';


class Curriculum extends StandardObject {

	function __construct(AreaInteres $areainteres=NULL, Provincia $provincia=NULL) {
		$this->curriculum_id = 0;
		$this->apellido = '';
		$this->nombre = '';
	    $this->localidad = '';
	    $this->direccion = '';
	    $this->correo = '';
	    $this->telefono = 0;
		$this->estudio = '';
		$this->titulo = '';
		$this->estadocivil = '';
	    $this->mensaje = '';
	    $this->fecha_carga = '';
	    $this->areainteres = $areainteres;
	    $this->provincia = $provincia;
	}
}
?>