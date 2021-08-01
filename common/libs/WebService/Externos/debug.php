<?php
require_once dirname(__FILE__)."/clases/HttpHelper.php";
require_once dirname(__FILE__)."/clases/Peticiones.php";
require_once dirname(__FILE__)."/clases/Util.php";
require_once dirname(__FILE__)."/deuda.php";
require_once dirname(__FILE__)."/cliente.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if (!empty($argv[1]) && !empty($argv[2])){
$busqueda = $argv[1];
$valor = $argv[2];
if ($busqueda == "dni"){
	$http = new HttpHelper("WsExternos");
	$http->setUser("externo01");
	$http->setPw("092348230947256");
	
	$http->setProtocolo("http");
	$http->setServer("localhost");
	$http->setPuerto("7080");
	$http->Debug(true);
	$http->Consola(true);
	$http->regen();
	
	$http->setServlet("GetDeuda");
	$http->agregarPeticion(Peticiones::DNI, $valor);
	$http->setMetodo(Peticionable::POST);
	$http->ejecutar();
}
if ($busqueda == "nis"){
	$http = new HttpHelper("WsExternos");
	$http->setUser("externo01");
	$http->setPw("092348230947256");
	
	$http->setProtocolo("http");
	$http->setServer("localhost");
	$http->setPuerto("7080");
	$http->Debug(true);
	$http->Consola(true);
	$http->regen();
	
	$http->setServlet("GetDeuda");
	$http->agregarPeticion(Peticiones::NIS, $valor);
	$http->setMetodo(Peticionable::POST);
	$http->ejecutar();
}
$flag_haydatos = $http->respuesta["haydatos"];

if ($flag_haydatos){
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
	}
	else{
		$cliente_std = $http->respuesta["datos"][0]->cliente;
		$cliente = wsCliente::CastStd($cliente_std);
	}
	$datos = array('cliente' => $cliente , 'deudas' => $deudas);
	echo Util::respuestaJSON($datos);
}

}

?>