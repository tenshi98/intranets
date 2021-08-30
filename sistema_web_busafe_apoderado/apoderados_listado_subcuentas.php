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
$original = "apoderados_listado_subcuentas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Subcuentas';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_subcuentas.php';
}
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_subcuentas.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_subcuentas.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Subcuenta creada correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Subcuenta editada correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Subcuenta borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['edit']) ) { 
// consulto los datos
$query = "SELECT Nombre, Usuario, Password, email
FROM `apoderados_subcuentas`
WHERE idSubcuenta = ".$_GET['edit'];
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
			<h5>Editar Subcuenta</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>

				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {     $x1  = $Nombre;    }else{$x1  = $rowdata['Nombre'];}
				if(isset($Usuario)) {    $x2  = $Usuario;   }else{$x2  = $rowdata['Usuario'];}
				if(isset($Password)) {   $x3  = $Password;  }else{$x3  = $rowdata['Password'];}
				if(isset($email)) {      $x4  = $email;     }else{$x4  = $rowdata['email'];}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombres', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_rut('Rut', 'Usuario', $x2, 2);
				$Form_Inputs->form_input_password('Contraseña', 'Password', $x3, 2);
				$Form_Inputs->form_input_icon('Email', 'email', $x4, 1,'fa fa-envelope-o');
				
				$Form_Inputs->form_input_hidden('idSubcuenta', $_GET['edit'], 2);
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
}elseif ( ! empty($_GET['new']) ) { ?>

<div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Crear Subcuenta</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
   
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {     $x1  = $Nombre;    }else{$x1  = '';}
				if(isset($Usuario)) {    $x2  = $Usuario;   }else{$x2  = '';}
				if(isset($Password)) {   $x3  = $Password;  }else{$x3  = '';}
				if(isset($email)) {      $x4  = $email;     }else{$x4  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_rut('Rut', 'Usuario', $x2, 2);
				$Form_Inputs->form_input_password('Contraseña', 'Password', $x3, 2);
				$Form_Inputs->form_input_icon('Email', 'email', $x4, 1,'fa fa-envelope-o');
				
				$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);
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
}else{
// Se trae un listado con todas las cargas familiares
$arrSubcuentas = array();
$query = "SELECT idSubcuenta, Nombre, Usuario, Password, email
FROM `apoderados_subcuentas`
WHERE idApoderado = ".$_SESSION['usuario']['basic_data']['idApoderado']."
ORDER BY Nombre ASC ";
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
array_push( $arrSubcuentas,$row );
}
//Se verifica el numero de subcuentas
$nSubcuentas = 0;
foreach ($arrSubcuentas as $sub) {
	$nSubcuentas++;
}

?>


<?php if($nSubcuentas<=9){ ?>
	<div class="col-sm-12 breadcrumb-bar">
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Subcuenta</a>
	</div>
	<div class="clearfix"></div> 
<?php } ?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Subcuentas</h5>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th>Email</th>
						<th width="120">Usuario</th>
						<th width="120">Password</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrSubcuentas as $sub) { ?>
					<tr class="odd">		
						<td><?php echo $sub['Nombre']; ?></td>	
						<td><?php echo $sub['email']; ?></td>
						<td><?php echo $sub['Usuario']; ?></td>	
						<td><?php echo $sub['Password']; ?></td>		
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo $location.'&edit='.$sub['idSubcuenta']; ?>" title="Editar Informacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php 
								$ubicacion = $location.'&del='.simpleEncode($sub['idSubcuenta'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar al usuario '.$sub['Nombre'].'?';?>
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


<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
