<?php
require_once "Autogestion/clases/HttpHelper.php";
require_once "Autogestion/clases/Util.php";
require_once "Autogestion/clases/Peticiones.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class WsAutogestionCheckRegistroUsuarioHelper {
	
	
	public function checkV10($nis,$dni,$email) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("CheckRegUsuario");
		$http->agregarPeticion(Peticiones::NIS, $nis);
		$http->agregarPeticion(Peticiones::DNI, $dni);
		$http->agregarPeticion(Peticiones::EMAIL, $email);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$respuesta = null;
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
				$respuesta = $http->respuesta["datos"];
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $respuesta;
	}
}
?>
