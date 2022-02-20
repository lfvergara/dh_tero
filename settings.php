<?php
# Ambiente del sistema
const AMBIENTE = "prod";
const SO_UNIX = true;

# Credenciales para la conexión con la base de datos MySQL
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '3d374r$1630';
const DB_NAME = 'bdedelar';


# Algoritmos utilizados para la encriptación de credenciales
# para el registro y acceso de usuarios del sistema
const ALGORITMO_USER = 'crc32';
const ALGORITMO_PASS = 'sha512';
const ALGORITMO_FINAL = 'md5';


# Direcciones a recursos estáticos de interfaz gráfica
const TEMPLATE = "static/template.html";
const TEMPLATE_FICHA = "static/template_ficha.html";
if (SO_UNIX == true) {
	define('URL_APP', "");
	define('URL_STATIC', "/static/template/");
	
	# Directorio private del sistema
	$url_private = "/srv/websites/dh_tero/private/";
	define('URL_PRIVATE', $url_private);
	ini_set("include_path", URL_PRIVATE);
} else {
	define('URL_APP', "/dh_tero");
	define('URL_STATIC', "/dh_tero/static/template/");

	# Directorio private del sistema
	$url_private = "d:/codeando/privatesDesarrollo/dhTeroFiles/private/";
	define('URL_PRIVATE', $url_private);
	ini_set("include_path", URL_PRIVATE);
}

# Configuración estática del sistema
const APP_TITTLE = "dhTero";
const APP_VERSION = "v1.0b";
const APP_ABREV = "Dharma";
const LOGIN_URI = "/usuario/login";
const DEFAULT_MODULE = "usuario";
const DEFAULT_ACTION = "perfil";

define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
ini_set('include_path', DOCUMENT_ROOT);

session_start();
$session_vars = array('loginDharma'=>0,'data-login-Dharma'=>0);
foreach($session_vars as $var=>$value) {
    if(!isset($_SESSION[$var])) $_SESSION[$var] = $value;
}
?>
