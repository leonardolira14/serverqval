<?php

/**
 * 
 */
class Model_Usuarios extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->constante="FpgH456Gtdgh43i349gjsjf%ttt";
	}

	//funcion para para saber cuantos registros tengo de un usuario
	public function getnumregistros($_ID_Usuario){
		$emisor=$this->db->select("count(*) as numero")->where("IDEmisor='$_ID_Usuario'")->get("tbcalificaciones");
		$receptor=$this->db->select("count(*) as numero")->where("IDReceptor='$_ID_Usuario'")->get("tbcalificaciones");

		$total=(int)$emisor->row_array()["numero"]+(int)$receptor->row_array()["numero"];

		return $total;
	}	
	//funcion para obtener el numero de usuarios de una empresa
	public function numus($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as NumUsuarios")->where("IDEmpresa='$_ID_Empresa'")->get("usuario");
		return $respuesta->row();
	}
	//funcion para el login
	public function login($_Usuario,$_Clave){
		//concateno la clave
		$_Clave=md5($_Clave.$this->constante);
		//ahora realizo la consulta
		$sql=$this->db->select()->where("Usuario='$_Usuario' and Clave='$_Clave'")->get("usuario");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row();
		}	
	}
	//funcion para actualizar la clave
	public function update_clave($IDUsuario,$Clave){
		$clave=md5($Clave.$this->constante);
		$array=array("Clave"=>$clave);
		$this->db->where("IDUsuario='$IDUsuario'")->update("usuario",$array);
	}
	//funcion para recuperar la clave
	public function recuperar_clave($_Correo){
		$sql=$this->db->select("*")->where("Correo='$_Correo'")->get("usuario");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row_array();
		}	
	}
	//funcion para actulizar datos generales
	public function update_general($_nombre,$_Correo,$_puesto,$apellidos,$_ID_Usuario){
		$array=array("Nombre"=>$_nombre,"Correo"=>$_Correo,"Puesto"=>$_puesto,"Apellidos"=>$apellidos);
		$this->db->where("IDUsuario='$_ID_Usuario'")->update("usuario",$array);
		
        
	}
	
	//funcion para obtener todos los usuarios de una empresa
	public function getAll($_ID_Empresa){
		$respuesta=$this->db->select("IDUsuario as Id,Nombre as nombre,Apellidos as apellido,IDEmpresa as empresa,Puesto,Usuario,Correo,Funciones as funciones,IDConfig as Config,Est as Estado")->where("IDEmpresa='$_ID_Empresa'")->get('usuario');
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result();
		}	
	}
	//funcion para egregar un nuevo usuario
	public function save($_ID_Empresa,$_Nombre,$_Apellido,$_Puesto,$_Correo,$_Configuracion,$_Funciones,$_Usuario){
		$datos=array("IDEmpresa"=>$_ID_Empresa,"Nombre"=>$_Nombre,"Apellidos"=>$_Apellido,"Puesto"=>$_Puesto,"Correo"=>$_Correo,"IDConfig"=>$_Configuracion,"Funciones"=>$_Funciones,"Usuario"=>$_Usuario,"Est"=>1);
		$this->db->insert("usuario",$datos);

	}
	public function update_status($_ID_Usuario,$_Estado){
		$array=array("Est"=>$_Estado);
		$respuesta=$this->db->where("IDUsuario=$_ID_Usuario")->update("usuario",$array);
		return $respuesta;
	}
	public function delete_user($_ID_Usuario){
		$this->db->where("IDUsuario='$_ID_Usuario'")->delete("usuario");
	}

	public function update($_ID_Usuario,$_Nombre,$_Apellido,$_Puesto,$_Correo,$_Configuracion,$_Funciones,$_Usuario){
		$datos=array("Nombre"=>$_Nombre,"Apellidos"=>$_Apellido,"Puesto"=>$_Puesto,"Correo"=>$_Correo,"IDConfig"=>$_Configuracion,"Funciones"=>$_Funciones,"Usuario"=>$_Usuario);
		return $this->db->where("IDUsuario='$_ID_Usuario'")->update("usuario",$datos);
	}
	public function update_function($_ID_Usuario,$_funciones){
		$array=array("Funciones"=>$_funciones);
		return $this->db->where("IDUsuario='$_ID_Usuario'")->update("usuario",$array);
	}
}