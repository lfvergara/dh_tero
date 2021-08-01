<?php
Class wsSuministro implements JsonSerializable {
	
	public $id;
	public $acceso;
	public $direccion;
	public $localidad;
	public $barrio;
	
	public function __construct(){
		$this->id = 0;
		$this->acceso = "";
		$this->direccion = "";
		$this->localidad = "";
		$this->barrio = "";
	}
	
	public function jsonSerialize() {
		return get_object_vars($this);
	}
	
	public static function CastStd($class){
		$suministro = new wsSuministro();
		$suministro->setId($class->id);
		$suministro->setAcceso($class->acceso);
		$suministro->setDireccion($class->direccion);
		$suministro->setLocalidad($class->localidad);
		$suministro->setBarrio($class->barrio);
		return $suministro;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}

	public function getLocalidad(){
		return $this->localidad;
	}
	
	public function setLocalidad($localidad){
		$this->localidad = $localidad;
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

	public function getBarrio(){
		return $this->barrio;
	}
	
	public function setBarrio($barrio){
		$this->barrio = $barrio;
	}
	
}
?>