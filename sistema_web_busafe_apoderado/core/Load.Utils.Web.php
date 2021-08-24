<?php
/**********************************************************************************************************************************/
/*                                   Se filtran las entradas para evitar ataques                                                  */
/**********************************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_seguridad/AntiXSS.php';
require_once '../A2XRXS_gears/xrxs_seguridad/Bootup.php';
require_once '../A2XRXS_gears/xrxs_seguridad/UTF8.php';
//Inicializo funcion
$security = new AntiXSS();
//Se limpian datos recibidos
$_POST = $security->xss_clean($_POST);
$_GET  = $security->xss_clean($_GET);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                  //Configuracion de la plataforma
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Utils.Load.php';                     //Carga de variables
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.FormInputs.Extended.php'; //carga formularios de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Inputs.Extended.php';     //carga inputs de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Session.php';                  //verificacion sesion usuario


?>
