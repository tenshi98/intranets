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
$original = "principal_peligros.php";
$location = $original;
$new_location = "principal_peligros_archivos.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-ban" aria-hidden="true"></i> Mis Zonas Peligrosas';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'upload_files';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_peligros_listado_archivos.php';
}
//se borra un dato
if ( !empty($_GET['del_Archivo']) )     {
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_files';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_peligros_listado_archivos.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Archivo adjuntado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Archivo eliminado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['new']) ) {  ?>

<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Adjuntar Archivos</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
							
				<?php 
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','File_Upload', 25, '"jpg", "png", "gif", "jpeg", "bmp"');
				
				$Form_Inputs->form_input_hidden('idPeligro', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);		
						
				?> 
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf093; Subir Archivo" name="submit"> 
					<a href="<?php echo $new_location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
							  
			</form> 
			<?php widget_validator(); ?>  
		</div>
	</div>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
} else  { 	 
// tomo los datos del usuario
$query = "SELECT 
seg_vecinal_peligros_tipos.Nombre AS Tipo

FROM `seg_vecinal_peligros_listado`
LEFT JOIN `seg_vecinal_peligros_tipos`  ON seg_vecinal_peligros_tipos.idTipo  = seg_vecinal_peligros_listado.idTipo

WHERE seg_vecinal_peligros_listado.idPeligro = ".simpleDecode($_GET['id'], fecha_actual());
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

//Se traen las rutas
$arrArchivos = array();
$query = "SELECT idArchivo, Nombre
FROM `seg_vecinal_peligros_listado_archivos`
WHERE idPeligro = ".simpleDecode($_GET['id'], fecha_actual())."
ORDER BY Nombre ASC";
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
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrArchivos,$row );
}
//se revisa la cantidad de archivos adjuntos
$N_Archivos = db_select_nrows (false, 'Nombre', 'seg_vecinal_peligros_listado_archivos', '', "idPeligro='".simpleDecode($_GET['id'], fecha_actual())."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'N_Archivos');
?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Zona de Peligro', $rowdata['Tipo'], 'Adjuntar Archivos a la Zona de Peligro');?>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<a href="<?php echo $new_location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Adjuntar Archivo</a>
	</div>
</div>
<div class="clearfix"></div> 




<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_peligros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-flag" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_peligros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Datos</a></li>
				<li class="active"><a href="<?php echo 'principal_peligros_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-file-archive-o" aria-hidden="true"></i> Archivos Adjuntos <span class="label label-danger"><?php echo $N_Archivos; ?></span></a></li>          
			</ul>	
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrArchivos as $zona) { ?>
						<tr class="odd">		
							<td><?php echo $zona['Nombre']; ?></td>	
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="view_doc_preview.php?path=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($zona['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="1download.php?dir=<?php echo simpleEncode(DB_SITE_REPO.DB_SITE_ALT_1_PATH.'/upload', fecha_actual()).'&file='.simpleEncode($zona['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
									<?php 
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $new_location.'&del_Archivo='.simpleEncode($zona['idArchivo'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el archivo '.$zona['Nombre'].'?';?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Informacion" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>                    
				</tbody>
			</table>
		</div>	
	</div>
</div>

<?php widget_modal(80, 95); ?>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
