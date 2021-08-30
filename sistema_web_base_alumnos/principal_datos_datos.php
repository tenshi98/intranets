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
	require_once 'A1XRXS_sys/xrxs_form/alumnos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Datos creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Datos editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Datos borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// consulto los datos
$query = "SELECT idCurso, Nombre, ApellidoPat, ApellidoMat, Rut 
FROM `alumnos_listado`
WHERE idAlumno = '".$_SESSION['usuario']['basic_data']['idAlumno']."'";
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Datos', $rowdata['Nombre'], 'Editar Datos Basicos');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php';?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'principal_datos_datos.php';?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_contacto.php';?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_password.php';?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>		
			
					<?php 
					//Se verifican si existen los datos
					if(isset($idCurso)) {          $x1  = $idCurso;           }else{$x1  = $rowdata['idCurso'];}
					if(isset($Nombre)) {           $x2  = $Nombre;            }else{$x2  = $rowdata['Nombre'];}
					if(isset($ApellidoPat)) {      $x3  = $ApellidoPat;       }else{$x3  = $rowdata['ApellidoPat'];}
					if(isset($ApellidoMat)) {      $x4  = $ApellidoMat;       }else{$x4  = $rowdata['ApellidoMat'];}
					if(isset($Rut)) {              $x5  = $Rut;               }else{$x5  = $rowdata['Rut'];}
					

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Curso','idCurso', $x1, 2, 'idCurso', 'Nombre', 'alumnos_cursos', 0, '',$dbConn);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 2);
					$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x3, 2);
					$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x4, 1);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x5, 2);
					
					$Form_Inputs->form_input_hidden('idAlumno', $_SESSION['usuario']['basic_data']['idAlumno'], 2);	
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
