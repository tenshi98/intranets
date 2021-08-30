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
$original = "trabajadores_listado.php";
$location = $original;
$new_location = "trabajadores_listado_cargas.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Choferes';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//se agregan ubicaciones
	$location=$new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado_cargas.php';
}
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//se agregan ubicaciones
	$location=$new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado_cargas.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//se agregan ubicaciones
	$location=$new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado_cargas.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Carga creada correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Carga editada correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Carga borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['edit']) ) { 
// consulto los datos
$query = "SELECT Nombre, ApellidoPat, ApellidoMat, idSexo, FNacimiento
FROM `trabajadores_listado_cargas`
WHERE idCarga = ".$_GET['edit'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado); 

 ?>

<div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Editar Carga</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>

				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = $rowdata['Nombre'];}
				if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = $rowdata['ApellidoPat'];}
				if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = $rowdata['ApellidoMat'];}
				if(isset($idSexo)) {              $x4  = $idSexo;               }else{$x4  = $rowdata['idSexo'];}
				if(isset($FNacimiento)) {         $x5  = $FNacimiento;          }else{$x5  = $rowdata['FNacimiento'];}
						
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 2);
				$Form_Inputs->form_select('Sexo','idSexo', $x4, 2, 'idSexo', 'Nombre', 'core_sexo', 0, '', $dbConn);
				$Form_Inputs->form_date('FNacimiento','FNacimiento', $x5, 2);
				
				$Form_Inputs->form_input_hidden('idCarga', $_GET['edit'], 2);
				?>
				
				<div class="form-group">		
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>		
				</div>
			</form>
			<?php widget_validator(); ?> 
		</div>
	</div>
</div>
 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}elseif ( ! empty($_GET['new']) ) { ?>
<div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Crear Nueva Carga</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
   
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = '';}
				if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = '';}
				if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = '';}
				if(isset($idSexo)) {              $x4  = $idSexo;               }else{$x4  = '';}
				if(isset($FNacimiento)) {         $x5  = $FNacimiento;          }else{$x5  = '';}
						
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 2);
				$Form_Inputs->form_select('Sexo','idSexo', $x4, 2, 'idSexo', 'Nombre', 'core_sexo', 0, '', $dbConn);
				$Form_Inputs->form_date('FNacimiento','FNacimiento', $x5, 2);
					
					
				$Form_Inputs->form_input_hidden('idTrabajador', $_GET['id'], 2);
				?>

				<div class="form-group">		
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit">	
					<a href="<?php echo $new_location.'&id='.$_GET['id']; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>		
				</div>
			</form>
			<?php widget_validator(); ?> 
		</div>
	</div>
</div>

 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}else{
// consulto los datos
$query = "SELECT Nombre, ApellidoPat, ApellidoMat
FROM `trabajadores_listado`
WHERE idTrabajador = ".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);

// consulto los datos
$arrCargas = array();
$query = "SELECT 
trabajadores_listado_cargas.idCarga,
trabajadores_listado_cargas.Nombre,
trabajadores_listado_cargas.ApellidoPat,
trabajadores_listado_cargas.ApellidoMat,
trabajadores_listado_cargas.FNacimiento,
core_sexo.Nombre AS Sexo

FROM `trabajadores_listado_cargas`
LEFT JOIN `core_sexo` ON core_sexo.idSexo = trabajadores_listado_cargas.idSexo
WHERE idTrabajador = ".$_GET['id']."
ORDER BY idCarga ASC ";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrCargas,$row );
}



?>
<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Chofer', $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat'], 'Cargas Familiares');?>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<a href="<?php echo $new_location.'&id='.$_GET['id'].'&new=true'; ?>" class="btn btn-default fright margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Nueva Carga</a>
	</div>	
</div>
<div class="clearfix"></div>   

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'trabajadores_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'trabajadores_listado_laboral.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-university" aria-hidden="true"></i> Informacion Laboral</a></li>
						<li class="active"><a href="<?php echo 'trabajadores_listado_cargas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Cargas Familiares</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_licencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Licencia Conducir</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Foto</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Contrato</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Curriculum</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_antecedentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Antecedentes</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_carnet.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Carnet</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_rhtm.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - RHTM</a></li>
						
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th width="120">Fecha Nacimiento</th>
						<th width="120">Sexo</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrCargas as $carga) { ?>
					<tr class="odd">
						<td><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></td>		
						<td><?php echo fecha_estandar($carga['FNacimiento']); ?></td>	
						<td><?php echo $carga['Sexo']; ?></td>		
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo $new_location.'&id='.$_GET['id'].'&edit='.$carga['idCarga']; ?>" title="Editar Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php 
									$ubicacion = $new_location.'&id='.$_GET['id'].'&del='.simpleEncode($carga['idCarga'], fecha_actual());
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
