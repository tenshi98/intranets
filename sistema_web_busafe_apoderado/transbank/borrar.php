<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once '../A1XRXS_sys/xrxs_configuracion/config.php';                                  //Configuracion de la plataforma
require_once '../../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                                Ejecucion de Logica                                                             */
/**********************************************************************************************************************************/

/*****************************************/
//elimino los planes
$query = "UPDATE `apoderados_listado` SET `idPlan`='0', `idCobro`='0' ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
/*****************************************/
//elimino los planes contratados
$query = "TRUNCATE TABLE `apoderados_listado_planes_contratados`";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
/*****************************************/
//elimino las facturaciones
$query = "TRUNCATE TABLE `vehiculos_facturacion_apoderados_listado_detalle`";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
/*****************************************/
//elimino los pagos
$query = "TRUNCATE TABLE `vehiculos_facturacion_apoderados_pago`";
//Consulta
$resultado = mysqli_query ($dbConn, $query);

echo 'Datos borrados correctamente';

?>

