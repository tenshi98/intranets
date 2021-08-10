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
$original = "principal_datos.php";
$location = $original;
$new_location = "principal_datos_datos.php";
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_clientes_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Cliente creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Cliente editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Cliente borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// Se traen todos los datos de mi usuario
$query = "SELECT idTipo, Nombre, Rut, fNacimiento, idCiudad, idComuna, Direccion
FROM `seg_vecinal_clientes_listado`
WHERE idCliente = '".$_SESSION['usuario']['basic_data']['idCliente']."'";
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
$rowdata = mysqli_fetch_assoc ($resultado);?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Vecino', $rowdata['Nombre'], 'Editar Datos Basicos');?>
</div>
<div class="clearfix"></div>

<?php
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

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php';?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'principal_datos_datos.php';?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_mapa.php';?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicacion Mapa</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_contacto.php';?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_datos_imagen.php';?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen Perfil</a></li>
						<li class=""><a href="<?php echo 'principal_datos_datos_persona_contacto.php';?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<?php if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
							<li class=""><a href="<?php echo 'principal_datos_datos_comerciales.php';?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'principal_datos_datos_password.php';?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>		
			
					<?php 
					//Se verifican si existen los datos
					if(isset($idTipo)) {           $x1  = $idTipo;            }else{$x1  = $rowdata['idTipo'];}
					if(isset($Nombre)) {           $x2  = $Nombre;            }else{$x2  = $rowdata['Nombre'];}
					if(isset($Rut)) {              $x3  = $Rut;               }else{$x3  = $rowdata['Rut'];}
					//if(isset($fNacimiento)) {      $x4  = $fNacimiento;       }else{$x4  = $rowdata['fNacimiento'];}
					if(isset($idCiudad)) {         $x5  = $idCiudad;          }else{$x5  = $rowdata['idCiudad'];}
					if(isset($idComuna)) {         $x6  = $idComuna;          }else{$x6  = $rowdata['idComuna'];}
					if(isset($Direccion)) {        $x7  = $Direccion;         }else{$x7  = $rowdata['Direccion'];}
					
					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo de Vecino','idTipo', $x1, 2, 'idTipo', 'Nombre', 'seg_vecinal_clientes_tipos', 0, '', $dbConn);
					//Si el cliente es una empresa
					if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){
						$Form_Inputs->form_input_text('Nombre Fantasia', 'Nombre', $x2, 2);
					//si es una persona
					}else{
						$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
						$Form_Inputs->form_input_rut('Rut', 'Rut', $x3, 2);
					} 
					//$Form_Inputs->form_date('F Ingreso Sistema','fNacimiento', $x4, 1);
					$Form_Inputs->form_select_depend1('Ciudad','idCiudad', $x5, 2, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x6, 2, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Direccion', 'Direccion', $x7, 2,'fa fa-map');	 
					
	
					$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);		
					?>

					<div class="form-group">		
						<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit"> 		
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>	
	</div>
</div>



<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
