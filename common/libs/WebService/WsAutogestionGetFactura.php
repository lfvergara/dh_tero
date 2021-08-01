<?php
require_once "Autogestion/clases/HttpHelper.php";
require_once "Autogestion/clases/Util.php";
require_once "Autogestion/clases/Peticiones.php";
require_once "Autogestion/factura.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAutogestionGetFacturaHelper {
	
	public function listarFacturasNis($nis,$cliente_token){
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setTimeout(5);
		$http->regen();
		$http->setServlet("GetListaFacturas");
		$http->agregarPeticion(Peticiones::NIS, $nis);
		$http->agregarPeticion(Peticiones::ID_CLIENTE_TOKEN, $cliente_token);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$facturas = array();
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
				$facturas_std = $http->respuesta["datos"];
				foreach ($facturas_std as $factura_std) {
					$factura = wsFactura::CastStd($factura_std);
					$facturas[] = $factura;
				}
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $facturas;
	}
	
	public function factura($id,$cliente_token) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setTimeout(10);
		$http->setServlet("GetFactura");
		$http->agregarPeticion(Peticiones::ID_DEUDA, $id);
		$http->agregarPeticion(Peticiones::ID_CLIENTE_TOKEN, $cliente_token);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutarArchivo();
		$r = $http->respuesta_archivo;
		$datos = Util::comprobarRespuestaDatos($r);
		$flag_haydatos = $datos['haydatos'];
		if($flag_haydatos){
			return $r;
		}
		else{
			die("ERRORCODE_".$http->respuesta["flag_error"]);
		}
	}

	public function nisPeriodo($nis,$periodo,$cliente_token) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setTimeout(10);
		$http->setServlet("GetFactura");
		$http->agregarPeticion(Peticiones::NIS, $nis);
		$http->agregarPeticion(Peticiones::PERIODO, $periodo);
		$http->agregarPeticion(Peticiones::ID_CLIENTE_TOKEN, $cliente_token);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutarArchivo();
		if ($http->respuesta["haydatos"]) {
			$headers = $http->getHeadersRespuesta();
			$tamtmp = $headers[6];
			$tam = explode(" ", $tamtmp);
			$crc = $headers[8];
			$resp = array();
			$resp ["archivo"] = $http->respuesta_archivo;
			$resp ["crc"] = $crc;
			$resp ["size"] = trim($tam[1]);
			return $resp;
		}
		else {
			die("ERRORCODE_".$http->respuesta["flag_error"]);
		}
	}
}
?>
