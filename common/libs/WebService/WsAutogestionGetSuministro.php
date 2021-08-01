<?php
require_once "Autogestion/clases/HttpHelper.php";
require_once "Autogestion/clases/Util.php";
require_once "Autogestion/clases/Peticiones.php";
require_once "Autogestion/suministro.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAutogestionGetSuministroHelper {
	
	
	public function getPorIdCliente($id) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("GetNis");
		$http->agregarPeticion(Peticiones::ID_CLIENTE, $id);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$suministros = array();
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
				$suministros_std = $http->respuesta["datos"];
				foreach ($suministros_std as $suministro_std) {
					$suministro = wsSuministro::CastStd($suministro_std);
					$suministros[] = $suministro;
				}
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $suministros;
	}
}
?>
