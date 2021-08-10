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
$original = "apoderados_listado_hijos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Hijos';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado_hijos.php';
}
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado_hijos.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado_hijos.php';	
}
//se borra un dato
if ( !empty($_GET['del_img']) )     {
	//Llamamos al formulario
	$form_trabajo= 'del_img';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado_hijos.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Hijo creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Hijo editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Hijo borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['edit']) ) { 
//Obtengo los datos de una observacion
$query = "SELECT Nombre, ApellidoPat, ApellidoMat, idSexo, FNacimiento, Direccion_img,idColegio
FROM `apoderados_listado_hijos`
WHERE idHijos = ".$_GET['edit'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado); 	?>
 
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar Hijo</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
			
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = $rowdata['Nombre'];}
				if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = $rowdata['ApellidoPat'];}
				if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = $rowdata['ApellidoMat'];}
				if(isset($idSexo)) {              $x4  = $idSexo;               }else{$x4  = $rowdata['idSexo'];}
				if(isset($FNacimiento)) {         $x5  = $FNacimiento;          }else{$x5  = $rowdata['FNacimiento'];}
				if(isset($idColegio)) {           $x6  = $idColegio;            }else{$x6  = $rowdata['idColegio'];}
						
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 1);
				$Form_Inputs->form_select('Sexo','idSexo', $x4, 1, 'idSexo', 'Nombre', 'core_sexo', 0, '',$dbConn);
				$Form_Inputs->form_date('Fecha Nacimiento','FNacimiento', $x5, 1);
				$Form_Inputs->form_select_filter('Colegio','idColegio', $x6, 2, 'idColegio', 'Nombre', 'colegios_listado', 'idEstado=1', '',$dbConn);
				
				if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){?>
        
					<div class="col-sm-10 fcenter">
					  <img src="<?php echo DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img'] ?>" width="100%" > 
					</div> 
					<a href="<?php echo $location.'&del_img='.$_GET['edit'].'&edit='.$_GET['edit']; ?>" class="btn btn-danger fright margin_width" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
					<div class="clearfix"></div>
					
				<?php 
				}else{ 
					$Form_Inputs->form_multiple_upload('Seleccionar foto','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');
							
				}
				
				$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);
				$Form_Inputs->form_input_hidden('idHijos', $_GET['edit'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit"> 
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>        
		</div>
	</div>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } elseif ( ! empty($_GET['new']) ) { ?>
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Hijo</h5>	
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
				
				<?php 
				//Se verifican si existen los datos
				if(isset($Patente)) {             $x1  = $Patente;              }else{$x1  = '';}
				if(isset($Nombre)) {              $x2  = $Nombre;               }else{$x2  = '';}
				if(isset($ApellidoPat)) {         $x3  = $ApellidoPat;          }else{$x3  = '';}
				if(isset($ApellidoMat)) {         $x4  = $ApellidoMat;          }else{$x4  = '';}
				if(isset($idSexo)) {              $x5  = $idSexo;               }else{$x5  = '';}
				if(isset($FNacimiento)) {         $x6  = $FNacimiento;          }else{$x6  = '';}
				if(isset($idColegio)) {           $x7  = $idColegio;            }else{$x7  = '';}
						
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Patente', 'Patente', $x1, 2);
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x3, 2);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x4, 1);
				$Form_Inputs->form_select('Sexo','idSexo', $x5, 1, 'idSexo', 'Nombre', 'core_sexo', 0, '',$dbConn);
				$Form_Inputs->form_date('Fecha Nacimiento','FNacimiento', $x6, 1);
				$Form_Inputs->form_select_filter('Colegio','idColegio', $x7, 2, 'idColegio', 'Nombre', 'colegios_listado', 'idEstado=1', '',$dbConn);
				$Form_Inputs->form_multiple_upload('Seleccionar foto','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');
						
					
				$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>        
		</div>
	</div>
</div>

 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
// Se trae un listado con todas las observaciones el cliente
$arrCargas = array();
$query = "SELECT 
apoderados_listado_hijos.idHijos,
apoderados_listado_hijos.Nombre,
apoderados_listado_hijos.ApellidoPat,
apoderados_listado_hijos.ApellidoMat,
apoderados_listado_hijos.FNacimiento,
core_sexo.Nombre AS Sexo,
sistema_planes.Nombre AS Plan_Nombre,
sistema_planes.Valor AS Plan_Valor,
vehiculos_listado.Patente AS VehiculoIda,
VehiculoVuelta.Patente AS VehiculoVuelta,
colegios_listado.Nombre AS Colegio

FROM `apoderados_listado_hijos`
LEFT JOIN `core_sexo`                        ON core_sexo.idSexo              = apoderados_listado_hijos.idSexo
LEFT JOIN `sistema_planes`                   ON sistema_planes.idPlan         = apoderados_listado_hijos.idPlan
LEFT JOIN `vehiculos_listado`                ON vehiculos_listado.idVehiculo  = apoderados_listado_hijos.idVehiculo
LEFT JOIN `vehiculos_listado` VehiculoVuelta ON VehiculoVuelta.idVehiculo     = apoderados_listado_hijos.idVehiculoVuelta
LEFT JOIN `colegios_listado`                 ON colegios_listado.idColegio    = apoderados_listado_hijos.idColegio
WHERE idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."' ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrCargas,$row );
}
/**************************************************/
//se cuentan las cargas
$nCargas = 0;
foreach ($arrCargas as $carga) {
	$nCargas++;
}
?>
<?php 
//mientras que el numero de cargas sea inferior al maximo propuesto por el plan
if ($nCargas<$_SESSION['usuario']['basic_data']['PlanN_Hijos']){ ?>
	<div class="col-sm-12 breadcrumb-bar">
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Hijo</a>
	</div>
	<div class="clearfix"></div>
<?php } ?> 
                    
                                 
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Hijos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th colspan="4" style="text-align:center;">Datos del Apoderado</th>
						<th colspan="3" style="text-align:center;">Datos del Transporte</th>
						<th></th>
					</tr>
					<tr role="row">
						<th>Nombre</th>
						<th width="120">Colegio</th>
						<th width="120">Fecha Nacimiento</th>
						<th width="120">Sexo</th>
						<th width="120">Plan Transporte Escolar</th>
						<th width="120">Vehiculo Ida</th>
						<th width="120">Vehiculo Vuelta</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>				  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCargas as $carga) { ?>
						<tr class="odd">
							<td><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></td>
							<td><?php echo $carga['Colegio']; ?></td>		
							<td><?php echo fecha_estandar($carga['FNacimiento']); ?></td>	
							<td><?php echo $carga['Sexo']; ?></td>		
							<td><?php if(isset($carga['Plan_Nombre'])&&$carga['Plan_Nombre']!=''){echo $carga['Plan_Nombre'].'('.valores($carga['Plan_Valor'], 0).')';} ?></td>
							<td><?php echo $carga['VehiculoIda']; ?></td>		
							<td><?php echo $carga['VehiculoVuelta']; ?></td>		
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo 'view_apoderado_hijo.php?view='.$carga['idHijos']; ?>" title="Ver Informacion Pasajero" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&edit='.$carga['idHijos']; ?>" title="Editar Informacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
									$ubicacion = $location.'&del='.simpleEncode($carga['idHijos'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la carga '.$carga['Nombre'].' '.$carga['ApellidoPat'].'?';?>
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


<?php } ?>           
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
