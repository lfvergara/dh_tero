<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__FILE__)."/clases/HttpHelper.php";
require_once dirname(__FILE__)."/clases/Peticiones.php";
require_once dirname(__FILE__)."/deuda.php";
require_once dirname(__FILE__)."/deudapub.php";
require_once dirname(__FILE__)."/cliente.php";
require_once dirname(__FILE__)."/factura.php";

if (!empty($argv[1]) && !empty($argv[2])){
$busqueda = $argv[1];
$valor = $argv[2];
$valor2 = $argv[3];

	if ($busqueda == "deudaidcliente"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		//$http->setProtocolo("http");
		//$http->setServer("localhost");
		//$http->setPuerto("7080");
		$http->Debug(false);
		$http->Consola(true);
		//$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("GetDeudaCliente");
		$http->agregarPeticion(Peticiones::ID_CLIENTE, $valor);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
	}
	
	if ($busqueda == "xmlfactura"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		//$http->setProtocolo("http");
		//$http->setServer("localhost");
		//$http->setPuerto("7080");
		$http->Debug(true);
		$http->Consola(true);
		$http->esArchivo(true);
		//$http->loguear(false);
		$http->setTimeout(10);

		$http->regen();
	
		$http->setServlet("GetFactura");
		$http->agregarPeticion(Peticiones::ID_XML, $valor);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		echo $http->getHeaders();
		//$fp = fopen('pdftest.pdf', 'w');
		//fwrite($fp, $http->respuesta_raw);
		//fclose($fp);
	}
	
	if ($busqueda == "xmlperiodos"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		$http->setProtocolo("http");
		$http->setServer("localhost");
		$http->setPuerto("7080");
		$http->Debug(true);
		$http->Consola(true);
		$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("GetListaFacturas");
		$http->agregarPeticion(Peticiones::NIS, $valor);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
	}
	
	if ($busqueda == "xmlfacturanisperiodo"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		//$http->setProtocolo("http");
		//$http->setServer("localhost");
		//$http->setPuerto("7080");
		$http->Debug(false);
		$http->Consola(true);
		//$http->loguear(false);
		$http->setTimeout(10);

		$http->regen();
	
		$http->setServlet("GetFactura");
		$http->agregarPeticion(Peticiones::NIS, $valor);
		$http->agregarPeticion(Peticiones::PERIODO, $valor2);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutarArchivo();
		$fp = fopen('pdftest.pdf', 'w');
		fwrite($fp, $http->respuesta_archivo);
		fclose($fp);
	}
	
	if ($busqueda == "validareg"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		$http->setProtocolo("http");
		$http->setServer("localhost");
		$http->setPuerto("7080");
		$http->Debug(true);
		$http->Consola(true);
		$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("CheckRegUsuario");
		$http->agregarPeticion(Peticiones::NIS, '1022438');
		$http->agregarPeticion(Peticiones::DNI, '35500741');
		$http->agregarPeticion(Peticiones::EMAIL, 'jorgtledo@gmail.co');
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
	}

	if ($busqueda == "clienteporid"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		$http->setProtocolo("http");
		$http->setServer("localhost");
		$http->setPuerto("7080");
		$http->Debug(true);
		$http->Consola(true);
		$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("GetCliente");
		$http->agregarPeticion(Peticiones::ID_CLIENTE, $valor);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
	}

	if ($busqueda == "nisporidcliente"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		//$http->setProtocolo("http");
		//$http->setServer("localhost");
		//$http->setPuerto("7080");
		$http->Debug(true);
		$http->Consola(true);
		//$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("GetNis");
		$http->agregarPeticion(Peticiones::ID_CLIENTE, $valor);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
	}

	if ($busqueda == "idfactura"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
	
		//$http->setProtocolo("http");
		//$http->setServer("localhost");
		//$http->setPuerto("7080");
		$http->Debug(false);
		$http->Consola(true);
		//$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("GetFactura");
		$http->agregarPeticion(Peticiones::ID_FACTURA, $valor);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
	}

	if ($busqueda == "nis"){
		$http = new HttpHelper("WsAutogestion");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");

		//$http->setProtocolo("http");
		//$http->setServer("localhost");
		//$http->setPuerto("7080");
		//$http->setServer("172.18.0.25");
		//$http->setPuerto("8090");
		$http->Debug(false);
		$http->Consola(true);
		$http->loguear(false);
		$http->setTimeout(5);

		$http->regen();
	
		$http->setServlet("GetDeudaPub");
		$http->agregarPeticion(Peticiones::NIS, $valor);
		$http->ejecutar();
	}

	if ($http->respuesta["haydatos"]){
		if($busqueda == "deudaidcliente" || $busqueda == "nis"){
			$deudas = array();
			if (!empty($http->respuesta["datos"])){
				$deudas_std = $http->respuesta["datos"];
				foreach ($deudas_std as $deuda_std) {
					if($busqueda == "deudaidcliente"){
						$deuda = wsDeuda::CastStd($deuda_std);
					}
					if ($busqueda == "nis"){
						$deuda = wsDeudaPublica::CastStd($deuda_std);
					}
					$deudas[] = $deuda;
				}
			}
			$hora = new DateTime(null, new DateTimeZone('America/Argentina/La_Rioja'));
			$datestring = date_format($hora, 'H:i:s m/d/Y');
			$datos = array('deudas' => $deudas);
			foreach ($deudas as $deuda) {
				echo "NIS: ".$deuda->suministro->id." TOTAL $".$deuda->importe_total."\n";
			}
			echo "---------------------------".$datestring."\n";
			//echo Util::respuestaJSON($datos);
		}
		if($busqueda == "clienteporid"){
			$cliente_std = $http->respuesta["datos"]->cliente;
			$cliente = wsCliente::CastStd($cliente_std);
			var_dump($cliente);
		}
		if($busqueda == "validareg"){
			$cod = $http->respuesta["datos"];
			var_dump($cod);
		}
		if($busqueda == "xmlperiodos"){
			$facturas = array();
			$facturas_std = $http->respuesta["datos"];
				foreach ($facturas_std as $factura_std) {
					$factura = wsFactura::CastStd($factura_std);
					$facturas[] = $factura;
				}
			$datos = array('facturas' => $facturas);
			echo Util::respuestaJSON($datos);
		}
	}
	else{
		$error_texto=Util::getTextoCodigo($http->respuesta["flag_error"]);
		echo $error_texto;
	}

}
else{
	echo "Error: usar php debub.php op valor\n";
}

?>