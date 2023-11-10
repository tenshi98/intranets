<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Ejecucion de la logica                                                         */
/**********************************************************************************************************************************/
//Se verifica si existe el directorio y el nombre del archivo a descargar
if(isset($_GET['dir'], $_GET['file'])&&$_GET['dir']!=''&&$_GET['file']!=''){

	//se decodifica los datos
	$Directorio = simpleDecode($_GET['dir'], fecha_actual());
	$Archivo    = simpleDecode($_GET['file'], fecha_actual());

	//enlace
	$file = $Directorio."/".$Archivo;

	header("Content-Description: File Transfer"); 
	header("Content-Type: application/octet-stream"); 
	header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 

	readfile ($file);
	exit();

	/*header ("Content-Disposition: attachment; filename=".$Archivo." ");
	header ("Content-Type: application/octet-stream");
	header ("Content-Length: ".filesize($enlace));
	readfile($enlace);*/
	
}

?> 


