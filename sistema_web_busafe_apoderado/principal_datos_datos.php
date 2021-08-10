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
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Perfil creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Perfil editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Perfil borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// Se traen todos los datos del trabajador
$query = "SELECT Nombre,ApellidoPat,ApellidoMat,Rut,FNacimiento,Fono1,Fono2,idCiudad,idComuna,Direccion
FROM `apoderados_listado`
WHERE idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);
?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Apoderado', $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat'], 'Editar Datos Personales');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_ubicacion.php'; ?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicacion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Foto</a></li>
						<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>		
			
					<?php 
					//Se verifican si existen los datos
					if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = $rowdata['Nombre'];}
					if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = $rowdata['ApellidoPat'];}
					if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = $rowdata['ApellidoMat'];}
					if(isset($FNacimiento)) {         $x4  = $FNacimiento;          }else{$x4  = $rowdata['FNacimiento'];}
					if(isset($Rut)) {                 $x5  = $Rut;                  }else{$x5  = $rowdata['Rut'];}
					if(isset($Fono1)) {               $x6  = $Fono1;                }else{$x6  = $rowdata['Fono1'];}
					if(isset($Fono2)) {               $x7  = $Fono2;                }else{$x7  = $rowdata['Fono2'];}
					if(isset($idCiudad)) {            $x8  = $idCiudad;             }else{$x8  = $rowdata['idCiudad'];}
					if(isset($idComuna)) {            $x9  = $idComuna;             }else{$x9  = $rowdata['idComuna'];}
					if(isset($Direccion)) {           $x10 = $Direccion;            }else{$x10 = $rowdata['Direccion'];}
					
					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
					$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 2);
					$Form_Inputs->form_date('Fecha Nacimiento','FNacimiento', $x4, 1);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x5, 2);
					$Form_Inputs->form_input_phone('Fono Celular', 'Fono1', $x6, 1);
					$Form_Inputs->form_input_phone('Fono Fijo', 'Fono2', $x7, 1);
					$Form_Inputs->form_select_depend1('Ciudad','idCiudad', $x8, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x9, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
											 $dbConn, 'form1');
					$Form_Inputs->form_input_icon('Direccion', 'Direccion', $x10, 1,'fa fa-map');
					
					

					$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);
					
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
