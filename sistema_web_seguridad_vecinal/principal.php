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
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';

/****************************************************************************/
//mensaje en caso de no haber aceptado la ubicacion
if(isset($_SESSION['usuario']['basic_data']['idNuevo'])&&$_SESSION['usuario']['basic_data']['idNuevo']==0){
	echo '<div class="col-sm-12">';
	$Alert_Text  = '<strong>Confirmar la direccion: </strong> ';
	$Alert_Text .= 'si la ubicacion mostrada es correcta presionar <strong>Confirmar Ubicacion</strong>, si no es asi presionar <strong>Modificar Ubicacion</strong>';
	$Alert_Text .= '<a href="principal_datos.php?mod=true" title="Modificar Ubicacion" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar Ubicacion</a>';
	$Alert_Text .= '<a href="principal_datos.php?confirm=true" title="Confirmar Ubicacion" class="btn btn-success btn-sm pull-right" ><i class="fa fa-check" aria-hidden="true"></i> Confirmar Ubicacion</a>';
	alert_post_data(2,1,2, $Alert_Text);
	echo '</div>';
} ?>

<style>
	.my-custom-scrollbar {position: relative;height: 550px;overflow: auto;}
	.table-wrapper-scroll-y {display: block;}
</style>	
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>&sensor=false"></script>


<div class="col-sm-12">
	
	<div class="row">
		<div class="cover profile">
			<?php include '1include_principal_interfaz_portada.php'; ?>
		</div>	
		<div class="box profile_content" style="margin-top:0px;">
			<?php include '1include_principal_interfaz_menu.php'; ?>
			
			<div id="div-3" class="tab-content">
				
				<?php
				//contenido en tabs
				include '1include_principal_interfaz_tab_0.php';
				include '1include_principal_interfaz_tab_1.php';
				
				include '1include_principal_interfaz_tab_97.php';
				include '1include_principal_interfaz_tab_98.php';
				include '1include_principal_interfaz_tab_99.php';
				
				?>
				
			</div>	
		</div>
	</div>


</div>
















<?php widget_modal(80, 95); ?>			
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
