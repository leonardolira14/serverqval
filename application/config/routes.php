<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*

*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login']="usuarios/loginn";
$route['forgetpass']="usuarios/forgetpass";
$route['panel']="general/panel";
$route['registro']="general/registro";
$route['getdatos']="general/getdatos";
$route['Notificacion']="notificacion/notificaciones";
$route['general']='general/general';
$route['updateus']='general/updatedateus';
$route['updateempresa']='empresa/updateempresa';


$route['getgrupos']='grupos/getall';
$route["updatestatusg"]="grupos/delete";
$route["updategrupo"]="grupos/update";
$route["addgroup"]="grupos/add";
$route["deletegrupo"]="grupos/borrar";

$route["cambiopas"]="usuarios/cambiopas";
$route["getalluser"]="usuarios/getAll";
$route["saveuser"]="usuarios/save";
$route["updateuser"]="usuarios/update";
$route["deleteuser"]="usuarios/deleteuser";
$route["numregistrosuser"]="usuarios/numderegistristros";
$route["deleteuserfin"]="usuarios/borrar";
$route["transfierecalificacion"]="usuarios/transferircalificaciones";
$route["updateuserfunction"]="usuarios/updatefunction";
$route["changepassword"]='usuarios/changepassword';
$route['activacuenta']='usuarios/activacuenta';
$route["resendpassword"]='usuarios/reeenvioclave';

$route["getallclient"]="cliente/getAll";
$route["saveclient"]="cliente/save";
$route["updateclient"]="cliente/update";
$route["deleteclient"]="cliente/delete";
$route["numregistrosclie"]="cliente/numregistro";
$route["borrarcliente"]="cliente/borrar";

$route["getuser"]="cliente/getuser";
$route["getallquestionary"]="cuestionario/getall";
$route["getquetionary"]="cuestionario/getdatoscuest";
$route["getdatoscues"]="cuestionario/getdatoscues";
$route["savequestionary"]="cuestionario/save";
$route["dataquestionary"]="cuestionario/getdata";
$route["updatequestionary"]="cuestionario/update";
$route["deletequestionary"]="cuestionario/delete";
$route["numregisrosquestionary"]="cuestionario/numregistros";
$route["borrarquestionary"]="cuestionario/borrar";
$route["deleterespuestas"]="cuestionario/deleterespuestas";

$route["addgroupquestionary"]="cuestionario/addgroup";
$route["updategroupquestionary"]="cuestionario/updategroup";
$route["deletegroupquestionary"]="cuestionario/deletegroup";
$route["addcuesgroupquestionary"]="cuestionario/addcuesgrp";

//nuevas rutas para el cuestionario
$route["addquestionary"]="cuestionario/addcuestionario";
$route["getdatosencuesta"]="cuestionario/getdatosencuesta";

//fin de las nuevas ruras para el custionario


$route["addcuesnotfquestionary"]="cuestionario/updatenotificacion";
$route["addgrupoencuesta"]='cuestionario/upsategrupo';
$route["addborradorencuesta"]='cuestionario/addborradorencuesta';


$route["getallask"]="pregunta/getall";
$route["updateask"]="pregunta/update";
$route["updatestatusask"]="pregunta/updatestatus";
$route["saveask"]="pregunta/save";
$route["numregistrospregunta"]="pregunta/numregistros";
$route["deleteask"]="pregunta/delete";
$route["getcategotia"]="pregunta/getcateria";
$route["getcategoriask"]="pregunta/getpregutacat";
$route['addplantilla']="pregunta/addplantilla";

$route["getresumen"]="resumen/getresumen";
$route["getdetailsresumen"]="resumen/getdetailstable";
$route["downloaddetall"]="resumen/detallessvg";
$route["downloadresumen"]="resumen/resumensvg";

//funcion para las notificaciones
$route["getnotificaciones"]="Notificacion/getNotificaciones";
$route["deletenotificacionpreg"]="Notificacion/deletepreg";

//funciones para usuarios plus
$route["getalluserplus"]="Usuariosplus/getall";
$route["updateuserplus"]="Usuariosplus/update";
$route["adduserplus"]="Usuariosplus/add";
$route["senspassuserplus"]="Usuariosplus/sendpass";
$route["countreguserplus"]="Usuariosplus/getreg";
$route["deleteuserplus"]="Usuariosplus/delete";
$route["changeuserplus"]="Usuariosplus/changestatus";

