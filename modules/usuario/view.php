<?php


class UsuarioView extends View {
	
	function login($arg) {
		$template = $this->render_login();
		if ($arg == "mError")  {
			$gui_mError = file_get_contents("static/modules/usuario/mError.html");	
			$template = str_replace("{gui_mError}", $gui_mError, $template);
		} else {
			$template = str_replace("{gui_mError}", "", $template);
		}
		print $template;
	}

	function agregar($usuario_collection, $configuracionmenu_collection) {
		$gui = file_get_contents("static/modules/usuario/agregar.html");
		$tbl_usuario = file_get_contents("static/modules/usuario/tbl_usuario.html");
		$slt_configuracionmenu = file_get_contents("static/modules/usuario/slt_configuracionmenu.html");
		
		$tbl_usuario = $this->render_regex_dict('TBL_USUARIO', $tbl_usuario, $usuario_collection);
		$configuracionmenu_collection = $this->order_collection_array($configuracionmenu_collection, 'DENOMINACION', SORT_ASC);
		$slt_configuracionmenu = $this->render_regex_dict('SLT_CONFIGURACIONMENU', $slt_configuracionmenu, $configuracionmenu_collection);

		$render = str_replace('{tbl_usuario}', $tbl_usuario, $gui);
		$render = str_replace('{slt_configuracionmenu}', $slt_configuracionmenu, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;
	}

	function editar($usuario_collection, $configuracionmenu_collection, $usuario) {
		$gui = file_get_contents("static/modules/usuario/editar.html");
		$tbl_usuario = file_get_contents("static/modules/usuario/tbl_usuario.html");
		$slt_configuracionmenu = file_get_contents("static/modules/usuario/slt_configuracionmenu.html");

		$tbl_usuario = $this->render_regex_dict('TBL_USUARIO', $tbl_usuario, $usuario_collection);
		$configuracionmenu_collection = $this->order_collection_array($configuracionmenu_collection, 'DENOMINACION', SORT_ASC);
		$slt_configuracionmenu = $this->render_regex_dict('SLT_CONFIGURACIONMENU', $slt_configuracionmenu, $configuracionmenu_collection);
		
		$usuario_nivel = $usuario->nivel;
		$nivel_denominacion = ($usuario_nivel == 1) ? "Operador" : "";
		$nivel_denominacion = ($usuario_nivel == 2) ? "Analista" : $nivel_denominacion;
		$nivel_denominacion = ($usuario_nivel == 3) ? "Administrador" : $nivel_denominacion;
		$nivel_denominacion = ($usuario_nivel == 9) ? "Desarrollador" : $nivel_denominacion;
		$usuario->nivel_denominacion = $nivel_denominacion;
		unset($usuario->configuracionmenu->submenu_collection, $usuario->configuracionmenu->item_collection);
		$usuario = $this->set_dict($usuario);
		$render = str_replace('{tbl_usuario}', $tbl_usuario, $gui);
		$render = str_replace('{slt_configuracionmenu}', $slt_configuracionmenu, $render);
		$render = $this->render($usuario, $render);
		$render = $this->render_breadcrumb($render);
		$template = $this->render_template($render);
		print $template;	
	}

	function perfil() {
		$gui = file_get_contents("static/modules/usuario/perfil.html");
		$dict_perfil = array(
			"{usuario-usuario_id}"=>$_SESSION["data-login-" . APP_ABREV]["usuario-usuario_id"],
			"{usuario-denominacion}"=>$_SESSION["data-login-" . APP_ABREV]["usuario-denominacion"],
			"{usuario-nombre}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-nombre"],
			"{usuario-apellido}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-apellido"],
			"{usuario-nivel}"=>$_SESSION["data-login-" . APP_ABREV]["nivel-denominacion"],
			"{usuario-rol}"=>$_SESSION["data-login-" . APP_ABREV]["configuracionmenu-denominacion"],
			"{usuariodetalle-correoelectronico}"=>$_SESSION["data-login-" . APP_ABREV]["usuariodetalle-correoelectronico"]);
		$render = $this->render($dict_perfil, $gui);
		$template = $this->render_template($render);
		print $template;
	}

	function administrador() {
		$gui = file_get_contents("static/modules/usuario/administrador.html");
		$template = $this->render_template($gui);
		print $template;
	}
}
?>