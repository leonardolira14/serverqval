<?

class Model_Admyo extends CI_Model
{
    function __construct()
	{
		parent::__construct();
        
        $this->constant="vkq4suQesgv6FVvfcWgc2TRQCmAc80iE";
    }  
    public function add_empresa($Persona,$RazonSocial,$NombreComercial,$RFC,$Tipo_Empresa,$No_Empleados){
        $DB2 = $this->load->database('admyo', TRUE);
        $array=array(
            "Persona"=>$Persona,
            "Razon_Social"=>$RazonSocial,
            "RFC"=>$RFC,
            "Nombre_Comer"=>$NombreComercial,
            "TipoEmpresa"=>$Tipo_Empresa,
            "NoEmpleados"=>$No_Empleados,
            "Esta"=>'0',
            "TipoCuenta"=>'basic'
        );
        $DB2->insert("empresa",$array);
       return $DB2->insert_id();
       //ahora agrego el usuario

    }
    public function add_Usuario($IDEmpresa,$Nombre,$Apellidos,$Correo){
        $DB2 = $this->load->database('admyo', TRUE);
        $TokenActivar=md5($Nombre.$Apellidos.$Correo.date('d/m/Y H:i:s'));
		$clave=md5('123456'.$this->constant).":".$this->constant;
        $array=array(
            "IDEmpresa"=>$IDEmpresa,
            "Nombre"=>$Nombre,
            "Apellidos"=>$Apellidos,
            "Correo"=>$Correo,
            "password"=>$clave,
            "Status"=>'0',
            "Token_Activar"=>$TokenActivar,
            "Tipo_Usuario"=>'Master'
        );
        $DB2->insert("usuarios",$array);
        return $TokenActivar;
        
    }   
}
