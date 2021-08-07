<?php
require_once 'modules/tipogestioncomercial/model.php';
require_once 'modules/gestioncomercialhistorico/model.php';
require_once 'modules/archivo/model.php';


class GestionComercial extends StandardObject {
	
	function __construct(TipoGestionComercial $tipogestioncomercial=NULL) {
		$this->gestioncomercial_id = 0;
		$this->suministro = 0;
		$this->fecha = '';
		$this->dni = 0;
		$this->apellido = '';
		$this->nombre = '';
		$this->correoelectronico = '';
		$this->telefono = 0;
		$this->tipogestioncomercial = $tipogestioncomercial;
		$this->gestioncomercialhistorico_collection = array();
		$this->archivo_collection = array();
	}

	function add_gestioncomercialhistorico(GestionComercialHistorico $gestioncomercialhistorico) {
		$this->gestioncomercialhistorico_collection[] = $gestioncomercialhistorico;
    }

	function add_archivo(Archivo $archivo) {
		$this->archivo_collection[] = $archivo;
	}
}

class GestionComercialHistoricoGestionComercial {
    function __construct(GestionComercial $gestioncomercial=null) {
        $this->gestioncomercialhistoricogestioncomercial_id = 0;
        $this->compuesto = $gestioncomercial;
        $this->compositor = $gestioncomercial->gestioncomercialhistorico_collection;
	}

    function get() {
    	$sql = "SELECT compositor FROM gestioncomercialhistoricogestioncomercial WHERE compuesto=?";
        $datos = array($this->compuesto->gestioncomercial_id);
        $resultados = execute_query($sql, $datos);
        if($resultados){
            foreach($resultados as $array) {
                $obj = new GestionComercialHistorico();
                $obj->gestioncomercialhistorico_id = $array['compositor'];
                $obj->get();
                $this->compuesto->add_gestioncomercialhistorico($obj);
        	}
    	}
	}

    function save() {
        $this->destroy();
    	$tuplas = array();
        $datos = array();
        $sql = "INSERT INTO gestioncomercialhistoricogestioncomercial (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $gestioncomercialhistorico) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->gestioncomercial_id;
            $datos[] = $gestioncomercialhistorico->gestioncomercialhistorico_id;
    	}

        $sql .= implode(', ', $tuplas);
        $execute = execute_query($sql, $datos);
	}

    function destroy() {
    	$sql = "DELETE FROM gestioncomercialhistoricogestioncomercial WHERE compuesto=?";
        $datos = array($this->compuesto->gestioncomercial_id);
        execute_query($sql, $datos);
	}
}

class ArchivoGestionComercial   {

    function __construct(GestionComercial $gestioncomercial=null) {
        $this->archivogestioncomercial_id = 0;
        $this->compuesto = $gestioncomercial;
        $this->compositor = $gestioncomercial->archivo_collection;
	}

    function get() {
    	$sql = "SELECT compositor FROM archivogestioncomercial WHERE compuesto=?";
        $datos = array($this->compuesto->gestioncomercial_id);
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
        $sql = "INSERT INTO archivogestioncomercial (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $archivo) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->gestioncomercial_id;
            $datos[] = $archivo->archivo_id;
    	}

        $sql .= implode(', ', $tuplas);
        $execute = execute_query($sql, $datos);
	}

    function destroy() {
    	$sql = "DELETE FROM archivogestioncomercial WHERE compuesto=?";
        $datos = array($this->compuesto->gestioncomercial_id);
        execute_query($sql, $datos);
	}
}
?>