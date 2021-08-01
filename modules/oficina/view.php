<?php


class OficinaView extends View {

	function panel($oficina_collection, $unicom_collection) {
		$gui = file_get_contents("static/modules/oficina/panel.html");
		$gui_tbl_oficina = file_get_contents("static/modules/oficina/tbl_oficina.html");
		$gui_slt_unicom = file_get_contents("static/common/slt_unicom.html");
		
		$gui_tbl_oficina = $this->render_regex('TBL_OFICINA', $gui_tbl_oficina, $oficina_collection);
		$gui_slt_unicom = $this->render_regex('SLT_UNICOM', $gui_slt_unicom, $unicom_collection);

		$render = str_replace('{slt_unicom}', $gui_slt_unicom, $gui);
		$render = str_replace('{tbl_oficina}', $gui_tbl_oficina, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($oficina_collection, $unicom_collection, $obj_oficina) {
		$gui = file_get_contents("static/modules/oficina/editar.html");
		$gui_tbl_oficina = file_get_contents("static/modules/oficina/tbl_oficina.html");
		$gui_slt_unicom = file_get_contents("static/common/slt_unicom.html");

		$gui_tbl_oficina = $this->render_regex('TBL_OFICINA', $gui_tbl_oficina, $oficina_collection);
		$gui_slt_unicom = $this->render_regex('SLT_UNICOM', $gui_slt_unicom, $unicom_collection);

		$obj_oficina->oficinadia->lunes_checked = ($obj_oficina->oficinadia->lunes == 1) ? 'checked' : '';
		$obj_oficina->oficinadia->martes_checked = ($obj_oficina->oficinadia->martes == 1) ? 'checked' : '';
		$obj_oficina->oficinadia->miercoles_checked = ($obj_oficina->oficinadia->miercoles == 1) ? 'checked' : '';
		$obj_oficina->oficinadia->jueves_checked = ($obj_oficina->oficinadia->jueves == 1) ? 'checked' : '';
		$obj_oficina->oficinadia->viernes_checked = ($obj_oficina->oficinadia->viernes == 1) ? 'checked' : '';
		$obj_oficina->oficinadia->sabado_checked = ($obj_oficina->oficinadia->sabado == 1) ? 'checked' : '';
		$obj_oficina->oficinadia->domingo_checked = ($obj_oficina->oficinadia->domingo == 1) ? 'checked' : '';

		unset($obj_oficina->configuracionturnero_collection);
		$obj_oficina = $this->set_dict($obj_oficina);
		
		$render = str_replace('{slt_unicom}', $gui_slt_unicom, $gui);
		$render = str_replace('{tbl_oficina}', $gui_tbl_oficina, $render);
		$render = $this->render($obj_oficina, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function configuracion_turnero($oficina_collection, $rangoturnero_collection) {
		$gui = file_get_contents("static/modules/oficina/configuracion_turnero.html");
		$gui_tbl_configurar_turnero_oficina = file_get_contents("static/modules/oficina/tbl_configurar_turnero_oficina.html");
		$gui_tbl_rangoturnero = file_get_contents("static/modules/oficina/tbl_rangoturnero.html");

		$tmp_array = array();
		foreach ($oficina_collection as $clave=>$valor) $tmp_array[] = $valor->oficina_id;		
		$array_oficinas = implode(',', $tmp_array);

		foreach ($rangoturnero_collection as $clave=>$valor) {
			$rangoturnero_collection[$clave]->fecha_desde = $this->reacomodar_fecha($valor->fecha_desde);
			$rangoturnero_collection[$clave]->fecha_hasta = $this->reacomodar_fecha($valor->fecha_hasta);
			$rangoturnero_collection[$clave]->icon_estado = ($valor->estado == 0) ? "close" : "check";
			$rangoturnero_collection[$clave]->class_estado = ($valor->estado == 0) ? "danger" : "success";			
			
			$rangoturnero_collection[$clave]->argumento_rango_activar = ($valor->estado == 0) ? 1 : 0;
			$rangoturnero_collection[$clave]->icon_rango_activar = ($valor->estado == 0) ? 'arrow-circle-up' : 'arrow-circle-down';
			$rangoturnero_collection[$clave]->class_rango_activar = ($valor->estado == 0) ? 'success' : 'danger';
			$rangoturnero_collection[$clave]->title_rango_activar = ($valor->estado == 0) ? 'Activar' : 'Desactivar';
		}

		$gui_tbl_configurar_turnero_oficina = $this->render_regex('TBL_OFICINA', $gui_tbl_configurar_turnero_oficina, $oficina_collection);
		$gui_tbl_rangoturnero = $this->render_regex('TBL_RANGOTURNERO', $gui_tbl_rangoturnero, $rangoturnero_collection);
		$render = str_replace('{tbl_oficina}', $gui_tbl_configurar_turnero_oficina, $gui);
		$render = str_replace('{array_oficinas}', $array_oficinas, $render);
		$render = str_replace('{tbl_rangoturnero}', $gui_tbl_rangoturnero, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function consultar_rango($oficina_collection, $rangoturnero_collection, $obj_rangoturnero) {
		$gui = file_get_contents("static/modules/oficina/consultar_rango.html");
		$gui_tbl_oficinarango = file_get_contents("static/modules/oficina/tbl_oficinarango.html");
		$gui_tbl_rangoturnero = file_get_contents("static/modules/oficina/tbl_rangoturnero.html");

		foreach ($rangoturnero_collection as $clave=>$valor) {
			$rangoturnero_collection[$clave]->fecha_desde = $this->reacomodar_fecha($valor->fecha_desde);
			$rangoturnero_collection[$clave]->fecha_hasta = $this->reacomodar_fecha($valor->fecha_hasta);
			$rangoturnero_collection[$clave]->icon_estado = ($valor->estado == 0) ? "close" : "check";
			$rangoturnero_collection[$clave]->class_estado = ($valor->estado == 0) ? "danger" : "success";			
			
			$rangoturnero_collection[$clave]->argumento_rango_activar = ($valor->estado == 0) ? 1 : 0;
			$rangoturnero_collection[$clave]->icon_rango_activar = ($valor->estado == 0) ? 'arrow-circle-up' : 'arrow-circle-down';
			$rangoturnero_collection[$clave]->class_rango_activar = ($valor->estado == 0) ? 'success' : 'danger';
			$rangoturnero_collection[$clave]->title_rango_activar = ($valor->estado == 0) ? 'Activar' : 'Desactivar';
		}

		$obj_rangoturnero->denominacion_estado = ($obj_rangoturnero->estado == 0) ? 'RANGO INACTIVO' : 'RANGO ACTIVO';
		$obj_rangoturnero->color_estado = ($obj_rangoturnero->estado == 0) ? '#c9302c' : '#398439';
		$obj_rangoturnero->fecha_desde = $this->reacomodar_fecha($obj_rangoturnero->fecha_desde);
		$obj_rangoturnero->fecha_hasta = $this->reacomodar_fecha($obj_rangoturnero->fecha_hasta);
		$gui_tbl_oficinarango = $this->render_regex_dict('TBL_OFICINA', $gui_tbl_oficinarango, $oficina_collection);
		$gui_tbl_rangoturnero = $this->render_regex('TBL_RANGOTURNERO', $gui_tbl_rangoturnero, $rangoturnero_collection);
		$obj_rangoturnero = $this->set_dict($obj_rangoturnero);
		$render = str_replace('{tbl_oficina}', $gui_tbl_oficinarango, $gui);
		$render = str_replace('{tbl_rangoturnero}', $gui_tbl_rangoturnero, $render);
		$render = $this->render($obj_rangoturnero, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}
}
?>