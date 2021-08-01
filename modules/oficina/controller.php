<?php
require_once "modules/oficina/model.php";
require_once "modules/oficina/view.php";
require_once "modules/unicom/model.php";
require_once "modules/oficinadia/model.php";
require_once "modules/configuracionturnero/model.php";
require_once "modules/rangoturnero/model.php";


class OficinaController {

	function __construct() {
		$this->model = new Oficina();
		$this->view = new OficinaView();
	}

	function panel() {
    	SessionHandler()->check_session();
    	$oficina_collection = Collector()->get('Oficina');
		foreach ($oficina_collection as $clave=>$valor) {
			$oficina_collection[$clave]->hora_desde = substr($valor->hora_desde, 0,5);
			$oficina_collection[$clave]->hora_hasta = substr($valor->hora_hasta, 0,5);

			$oficina_collection[$clave]->icon_turnero_activo = ($valor->turnero_online == 0) ? 'close' : 'check';
			$oficina_collection[$clave]->class_turnero_activo = ($valor->turnero_online == 0) ? 'danger' : 'success';

			$oficina_collection[$clave]->argumento_turnero_activar = ($valor->turnero_online == 0) ? 1 : 0;
			$oficina_collection[$clave]->icon_turnero_activar = ($valor->turnero_online == 0) ? 'arrow-circle-up' : 'arrow-circle-down';
			$oficina_collection[$clave]->class_turnero_activar = ($valor->turnero_online == 0) ? 'success' : 'danger';
			$oficina_collection[$clave]->title_turnero_activar = ($valor->turnero_online == 0) ? 'Activar' : 'Desactivar';
			unset($oficina_collection[$clave]->configuracionturnero_collection);
		}

		$unicom_collection = Collector()->get('Unicom');
		$this->view->panel($oficina_collection, $unicom_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$this->model->oficina_id = $arg;
		$this->model->get();
		$oficina_collection = Collector()->get('Oficina');
		foreach ($oficina_collection as $clave=>$valor) {
			$oficina_collection[$clave]->hora_desde = substr($valor->hora_desde, 0,5);
			$oficina_collection[$clave]->hora_hasta = substr($valor->hora_hasta, 0,5);

			$oficina_collection[$clave]->icon_turnero_activo = ($valor->turnero_online == 0) ? 'close' : 'check';
			$oficina_collection[$clave]->class_turnero_activo = ($valor->turnero_online == 0) ? 'danger' : 'success';

			$oficina_collection[$clave]->argumento_turnero_activar = ($valor->turnero_online == 0) ? 1 : 0;
			$oficina_collection[$clave]->icon_turnero_activar = ($valor->turnero_online == 0) ? 'arrow-circle-up' : 'arrow-circle-down';
			$oficina_collection[$clave]->class_turnero_activar = ($valor->turnero_online == 0) ? 'success' : 'danger';
			$oficina_collection[$clave]->title_turnero_activar = ($valor->turnero_online == 0) ? 'Activar' : 'Desactivar';
			unset($oficina_collection[$clave]->configuracionturnero_collection);
		}

		$unicom_collection = Collector()->get('Unicom');
		$this->view->editar($oficina_collection, $unicom_collection, $this->model);
	}

	function configuracion_turnero() {
		SessionHandler()->check_session();
		$oficina_collection = Collector()->get('Oficina');
		foreach ($oficina_collection as $clave=>$valor) {
			if ($valor->turnero_online == 0) unset($oficina_collection[$clave]);
			unset($oficina_collection[$clave]->configuracionturnero_collection);
		}

		$rangoturnero_collection = Collector()->get("RangoTurnero");
		$this->view->configuracion_turnero($oficina_collection, $rangoturnero_collection);
	}
	
	function guardar() {
		SessionHandler()->check_session();

		$lunes = (is_null(filter_input(INPUT_POST, 'lunes'))) ? 0 : 1;
		$martes = (is_null(filter_input(INPUT_POST, 'martes'))) ? 0 : 1;
		$miercoles = (is_null(filter_input(INPUT_POST, 'miercoles'))) ? 0 : 1;
		$jueves = (is_null(filter_input(INPUT_POST, 'jueves'))) ? 0 : 1;
		$viernes = (is_null(filter_input(INPUT_POST, 'viernes'))) ? 0 : 1;
		$sabado = (is_null(filter_input(INPUT_POST, 'sabado'))) ? 0 : 1;
		$domingo = (is_null(filter_input(INPUT_POST, 'domingo'))) ? 0 : 1;

		$odm = new OficinaDia();
		$odm->lunes = $lunes;
		$odm->martes = $martes;
		$odm->miercoles = $miercoles;
		$odm->jueves = $jueves;
		$odm->viernes = $viernes;
		$odm->sabado = $sabado;
		$odm->domingo = $domingo;
		$odm->save();
		$oficinadia_id = $odm->oficinadia_id;

		$this->model->denominacion = filter_input(INPUT_POST, "denominacion");
		$this->model->hora_desde = filter_input(INPUT_POST, "hora_desde");
		$this->model->hora_hasta = filter_input(INPUT_POST, "hora_hasta");
		$this->model->turnero_online = filter_input(INPUT_POST, "turnero_online");
		$this->model->direccion = filter_input(INPUT_POST, "direccion");
		$this->model->oficinadia = $oficinadia_id;
		$this->model->unicom = filter_input(INPUT_POST, "unicom");
		$this->model->save();
		header("Location: " . URL_APP . "/oficina/panel");
	}

	function actualizar() {
		SessionHandler()->check_session();
		$oficina_id = filter_input(INPUT_POST, 'oficina_id');
		$oficinadia_id = filter_input(INPUT_POST, 'oficinadia_id');

		$lunes = (is_null(filter_input(INPUT_POST, 'lunes'))) ? 0 : 1;
		$martes = (is_null(filter_input(INPUT_POST, 'martes'))) ? 0 : 1;
		$miercoles = (is_null(filter_input(INPUT_POST, 'miercoles'))) ? 0 : 1;
		$jueves = (is_null(filter_input(INPUT_POST, 'jueves'))) ? 0 : 1;
		$viernes = (is_null(filter_input(INPUT_POST, 'viernes'))) ? 0 : 1;
		$sabado = (is_null(filter_input(INPUT_POST, 'sabado'))) ? 0 : 1;
		$domingo = (is_null(filter_input(INPUT_POST, 'domingo'))) ? 0 : 1;

		$odm = new OficinaDia();
		$odm->oficinadia_id = $oficinadia_id;
		$odm->get();
		$odm->lunes = $lunes;
		$odm->martes = $martes;
		$odm->miercoles = $miercoles;
		$odm->jueves = $jueves;
		$odm->viernes = $viernes;
		$odm->sabado = $sabado;
		$odm->domingo = $domingo;
		$odm->save();

		$this->model->oficina_id = $oficina_id;
		$this->model->get();
		$this->model->denominacion = filter_input(INPUT_POST, "denominacion");
		$this->model->hora_desde = filter_input(INPUT_POST, "hora_desde");
		$this->model->hora_hasta = filter_input(INPUT_POST, "hora_hasta");
		$this->model->turnero_online = filter_input(INPUT_POST, "turnero_online");
		$this->model->direccion = filter_input(INPUT_POST, "direccion");
		$this->model->oficinadia = $oficinadia_id;
		$this->model->unicom = filter_input(INPUT_POST, "unicom");
		$this->model->save();
		header("Location: " . URL_APP . "/oficina/editar/{$oficina_id}");
	}

	function estado_turnero($arg) {
		SessionHandler()->check_session();
		$ids = explode("@", $arg);
		$oficina_id = $ids[0];
		$turnero_online = $ids[1];

		$this->model->oficina_id = $oficina_id;
		$this->model->get();
		$this->model->turnero_online = $turnero_online;
		$this->model->save();
		
		header("Location: " . URL_APP . "/oficina/panel");
	}

	function guardar_configuracion_turnero() {
		SessionHandler()->check_session();

		$fecha_desde = filter_input(INPUT_POST, 'fecha_desde');
		$fecha_hasta = filter_input(INPUT_POST, 'fecha_hasta');
		$array_gestores = $_POST["oficina_gestores"];
		$array_duracion = $_POST["oficina_duracion"];

		$tmp_array = array();
		foreach ($array_gestores as $clave=>$valor) {
			foreach ($array_duracion as $c=>$v) {
				if ($clave == $c) {
					$array = array();
					$array = array('oficina_id'=>$clave, 'gestores'=>$valor, 'duracion'=>$v);
					$tmp_array[] = $array;
				}
			}
		}
		
		$rtm = new RangoTurnero();
		$rtm->fecha_desde = $fecha_desde;
		$rtm->fecha_hasta = $fecha_hasta;
		$rtm->estado = 0;
		$rtm->save();
		$rangoturnero_id = $rtm->rangoturnero_id;

		foreach ($tmp_array as $clave=>$configuracion) {
			$oficina_id = $configuracion['oficina_id'];
			$cantidad_gestores = $configuracion['gestores'];
			$duracion_turno = $configuracion['duracion'];

			$ctm = new ConfiguracionTurnero();
			$ctm->cantidad_gestores = $cantidad_gestores;
			$ctm->duracion_turno = $duracion_turno;
			$ctm->rangoturnero = $rangoturnero_id;
			$ctm->save();
			$configuracionturnero_id = $ctm->configuracionturnero_id;

			$ctm = new ConfiguracionTurnero();
			$ctm->configuracionturnero_id = $configuracionturnero_id;
			$ctm->get();

			$om = new Oficina();
			$om->oficina_id = $oficina_id;
			$om->get();
			$om->add_configuracionturnero($ctm);

			$ctom = new ConfiguracionTurneroOficina($om);
			$ctom->save();
		}

		
		header("Location: " . URL_APP . "/oficina/consultar_rango/{$rangoturnero_id}");
	}

	function consultar_rango($arg) {
		SessionHandler()->check_session();
		$rangoturnero_id = $arg;

		$rtm = new RangoTurnero();
		$rtm->rangoturnero_id = $rangoturnero_id;
		$rtm->get();

		$select = "ct.cantidad_gestores AS GESTORES, ct.duracion_turno AS DURACION, o.denominacion AS OFICINA, u.denominacion AS UNICOM";
		$from = "rangoturnero rt INNER JOIN configuracionturnero ct ON rt.rangoturnero_id = ct.rangoturnero INNER JOIN configuracionturnerooficina cto ON ct.configuracionturnero_id = cto.compositor INNER JOIN oficina o ON cto.compuesto = o.oficina_id INNER JOIN unicom u ON o.unicom = u.unicom_id";
		$where = "rt.rangoturnero_id = {$rangoturnero_id}";
		$oficina_collection = CollectorCondition()->get("RangoTurnero", $where, 4, $from, $select);
		$rangoturnero_collection = Collector()->get("RangoTurnero");

		$this->view->consultar_rango($oficina_collection, $rangoturnero_collection, $rtm);
	}

	function estado_rangoturnero($arg) {
		SessionHandler()->check_session();
		$ids = explode("@", $arg);
		$rangoturnero_id = $ids[0];
		$estado = $ids[1];
		$this->model->desactivar_rangos();

		$rtm = new RangoTurnero();
		$rtm->rangoturnero_id = $rangoturnero_id;
		$rtm->get();
		$rtm->estado = $estado;
		$rtm->save();
		header("Location: " . URL_APP . "/oficina/consultar_rango/{$rangoturnero_id}");
	}
}
?>