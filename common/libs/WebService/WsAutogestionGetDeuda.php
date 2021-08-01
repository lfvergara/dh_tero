<?php
require_once "Autogestion/clases/HttpHelper.php";
require_once "Autogestion/clases/Util.php";
require_once "Autogestion/clases/Peticiones.php";
require_once "Autogestion/deuda.php";
require_once "Autogestion/deudapub.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAutogestionGetDeudaHelper {
	
	
	public function cliente($cliente_id) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("GetDeudaCliente");
		$http->agregarPeticion(Peticiones::ID_CLIENTE, $cliente_id);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$deudas = array();
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
			$deudas_std = $http->respuesta["datos"];
				foreach ($deudas_std as $deuda_std) {
					$deuda = wsDeuda::CastStd($deuda_std);
					$deudas[] = $deuda;
				}
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $deudas;
	}

	public function nis($nis_id) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("GetDeudaPub");
		$http->agregarPeticion(Peticiones::NIS, $nis_id);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$deudas = array();
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
			$deudas_std = $http->respuesta["datos"];
				foreach ($deudas_std as $deuda_std) {
					$deuda = wsDeudaPublica::CastStd($deuda_std);
					$deudas[] = $deuda;
				}
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $deudas;
	}

	public function dni($dni) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("GetDeudaPubDni");
		$http->agregarPeticion(Peticiones::DNI, $nis_id);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$deudas = array();
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
			$deudas_std = $http->respuesta["datos"];
				foreach ($deudas_std as $deuda_std) {
					$deuda = wsDeudaPublica::CastStd($deuda_std);
					$deudas[] = $deuda;
				}
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $deudas;
	}
}
?>
