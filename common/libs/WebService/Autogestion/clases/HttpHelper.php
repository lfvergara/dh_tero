<?php
require_once "PeticionableInterface.php";
require_once "Peticion.php";
require_once "JwtProtocolo.php";
require_once "Errores.php";
include_once "config.php";
require_once "Util.php";


Class HttpHelper implements Peticionable {

	private $SERVER;
	private $PROTOCOLO;
	private $PUERTO;
	private $user_agent;
	private $servicio_nombre;
	private $url_conexion;
	private $servlet;
	private $metodo;
	public  $respuesta;
	public 	$respuesta_raw;
	public 	$respuesta_archivo;
	private $user_agent_cliente;
	private $cliente_curl;
	private $peticiones;
	private $debug;
	private $headers_respuesta;
	private $consola;
	private $archivo;
	private $log;
	private $timeout;
	private $ip;
	private $user;
	private $pass;
	private $CA_PATH;

	public function __construct($s){
		$this->servicio_nombre = $s;
		$this->PROTOCOLO = "https";
		$this->SERVER = servidor;
		$this->PUERTO = puerto;
		$this->user_agent = "EdelarWS 1.1";
		$this->url_conexion = $this->PROTOCOLO."://".$this->SERVER.":".$this->PUERTO."/".$this->servicio_nombre."/";
		$this->peticiones = array();
		$this->setCaPath(HTTPS_CA_PATH);
		$this->metodo = Peticionable::POST;
		$this->debug = false;
		$this->consola = false;
		$this->log = true;
		$this->timeout = timeout_connection;
		$this->ip = "";
		$this->user = "";
		$this->pass = "";
		$this->servlet = "";
		$this->user_agent_cliente = "";
		$this->headers_respuesta = "";
		$this->archivo = false;
	}
	
	public function getHeadersRespuesta(){
		return $this->headers_respuesta;
	}

	public function regen(){
		$this->url_conexion = $this->PROTOCOLO."://".$this->SERVER.":".$this->PUERTO."/".$this->servicio_nombre."/";
		$this->peticiones = array();
	}

	public function setServer($sv){
		$this->SERVER = $sv;
	}

	public function loguear($l){
		$this->log = $l;
	}

	public function setTimeout($to){
		$this->timeout = $to * 1000;
	}
	
	public function setCaPath($path){
		$this->CA_PATH = $path;
	}
	
	public function setUser($u){
		$this->user = $u;
	}
	
	public function setPw($p){
		$this->pass = $p;
	}
	
	public function Debug($d){
		$this->debug = $d;
	}

	public function Consola($c){
		$this->consola = $c;
	}

	public function setProtocolo($proto){
		$this->PROTOCOLO = $proto;
	}

	public function setPuerto($puerto){
		$this->PUERTO = $puerto;
	}

	public function agregarPeticion($parametro, $valor){
		$peticion = new Peticion();
		$peticion->setParametro($parametro);
		$peticion->setValor($valor);
		$peticiones = array_push($this->peticiones,$peticion);
	}

	public function limpiarPeticiones(){
		$this->peticiones = array();
	}

	public function setServlet($serv){
		$this->servlet = $serv;
	}

	public function setMetodo($m){
		$this->metodo = $m;
	}

	public function ejecutar(){
		$this->cliente_curl = curl_init();
		$jwt = new JwtProtocolo();
		$token = $jwt->autenticar($this->user, $this->pass);
		curl_setopt_array($this->cliente_curl,array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => $this->user_agent, CURLOPT_TIMEOUT => $this->timeout, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSLVERSION=> 6, CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_CAINFO => $this->CA_PATH, CURLOPT_VERBOSE => $this->debug));	
		$this->ip = "";
		if($this->consola){
			$this->ip = ip_servidor;
			$this->user_agent_cliente = PHP_OS;
		}
		else{
			$this->ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
			$this->user_agent_cliente = $_SERVER['HTTP_USER_AGENT'];
		}
		curl_setopt($this->cliente_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"auth-token: $token","ip-origen:".$this->ip));
		switch ($this->metodo) {
			case Peticionable::POST:
				$this->enviarPost();
				break;
			case Peticionable::GET:
				$this->enviarGet();
				break;
			case Peticionable::DELETE:
				$this->enviarPut();
				break;
			case Peticionable::PUT:
				$this->enviarDelete();
				break;
			default:
				break;
		}

	}
	
	public function ejecutarArchivo(){
		$this->archivo = true;
		$this->cliente_curl = curl_init();
		$jwt = new JwtProtocolo();
		$token = $jwt->autenticar($this->user, $this->pass);
		curl_setopt_array($this->cliente_curl,array(CURLOPT_TCP_KEEPALIVE => 1, CURLOPT_HEADER => 1, CURLOPT_TCP_KEEPIDLE => 2, CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => $this->user_agent, CURLOPT_TIMEOUT => $this->timeout, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSLVERSION=> 6, CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_CAINFO => $this->CA_PATH, CURLOPT_VERBOSE => $this->debug));
		$this->ip = "";
		if($this->consola){
			$this->ip = ip_servidor;
			$this->user_agent_cliente = PHP_OS;
		}
		else{
			$this->ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
			$this->user_agent_cliente = $_SERVER['HTTP_USER_AGENT'];
		}
		curl_setopt($this->cliente_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/octet-stream',"auth-token: $token","ip-origen:".$this->ip));
		switch ($this->metodo) {
			case Peticionable::POST:
				$this->enviarPost();
				break;
			case Peticionable::GET:
				$this->enviarGet();
				break;
			case Peticionable::DELETE:
				$this->enviarPut();
				break;
			case Peticionable::PUT:
				$this->enviarDelete();
				break;
			default:
				break;
		}

	}

	public function ejecutarContoken($token){
		$this->cliente_curl = curl_init();
		curl_setopt_array($this->cliente_curl,array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => $this->user_agent, CURLOPT_TIMEOUT => $this->timeout, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSLVERSION=> 6, CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_CAINFO => $this->CA_PATH, CURLOPT_VERBOSE => $this->debug));
		curl_setopt($this->cliente_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"auth-token: $token",'Expect:'));
		switch ($this->metodo) {
			case Peticionable::POST:
				$this->enviarPost();
				break;
			case Peticionable::GET:
				$this->enviarGet();
				break;
			case Peticionable::DELETE:
				$this->enviarPut();
				break;
			case Peticionable::PUT:
				$this->enviarDelete();
				break;
			default:
				break;
		}

	}
	
	private function armarHeaders($respuesta){
		$s = explode("Strict-Transport-Security: max-age=15768000",$respuesta);
		$headers = explode("\n", $s[0]);
		return $headers;
	}
	
	private function separarContenido($respuesta){
		$s = explode("Strict-Transport-Security: max-age=15768000",$respuesta);
		$contenido = $s[1];
		$contenido = ltrim($contenido);
		return $contenido;
	}

	public function enviarPost(){
		$session_id = $this->getSession();
		$p = $this->getPeticionString($this->peticiones);
		$this->respuesta_raw = "";
		$cantidad = count($this->peticiones);
		curl_setopt_array($this->cliente_curl,array(CURLOPT_URL => $this->url_conexion.$this->servlet, CURLOPT_POST => true));
		curl_setopt($this->cliente_curl,CURLOPT_POST, $cantidad);
		curl_setopt($this->cliente_curl,CURLOPT_POSTFIELDS, $p);
		$jwt = new JwtProtocolo();
		if($this->log)Util::LogAccess($this->servlet,$this->servicio_nombre,$this->ip,$this->debug,$this->peticiones,$session_id,$this->user_agent_cliente,$this->user);
		$this->respuesta_raw = curl_exec($this->cliente_curl);
		if (curl_errno($this->cliente_curl)) {
			$errores = new Errores();
			$this->respuesta_raw = $errores->COD_CONEXION;
		}
		$this->cerrarConexion();
		$array_respuesta = null;
		$datos = null;
		if($this->archivo){
			$this->headers_respuesta = $this->armarHeaders($this->respuesta_raw);
			$this->respuesta_archivo = $this->separarContenido($this->respuesta_raw);
			$array_respuesta = Util::comprobarRespuestaDatos($this->respuesta_archivo);
		}
		else {
			$array_respuesta = Util::comprobarRespuestaDatos($this->respuesta_raw);
		}
		$flag_haydatos = $array_respuesta['haydatos'];
		if ($flag_haydatos){
			$this->respuesta_raw = $jwt->descifar($this->respuesta_raw);
			if($this->log)Util::UpdateAccessLog($session_id,"ok");
		}
		else{
			$this->respuesta = $array_respuesta;
			if($this->log)Util::LogError($array_respuesta["flag_error"],$this->servlet,$this->servicio_nombre,$this->ip,$session_id);
			if(Util::islogearError($array_respuesta["flag_error"])){
				if($this->log)Util::UpdateAccessLog($session_id,"error");
			}
			else{
				if($this->log)Util::UpdateAccessLog($session_id,"ok");
			}
			return;
		}
		error_reporting(0);
		if ($this->respuesta_raw->datos) {
			$datos = json_decode($this->respuesta_raw->datos, false, 512, JSON_UNESCAPED_UNICODE);
		} else {
			$this->respuesta = $this->respuesta_raw;
			return true;
		}
		error_reporting(1);
		$array_datos = array('datos'=>$datos->respuesta[0]);
		if($array_datos ==null || !empty($array_datos)){
			$this->respuesta = array_merge($array_respuesta,$array_datos);
		}
	}

	private function getSession(){
		$session = "";
		$letras = "abcdefghijkmnopqrstuvwxyw0123456789";
		$tam = 12;
  		for ($i = 0; $i != $tam; ++$i)$session .= $letras[mt_rand(0, strlen($letras) - 1)];
    	$session = sha1($session);
  		return $session;
	}

	public function enviarGet(){
		$p = $this->getPeticionString($this->peticiones);
		$this->respuesta_raw = "";
		if (!empty($p)){
			curl_setopt($this->cliente_curl,CURLOPT_URL,$this->url_conexion.$this->servlet."?".$p);
		}
		else{
			curl_setopt($this->cliente_curl,CURLOPT_URL,$this->url_conexion.$this->servlet);
		}
		$jwt = new JwtProtocolo();
		if($this->log)Util::LogAccess($this->servlet,$this->servicio_nombre,$this->ip,$this->debug,$this->peticiones,$session_id,$this->user_agent_cliente);
		$this->respuesta_raw = curl_exec($this->cliente_curl);
		if (curl_errno($this->cliente_curl)) {
			$this->respuesta_raw = "ERROR_CON";
		}
		$this->cerrarConexion();
		$datos = null;
		$array_respuesta = Util::comprobarRespuestaDatos($this->respuesta_raw);
		$flag_haydatos = $array_respuesta['haydatos'];
		if ($flag_haydatos){
			$this->respuesta_raw = $jwt->descifar($this->respuesta_raw);
			if($this->log)Util::UpdateAccessLog($session_id,"ok");
		}
		else{
			$this->respuesta = $array_respuesta;
			if($this->log)Util::LogError($array_respuesta["flag_error"],$this->servlet,$this->servicio_nombre,$this->ip,$session_id);
			if(Util::islogearError($array_respuesta["flag_error"])){
				if($this->log)Util::UpdateAccessLog($session_id,"error");
			}
			else{
				if($this->log)Util::UpdateAccessLog($session_id,"ok");
			}
			return;
		}
		error_reporting(0);
		if ($this->respuesta_raw->datos) {
			$datos = json_decode($this->respuesta_raw->datos, false, 512, JSON_UNESCAPED_UNICODE);
		} else {
			$this->respuesta = $this->respuesta_raw;
			return true;
		}
		error_reporting(1);
		$array_datos = array('datos'=>$datos->respuesta[0]);
		if($array_datos ==null || !empty($array_datos)){
			$this->respuesta = array_merge($array_respuesta,$array_datos);
		}
	}

	private function getPeticionString($peticiones){
		$p = "";
		$cantidad = count($peticiones);
		$i = 1;
		foreach ($peticiones as $peticion) {
			if ($i<$cantidad){
				$p = $p.$peticion->getParametro()."=".urlencode($peticion->getValor())."&";
			}
			else{
				$p = $p.$peticion->getParametro()."=".urlencode($peticion->getValor());
			}
			$i++;
		}
		return $p;
	}

	public function enviarPut(){

	}

	public function enviarDelete(){

	}

	private function cerrarConexion(){
		curl_close($this->cliente_curl);
	}

}
?>