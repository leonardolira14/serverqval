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
$route['Notificacion']="notificacion/notificaciones";
$route['general']='general/general';
$route['updateus']='general/updatedateus';
$route['updateempresa']='empresa/updateempresa';
$route['getgrupos']='grupos/getall';
$route["updatestatusg"]="grupos/delete";
$route["updategrupo"]="grupos/update";
$route["addgroup"]="grupos/add";
$route["getalluser"]="usuarios/getAll";
$route["saveuser"]="usuarios/save";
$route["updateuser"]="usuarios/update";
$route["deleteuser"]="usuarios/deleteuser";
$route["updateuserfunction"]="usuarios/updatefunction";
$route["getallclient"]="cliente/getAll";
$route["saveclient"]="cliente/save";
$route["updateclient"]="cliente/update";
$route["deleteclient"]="cliente/delete";
$route["getuser"]="cliente/getuser";
$route["getallquestionary"]="cuestionario/getall";
$route["getquetionary"]="cuestionario/getdatoscuest";
$route["getdatoscues"]="cuestionario/getdatoscues";
$route["savequestionary"]="cuestionario/save";
$route["dataquestionary"]="cuestionario/getdata";
$route["updatequestionary"]="cuestionario/update";
$route["deletequestionary"]="cuestionario/delete";
$route["getallask"]="pregunta/getall";
$route["updateask"]="pregunta/update";
$route["deleteask"]="pregunta/delete";
$route["saveask"]="pregunta/save";
$route["getresumen"]="resumen/getresumen";
$route["getdetailsresumen"]="resumen/getdetailstable";
$route["downloaddetall"]="resumen/detallessvg";
$route["downloadresumen"]="resumen/resumensvg";