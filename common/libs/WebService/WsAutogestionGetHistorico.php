<?php
require_once "Autogestion/clases/HttpHelper.php";
require_once "Autogestion/clases/Util.php";
require_once "Autogestion/clases/Peticiones.php";
require_once "Autogestion/historico.php";
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


class wsAutogestionGetHistoricoHelper {
	
	
	public function getPorNis($nis_id,$cliente_token) {
		$http = new HttpHelper("WsV10");
		$http->setUser("edelar01");
		$http->setPw("9183217388123012");
		$http->setServlet("GetHistoricoCliente");
		$http->agregarPeticion(Peticiones::NIS, $nis_id);
		$http->agregarPeticion(Peticiones::ID_CLIENTE_TOKEN, $cliente_token);
		$http->setMetodo(Peticionable::POST);
		$http->ejecutar();
		$historicos = array();
		if ($http->respuesta["haydatos"]) {
			if (!empty($http->respuesta["datos"])) {
			$historicos_std = $http->respuesta["datos"];
				foreach ($historicos_std as $historico_std) {
					$historico = wsHistorico::CastStd($historico_std);
					$historicos[] = $historico;
				}
			}
		}
		else{
			return "ERRORCODE_".$http->respuesta["flag_error"];
		}
		return $historicos;
	}
}
?>
