<?php


class BarrioView extends View {
	
	function panel($barrio_collection) {
		$gui = file_get_contents("static/modules/barrio/panel.html");
		$gui_tbl_barrio = file_get_contents("static/modules/barrio/tbl_barrio.html");
		$gui_tbl_barrio = $this->render_regex_dict('TBL_BARRIO', $gui_tbl_barrio, $barrio_collection);
		$render = str_replace('{tbl_barrio}', $gui_tbl_barrio, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function agregar($departamento_collection) {
		$gui = file_get_contents("static/modules/barrio/agregar.html");
		$gui_slt_departamento = file_get_contents("static/common/slt_departamento.html");
		$gui_slt_departamento = $this->render_regex('SLT_DEPARTAMENTO', $gui_slt_departamento, $departamento_collection);
		$render = str_replace('{slt_departamento}', $gui_slt_departamento, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}

	function editar($departamento_collection, $obj_barrio) {
		$gui = file_get_contents("static/modules/barrio/editar.html");
		$gui_slt_departamento = file_get_contents("static/common/slt_departamento.html");
		$gui_lst_coordenada = file_get_contents("static/modules/barrio/lst_coordenada.html");
		
		$coordenada_collection = $obj_barrio->coordenada_collection;
		$obj_barrio->fillcolor = $coordenada_collection[0]->fillcolor;
		$obj_barrio->strokecolor = $coordenada_collection[0]->strokecolor;
		$obj_barrio->etiqueta = $coordenada_collection[0]->etiqueta;
		unset($obj_barrio->coordenada_collection);
		
		$obj_barrio = $this->set_dict($obj_barrio);
		$gui_slt_departamento = $this->render_regex('SLT_DEPARTAMENTO', $gui_slt_departamento, $departamento_collection);
		$gui_lst_coordenada = $this->render_regex("LST_COORDENADA", $gui_lst_coordenada, $coordenada_collection);
		$gui_lst_coordenada = str_replace('<!--LST_COORDENADA-->', ' ', $gui_lst_coordenada);

		$render = str_replace('{slt_departamento}', $gui_slt_departamento, $gui);
		$render = str_replace('{lst_coordenada}', $gui_lst_coordenada, $render);
		$render = $this->render($obj_barrio, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}

	function consultar_barrios($barrio_collection) {
		$gui = file_get_contents("static/modules/barrio/consultar_barrios.html");
		$lst_coordenada = file_get_contents("static/modules/barrio/lst_coordenadas_todas.html");
		$cod_opt_coordenada = file_get_contents("static/modules/barrio/opt_coordenadas.html");

		foreach ($barrio_collection as $clave=>$valor) {
			$coordenada_collection = $valor->coordenada_collection;
			
			$var_coordenadas = Array();
			foreach ($coordenada_collection as $temp_coordenada) {
 			 	$var_coordenadas[] = array("latitud"=>$temp_coordenada->latitud, "longitud"=>$temp_coordenada->longitud);
			}

			$array_coordenadas[$clave] = array("barrio_id"=>$valor->barrio_id,
											   "latitud"=>$valor->latitud,
											   "longitud"=>$valor->longitud,
											   "etiqueta"=>$coordenada_collection[0]->etiqueta,
											   "filcolor"=>$coordenada_collection[0]->fillcolor,
											   "strockcolor"=>$coordenada_collection[0]->strokecolor,
											   "coordenadas"=> $var_coordenadas);
		}
		
		$render_coordenada = '';
		$cod_lst_coordenada= $this->get_regex('LST_COORDENADA', $lst_coordenada);
		$array_coordenadas_sizeof = sizeof($array_coordenadas);

		foreach ($array_coordenadas as $clave=>$valor) {
			$titulo = $valor['etiqueta'];
			$coordenadas = $valor['coordenadas'];
			$filcolor = $valor['filcolor'];
			$strockcolor = $valor['strockcolor'];
			$longitud = $valor['longitud'];
			$latitud = $valor['latitud'];
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
			$render_opcion_coordenada = str_replace('{latitud}', $latitud, $render_opcion_coordenada);
			$render_opcion_coordenada = str_replace('{longitud}', $longitud, $render_opcion_coordenada);
			$lst_coordenada = str_replace('{lista_coordenadas}', $render_opcion_coordenada, $lst_coordenada);
			$render_coordenada .= $lst_coordenada;
		}

		$render_coordenada = str_replace('<!--LST_COORDENADA-->', '', $render_coordenada);
		$render_coordenada = substr(trim($render_coordenada), 0, -1);

		$render = str_replace('{lst_coordenada}', $render_coordenada, $gui);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>