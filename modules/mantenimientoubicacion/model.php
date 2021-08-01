<?php
require_once 'modules/departamento/model.php';


class MantenimientoUbicacion extends StandardObject {
	
	function __construct() {
		$this->mantenimientoubicacion_id = 0;
		$this->sector = '';
        $this->calles = '';
        $this->latitud = '';
        $this->longitud = '';
        $this->zoom = 0;
		$this->departamento_collection = array();
	}

	function add_departamento(Departamento $departamento) {
		$this->departamento_collection[] = $departamento;
    }
}

class DepartamentoMantenimientoUbicacion {

	function __construct(MantenimientoUbicacion $mantenimientoubicacion=null) {
        $this->departamentomantenimientoubicacion_id = 0;
        $this->compuesto = $mantenimientoubicacion;
        $this->compositor = $mantenimientoubicacion->departamento_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM departamentomantenimientoubicacion WHERE compuesto=?";
        $datos = array($this->compuesto->mantenimientoubicacion_id);
        $resultados = execute_query($sql, $datos);
        if($resultados){
			foreach($resultados as $array) {
				$obj = new Departamento();
				$obj->departamento_id = $array['compositor'];
				$obj->get();
				$this->compuesto->add_departamento($obj);
			}
		}
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO departamentomantenimientoubicacion (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $departamento) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->mantenimientoubicacion_id;
            $datos[] = $departamento->departamento_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM departamentomantenimientoubicacion WHERE compuesto=?";
        $datos = array($this->compuesto->mantenimientoubicacion_id);
        execute_query($sql, $datos);
    }
}
?>