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
$new_location = "principal_camaras_config.php";
$new_location .='?pagina='.$_GET['pagina'];
$new_location .='&id='.$_GET['id'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-video-camera" aria-hidden="true"></i> Mis Grupos de Camaras';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit_zona']) )  { 
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'camara_insert';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_camaras_listado.php';
}
//formulario para editar
if ( !empty($_POST['submit_edit_camara']) )  { 
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'camara_update';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_camaras_listado.php';
}
//se borra un dato
if ( !empty($_GET['del_camara']) )     {
	//se agregan ubicaciones
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'camara_del';
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
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Camara creada correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Camara editada correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Camara borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['edit_camara']) ) {
// consulto los datos
$query = "SELECT idSubconfiguracion
FROM `seg_vecinal_camaras_listado`
WHERE idCamara = ".simpleDecode($_GET['id'], fecha_actual());
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
$rowConfig = mysqli_fetch_assoc ($resultado);	 
// consulto los datos
$query = "SELECT Nombre,idTipoCamara,Config_usuario,Config_Password,Config_IP,
Config_Puerto,Config_Web,idEstado, Chanel
FROM `seg_vecinal_camaras_listado_canales`
WHERE idCanal = ".simpleDecode($_GET['edit_camara'], fecha_actual());
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
 <div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Editar Camara</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
				<?php 
				
				//Se verifican si existen los datos
				if(isset($Nombre)) {           $x1  = $Nombre;           }else{$x1  = $rowdata['Nombre'];}
				if(isset($idTipoCamara)) {     $x2  = $idTipoCamara;     }else{$x2  = $rowdata['idTipoCamara'];}
				if(isset($Config_usuario)) {   $x3  = $Config_usuario;   }else{$x3  = $rowdata['Config_usuario'];}
				if(isset($Config_Password)) {  $x4  = $Config_Password;  }else{$x4  = $rowdata['Config_Password'];}
				if(isset($Config_IP)) {        $x5  = $Config_IP;        }else{$x5  = $rowdata['Config_IP'];}
				if(isset($Config_Puerto)) {    $x6  = $Config_Puerto;    }else{$x6  = $rowdata['Config_Puerto'];}
				if(isset($Config_Web)) {       $x7  = $Config_Web;       }else{$x7  = $rowdata['Config_Web'];}
				if(isset($Chanel)) {           $x8  = $Chanel;           }else{$x8  = $rowdata['Chanel'];}
				if(isset($idEstado)) {         $x9  = $idEstado;         }else{$x9  = $rowdata['idEstado'];}
				//IP en caso de no existir
				if(!isset($x5) OR $x5=='') { $x5 = obtenerIpCliente();}
					
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre de la Camara', 'Nombre', $x1, 2);	
				//se verifica que permita subconfiguracion
				if(isset($rowConfig['idSubconfiguracion'])&&$rowConfig['idSubconfiguracion']==1){
					$Form_Inputs->form_select('Tipo de Camara','idTipoCamara', $x2, 1, 'idTipoCamara', 'Nombre', 'core_tipos_camara', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Usuario', 'Config_usuario', $x3, 1);
					$Form_Inputs->form_input_text('Password', 'Config_Password', $x4, 1);
					$Form_Inputs->form_input_text('Web o IP', 'Config_IP', $x5, 1);
					$Form_Inputs->form_input_number_spinner('N° Puerto','Config_Puerto', $x6, 0, 10000, 1, 0, 1);
					$Form_Inputs->form_input_text('Web configuracion', 'Config_Web', $x7, 1);
				}
				$Form_Inputs->form_post_data(2, 'Este numero de canal debe de coincidir con el que figura en el DVR O NVR.');
				$Form_Inputs->form_input_number_spinner('N° de Canal','Chanel', $x8, 0, 99, 1, 0, 2);
				$Form_Inputs->form_select('Estado','idEstado', $x9, 2, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);	
				
				$Form_Inputs->form_input_hidden('idCamara', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idCanal', $_GET['edit_camara'], 2);
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
				?>

							
				<div class="form-group">	
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_camara">	
					<a href="<?php echo $new_location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>		
				</div>
			</form> 
			<?php widget_validator(); ?>
		</div>
	</div>
</div> 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } elseif ( ! empty($_GET['new']) ) { 
// consulto los datos
$query = "SELECT idSubconfiguracion
FROM `seg_vecinal_camaras_listado`
WHERE idCamara = ".simpleDecode($_GET['id'], fecha_actual());
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
$rowConfig = mysqli_fetch_assoc ($resultado);	 
	 
?>
 <div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Crear Camara</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {           $x1  = $Nombre;           }else{$x1  = '';}
				if(isset($idTipoCamara)) {     $x2  = $idTipoCamara;     }else{$x2  = '';}
				if(isset($Config_usuario)) {   $x3  = $Config_usuario;   }else{$x3  = '';}
				if(isset($Config_Password)) {  $x4  = $Config_Password;  }else{$x4  = '';}
				if(isset($Config_IP)) {        $x5  = $Config_IP;        }else{$x5  = obtenerIpCliente();}
				if(isset($Config_Puerto)) {    $x6  = $Config_Puerto;    }else{$x6  = '';}
				if(isset($Config_Web)) {       $x7  = $Config_Web;       }else{$x7  = '';}
				if(isset($Chanel)) {           $x8  = $Chanel;           }else{$x8  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre de la Camara', 'Nombre', $x1, 2);	
				//se verifica que permita subconfiguracion
				if(isset($rowConfig['idSubconfiguracion'])&&$rowConfig['idSubconfiguracion']==1){
					$Form_Inputs->form_select('Tipo de Camara','idTipoCamara', $x2, 1, 'idTipoCamara', 'Nombre', 'core_tipos_camara', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Usuario', 'Config_usuario', $x3, 1);
					$Form_Inputs->form_input_text('Password', 'Config_Password', $x4, 1);
					$Form_Inputs->form_input_text('Web o IP', 'Config_IP', $x5, 1);
					$Form_Inputs->form_input_number_spinner('N° Puerto','Config_Puerto', $x6, 0, 10000, 1, 0, 1);
					$Form_Inputs->form_input_text('Web configuracion', 'Config_Web', $x7, 1);
				}
				$Form_Inputs->form_post_data(2, 'Este numero de canal debe de coincidir con el que figura en el DVR O NVR.');
				$Form_Inputs->form_input_number_spinner('N° de Canal','Chanel', $x8, 0, 99, 1, 0, 2);
					
				$Form_Inputs->form_input_hidden('idCamara', $_GET['id'], 2);
				$Form_Inputs->form_input_hidden('idEstado', simpleEncode(1, fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
				
				?>

							
				<div class="form-group">	
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_zona">	
					<a href="<?php echo $new_location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>		
				</div>
			</form> 
			<?php widget_validator(); ?>
		</div>
	</div>
</div> 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
} else  { 	 
// consulto los datos
$query = "SELECT Nombre, N_Camaras, idSubconfiguracion
FROM `seg_vecinal_camaras_listado`
WHERE idCamara = ".simpleDecode($_GET['id'], fecha_actual());
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
$arrCamaras = array();
$query = "SELECT 
seg_vecinal_camaras_listado_canales.idCanal,
seg_vecinal_camaras_listado_canales.idCamara,
seg_vecinal_camaras_listado_canales.Nombre,
seg_vecinal_camaras_listado_canales.Chanel,
seg_vecinal_camaras_listado_canales.Config_usuario,
seg_vecinal_camaras_listado_canales.Config_Password,
seg_vecinal_camaras_listado_canales.Config_IP,
core_estados.Nombre AS estado,
seg_vecinal_camaras_listado_canales.idEstado

FROM `seg_vecinal_camaras_listado_canales`
LEFT JOIN `core_estados`   ON core_estados.idEstado = seg_vecinal_camaras_listado_canales.idEstado
WHERE seg_vecinal_camaras_listado_canales.idCamara = ".simpleDecode($_GET['id'], fecha_actual())."
ORDER BY seg_vecinal_camaras_listado_canales.Nombre ASC";
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
array_push( $arrCamaras,$row );
}

//Se cuenta el total de camaras
$total_cam = 0;
foreach ($arrCamaras as $zona) {
	$total_cam++;
}

?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowdata['Nombre'], 'Editar Camaras');?>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<?php if ($rowdata['N_Camaras']>$total_cam){?><a href="<?php echo $new_location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Camara</a><?php } ?>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_camaras.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-ol" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class="active"><a href="<?php echo 'principal_camaras_config.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>	
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<?php if(isset($rowdata['idSubconfiguracion'])&&$rowdata['idSubconfiguracion']==1){ ?>
							<th>Usuario</th>
							<th>Password</th>
							<th>IP</th>
						<?php } ?>
						<th width="160">N° de Canal</th>
						<th width="160">Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCamaras as $zona) { ?>
						<tr class="odd">		
							<td><?php echo $zona['Nombre']; ?></td>	
							<?php if(isset($rowdata['idSubconfiguracion'])&&$rowdata['idSubconfiguracion']==1){ ?>
								<td><?php echo $zona['Config_usuario']; ?></td>	
								<td><?php echo $zona['Config_Password']; ?></td>	
								<td><?php echo $zona['Config_IP']; ?></td>	
							<?php } ?>
							<td><?php echo $zona['Chanel']; ?></td>	
							<td><label class="label <?php if(isset($zona['idEstado'])&&$zona['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $zona['estado']; ?></label></td>		
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $new_location.'&edit_camara='.simpleEncode($zona['idCanal'], fecha_actual()); ?>" title="Editar Informacion Basica" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $new_location.'&idCamara='.simpleEncode($zona['idCamara'], fecha_actual()).'&del_camara='.simpleEncode($zona['idCanal'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la camara '.$zona['Nombre'].'?';?>
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
