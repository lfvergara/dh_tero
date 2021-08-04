<?php


class MantenimientoPreventivoView extends View {
	function panel($mantenimientopreventivo_collection) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/panel.html");
		$tbl_mantenimientopreventivo = file_get_contents("static/modules/mantenimientopreventivo/tbl_mantenimientopreventivo.html");
		$tbl_mantenimientopreventivo = $this->render_regex_dict('TBL_MANTENIMIENTOPREVENTIVO', $tbl_mantenimientopreventivo, $mantenimientopreventivo_collection);
		$render = str_replace('{tbl_mantenimientopreventivo}', $tbl_mantenimientopreventivo, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function agregar($mantenimientocategoria_collection, $mantenimientoinstitucion_collection, $departamento_collection, $barrio_collection, $numero_eucop) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/agregar.html");
		$gui_slt_categoria = file_get_contents("static/modules/mantenimientopreventivo/slt_mantenimientocategoria.html");
		$gui_slt_institucion = file_get_contents("static/modules/mantenimientopreventivo/slt_mantenimientoinstitucion.html");
		$gui_slt_departamento = file_get_contents("static/modules/mantenimientopreventivo/multi_slt_departamento.html");
		$gui_slt_barrio = file_get_contents("static/modules/mantenimientopreventivo/multi_slt_barrio.html");

		foreach ($barrio_collection as $clave=>$valor) unset($barrio_collection[$clave]->coordenada_collection);
		$gui_slt_institucion = $this->render_regex('SLT_MANTENIMIENTOINSTITUCION', $gui_slt_institucion, $mantenimientoinstitucion_collection);
		$gui_slt_categoria = $this->render_regex('SLT_MANTENIMIENTOCATEGORIA', $gui_slt_categoria, $mantenimientocategoria_collection);
		$gui_slt_departamento = $this->render_regex('MULTI_SLT_DEPARTAMENTO', $gui_slt_departamento, $departamento_collection);
		$gui_slt_barrio = $this->render_regex('MULTI_SLT_BARRIO', $gui_slt_barrio, $barrio_collection);

		$render = str_replace('{slt_mantenimientoinstitucion}', $gui_slt_institucion, $gui);
		$render = str_replace('{slt_mantenimientocategoria}', $gui_slt_categoria, $render);
		$render = str_replace('{slt_departamento}', $gui_slt_departamento, $render);
		$render = str_replace('{slt_barrio}', $gui_slt_barrio, $render);
		$render = str_replace('{numero_eucop}', $numero_eucop, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}

	function configurar_barrio($coordenadas, $mantenimientopreventivo_id) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/configurar_barrio.html");
		$lst_coordenada = file_get_contents("static/modules/mantenimientopreventivo/lst_coordenada_editar.html");

		if (!empty($coordenadas)) {
			foreach ($coordenadas as $clave=>$valor) {
				$array_coordenadas[$clave] = array("mantenimientopreventivo_id"=>$valor[$clave]['mantenimientopreventivo_id'],
												   "etiqueta"=>$valor[$clave]['etiqueta'],
												   "filcolor"=>$valor[$clave]['filcolor'],
												   "strockcolor"=>$valor[$clave]['strockcolor'],
												   "coordenadas"=> array());

				$var_coordenadas = Array();
				foreach ($valor as $c=>$v) $var_coordenadas[] = array("latitud"=>$v['latitud'],"longitud"=>$v['longitud']);
				$array_coordenadas[$clave]['coordenadas'] = $var_coordenadas;
			}

			$render_coordenada = '';
			$cod_lst_coordenada= $this->get_regex('LST_COORDENADA', $lst_coordenada);
			$array_coordenadas_sizeof = sizeof($array_coordenadas);

			foreach ($array_coordenadas as $clave=>$valor) {
				$cod_opt_coordenada = file_get_contents("static/modules/mantenimientopreventivo/opt_coordenada_editar.html");
				$titulo = $valor['etiqueta'];
				$coordenadas = $valor['coordenadas'];
				$filcolor = $valor['filcolor'];
				$strockcolor = $valor['strockcolor'];
				$i = $clave;
				$mantenimientopreventivo_id = $valor['mantenimientopreventivo_id'];
				unset($valor['coordenadas']);
				$lst_coordenada = $this->render($valor, $cod_lst_coordenada);

				$cod_option_coordenada = $this->get_regex('OPT_COORDENADA', $cod_opt_coordenada);
				$render_opcion_coordenada = '';
				foreach($coordenadas as $coordenada) {
					$opt_coordenada = $this->render($coordenada, $cod_option_coordenada);
					$render_opcion_coordenada .= $opt_coordenada;
				}

				$render_opcion_coordenada = str_replace('<!--OPT_COORDENADA-->', '', $render_opcion_coordenada);
				$render_opcion_coordenada = substr(trim($render_opcion_coordenada), 0, -1);
				$render_opcion_coordenada = str_replace($this->get_regex('OPT_COORDENADA', $cod_opt_coordenada), $render_opcion_coordenada, $cod_opt_coordenada);
				$render_opcion_coordenada = str_replace('{title}', $titulo, $render_opcion_coordenada);
				$render_opcion_coordenada = str_replace('{filcolor}', $filcolor, $render_opcion_coordenada);
				$render_opcion_coordenada = str_replace('{strockcolor}', $strockcolor, $render_opcion_coordenada);
				$lst_coordenada = str_replace('{lista_coordenadas}', $render_opcion_coordenada, $lst_coordenada);
				$render_coordenada .= $lst_coordenada;
			}

			$render_coordenada = str_replace('<!--LST_COORDENADA-->', '', $render_coordenada);
			$render_coordenada = substr(trim($render_coordenada), 0, -1);
		} else {
			$render_coordenada = '';
		}
		
		$render = str_replace('{lst_coordenada}', $render_coordenada, $gui);
		$render = str_replace('{mantenimientopreventivo_id}', $mantenimientopreventivo_id, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function configurar($distribuidor_unicom_collection, $ceta_unicom_collection, $obj_mantenimientopreventivo) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/configurar.html");
		$gui_lst_btn_distribuidor = file_get_contents("static/modules/mantenimientopreventivo/lst_btn_distribuidor.html");
		$gui_lst_btn_ceta = file_get_contents("static/modules/mantenimientopreventivo/lst_btn_ceta.html");
		$gui_multi_slt_distribuidor = file_get_contents("static/modules/mantenimientopreventivo/multi_slt_distribuidor.html");
		$gui_multi_slt_ceta = file_get_contents("static/modules/mantenimientopreventivo/multi_slt_ceta.html");

		$departamento_collection = $obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection;
		$distribuidor_collection = $obj_mantenimientopreventivo->distribuidor_collection;
		$ceta_collection = $obj_mantenimientopreventivo->ceta_collection;
		unset($obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection,
			  $obj_mantenimientopreventivo->distribuidor_collection,
			  $obj_mantenimientopreventivo->ceta_collection);

		$str_departamento = array();
		foreach ($departamento_collection as $clave=>$valor) $str_departamento[] = $valor->denominacion;
		$str_departamento = implode(" - ", $str_departamento);

		$obj_mantenimientopreventivo->aprobado = ($obj_mantenimientopreventivo->aprobado == 1) ? "Si" : "No";
		$obj_mantenimientopreventivo->informe = ($obj_mantenimientopreventivo->informe == 1) ? "Si" : "No";
		$obj_mantenimientopreventivo->departamentos = $str_departamento;
		$obj_mantenimientopreventivo = $this->set_dict($obj_mantenimientopreventivo);

		$temp_distribuidor = array();
		foreach ($distribuidor_collection as $distribuidor) $temp_distribuidor[] = $distribuidor->distribuidor;

		foreach ($distribuidor_unicom_collection as $clave=>$valor) {
			$dist_unicom = $distribuidor_unicom_collection[$clave]['DISTRIBUIDOR'];
			if (in_array($dist_unicom, $temp_distribuidor)) {
				$distribuidor_unicom_collection[$clave]['DIST_SELECTED'] = "selected";
			} else {
				$distribuidor_unicom_collection[$clave]['DIST_SELECTED'] = "";
			}
		}

		$temp_ceta = array();
		foreach ($ceta_collection as $ceta) $temp_ceta[] = $ceta->ceta;
		foreach ($ceta_unicom_collection as $clave=>$valor) {
			$cet_unicom = $ceta_unicom_collection[$clave]['CETA'];
			if (in_array($cet_unicom, $temp_ceta)) {
				$ceta_unicom_collection[$clave]['CET_SELECTED'] = "selected";
			} else {
				$ceta_unicom_collection[$clave]['CET_SELECTED'] = "";
			}
		}

		$gui_multi_slt_distribuidor = $this->render_regex_dict('MULTI_SLT_DIST', $gui_multi_slt_distribuidor, $distribuidor_unicom_collection);
		$gui_multi_slt_ceta = $this->render_regex_dict('MULTI_SLT_CET', $gui_multi_slt_ceta, $ceta_unicom_collection);
		$gui_lst_btn_distribuidor = $this->render_regex('BTN_DISTRIBUIDOR', $gui_lst_btn_distribuidor, $distribuidor_collection);
		$gui_lst_btn_ceta = $this->render_regex('BTN_CETA', $gui_lst_btn_ceta, $ceta_collection);

		$render = str_replace('{multi_slt_distribuidor}', $gui_multi_slt_distribuidor, $gui);
		$render = str_replace('{multi_slt_ceta}', $gui_multi_slt_ceta, $render);
		$render = str_replace('{lst_btn_distribuidor}', $gui_lst_btn_distribuidor, $render);
		$render = str_replace('{lst_btn_ceta}', $gui_lst_btn_ceta, $render);
		$render = $this->render($obj_mantenimientopreventivo, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($institucion_collection, $categoria_collection, $departamento_collection, $obj_mantenimientopreventivo) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/editar.html");
		$gui_slt_categoria = file_get_contents("static/modules/mantenimientopreventivo/slt_mantenimientocategoria.html");
		$gui_slt_institucion = file_get_contents("static/modules/mantenimientopreventivo/slt_mantenimientoinstitucion.html");
		$gui_slt_departamento = file_get_contents("static/modules/mantenimientopreventivo/multi_slt_departamento_editar.html");

		$obj_departamento_collection = $obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection;
		unset($obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection,
			  $obj_mantenimientopreventivo->distribuidor_collection,
			  $obj_mantenimientopreventivo->ceta_collection);

		$temp_departamento = array();
		foreach ($obj_departamento_collection as $departamento) $temp_departamento[] = $departamento->departamento_id;
		foreach ($departamento_collection as $clave=>$valor) {
			$departamento_id = $departamento_collection[$clave]->departamento_id;
			if (in_array($departamento_id, $temp_departamento)) {
				$departamento_collection[$clave]->selected = "selected";
			} else {
				$departamento_collection[$clave]->selected = "";
			}
		}

		$gui_slt_institucion = $this->render_regex('SLT_MANTENIMIENTOINSTITUCION', $gui_slt_institucion, $institucion_collection);
		$gui_slt_categoria = $this->render_regex('SLT_MANTENIMIENTOCATEGORIA', $gui_slt_categoria, $categoria_collection);
		$gui_slt_departamento = $this->render_regex('MULTI_SLT_DEPARTAMENTO', $gui_slt_departamento, $departamento_collection);

		$obj_mantenimientopreventivo->informe_checked_si = ($obj_mantenimientopreventivo->informe == 1) ? 'checked' : '';
		$obj_mantenimientopreventivo->informe_checked_no = ($obj_mantenimientopreventivo->informe == 1) ? '' : 'checked';
		$obj_mantenimientopreventivo = $this->set_dict($obj_mantenimientopreventivo);
		$render = $this->render($obj_mantenimientopreventivo, $gui);
		$render = str_replace('{slt_mantenimientoinstitucion}', $gui_slt_institucion, $render);
		$render = str_replace('{slt_mantenimientocategoria}', $gui_slt_categoria, $render);
		$render = str_replace('{slt_departamento}', $gui_slt_departamento, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar_coordenadas($coordenadas) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/editar_coordenadas.html");
		$lst_coordenada = file_get_contents("static/modules/mantenimientopreventivo/lst_coordenada_editar.html");

		if (is_array($coordenadas)) {
			foreach ($coordenadas as $clave=>$valor) {
				$array_coordenadas[$clave] = array("mantenimientopreventivo_id"=>$valor[$clave]['mantenimientopreventivo_id'],
												   "etiqueta"=>$valor[$clave]['etiqueta'],
												   "filcolor"=>$valor[$clave]['filcolor'],
												   "strockcolor"=>$valor[$clave]['strockcolor'],
												   "coordenadas"=> array());

				$var_coordenadas = Array();
				foreach ($valor as $c=>$v) {
					$var_coordenadas[] = array("latitud"=>$v['latitud'], "longitud"=>$v['longitud']);
				}

				$array_coordenadas[$clave]['coordenadas'] = $var_coordenadas;
			}

			$render_coordenada = '';
			$cod_lst_coordenada= $this->get_regex('LST_COORDENADA', $lst_coordenada);
			$array_coordenadas_sizeof = sizeof($array_coordenadas);
			foreach ($array_coordenadas as $clave=>$valor) {
				$cod_opt_coordenada = file_get_contents("static/modules/mantenimientopreventivo/opt_coordenada_editar.html");
				$titulo = $valor['etiqueta'];
				$coordenadas = $valor['coordenadas'];
				$filcolor = $valor['filcolor'];
				$strockcolor = $valor['strockcolor'];
				$i = $clave;
				unset($valor['coordenadas']);
				$lst_coordenada = $this->render($valor, $cod_lst_coordenada);

				$cod_option_coordenada = $this->get_regex('OPT_COORDENADA', $cod_opt_coordenada);
				$render_opcion_coordenada = '';
				foreach($coordenadas as $coordenada) {
					$opt_coordenada = $this->render($coordenada, $cod_option_coordenada);
					$render_opcion_coordenada .= $opt_coordenada;
				}

				$render_opcion_coordenada = str_replace('<!--OPT_COORDENADA-->', '', $render_opcion_coordenada);
				$render_opcion_coordenada = substr(trim($render_opcion_coordenada), 0, -1);
				$render_opcion_coordenada = str_replace($this->get_regex('OPT_COORDENADA', $cod_opt_coordenada), $render_opcion_coordenada, $cod_opt_coordenada);
				$render_opcion_coordenada = str_replace('{title}', $titulo, $render_opcion_coordenada);
				$render_opcion_coordenada = str_replace('{filcolor}', $filcolor, $render_opcion_coordenada);
				$render_opcion_coordenada = str_replace('{strockcolor}', $strockcolor, $render_opcion_coordenada);
				$lst_coordenada = str_replace('{lista_coordenadas}', $render_opcion_coordenada, $lst_coordenada);
				$render_coordenada .= $lst_coordenada;
			}

			$render_coordenada = str_replace('<!--LST_COORDENADA-->', '', $render_coordenada);
			$render_coordenada = substr(trim($render_coordenada), 0, -1);
			$render = str_replace('{lst_coordenada}', $render_coordenada, $gui);
			$render = str_replace('{mantenimientopreventivo_id}', $array_coordenadas[0]['mantenimientopreventivo_id'], $render);
			$render = str_replace('{display}', 'inline', $render);
		}else {
			$render = str_replace('{display}', 'none', $gui);
		}
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function consultar($coordenadas, $institucion_collection, $categoria_collection, $departamento_collection, $obj_mantenimientopreventivo) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/consultar.html");
		$lst_coordenada = file_get_contents("static/modules/mantenimientopreventivo/lst_coordenada.js");

		$mantenimientopreventivo_id = $obj_mantenimientopreventivo->mantenimientopreventivo_id;
		$departamento_collection = $obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection;
		$distribuidor_collection = $obj_mantenimientopreventivo->distribuidor_collection;
		$ceta_collection = $obj_mantenimientopreventivo->ceta_collection;
		unset($obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection, 
			  $obj_mantenimientopreventivo->distribuidor_collection,
			  $obj_mantenimientopreventivo->ceta_collection);

		$str_departamento = array();
		foreach ($departamento_collection as $clave=>$valor) $str_departamento[] = $valor->denominacion;
		$str_departamento = implode(" - ", $str_departamento);

		$obj_mantenimientopreventivo->aprobado = ($obj_mantenimientopreventivo->aprobado == 1) ? "Si" : "No";
		$obj_mantenimientopreventivo->informe = ($obj_mantenimientopreventivo->informe == 1) ? "Si" : "No";
		$obj_mantenimientopreventivo->departamentos = $str_departamento;

		$latitud = $obj_mantenimientopreventivo->mantenimientoubicacion->latitud;
		$longitud = $obj_mantenimientopreventivo->mantenimientoubicacion->longitud;
		$zoom = $obj_mantenimientopreventivo->mantenimientoubicacion->zoom;
		if ($latitud == '' OR $longitud == '' OR $zoom == '') {
			$latitud = '-29.4156342';
			$longitud = '-66.8679657';
			$zoom = '13';
		}

		$obj_mantenimientopreventivo = $this->set_dict($obj_mantenimientopreventivo);
		if(is_array($coordenadas)){
			$array_coordenadas = array();
			foreach ($coordenadas as $clave=>$valor) {
				$array_coordenadas[$clave] = array("mantenimientopreventivo_id"=>$valor[$clave]['mantenimientopreventivo_id'],
												   "etiqueta"=>$valor[$clave]['etiqueta'],
												   "filcolor"=>$valor[$clave]['filcolor'],
												   "strockcolor"=>$valor[$clave]['strockcolor'],
												   "coordenadas"=> array());

				$var_coordenadas = Array();
				foreach ($valor as $c=>$v) $var_coordenadas[] = array("latitud"=>$v['latitud'], "longitud"=>$v['longitud']);
				$array_coordenadas[$clave]['coordenadas'] = $var_coordenadas;
			}

			$render_coordenada = '';
			$cod_lst_coordenada= $this->get_regex('LST_COORDENADA', $lst_coordenada);

			foreach ($array_coordenadas as $clave=>$valor) {
				$cod_opt_coordenada = file_get_contents("static/modules/mantenimientopreventivo/opt_coordenada.html");
				$etiqueta = $valor['etiqueta'];
				$coordenadas = $valor['coordenadas'];
				$i = $clave;
				unset($valor['coordenadas']);
				$lst_coordenada = $this->render($valor, $cod_lst_coordenada);

				$cod_option_coordenada = $this->get_regex('OPT_COORDENADA', $cod_opt_coordenada);
				$render_opcion_coordenada = '';
				foreach($coordenadas as $coordenada) {
					$opt_coordenada = $this->render($coordenada, $cod_option_coordenada);
					$render_opcion_coordenada .= $opt_coordenada;
				}

				$render_opcion_coordenada = str_replace($this->get_regex('OPT_COORDENADA', $cod_opt_coordenada), $render_opcion_coordenada, $cod_opt_coordenada);
				$lst_coordenada = str_replace('{lista_coordenadas}', $render_opcion_coordenada, $lst_coordenada);
				$lst_coordenada = str_replace('{i}', $i, $lst_coordenada);
				$render_coordenada .= $lst_coordenada;
			}

			$render_coordenada = str_replace('<!--LST_COORDENADA-->', '', $render_coordenada);
			$render_coordenada = str_replace('<!--OPT_COORDENADA-->', '', $render_coordenada);
			$gui = str_replace('{latitud}', $latitud, $gui);
			$gui = str_replace('{longitud}', $longitud, $gui);
			$gui = str_replace('{zoom}', $zoom, $gui);
			$gui = str_replace('{lst_coordenada}', $render_coordenada, $gui);
		}

		$render = str_replace('{mantenimientopreventivo_id}', $mantenimientopreventivo_id, $gui);
		$render = $this->render($obj_mantenimientopreventivo, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function wsp_coordenadas($coordenadas){
		$gui = file_get_contents("static/modules/mantenimientopreventivo/wsp_coordenadas.html");
  		$lst_coordenada = file_get_contents("static/modules/mantenimientopreventivo/lst_coordenada.js");

    	if(is_array($coordenadas)){
      		$array_coordenadas = array();
      		foreach ($coordenadas as $clave=>$valor) {
        		$array_coordenadas[$clave] = array("mantenimientopreventivo_id"=>$valor[$clave]['mantenimientopreventivo_id'],
        										 "etiqueta"=>$valor[$clave]['etiqueta'],
        										 "filcolor"=>$valor[$clave]['filcolor'],
        										 "strockcolor"=>$valor[$clave]['strockcolor'],
        										 "coordenadas"=> array());

        		$var_coordenadas = Array();
        		foreach ($valor as $c=>$v) {
	         		$var_coordenadas[] = array("latitud"=>$v['latitud'], "longitud"=>$v['longitud']);
        		}
        		
        		$array_coordenadas[$clave]['coordenadas'] = $var_coordenadas;
      		}

      		$render_coordenada = '';
      		$cod_lst_coordenada= $this->get_regex('LST_COORDENADA', $lst_coordenada);

      		foreach ($array_coordenadas as $clave=>$valor) {
        		$cod_opt_coordenada = file_get_contents("static/modules/mantenimientopreventivo/opt_coordenada.html");
        		$coordenadas = $valor['coordenadas'];
        		$i = $clave;
        		unset($valor['coordenadas']);
        		$lst_coordenada = $this->render($valor, $cod_lst_coordenada);

        		$cod_option_coordenada = $this->get_regex('OPT_COORDENADA', $cod_opt_coordenada);
        		$render_opcion_coordenada = '';
        		foreach($coordenadas as $coordenada) {
          			$opt_coordenada = $this->render($coordenada, $cod_option_coordenada);
          			$render_opcion_coordenada .= $opt_coordenada;
        		}

        		$render_opcion_coordenada = str_replace($this->get_regex('OPT_COORDENADA', $cod_opt_coordenada), $render_opcion_coordenada, $cod_opt_coordenada);
        		$lst_coordenada = str_replace('{lista_coordenadas}', $render_opcion_coordenada, $lst_coordenada);
        		$lst_coordenada = str_replace('{i}', $i, $lst_coordenada);
        		$render_coordenada .= $lst_coordenada;
      		}

      		$render_coordenada = str_replace('<!--LST_COORDENADA-->', '', $render_coordenada);
      		$render_coordenada = str_replace('<!--OPT_COORDENADA-->', '', $render_coordenada);
      		$gui = str_replace('{lst_coordenada}', $render_coordenada, $gui);
    	}

		print $gui;
	}

	function wsp_consultar($obj_mantenimientopreventivo) {
    	$obj_mantenimientopreventivo->departamentos = array();
    	$obj_mantenimientopreventivo->hora_inicio = substr($obj_mantenimientopreventivo->hora_inicio, 0, 5);
    	$obj_mantenimientopreventivo->hora_fin = substr($obj_mantenimientopreventivo->hora_fin, 0, 5);
		foreach ($obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection as $departamento) {
            $obj_mantenimientopreventivo->departamentos[] = $departamento->denominacion;
        }

        $obj_mantenimientopreventivo->sector = $obj_mantenimientopreventivo->mantenimientoubicacion->sector;
        $obj_mantenimientopreventivo->calles = $obj_mantenimientopreventivo->mantenimientoubicacion->calles;
    	$obj_mantenimientopreventivo->departamentos = implode(' - ', $obj_mantenimientopreventivo->departamentos);
		$json = json_encode($obj_mantenimientopreventivo, JSON_UNESCAPED_UNICODE );
        echo $json;
	}

	function form_email_ajax($agenda_collection, $obj_mantenimientopreventivo) {
		$gui = file_get_contents("static/modules/mantenimientopreventivo/form_email_ajax.html");

    	$obj_mantenimientopreventivo->departamentos = array();
    	$obj_mantenimientopreventivo->hora_inicio = substr($obj_mantenimientopreventivo->hora_inicio, 0, 5);
    	$obj_mantenimientopreventivo->hora_fin = substr($obj_mantenimientopreventivo->hora_fin, 0, 5);
		foreach ($obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection as $departamento) {
            $obj_mantenimientopreventivo->departamentos[] = $departamento->denominacion;
        }

    	$obj_mantenimientopreventivo->departamentos = implode(' - ', $obj_mantenimientopreventivo->departamentos);
    	unset($obj_mantenimientopreventivo->distribuidor_collection,
    		  $obj_mantenimientopreventivo->ceta_collection,
    		  $obj_mantenimientopreventivo->mantenimientoubicacion->departamento_collection);

    	$obj_mantenimientopreventivo = $this->set_dict($obj_mantenimientopreventivo);
    	$render = $this->render_regex_dict('CHK_AGENDA', $gui, $agenda_collection);
    	$render = $this->render($obj_mantenimientopreventivo, $render);
    	$render = str_replace('{url_app}', URL_APP, $render);
        print $render;
	}
}
?>