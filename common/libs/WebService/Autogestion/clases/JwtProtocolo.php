<?php
require_once "lib/php-jwt/JWT.php";
require_once "lib/php-jwt/ExpiredException.php";
use \Firebase\JWT\JWT;


Class JwtProtocolo {

	private $keyjwt = "128793978129837";
	private $session_tiempo_auth = 6;
	private $session_tiempo_cliente = 15;
	private $hora;
	private $hora_exp;
	private $hora_exp_cliente;

	public function __construct(){
		$this->hora = time();
		$this->hora_exp = $this->hora + ($this->session_tiempo_auth * 60);
		$this->hora_exp_cliente = $this->hora + ($this->session_tiempo_cliente * 60);
	}

	public function autenticar($user,$pw){
		$kfinal = $this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt;
		$datos = array(
		"jti" => "0",
    	"iss" => "www.edelar.com.ar",
    	"aud" => "edelarws",
    	"iat" => $this->hora,
    	"exp" => $this->hora_exp,
    	'auth' => [
        'usuario' => $user,
        'clave' => $pw]);
    	$token = JWT::encode($datos, $kfinal);
    	return $token;
	}

	public function crearTokenUsuario($usuario){
		$kfinal = $this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt;
		$datos = array(
		"jti" => $usuario->getId(),
    	"iss" => $usuario->getUsuarioDetalle()->getNombre()." ".$usuario->getUsuarioDetalle()->getApellido(),
    	"aud" => "edelarws",
    	"iat" => $this->hora,
    	"exp" => $this->hora_exp_cliente,
    	'auth' => [
        'usuario' => $usuario->getDenominacion(),
        'clave' => $usuario->getUsuarioDetalle()->getToken()]);
    	$token = JWT::encode($datos, $kfinal);
    	$usuario->setJwt($token);
    	return $usuario;
	}

	public function descifar ($respuesta){
		$kfinal = $this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt;
		try {
			$decoded = JWT::decode($respuesta , $kfinal , array('HS256'));
		} catch (Exception $e) {
			$respuesta = "ERROR_DECODEJWT";
			return $respuesta;
		}
		return $decoded;
	}

}
?>