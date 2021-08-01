<?php
require_once "Autogestion/clases/HttpHelper.php";
require_once "Autogestion/clases/Util.php";
require_once "Autogestion/clases/Peticiones.php";
require_once "Autogestion/cliente.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAutogestionGetClienteHelper {
	
	
	public function getPorId($id) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("GetCliente");
		$http->agregarPeticion(Peticiones::ID_CLIENTE, $id);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$cliente = null;
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
				$cliente_std = $http->respuesta["datos"]->cliente;
				$cliente = wsCliente::CastStd($cliente_std);
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $cliente;
	}
}
?>
