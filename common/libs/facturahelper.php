<?php

class FacturaHelper {
	private $NIS = "";
	private $ARCHIVOS="";

	function FacturaHelper($nis){
		$this->NIS = $nis;
	}

	public function validarNIS(){
		$archivosasd = $this->readService();
		if ($archivosasd!="<result></result>") {
			$this->ARCHIVOS = $archivosasd;
			return true;
		}
		else{
			return false;
		}	
	}

	public function getArchivos(){
		return $this->ARCHIVOS;

	}

	private function parseArchivo($mvalues){
		for ($i=0; $i < count($mvalues); $i++) {
			$mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
		}
		return new Archivo($mol);
	}

	private function readService(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => "http://provider:123456@200.91.37.167:9190/FacturaProvider/query?nis=".$this->NIS,
			CURLOPT_USERAGENT => 'Edelar Service'
		));
		$archivohttp = curl_exec($curl);
		curl_close($curl);
		$archivohttp;
		return $archivohttp;
	}
}

?>