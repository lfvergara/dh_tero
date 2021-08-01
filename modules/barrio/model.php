<?php
require_once 'modules/departamento/model.php';
require_once 'modules/coordenada/model.php';


class Barrio extends StandardObject {
	
	function __construct(Departamento $departamento=NULL) {
		$this->barrio_id = 0;
		$this->denominacion = '';
        $this->latitud = '';
        $this->longitud = '';
        $this->zoom = 0;
        $this->departamento = $departamento;
		$this->coordenada_collection = array();
	}

	function add_coordenada(Coordenada $coordenada) {
		$this->coordenada_collection[] = $coordenada;
    }
}

class CoordenadaBarrio {

	function __construct(Barrio $barrio=null) {
        $this->coordenadabarrio_id = 0;
        $this->compuesto = $barrio;
        $this->compositor = $barrio->coordenada_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM coordenadabarrio WHERE compuesto=?";
        $datos = array($this->compuesto->barrio_id);
        $resultados = execute_query($sql, $datos);
        if($resultados){
			foreach($resultados as $array) {
				$obj = new Coordenada();
				$obj->coordenada_id = $array['compositor'];
				$obj->get();
				$this->compuesto->add_coordenada($obj);
			}
		}
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO coordenadabarrio (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $coordenada) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->barrio_id;
            $datos[] = $coordenada->coordenada_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM coordenadabarrio WHERE compuesto=?";
        $datos = array($this->compuesto->barrio_id);
        execute_query($sql, $datos);
    }
}
?>