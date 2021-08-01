<?php
require_once "Geco/clases/HttpHelper.php";
require_once "Geco/clases/Util.php";
require_once "Geco/clases/Peticiones.php";
require_once "Geco/deuda.php";
require_once "Geco/cliente.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAgenteExternoGetDeudaHelper {
	public function suministro($suministro) { 
		$http = new HttpHelper("WsGeco");
		$http->setUser("geco01");
		$http->setPw("983458734623049");
		$http->setServlet("GetDeuda");
		$http->agregarPeticion(Peticiones::NIS, $suministro);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();

		if ($http->respuesta["haydatos"]) {
			$cliente = null;
			$deudas = array();
			$tamr = count($http->respuesta["datos"]);
			if ($tamr > 1){
			$deudas_std = $http->respuesta["datos"][0];
			$cliente_std = $http->respuesta["datos"][1]->cliente;
			$cliente = wsCliente::CastStd($cliente_std);
			$deudas = array();
			foreach ($deudas_std as $deuda_std) {
				$deuda = wsDeuda::CastStd($deuda_std);
				$deudas[] = $deuda;
			}
			} else {
				$cliente_std = $http->respuesta["datos"][0]->cliente;
				$cliente = wsCliente::CastStd($cliente_std);
			}
			$datos = array('cliente' => $cliente , 'deuda_collection' => $deudas);
			return $datos;
		} else {
			$flag_error = $http->respuesta["flag_error"];
			header("Location: " . URL_APP . "/agenteexterno/deuda_cliente/{$flag_error}");
		}
        
	}

	public function documento($documento) { 
		$http = new HttpHelper("WsGeco");
		$http->setUser("geco01");
		$http->setPw("983458734623049");
		$http->setServlet("GetDeuda");
		$http->agregarPeticion(Peticiones::DNI, $documento);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
        
        if ($http->respuesta["haydatos"]) {
			$cliente = null;
			$deudas = array();
			$tamr = count($http->respuesta["datos"]);
			if ($tamr > 1){
			$deudas_std = $http->respuesta["datos"][0];
			$cliente_std = $http->respuesta["datos"][1]->cliente;
			$cliente = wsCliente::CastStd($cliente_std);
			$deudas = array();
			foreach ($deudas_std as $deuda_std) {
				$deuda = wsDeuda::CastStd($deuda_std);
				$deudas[] = $deuda;
			}
			} else {
				$cliente_std = $http->respuesta["datos"][0]->cliente;
				$cliente = wsCliente::CastStd($cliente_std);
			}
			$datos = array('cliente' => $cliente , 'deuda_collection' => $deudas);
			return $datos;
		} else {
			$flag_error = $http->respuesta["flag_error"];
			header("Location: " . URL_APP . "/agenteexterno/deuda_cliente/{$flag_error}");
		}
        
	}
}
?>