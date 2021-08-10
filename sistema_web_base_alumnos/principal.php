<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "principal.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-dashboard" aria-hidden="true"></i> Principal';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_form']) )  { 
	//Llamamos al formulario
	$form_obligatorios = 'idQuizRealizadas';
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_alumnos_evaluaciones_asignar.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['rendida'])) {$error['rendida'] 	  = 'sucess/Evaluacion Rendida correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};

?>
<style>
.tab-content {
    min-height: 420px !important;
}
.messaging {height: 420px!important;overflow-y: auto!important;}
</style>	
 				
<div class="col-sm-12">
	<div class="row">
		
		<?php
		/*****************************************************************************************************************/
		/*                                Se verifica si se ha cambiado la clave de inicio                               */
		/*****************************************************************************************************************/
		if($_SESSION['usuario']['basic_data']['password']=='81dc9bdb52d04dc20036dbd8313ed055') {  ?>	
			
			<div class="col-xs-12" style="margin-top:15px;">
				<?php
				$Alert_Text  = 'Aun no ha cambiado la contraseña, se recomienda el cambio de esta para poder ';
				$Alert_Text .= 'acceder a las pruebas. Para cambiarla presione ';
				$Alert_Text .= '<a href="principal_datos_datos_password.php" class="">aqui</a>';
				alert_post_data(4,3,3, $Alert_Text);
				?>
			</div>
			
		<?php 
		/*****************************************************************************************************************/
		//si ha cambiado la contraseña se muestra el contenido
		}else{ 
			//Titulo del curso
			echo '<h3 class="supertittle text-primary">'.$_SESSION['usuario']['basic_data']['CursoNombre'].'</h3>';
			
			//contenido en tabs
			include '1include_principal_asignaturas.php';
			include '1include_principal_videoconferencias.php';
			
			echo '<div class="clearfix"></div>';
			
			include '1include_principal_calendario.php';
			include '1include_principal_archivos.php';
			
			
		} ?>


	</div>
</div>
<?php widget_modal(80, 95); ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
