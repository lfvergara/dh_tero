<?php
require_once "Externos/clases/HttpHelper.php";
require_once "Externos/clases/Util.php";
require_once "Externos/clases/Peticiones.php";
require_once "Externos/deuda.php";
require_once "Externos/cliente.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAgenteExternoGetDeudaHelper {
	public function suministro($suministro) { 
		$http = new HttpHelper("WsExternos");
		$http->setUser("externo01");
		$http->setPw("092348230947256");
		$http->setServlet("GetDeuda");
		$http->agregarPeticion(Peticiones::NIS, $suministro);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();

		if ($http->respuesta["haydatos"]) {
			$cliente = null;
			$deudas = array();
			$tamr = count($http->respuesta["datos"]);
			if ($tamr > 1) {
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
			header("Location: " . URL_APP . "/sitio/error_deuda/{$flag_error}");
		}
        
	}

	public function documento($documento) { 
		$http = new HttpHelper("WsExternos");
		$http->setUser("externo01");
		$http->setPw("092348230947256");
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