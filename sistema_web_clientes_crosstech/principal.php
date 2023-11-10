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
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "principal.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-dashboard" aria-hidden="true"></i> Principal';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';

/****************************************************************************/
//mensaje en caso de no haber cambiado la contraseña
if(isset($_SESSION['usuario']['basic_data']['password'])&&$_SESSION['usuario']['basic_data']['password']=='81dc9bdb52d04dc20036dbd8313ed055'){
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
	$Alert_Text  = '<strong>Cambio de contraseña: </strong> ';
	$Alert_Text .= 'Por motivos de seguridad, se recomienda <strong>cambiar</strong> la contraseña';
	$Alert_Text .= '<a href="principal_datos_datos_password.php" title="Cambio de contraseña" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cambio de contraseña</a>';
	alert_post_data(2,1,2,0, $Alert_Text);
	echo '</div>';
} ?>

<style>
	.my-custom-scrollbar {position: relative;height: 550px;overflow: auto;}
	.table-wrapper-scroll-y {display: block;}
</style>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div class="row">
		<div class="cover profile">
			<?php //include '1include_principal_interfaz_portada.php'; ?>
		</div>
		<div class="box profile_content" style="margin-top:0px;">
			<?php include '1include_principal_interfaz_menu.php'; ?>

			<div class="tab-content">

				<?php
				//contenido en tabs
				include '1include_principal_interfaz_tab_0.php';
				include '1include_principal_interfaz_tab_1.php';

				?>

			</div>
		</div>
	</div>

</div>













<?php widget_whatsappFloatBtn('+56943497697', 'Necesito un poco de información'); ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
