<?php
require_once "modules/mantenimientopreventivo/model.php";
require_once "modules/mantenimientopreventivo/view.php";
require_once "modules/mantenimientoubicacion/model.php";
require_once "modules/mantenimientocategoria/model.php";
require_once "modules/mantenimientoinstitucion/model.php";
require_once "modules/departamento/model.php";
require_once "modules/barrio/model.php";
require_once "modules/coordenadamantenimientopreventivo/model.php";
require_once "modules/distcetnis/model.php";
require_once "modules/distribuidor/model.php";
require_once "modules/ceta/model.php";
require_once "modules/agenda/model.php";


class MantenimientoPreventivoController {

	function __construct() {
		$this->model = new MantenimientoPreventivo();
		$this->view = new MantenimientoPreventivoView();
	}
	
	function panel() {
    	SessionHandler()->check_session();
    	$select = "mp.mantenimientopreventivo_id AS MANTENIMIENTO_ID, CONCAT('<b>(', mp.numero_eucop, ')</b> ', mp.motivo) AS MOTIVO, CONCAT('El ', mp.fecha_inicio, ', Desde ', SUBSTRING(mp.hora_inicio, 1, 5), ' Hasta las ', SUBSTRING(mp.hora_fin, 1, 5)) AS FECHA, DATEDIFF(mp.fecha_inicio, CURDATE()) AS DIAS_RESTANTES, IF(mp.fecha_inicio = CURDATE() AND mp.hora_fin > CURTIME() AND mp.hora_inicio < CURTIME(), 'EN EJECUCIÓN', 'PENDIENTE') AS ESTADO, CASE WHEN DATEDIFF(mp.fecha_inicio, CURDATE()) = 0 THEN 'danger' WHEN DATEDIFF(mp.fecha_inicio, CURDATE()) <= 3 THEN 'warning' WHEN DATEDIFF(mp.fecha_inicio, CURDATE()) >= 5 AND DATEDIFF(mp.fecha_inicio, CURDATE()) <= 10 THEN 'success' WHEN DATEDIFF(mp.fecha_inicio, CURDATE()) > 10 THEN 'info' END AS MANTENIMIENTO_CLASS";
    	$from = "mantenimientopreventivo mp";
    	$where = "mp.fecha_inicio > CURDATE() OR (mp.fecha_inicio = CURDATE() AND mp.hora_fin >= CURTIME()) ORDER BY DIAS_RESTANTES ASC, mp.hora_inicio ASC";
    	$mantenimiento_collection = CollectorCondition()->get('MantenimientoPreventivo', $where, 4, $from, $select);
		$this->view->panel($mantenimiento_collection);
	}
	
	function agregar() {
		SessionHandler()->check_session();
		$anio = substr(date('Y'), -2, 2);

		$mantenimientocategoria_collection = Collector()->get('MantenimientoCategoria');
    	$mantenimientoinstitucion_collection = Collector()->get('MantenimientoInstitucion');
		$departamento_collection = Collector()->get('Departamento');
		$barrio_collection = Collector()->get('Barrio');


		$select = "CONCAT((CONVERT(SUBSTRING_INDEX(mp.numero_eucop, '/', 1), UNSIGNED INTEGER) + 1), '/', SUBSTRING_INDEX(mp.numero_eucop, '/', -1)) AS NUEVO_EUCOP";
    	$from = "mantenimientopreventivo mp";
    	$where = "SUBSTRING_INDEX(mp.numero_eucop, '/', -1) = {$anio} ORDER BY CONVERT(SUBSTRING_INDEX(mp.numero_eucop, '/', 1), UNSIGNED INTEGER) DESC LIMIT 1";
    	$nuevo_eucop = CollectorCondition()->get('MantenimientoCategoriaMantenimientoPreventivo', $where, 4, $from, $select);
    	$numero_eucop = $nuevo_eucop[0]['NUEVO_EUCOP'];
		print_r($numero_eucop); exit;

		$this->view->agregar($mantenimientocategoria_collection, $mantenimientoinstitucion_collection, $departamento_collection, $barrio_collection);
	}

	function editar($arg) {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$departamento_collection = Collector()->get('Departamento');
    	$categoria_collection = Collector()->get('MantenimientoCategoria');
    	$institucion_collection = Collector()->get('MantenimientoInstitucion');

		$this->view->editar($institucion_collection, $categoria_collection, $departamento_collection, $this->model);
	}

	function editar_coordenadas($arg) {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$select = "cmp.coordenadamantenimientopreventivo_id AS ID, cmp.latitud AS LATITUD, cmp.longitud AS LONGITUD, cmp.altitud AS ALTITUD, cmp.etiqueta AS ETIQUETA, cmp.fillcolor AS FILLCOLOR, cmp.strokecolor AS STROKECOLOR, cmp.indice AS INDICE, cmp.mantenimientopreventivo_id AS MANPREID";
		$from = "coordenadamantenimientopreventivo cmp";
		$where = "cmp.mantenimientopreventivo_id = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);
		if (is_array($coordenadamantenimientopreventivo_collection)) {
				$tmp_array = array();
				foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
					$etiqueta = $valor["ETIQUETA"];
				 	if(!in_array($etiqueta, $tmp_array)) $tmp_array[] = $etiqueta;
				}

				$coordenadas = array();
				foreach ($tmp_array as $claves=>$valores) {
					$array_coordenada = array();
					foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
						if ($valor["ETIQUETA"] == $valores) {
							$array_temp = array("latitud"=>$valor["LATITUD"],
												"longitud"=>$valor["LONGITUD"],
												"etiqueta"=>$valor["ETIQUETA"],
												"filcolor"=>$valor["FILLCOLOR"],
												"strockcolor"=>$valor["STROKECOLOR"],
												"indice"=>$valor["INDICE"],
												"mantenimientopreventivo_id"=>$valor["MANPREID"]);
							$array_coordenada[] = $array_temp;
						}
					}

					$coordenadas[] = $array_coordenada;
				}
		} else {
			$coordenadas = "";
		}

		$this->view->editar_coordenadas($coordenadas);
	}

	function consultar($arg) {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$departamento_collection = Collector()->get('Departamento');
    	$categoria_collection = Collector()->get('MantenimientoCategoria');
    	$institucion_collection = Collector()->get('MantenimientoInstitucion');

		$select = "cmp.coordenadamantenimientopreventivo_id AS ID, cmp.latitud AS LATITUD, cmp.longitud AS LONGITUD, cmp.altitud AS ALTITUD, cmp.etiqueta AS ETIQUETA, cmp.fillcolor AS FILLCOLOR, cmp.strokecolor AS STROKECOLOR, cmp.indice AS INDICE, cmp.mantenimientopreventivo_id AS MANPREID";
		$from = "coordenadamantenimientopreventivo cmp";
		$where = "cmp.mantenimientopreventivo_id = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);

		if(is_array($coordenadamantenimientopreventivo_collection)){
			$tmp_array = array();
			foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
				$etiqueta = $valor["ETIQUETA"];
		   		if(!in_array($etiqueta, $tmp_array)) $tmp_array[] = $etiqueta;
			}

			$coordenadas = array();
			foreach ($tmp_array as $claves=>$valores) {
				$array_coordenada = array();
				foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
					if ($valor["ETIQUETA"] == $valores) {
						$array_temp = array("latitud"=>$valor["LATITUD"],
											"longitud"=>$valor["LONGITUD"],
											"etiqueta"=>$valor["ETIQUETA"],
											"filcolor"=>$valor["FILLCOLOR"],
											"strockcolor"=>$valor["STROKECOLOR"],
											"indice"=>$valor["INDICE"],
											"mantenimientopreventivo_id"=>$valor["MANPREID"]);
						$array_coordenada[] = $array_temp;
					}
				}

				$coordenadas[] = $array_coordenada;
			}
		} else {
			$coordenadas = array();
		}

		$this->view->consultar($coordenadas, $institucion_collection, $categoria_collection, $departamento_collection, $this->model);
	}

	function guardar() {
		SessionHandler()->check_session();
		$mum = new MantenimientoUbicacion();
		$mum->sector = filter_input(INPUT_POST, 'sector');
		$mum->calles = filter_input(INPUT_POST, 'calles');
		$mum->latitud = '';
		$mum->longitud = '';
		$mum->zoom = 0;
		$mum->save();
		$mantenimientoubicacion_id = $mum->mantenimientoubicacion_id;

		$mum->mantenimientoubicacion_id = $mantenimientoubicacion_id;
		$mum->get();

		foreach ($_POST['departamento'] as $departamento_id) {
			$dm = new Departamento();
			$dm->departamento_id = $departamento_id;
			$dm->get();
			$mum->add_departamento($dm);
		}

		$dmum = new DepartamentoMantenimientoUbicacion($mum);
		$dmum->save();

		$this->model->numero_eucop = filter_input(INPUT_POST, 'numero_eucop');
		$this->model->fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio');
		$this->model->hora_inicio = filter_input(INPUT_POST, 'hora_inicio');
		$this->model->hora_fin = filter_input(INPUT_POST, 'hora_fin');
		$this->model->motivo = filter_input(INPUT_POST, 'motivo');
		$this->model->descripcion = filter_input(INPUT_POST, 'descripcion');
		$this->model->responsable_edelar = filter_input(INPUT_POST, 'responsable_edelar');
		$this->model->responsable_contratista = filter_input(INPUT_POST, 'responsable_contratista');
		$this->model->informe = filter_input(INPUT_POST, 'informe');
		$this->model->aprobado = 0;
		$this->model->mantenimientoinstitucion = filter_input(INPUT_POST, 'mantenimientoinstitucion');
		$this->model->mantenimientocategoria = filter_input(INPUT_POST, 'mantenimientocategoria');
		$this->model->mantenimientoubicacion = $mantenimientoubicacion_id;
		$this->model->save();
		$mantenimientopreventivo_id = $this->model->mantenimientopreventivo_id;

		foreach ($_POST['barrio'] as $barrio_id) {
			$bm = new Barrio();
			$bm->barrio_id = $barrio_id;
			$bm->get();
			$coordenada_collection = $bm->coordenada_collection;
			foreach ($coordenada_collection as $clave=>$valor) {
				$cmpm = new CoordenadaMantenimientoPreventivo();
				$cmpm->latitud = $valor->latitud;
				$cmpm->longitud = $valor->longitud;
				$cmpm->altitud = $valor->altitud;
				$cmpm->etiqueta = $valor->etiqueta;
				$cmpm->fillcolor = $valor->fillcolor;
				$cmpm->strokecolor = $valor->strokecolor;
				$cmpm->indice = $valor->indice;
				$cmpm->mantenimientopreventivo_id = $mantenimientopreventivo_id;
				$cmpm->save();
			}
		}

		header("Location: " . URL_APP . "/mantenimientopreventivo/configurar_barrio/{$mantenimientopreventivo_id}");
	}

	function configurar_barrio($arg) {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$select = "cmp.coordenadamantenimientopreventivo_id AS ID, cmp.latitud AS LATITUD, cmp.longitud AS LONGITUD, cmp.altitud AS ALTITUD, cmp.etiqueta AS ETIQUETA, cmp.fillcolor AS FILLCOLOR, cmp.strokecolor AS STROKECOLOR, cmp.indice AS INDICE, cmp.mantenimientopreventivo_id AS MANPREID";
		$from = "coordenadamantenimientopreventivo cmp";
		$where = "cmp.mantenimientopreventivo_id = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);

		if (is_array($coordenadamantenimientopreventivo_collection)) {
			$tmp_array = array();
			foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
				$etiqueta = $valor["ETIQUETA"];
			 	if(!in_array($etiqueta, $tmp_array)) $tmp_array[] = $etiqueta;
			}

			$coordenadas = array();
			foreach ($tmp_array as $clave=>$valor) {
				$array_coordenada = array();
				foreach ($coordenadamantenimientopreventivo_collection as $c=>$v) {
					if ($v["ETIQUETA"] == $valor) {
						$array_temp = array("latitud"=>$v["LATITUD"],
											"longitud"=>$v["LONGITUD"],
											"etiqueta"=>$v["ETIQUETA"],
											"filcolor"=>$v["FILLCOLOR"],
											"strockcolor"=>$v["STROKECOLOR"],
											"indice"=>$v["INDICE"],
											"mantenimientopreventivo_id"=>$v["MANPREID"]);
						$array_coordenada[] = $array_temp;
					}
				}

				$coordenadas[] = $array_coordenada;
			}
		} else {
			$coordenadas = array();
		}

		$this->view->configurar_barrio($coordenadas, $mantenimientopreventivo_id);
	}

	function actualizar_coordenadas() {
		SessionHandler()->check_session();

		$mantenimientopreventivo_id = filter_input(INPUT_POST, 'mantenimientopreventivo_id');
		$coordenadas = json_decode(json_decode($_POST['array'],true),true);

		/*SE GUARDA CENTRO DE MAPA*/
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();
		$mantenimientoubicacion_id = $this->model->mantenimientoubicacion->mantenimientoubicacion_id;

		$mum = new MantenimientoUbicacion();
		$mum->mantenimientoubicacion_id = $mantenimientoubicacion_id;
		$mum->get();
		$mum->latitud = $coordenadas["center"]["lat"];
		$mum->longitud = $coordenadas["center"]["lng"];
		$mum->zoom = $coordenadas["zoom"];
		$mum->save();
	 
		$select = "cmp.coordenadamantenimientopreventivo_id AS ID";
		$from = "coordenadamantenimientopreventivo cmp";
		$where = "cmp.mantenimientopreventivo = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);

		foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
			$coordenadamantenimientopreventivo_id = $valor["ID"];
			$cmpm = new CoordenadaMantenimientoPreventivo();
			$cmpm->coordenadamantenimientopreventivo_id = $coordenadamantenimientopreventivo_id;
			$cmpm->delete();
		}

		foreach ($coordenadas["overlays"] as $coordenada) {
			$etiqueta = $coordenada["title"];
			$fillcolor = $coordenada["fillColor"];
			$strokecolor = $coordenada["strokeColor"];
			foreach ($coordenada["paths"] as $paths) {
				foreach ($paths as $clave=>$path) {
					$latitud = $path["lat"];
					$longitud = $path["lng"];

					$cmpm = new CoordenadaMantenimientoPreventivo();
					$cmpm->latitud = $latitud;
					$cmpm->longitud = $longitud;
					$cmpm->altitud = 0;
					$cmpm->etiqueta = $etiqueta;
					$cmpm->fillcolor = $fillcolor;
					$cmpm->strokecolor = $strokecolor;
					$cmpm->indice = $clave;
					$cmpm->mantenimientopreventivo_id = $mantenimientopreventivo_id;
					$cmpm->save();
				}
			}
		}
	}

	function configurar($arg) {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();
		$departamentos = $this->model->mantenimientoubicacion->departamento_collection;

		$unicom_ids = array();
		foreach ($departamentos as $departamento) {
			$unicom_id = $departamento->unicom->unicom_id;
			if(!in_array($departamento->unicom->unicom_id, $unicom_ids)) $unicom_ids[] = $unicom_id;
		}

		$unicom_ids = implode(',', $unicom_ids);
		$select = "DISTINCT dcn.distribuidor AS DISTRIBUIDOR";
		$from = "distcetnis dcn";
		$where = "dcn.distrito IN ({$unicom_ids})";
		$distribuidor_collection = CollectorCondition()->get('DistCetNis', $where, 4, $from, $select);

		$select = "DISTINCT dcn.cet AS CETA";
		$from = "distcetnis dcn";
		$where = "dcn.distrito IN ({$unicom_ids})";
		$ceta_collection = CollectorCondition()->get('DistCetNis', $where, 4, $from, $select);

		$this->view->configurar($distribuidor_collection, $ceta_collection, $this->model);
	}

	function guardar_distribuidor() {
		$array_distribuidor = $_POST['distribuidor'];
		$mantenimientopreventivo_id = filter_input(INPUT_POST, 'mantenimientopreventivo_id');
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$distribuidor_collection = $this->model->distribuidor_collection;
		if (!empty($distribuidor_collection)) {
			foreach ($distribuidor_collection as $clave=>$valor) {
				$dm = new Distribuidor();
				$dm->distribuidor_id = $valor->distribuidor_id;
				$dm->delete();
			}
		}

		$this->model = new MantenimientoPreventivo();
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();
		$this->model->distribuidor_collection = array();
		if (!empty($array_distribuidor)) {
			foreach ($array_distribuidor as $clave=>$valor) {
				$dm = new Distribuidor();
				$dm->distribuidor = $valor;
				$dm->save();
				$distribuidor_id = $dm->distribuidor_id;

				$dm = new Distribuidor();
				$dm->distribuidor_id = $distribuidor_id;
				$dm->get();

				$this->model->add_distribuidor($dm);
			}
		}

		$dmpm = new DistribuidorMantenimientoPreventivo($this->model);
		$dmpm->save();

		header("Location: " . URL_APP . "/mantenimientopreventivo/configurar/{$mantenimientopreventivo_id}");
	}

	function guardar_ceta() {
		$array_ceta = $_POST['ceta'];
		$mantenimientopreventivo_id = filter_input(INPUT_POST, 'mantenimientopreventivo_id');
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$ceta_collection = $this->model->ceta_collection;
		if (!empty($ceta_collection)) {
			foreach ($ceta_collection as $clave=>$valor) {
				$cm = new Ceta();
				$cm->ceta_id = $valor->ceta_id;
				$cm->delete();
			}
		}

		$this->model = new MantenimientoPreventivo();
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();
		$this->model->ceta_collection = array();
		if (!empty($array_ceta)) {
			foreach ($array_ceta as $clave=>$valor) {
				$cm = new Ceta();
				$cm->ceta = $valor;
				$cm->save();
				$ceta_id = $cm->ceta_id;

				$cm = new Ceta();
				$cm->ceta_id = $ceta_id;
				$cm->get();

				$this->model->add_ceta($cm);
			}
		}

		$cmpm = new CetaMantenimientoPreventivo($this->model);
		$cmpm->save();

		header("Location: " . URL_APP . "/mantenimientopreventivo/configurar/{$mantenimientopreventivo_id}");
	}

	function actualizar() {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = filter_input(INPUT_POST, 'mantenimientopreventivo_id');
		$mantenimientoubicacion_id = filter_input(INPUT_POST, 'mantenimientoubicacion_id');
		
		$mum = new MantenimientoUbicacion();
		$mum->mantenimientoubicacion_id = $mantenimientoubicacion_id;
		$mum->get();
		$mum->sector = filter_input(INPUT_POST, 'sector');
		$mum->calles = filter_input(INPUT_POST, 'calles');
		$mum->save();

		$array_departamento = $_POST['departamento'];
		$mum = new MantenimientoUbicacion();
		$mum->mantenimientoubicacion_id = $mantenimientoubicacion_id;
		$mum->get();
		$mum->departamento_collection = array();

		foreach ($array_departamento as $departamento_id) {
			$dm = new Departamento();
			$dm->departamento_id = $departamento_id;
			$dm->get();
			$mum->add_departamento($dm);
		}

		$dmum = new DepartamentoMantenimientoUbicacion($mum);
		$dmum->save();

		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();
		$this->model->numero_eucop = filter_input(INPUT_POST, 'numero_eucop');
		$this->model->fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio');
		$this->model->hora_inicio = filter_input(INPUT_POST, 'hora_inicio');
		$this->model->hora_fin = filter_input(INPUT_POST, 'hora_fin');
		$this->model->motivo = filter_input(INPUT_POST, 'motivo');
		$this->model->descripcion = filter_input(INPUT_POST, 'descripcion');
		$this->model->responsable_edelar = filter_input(INPUT_POST, 'responsable_edelar');
		$this->model->responsable_contratista = filter_input(INPUT_POST, 'responsable_contratista');
		$this->model->informe = filter_input(INPUT_POST, 'informe');
		$this->model->aprobado = 0;
		$this->model->mantenimientoinstitucion = filter_input(INPUT_POST, 'mantenimientoinstitucion');
		$this->model->mantenimientocategoria = filter_input(INPUT_POST, 'mantenimientocategoria');
		$this->model->mantenimientoubicacion = $mantenimientoubicacion_id;
		$this->model->save();
		header("Location: " . URL_APP . "/mantenimientopreventivo/configurar/{$mantenimientopreventivo_id}");
	}

	function enviar_informe() {
		$mantenimientopreventivo_id = filter_input(INPUT_POST, 'mantenimientopreventivo_id');
		$mensaje = filter_input(INPUT_POST, 'mensaje');
		

		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();
		$mantenimientopreventivo_departamentos = $this->model->mantenimientoubicacion->departamento_collection;
		unset($this->model->distribuidor_collection, $this->model->ceta_collection, $this->model->mantenimientoubicacion->departamento_collection);
		
		$temp_departamentos = array();
		foreach ($mantenimientopreventivo_departamentos as $departamento) $temp_departamentos[] = $departamento->denominacion;
		$this->model->departamentos = implode(' - ', $temp_departamentos);
		$this->model->hora_inicio = substr($this->model->hora_inicio, 0, 5);
		$this->model->hora_fin = substr($this->model->hora_fin, 0, 5);
		$this->model->mensaje = $mensaje;

		$mpm_fecha_inicio = explode('-', $this->model->fecha_inicio);
		$this->model->fecha_inicio = $mpm_fecha_inicio[2] . '/' . $mpm_fecha_inicio[1] . '/' .$mpm_fecha_inicio[0];

		$correos = filter_input(INPUT_POST, 'correos');
		if (is_null($correos)) {
			$array_correos1 = array();
		} else {
			$array_correos1 = explode(';', $correos);
		}

		$agenda_ids = $_POST['agenda'];
		$array_correos2 = array();
		if (!empty($agenda_ids)) {
			foreach ($agenda_ids as $agenda_id) {
				$am = new Agenda();
				$am->agenda_id = $agenda_id;
				$am->get();

				$destinatario_collection = $am->destinatario_collection;
				foreach ($destinatario_collection as $destinatario) $array_correos2[] = $destinatario->correoelectronico;
			}
		}

		$array_correos = array_merge($array_correos1, $array_correos2);
		if (empty($array_correos)) {
			header("Location: " . URL_APP . "/mantenimientopreventivo/panel");
		} else {
			foreach ($array_correos as $clave=>$valor) if (empty($valor)) unset($array_correos[$clave]);
			$emailHelper = new EmailHelper();
			$emailHelper->envia_informe_mantenimientopreventivo($array_correos, $this->model);
			header("Location: " . URL_APP . "/mantenimientopreventivo/panel");
		}
	}

	function wsp_coordenadas($arg){
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$select = "cmp.coordenadamantenimientopreventivo_id AS ID, cmp.latitud AS LATITUD, cmp.longitud AS LONGITUD, cmp.altitud AS ALTITUD, cmp.etiqueta AS ETIQUETA, cmp.fillcolor AS FILLCOLOR, cmp.strokecolor AS STROKECOLOR, cmp.indice AS INDICE, cmp.mantenimientopreventivo_id AS MANPREID";
		$from = "coordenadamantenimientopreventivo";
		$where = "mantenimientopreventivo_id = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);

		if(is_array($coordenadamantenimientopreventivo_collection)){
			$tmp_array = array();
			foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
				$etiqueta = $valor["ETIQUETA"];
			 	if(!in_array($etiqueta, $tmp_array)){
					$tmp_array[] = $etiqueta;
			 	}
			}

			$coordenadas = array();
			foreach ($tmp_array as $c=>$v) {
				$array_coordenada = array();
				foreach ($coordenadamantenimientopreventivo_collection as $clave=>$valor) {
					if ($valor["ETIQUETA"] == $v) {
						$array_temp = array("latitud"=>$valor["LATITUD"],
											"longitud"=>$valor["LONGITUD"],
											"etiqueta"=>$valor["ETIQUETA"],
											"filcolor"=>$valor["FILLCOLOR"],
											"strockcolor"=>$valor["STROKECOLOR"],
											"indice"=>$valor["INDICE"],
											"mantenimientopreventivo_id"=>$valor["MANPREID"]);
						$array_coordenada[] = $array_temp;
					}
				}
				
				$coordenadas[] = $array_coordenada;
			}
		} else {
			$coordenadas = array();
		}

		$this->view->wsp_coordenadas($coordenadas);
	}

	function wsp_consultar($arg) {
		SessionHandler()->check_session();
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$select = "cmp.coordenadamantenimientopreventivo_id AS ID, cmp.latitud AS LATITUD, cmp.longitud AS LONGITUD, cmp.altitud AS ALTITUD, cmp.etiqueta AS ETIQUETA, cmp.fillcolor AS FILLCOLOR, cmp.strokecolor AS STROKECOLOR, cmp.indice AS INDICE, cmp.mantenimientopreventivo_id AS MANPREID";
		$from = "coordenadamantenimientopreventivo cmp";
		$where = "mantenimientopreventivo_id = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);
		$haycord = true;
		if (empty($coordenadamantenimientopreventivo_collection)){
			$haycord = false;
		}
		
		$this->model->haycord = $haycord;
		$this->view->wsp_consultar($this->model);
	}

	function form_email_ajax($arg) {
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$select = "a.denominacion AS DENOMINACION, a.agenda_id AS ID";
		$from = "agenda a ORDER BY a.denominacion ASC";
		$agenda_collection = CollectorCondition()->get('Agenda', NULL, 4, $from, $select);

		$this->view->form_email_ajax($agenda_collection, $this->model);
	}

	function apiGetMantenimientos($arg){
		if($arg == 'enejecucion') {
			$where = 'fecha_inicio >= CURDATE() OR (fecha_inicio = CURDATE() AND hora_fin >= CURTIME())';
			$mantenimientos = CollectorCondition()->get('MantenimientoPreventivo',$where,2);
			$json = json_encode(array('resultados' => $mantenimientos, JSON_UNESCAPED_UNICODE));
			print_r($json);
		}
	}

	function apiMantenimientoMapa($arg) {
		$mantenimientopreventivo_id = $arg;
		$this->model->mantenimientopreventivo_id = $mantenimientopreventivo_id;
		$this->model->get();

		$select = "cmp.coordenadamantenimientopreventivo_id AS ID, cmp.latitud AS LATITUD, cmp.longitud AS LONGITUD, cmp.altitud AS ALTITUD, cmp.etiqueta AS ETIQUETA, cmp.fillcolor AS FILLCOLOR, cmp.strokecolor AS STROKECOLOR, cmp.indice AS INDICE, mantenimientopreventivo_id AS MANPREID";
		$from = "coordenadamantenimientopreventivo cmp";
		$where = "cmp.mantenimientopreventivo_id = {$mantenimientopreventivo_id}";
		$coordenadamantenimientopreventivo_collection = CollectorCondition()->get('CoordenadaMantenimientoPreventivo', $where, 4, $from, $select);
		if (is_array($coordenadamantenimientopreventivo_collection)) {
			$json = json_encode(array('resultados' => $coordenadamantenimientopreventivo_collection, JSON_UNESCAPED_UNICODE));
			print_r($json);
		} else {
			echo "nomapa";
		}
	}
}
?>