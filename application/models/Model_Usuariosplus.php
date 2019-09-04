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
    // funcion para obtener los datos de un usuario
    public function getdata($_IDUsuario){
        $respuesta=$this->db->select('*')->where("IDUsuario='$_IDUsuario'")->get('tbusuarios_plus');
        return $respuesta->row_array();
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
    //funcion para modificar una contraseña temporal
    public function update_clave_tem($_Clave,$_IDUsuario){
        $_clave=md5($_Clave.$this->constante);
       $this->db->where("IDUsuario='$_IDUsuario'")->update("tbusuarios_plus",array("Clave"=>$_clave));
       return $_clave;
    }
    //funcion para actualizar los datos de un usuario 
    public function update($_Nombre,$_Apellidos,$_Correo,$_Celular,$_Status,$_Foto,$_IDUsuario)
    {
        $array=array(
            "Nombre"=>$_Nombre,
            "Apellidos"=>$_Apellidos,
            "Correo"=>$_Correo,
            "Celular"=>$_Celular,
            "Status"=>$_Status,
            "Foto"=>$_Foto
        );
        return $this->db->where("IDUsuario='$_IDUsuario'")->update("tbusuarios_plus",$array);
    }
    //funcion para obtener el numero de registro de un usario
    public function get_num_reg($_IDUsuario,$_IDEmpresa){
        $respuesta=$this->db->select("count(*) as num")->where("TReceptor='E' and IDReceptor='$_IDEmpresa' and IDUsuarioReceptor='$_IDUsuario'")->get('tbcalificaciones');
        return $respuesta->row_array();
    }
    public function delete($_IDUsuario,$_IDEmpresa){
       // primero guardo los datos en los que aparece
        $respuesta=$this->db->select("*")->where("TReceptor='E'and IDReceptor='$_IDEmpresa'  and IDUsuarioReceptor='$_IDUsuario'")->get('tbcalificaciones');
       
        //ahora elimino los detalles de calificaciones
        foreach ($respuesta->result_array() as $key => $item) {
            $this->db->where("IDValora='".$item["IDCalificacion"]."'")->delete('detallecalificacion');

        }

        //ahora elimino los registros de calificaciones
        $this->db->where("TReceptor='E'and IDReceptor='$_IDEmpresa'  and IDUsuarioReceptor='$_IDUsuario'")->delete('tbcalificaciones');

        //ahora elimino el usuario
       return $this->db->where("IDUsuario='$_IDEmpresa'  ")->delete('tbusuarios_plus');
    }

    //funcion para activar o desacativar un suario 
    public function update_status($_IDUsuario,$_Status){
        $array=array("Status"=>$_Status);
        return $this->db->where("IDUsuario='$_IDUsuario'")->update("tbusuarios_plus",$array);
    }
    

    //funcion para solo actualizar la foto
    public function update_fot($_Foto){
        $array=array("Foto"=>$_Foto);
        return $this->db->where("IDUsuario='$_IDUsuario'")->update("tbusuarios_plus",$array);
    }
    
}
