<?php
require_once 'modules/mantenimientocategoria/model.php';
require_once 'modules/mantenimientoinstitucion/model.php';
require_once 'modules/mantenimientoubicacion/model.php';


class MantenimientoPreventivo extends StandardObject {
	
	function __construct(MantenimientoCategoria $mantenimientocategoria=NULL, MantenimientoInstitucion $mantenimientoinstitucion=NULL, MantenimientoUbicacion $mantenimientoubicacion=NULL) {
		$this->mantenimientopreventivo_id = 0;
        $this->numero_eucop = "";
        $this->fecha_inicio = "";
        $this->hora_inicio = "";
        $this->hora_fin = "";
        $this->motivo = "";
        $this->descripcion = "";
        $this->responsable_edelar = "";
        $this->responsable_contratista = "";
        $this->informe = 0;
        $this->aprobado = 0;
        $this->mantenimientocategoria = $mantenimientocategoria;
        $this->mantenimientoinstitucion = $mantenimientoinstitucion;
        $this->mantenimientoubicacion = $mantenimientoubicacion;
        $this->distribuidor_collection = array();
        $this->ceta_collection = array();
	}

    function add_distribuidor(Distribuidor $distribuidor) {
        $this->distribuidor_collection[] = $distribuidor;
    }

    function add_ceta(Ceta $ceta) {
        $this->ceta_collection[] = $ceta;
    }
}

class DistribuidorMantenimientoPreventivo {

    function __construct(MantenimientoPreventivo $mantenimientopreventivo=null) {
        $this->distribuidormantenimientopreventivo_id = 0;
        $this->compuesto = $mantenimientopreventivo;
        $this->compositor = $mantenimientopreventivo->distribuidor_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM distribuidormantenimientopreventivo WHERE compuesto=?";
        $datos = array($this->compuesto->mantenimientopreventivo_id);
        $resultados = execute_query($sql, $datos);
        if($resultados != 0){
            foreach($resultados as $array) {
                $obj = new Distribuidor();
                $obj->distribuidor_id = $array['compositor'];
                $obj->get();
                $this->compuesto->add_distribuidor($obj);
            }
        }
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO distribuidormantenimientopreventivo (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $distribuidor) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->mantenimientopreventivo_id;
            $datos[] = $distribuidor->distribuidor_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM distribuidormantenimientopreventivo WHERE compuesto=?";
        $datos = array($this->compuesto->mantenimientopreventivo_id);
        execute_query($sql, $datos);
    }
}

class CetaMantenimientoPreventivo {

    function __construct(MantenimientoPreventivo $mantenimientopreventivo=null) {
        $this->cetamantenimientopreventivo_id = 0;
        $this->compuesto = $mantenimientopreventivo;
        $this->compositor = $mantenimientopreventivo->ceta_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM cetamantenimientopreventivo WHERE compuesto=?";
        $datos = array($this->compuesto->mantenimientopreventivo_id);
        $resultados = execute_query($sql, $datos);
        if($resultados != 0){
            foreach($resultados as $array) {
                $obj = new Ceta();
                $obj->ceta_id = $array['compositor'];
                $obj->get();
                $this->compuesto->add_ceta($obj);
            }
        }
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO cetamantenimientopreventivo (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $ceta) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->mantenimientopreventivo_id;
            $datos[] = $ceta->ceta_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM cetamantenimientopreventivo WHERE compuesto=?";
        $datos = array($this->compuesto->mantenimientopreventivo_id);
        execute_query($sql, $datos);
    }
}
?>