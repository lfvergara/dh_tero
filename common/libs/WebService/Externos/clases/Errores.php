<?php
Class Errores {
	public $COD_NOAUTH_JWT = "ERROR_TOKEN";
	public $COD_NO_JWT = "ERROR_NOTOKEN";
	public $COD_CONEXIONBASE = "ERROR_CONDB";
	public $COD_NOAUTH_USER = "ERROR_LOGIN";
	public $COD_QUERYBASE = "ERROR_QDB";
	public $COD_NO_DATA = "NODATA";
	public $COD_RESTRICTED_DATA = "RESTRICTEDATA";
	public $COD_NIS_INVALIDO = "NIS_INVAL";
	public $COD_EMAIL_INVALIDO = "EMAIL_INVAL";
	public $COD_DNI_INVALIDO = "DNI_INVAL";
	public $COD_IDCLIENTE_INVALIDO = "CLI_INVAL";
	public $COD_CONEXION = "ERROR_CON";
	public $COD_CONEXION_SERVLET = "<title>Error 404</title>";
	public $COD_CONEXION_SERVLET_GATEWAY = "<title>502 Bad Gateway</title>";
	public $COD_CONEXION_SERVLET_CONCURRENCIA = "<title>503 Service Temporarily Unavailable</title>";
	public $COD_CONEXION_PROHIBIDO = "<title>403 Forbidden</title>";
	public $COD_DESC = "ERROR_DESC";
	public $COD_PARAMETROS = "ERROR_PARAMETROS";
}
?>