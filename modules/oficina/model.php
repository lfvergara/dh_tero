<?php
require_once 'modules/oficinadia/model.php';
require_once 'modules/unicom/model.php';
require_once 'modules/configuracionturnero/model.php';


class Oficina extends StandardObject {
	
	function __construct(OficinaDia $oficinadia=NULL, Unicom $unicom=NULL) {
		$this->oficina_id = 0;
		$this->denominacion = '';
		$this->direccion = '';
		$this->hora_desde = '';
		$this->hora_hasta = '';
		$this->turnero_online = 0;
		$this->oficinadia = $oficinadia;
		$this->unicom = $unicom;
		$this->configuracionturnero_collection = array();
	}

	function desactivar_rangos() {
		$sql = "UPDATE rangoturnero SET estado = 0";
		execute_query($sql);
	}

	function add_configuracionturnero(ConfiguracionTurnero $configuracionturnero) {
        $this->configuracionturnero_collection[] = $configuracionturnero;
    }
}

class ConfiguracionTurneroOficina {

    function __construct(Oficina $oficina=null) {
        $this->configuracionturnerooficina_id = 0;
        $this->compuesto = $oficina;
        $this->compositor = $oficina->configuracionturnero_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM configuracionturnerooficina WHERE compuesto=?";
        $datos = array($this->compuesto->oficina_id);
        $resultados = execute_query($sql, $datos);
        if($resultados != 0){
            foreach($resultados as $array) {
                $obj = new ConfiguracionTurnero();
                $obj->configuracionturnero_id = $array['compositor'];
                $obj->get();
                $this->compuesto->add_configuracionturnero($obj);
            }
        }
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO configuracionturnerooficina (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $configuracionturnero) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->oficina_id;
            $datos[] = $configuracionturnero->configuracionturnero_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM configuracionturnerooficina WHERE compuesto=?";
        $datos = array($this->compuesto->oficina_id);
        execute_query($sql, $datos);
    }
}
?>