<?php
# Ambiente y Versión del sistema
const AMBIENTE = "desa";
const SO_UNIX = true;
const VERSION = "prod";
const APP_VERSION = "v2.0";

# Algoritmos utilizados para encriptar credenciales
# de registro y acceso de usuarios del sistema
const ALGORITMO_USER = 'crc32';
const ALGORITMO_PASS = 'sha512';
const ALGORITMO_FINAL = 'md5';

# Definición de recursos estáticos para interfaz gráfica
$uri_dominio = (SO_UNIX == true) ? "" : "/edelar";
$uri_app = (SO_UNIX == true) ? "" : "/edelar";

switch (AMBIENTE) {
	case 'prod':
		define('URL_STATIC', "/static/theme/");
    	define('URL_STATIC_GESTOR', "/static/theme_gestor/");
		break;
	case 'desa':
		define('URL_STATIC', "{$uri_dominio}/static/theme/");
    	define('URL_STATIC_GESTOR', "{$uri_dominio}/static/theme_gestor/");
		break;
}

const THEME_HOME_SITIO = "static/theme_home.html";
const THEME_SECCION_SITIO = "static/theme_seccion.html";
const SIDEBAR_SITIO_LOGIN_AUTOGESTION = "static/sitio_sidebar_login.html";
const SIDEBAR_SITIO_DEUDA_TURNO_MOVIL = "static/sitio_sidebar_deuda_turno_movil.html";
const THEME_404 = "static/theme_404.html";

define('URL_APP', $uri_app);

const APP_TITTLE = "EDELAR";
const APP_ABREV = "webedelar";
const DEFAULT_MODULE = "sitio";
const DEFAULT_ACTION = "home";

//const TEMPLATE_AUTOGESTION = "static/theme_autogestion.html";
//const TEMPLATE_GESTOR = "static/theme_gestor.html";
//const LOGIN_URI = "modules/sitio/home";
//const URL_DOCUMENTACION = "/srv/edelar.com.arsites/www.edelar.com.ar/edelar.com.ar/private/edelar.com.ar/";
const URL_PRIVATE = "/srv/websites/dh_tero/private/";
//const URL_DOCUMENTACION = "/home/dharma/Proyectos/edelar.com.ar/private/edelar.com.ar/";
//const URL_APPFILES = "/home/dharma/Proyectos/edelar.com.ar/private/";

# Credenciales para la conexión a la BD
const DB_HOST = 'localhost';
const DB_USER = 'Tatooine';
const DB_PASS = '3d374r$1630';
const DB_NAME = 'bdedelar';


# Definición de sesiones
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
ini_set('include_path', DOCUMENT_ROOT);
session_start();
$session_vars = array('login'=>false);
foreach($session_vars as $var=>$value) {
    if(!isset($_SESSION[$var])) $_SESSION[$var] = $value;
}
?>
