<?php
Class wsSuministro implements JsonSerializable {
	
	public $id;
	public $acceso;
	public $direccion;
	
	public function __construct(){
		$this->id = 0;
		$this->acceso = "";
		$this->direccion = "";
	}
	
	public function jsonSerialize() {
		return get_object_vars($this);
	}
	
	public static function CastStd($class){
		$suministro = new wsSuministro();
		$suministro->setId($class->id);
		$suministro->setAcceso($class->acceso);
		$suministro->setDireccion($class->direccion);
		return $suministro;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getAcceso(){
		return $this->acceso;
	}
	
	public function setAcceso($acceso){
		$this->acceso = $acceso;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}
	
}
?>