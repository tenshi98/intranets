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
$original = "vehiculos_listado.php";
$location = $original;
$new_location = "vehiculos_listado_doc_mantencion.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Vehiculos';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'submit_doc_mantencion';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';
}
//se borra un dato
if ( !empty($_GET['del_doc_mantencion']) )     {
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_doc_mantencion';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Vehiculo creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Vehiculo editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Vehiculo borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['new_mant']) ) { ?>
 
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificacion del Contacto</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
					
				<?php 
				//Se verifican si existen los datos
				if(isset($doc_fecha_mantencion)) {  $x1  = $doc_fecha_mantencion;   }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				echo '<h3>Mantenciones</h3>';
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','doc_mantencion', 1, '"doc","docx","pdf","jpg", "png", "gif", "jpeg"');
				$Form_Inputs->form_date('Fecha Vencimiento','doc_fecha_mantencion', $x1, 2);
				
				$Form_Inputs->form_input_hidden('idVehiculo', $_GET['id'], 2);
				?> 

				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf093; Subir Archivo" name="submit_edit"> 
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
							  
			</form> 
			<?php widget_validator(); ?>  
		</div>
	</div>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else{
// consulto los datos
$query = "SELECT Nombre,Patente, doc_mantencion, doc_fecha_mantencion
FROM `vehiculos_listado`
WHERE idVehiculo = ".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);

$arrTipoCliente = array();
$query = "SELECT idMantenciones, doc_mantencion, doc_fecha_mantencion, Fecha_ingreso 
FROM `vehiculos_mantenciones`
WHERE idVehiculo = ".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrTipoCliente,$row );
}


?>

<div class="col-sm-12">
	<?php 
	$vehiculo = $rowdata['Nombre'];
	if(isset($rowdata['Patente'])&&$rowdata['Patente']!=''){
		$vehiculo .= ' Patente '.$rowdata['Patente'];
	}
	echo widget_title('bg-aqua', 'fa-cog', 100, 'Vehiculo', $vehiculo, 'Editar Mantenciones');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'vehiculos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'vehiculos_listado_opc_4.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Chofer</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password APP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_colegios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i> Colegios</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-picture-o" aria-hidden="true"></i>  Foto</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_padron.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Padron</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_permiso_circulacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Permiso Circulacion</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_soap.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - SOAP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_revision_tecnica.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Revision Tecnica</a></li>
						<li class="active"><a href="<?php echo 'vehiculos_listado_doc_mantencion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Mantenciones</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_trans_personas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Cert. Transporte Personas</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Ficha Tecnica</a></li>
						
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;">
				
				<?php if(isset($rowdata['doc_mantencion'])&&$rowdata['doc_mantencion']!=''){?>
        
					<div class="col-sm-10 fcenter">
						<h3>Archivo</h3>
						<p>Fecha de Vencimiento: <?php echo fecha_estandar($rowdata['doc_fecha_mantencion']); ?></p>
						<?php echo preview_docs('upload', $rowdata['doc_mantencion'], '', DB_SITE_REPO, DB_SITE_ALT_1_PATH); ?>
					</div>
					
				<?php }?> 
			</div>
			
			
			
			
<div class="col-sm-12">
	<a href="<?php echo $new_location.'&id='.$_GET['id'].'&new_mant='.$_GET['id']; ?>" class="btn btn-default fright margin_width" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-file-o" aria-hidden="true"></i> Crear Nueva Mantencion</a>
</div>
<div class="clearfix"></div>                       
                                 
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Mantenciones</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre Archivo</th>
						<th>Fecha Vencimiento</th>
						<th>Fecha Ingreso</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
								 
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrTipoCliente as $tipo) { ?>
					<tr class="odd">
						<td><?php echo $tipo['doc_mantencion']; ?></td>
						<td><?php echo fecha_estandar($tipo['doc_fecha_mantencion']); ?></td>
						<td><?php echo fecha_estandar($tipo['Fecha_ingreso']); ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($tipo['doc_mantencion'], fecha_actual()); ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<?php 
								$ubicacion = $location.'&del_doc_mantencion='.simpleEncode($tipo['idMantenciones'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar el documento '.$tipo['doc_mantencion'].'?';?>
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
					
					
		</div>	
	</div>
</div>

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
