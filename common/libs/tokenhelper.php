<?php
require_once "jtwToken/JWT.php";
require_once "jtwToken/ExpiredException.php";
use \Firebase\JWT\JWTT;

class TokenHelper {
	
	private $keyjwt = "751425294079043";
	private $session_tiempo_auth = 20;
	private $hora;
	private $hora_exp;
	
	public function __construct(){
		$this->hora = time();
		$this->hora_exp = $this->hora + ($this->session_tiempo_auth * 60);
	}
	
	public static function autenticar($token){
		$keyjwt = "751425294079043";
		$kfinal = $keyjwt.$keyjwt.$keyjwt.$keyjwt.$keyjwt;
		$hash;
		try {
			$dec = JWTT::decode($token, $kfinal, array('HS256'));
			$dec_array = (array) $dec;
			$aud = $dec_array["aud"];
			if($aud == "www.edelar.com.ar"){
				$hash = $dec_array["auth"]->hashp;
			}
			else{
				$hash = "ERROR_TOKEN";
			}
		}
		catch (Exception $e) {
			$hash = "ERROR_TOKEN";
		}
    	return $hash;
	}
	
	public static function getClienteToken($token){
		$keyjwt = "751425294079043";
		$kfinal = $keyjwt.$keyjwt.$keyjwt.$keyjwt.$keyjwt;
		$cliente;
		try {
			$dec = JWTT::decode($token, $kfinal, array('HS256'));
			$dec_array = (array) $dec;
			$aud = $dec_array["aud"];
			if($aud == "www.edelar.com.ar"){
				$cliente = $dec_array["jti"];
			}
			else{
				$cliente = "ERROR_TOKEN";
			}
		}
		catch (Exception $e) {
			$cliente = "ERROR_TOKEN";
		}
    	return $cliente;
	}

	public function crearTokenUsuario($usuario,$cliente){
		$kfinal = $this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt.$this->keyjwt;
		$datos = array(
		"jti" => $cliente->cliente_id,
    	"iss" => $cliente->apellido,
    	"aud" => "www.edelar.com.ar",
    	"iat" => $this->hora,
    	"exp" => $this->hora_exp,
    	'auth' => [
        'usuario' => $usuario->denominacion,
        'hashp' => $usuario->clienteusuariodetalle->token]);
    	$token = JWTT::encode($datos, $kfinal);
    	$usuario->clienteusuariodetalle->token = $token;
    	return $usuario;
	}
	
}

?>