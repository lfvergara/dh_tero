<?php
require_once 'modules/destinatario/model.php';


class Agenda extends StandardObject {
	
	function __construct() {
		$this->agenda_id = 0;
		$this->denominacion = '';
		$this->destinatario_collection = array();
	}

	function add_destinatario(Destinatario $destinatario) {
		$this->destinatario_collection[] = $destinatario;
    }
}

class DestinatarioAgenda {

	function __construct(Agenda $agenda=null) {
        $this->destinatarioagenda_id = 0;
        $this->compuesto = $agenda;
        $this->compositor = $agenda->destinatario_collection;
    }

    function get() {
        $sql = "SELECT compositor FROM destinatarioagenda WHERE compuesto=?";
        $datos = array($this->compuesto->agenda_id);
        $resultados = execute_query($sql, $datos);
        if($resultados){
			foreach($resultados as $array) {
				$obj = new Destinatario();
				$obj->destinatario_id = $array['compositor'];
				$obj->get();
				$this->compuesto->add_destinatario($obj);
			}
		}
    }

    function save() {
        $this->destroy();
        $tuplas = array();
        $datos = array();
        $sql = "INSERT INTO destinatarioagenda (compuesto, compositor)
                VALUES ";
        foreach($this->compositor as $destinatario) {
            $tuplas[] = "(?, ?)";
            $datos[] = $this->compuesto->agenda_id;
            $datos[] = $destinatario->destinatario_id;
        }
        $sql .= implode(', ', $tuplas);
        execute_query($sql, $datos);
    }

    function destroy() {
        $sql = "DELETE FROM destinatarioagenda WHERE compuesto=?";
        $datos = array($this->compuesto->agenda_id);
        execute_query($sql, $datos);
    }
}
?>