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
$original = "principal_camaras.php";
$location = $original;
$new_location = "principal_camaras_estado.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-video-camera" aria-hidden="true"></i> Mis Grupos de Camaras';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Si el estado esta distinto de vacio
if ( !empty($_GET['estado']) ) {
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'grupo_estado';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_camaras_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Estado cambiado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// consulto los datos
$query = "SELECT 
seg_vecinal_camaras_listado.idCamara,
seg_vecinal_camaras_listado.Nombre,
core_estados.Nombre AS estado,
seg_vecinal_camaras_listado.idEstado

FROM `seg_vecinal_camaras_listado`
LEFT JOIN `core_estados`     ON core_estados.idEstado     = seg_vecinal_camaras_listado.idEstado
WHERE seg_vecinal_camaras_listado.idCamara = ".simpleDecode($_GET['id'], fecha_actual());
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
						
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
$rowdata = mysqli_fetch_assoc ($resultado);

?>
<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowdata['Nombre'], 'Editar Estado');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_camaras.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-ol" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class="active"><a href="<?php echo 'principal_camaras_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_config.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>	
		</header>
        <div class="table-responsive"> 
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd">			
						<td><?php echo 'Grupo Camaras '.$rowdata['estado']; ?></td>		
						<td>
							<div class="btn-group" style="width: 100px;" id="toggle_event_editing">	 
								<?php if ( $rowdata['estado']=='Activo' ) {?>   
									<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&estado='.simpleEncode(2, fecha_actual()) ; ?>">OFF</a>
									<a class="btn btn-sm btn-info locked_active" href="#">ON</a>
								  <?php } else {?>
									<a class="btn btn-sm btn-info locked_active" href="#">OFF</a>
									<a class="btn btn-sm btn-default unlocked_inactive" href="<?php echo $new_location.'&estado='.simpleEncode(1, fecha_actual()) ; ?>" >ON</a>
								<?php }?>
							</div>     
						</td>	
					</tr>                  
				</tbody>
			</table>
		</div>	
	</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
