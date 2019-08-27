<?php

/**
 * 
 */
class Model_Usuariosplus extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->constante="FpgH456Gtdgh43i349gjsjf%ttt";
    }
    
    //funcion para obtener los usuarios de una empresa
    public function getAll_empresa($_IDEmpresa){
        $respuesta=$this->db->select('*')->where("IDEmpresa='$_IDEmpresa'")->get('tbusuarios_plus');
        return $respuesta->result_array();
    }
    public function add_user($_Nombre,$_Apellidos,$_Correo,$_Celular,$_Status,$_Foto,$_Clave,$_IDEmpresa){
        $clave=md5($_Clave.$this->constante);
		$Token=md5(date("d-m-Y").date("H:i:s"));
        $array=array(
            "Nombre"=>$_Nombre,
            "Apellidos"=>$_Apellidos,
            "Correo"=>$_Correo,
            "Celular"=>$_Celular,
            "Status"=>$_Status,
            "Clave"=>$clave,
            "Foto"=>$_Foto,
            "Token"=>$Token,
            "IDEmpresa"=>$_IDEmpresa
        );
        $this->db->insert("tbusuarios_plus",$array);
        return $Token;
    }
}