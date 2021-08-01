<?php
Class wsCliente implements JsonSerializable {
	
	public $id;
	public $documento;
	public $nombre;
	public $segundo_nombre;
	public $apellido;
	public $segundo_apellido;
	public $nombre_completo;
	public $telefono1;
	public $telefono2;
	public $telefono3;
	public $telefono4;
	public $telefono5;
	public $email1;
	public $email2;
	public $email3;
	public $direccion;
	public $fecha_alta;
	public $fecha_baja;
	
	public function __construct(){	
		$this->id = 0;
		$this->documento = 0;
		$this->nombre = "";
		$this->segundo_nombre = "";
		$this->apellido = "";
		$this->segundo_apellido = "";
		$this->nombre_completo = "";
		$this->telefono1 = "";
		$this->telefono2 = "";
		$this->telefono3 = "";
		$this->telefono4 = "";
		$this->telefono5 = "";
		$this->email1 = "";
		$this->email2 = "";
		$this->email3 = "";
		$this->direccion = "";
		$this->fecha_alta = "";
		$this->fecha_baja = "";
	}
	
	public function jsonSerialize() {
		return get_object_vars($this);
	}
	
	public static function CastStd($class){
		$cliente = new wsCliente();
		$cliente->setId($class->id);
		$cliente->setDocumento($class->documento);
		$cliente->setNombre($class->nombre);
		$cliente->setSegundo_nombre($class->segundo_nombre);
		$cliente->setApellido($class->apellido);
		$cliente->setSegundo_apellido($class->segundo_apellido);
		$cliente->setNombre_completo($class->nombre_completo);
		$cliente->setTelefono1($class->telefono1);
		$cliente->setTelefono2($class->telefono2);
		$cliente->setTelefono3($class->telefono3);
		$cliente->setTelefono4($class->telefono4);
		$cliente->setTelefono5($class->telefono5);
		$cliente->setEmail1($class->email1);
		$cliente->setEmail2($class->email2);
		$cliente->setEmail3($class->email3);
		$cliente->setDireccion($class->direccion);
		$cliente->setFecha_alta($class->fecha_alta);
		return $cliente;
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDocumento() {
		return $this->documento;
	}

	public function setDocumento($documento) {
		$this->documento = $documento;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	public function getSegundo_nombre() {
		return $this->segundo_nombre;
	}

	public function setSegundo_nombre($segundo_nombre) {
		$this->segundo_nombre = $segundo_nombre;
	}

	public function getApellido() {
		return $this->apellido;
	}

	public function setApellido($apellido) {
		$this->apellido = $apellido;
	}

	public function getSegundo_apellido() {
		return $this->segundo_apellido;
	}

	public function setSegundo_apellido($segundo_apellido) {
		$this->segundo_apellido = $segundo_apellido;
	}

	public function getNombre_completo() {
		return $this->nombre_completo;
	}

	public function setNombre_completo($nombre_completo) {
		$this->nombre_completo = $nombre_completo;
	}

	public function getTelefono1() {
		return $this->telefono1;
	}

	public function setTelefono1($telefono1) {
		$this->telefono1 = $telefono1;
	}

	public function getTelefono2() {
		return $this->telefono2;
	}

	public function setTelefono2($telefono2) {
		$this->telefono2 = $telefono2;
	}

	public function getTelefono3() {
		return $this->telefono3;
	}

	public function setTelefono3($telefono3) {
		$this->telefono3 = $telefono3;
	}

	public function getTelefono4() {
		return $this->telefono4;
	}

	public function setTelefono4($telefono4) {
		$this->telefono4 = $telefono4;
	}

	public function getTelefono5() {
		return $this->telefono5;
	}

	public function setTelefono5($telefono5) {
		$this->telefono5 = $telefono5;
	}

	public function getEmail1() {
		return $this->email1;
	}

	public function setEmail1($email1) {
		$this->email1 = $email1;
	}

	public function getEmail2() {
		return $this->email2;
	}

	public function setEmail2($email2) {
		$this->email2 = $email2;
	}

	public function getEmail3() {
		return $this->email3;
	}

	public function setEmail3($email3) {
		$this->email3 = $email3;
	}
	
	public function getDireccion() {
		return $this->direccion;
	}

	public function setDireccion($direccion) {
		$this->direccion = $direccion;
	}

	public function getFecha_alta() {
		return $this->fecha_alta;
	}

	public function setFecha_alta($fecha_alta) {
		$this->fecha_alta = $fecha_alta;
	}

	public function getFecha_baja() {
		return $this->fecha_baja;
	}

	public function setFecha_baja($fecha_baja) {
		$this->fecha_baja = $fecha_baja;
	}
	
}
?>