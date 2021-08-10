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
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-video-camera" aria-hidden="true"></i> Mis Grupos de Camaras';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'grupo_update';
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
// tomo los datos del usuario
$query = "SELECT Nombre, idSistema, N_Camaras, idSubconfiguracion, idTipoCamara, 
Config_usuario, Config_Password, Config_IP, Config_Puerto, Config_Web
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
$rowdata = mysqli_fetch_assoc ($resultado);?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowdata['Nombre'], 'Editar Datos Basicos');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_camaras.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'principal_camaras_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-ol" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_config.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;min-height:500px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>		
			
					<?php  
					//Se verifican si existen los datos
					if(isset($Nombre)) {              $x1 = $Nombre;               }else{$x1 = $rowdata['Nombre'];}
					if(isset($N_Camaras)) {           $x2 = $N_Camaras;            }else{$x2 = $rowdata['N_Camaras'];}
					if(isset($idSubconfiguracion)) {  $x3 = $idSubconfiguracion;   }else{$x3 = $rowdata['idSubconfiguracion'];}
					if(isset($idTipoCamara)) {        $x4 = $idTipoCamara;         }else{$x4 = $rowdata['idTipoCamara'];}
					if(isset($Config_usuario)) {      $x5 = $Config_usuario;       }else{$x5 = $rowdata['Config_usuario'];}
					if(isset($Config_Password)) {     $x6 = $Config_Password;      }else{$x6 = $rowdata['Config_Password'];}
					if(isset($Config_IP)) {           $x7 = $Config_IP;            }else{$x7 = $rowdata['Config_IP'];}
					if(isset($Config_Puerto)) {       $x8 = $Config_Puerto;        }else{$x8 = $rowdata['Config_Puerto'];}
					if(isset($Config_Web)) {          $x9 = $Config_Web;           }else{$x9 = $rowdata['Config_Web'];}
					//IP en caso de no existir
					if(!isset($x7) OR $x7=='') { $x7 = obtenerIpCliente();}
					
					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre del Grupo Camaras', 'Nombre', $x1, 1);
					$Form_Inputs->form_input_number_spinner('N° Camaras','N_Camaras', $x2, 0, 500, 1, 0, 1);
					$Form_Inputs->form_select('Subconfiguracion','idSubconfiguracion', $x3, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Tipo de Camara','idTipoCamara', $x4, 1, 'idTipoCamara', 'Nombre', 'core_tipos_camara', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Usuario', 'Config_usuario', $x5, 1);
					$Form_Inputs->form_input_text('Password', 'Config_Password', $x6, 1);
					$Form_Inputs->form_input_text('Web o IP', 'Config_IP', $x7, 1);
					$Form_Inputs->form_input_number_spinner('N° Puerto','Config_Puerto', $x8, 0, 10000, 1, 0, 1);
					$Form_Inputs->form_input_text('Web configuracion', 'Config_Web', $x9, 1);
					
					
					$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);
					$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
					$Form_Inputs->form_input_hidden('idCamara', $_GET['id'], 2);
					
					
					?>
					
					<script>
						//oculto los div
						document.getElementById('div_idTipoCamara').style.display = 'none';
						document.getElementById('div_Config_usuario').style.display = 'none';
						document.getElementById('div_Config_Password').style.display = 'none';
						document.getElementById('div_Config_IP').style.display = 'none';
						document.getElementById('div_Config_Puerto').style.display = 'none';
						document.getElementById('div_Config_Web').style.display = 'none';
						
						var idSubconfiguracion;
						var idSubconfiguracion_sel;
						
						$(document).ready(function(){ //se ejecuta al cargar la página (OBLIGATORIO)
									
							idSubconfiguracion= $("#idSubconfiguracion").val();
							
							//Si tiene subconfiguracion
							if(idSubconfiguracion == 1){ 
								document.getElementById('div_idTipoCamara').style.display = 'none';
								document.getElementById('div_Config_usuario').style.display = 'none';
								document.getElementById('div_Config_Password').style.display = 'none';
								document.getElementById('div_Config_IP').style.display = 'none';
								document.getElementById('div_Config_Puerto').style.display = 'none';			
								document.getElementById('div_Config_Web').style.display = 'none';			
								//se vacian los datos
								document.getElementById('idTipoCamara').selectedIndex = 0;
								document.getElementById('Config_usuario').value = "";
								document.getElementById('Config_Password').value = "";
								document.getElementById('Config_IP').value = "";
								document.getElementById('Config_Puerto').value = "";
								document.getElementById('Config_Web').value = "";
								
							//No tiene subconfiguracion
							}else if(idSubconfiguracion == 2){ 
								document.getElementById('div_idTipoCamara').style.display = 'block';
								document.getElementById('div_Config_usuario').style.display = 'block';
								document.getElementById('div_Config_Password').style.display = 'block';
								document.getElementById('div_Config_IP').style.display = 'block';
								document.getElementById('div_Config_Puerto').style.display = 'block';
								document.getElementById('div_Config_Web').style.display = 'block';			
								
							//si no en ninguno
							}else{ 
								document.getElementById('div_idTipoCamara').style.display = 'none';
								document.getElementById('div_Config_usuario').style.display = 'none';
								document.getElementById('div_Config_Password').style.display = 'none';
								document.getElementById('div_Config_IP').style.display = 'none';
								document.getElementById('div_Config_Puerto').style.display = 'none';
								document.getElementById('div_Config_Web').style.display = 'none';			
								//se vacian los datos
								document.getElementById('idTipoCamara').selectedIndex = 0;
								document.getElementById('Config_usuario').value = "";
								document.getElementById('Config_Password').value = "";
								document.getElementById('Config_IP').value = "";
								document.getElementById('Config_Puerto').value = "";
								document.getElementById('Config_Web').value = "";
								
							}		
						}); 
						
									
						$("#idSubconfiguracion").on("change", function(){ //se ejecuta al cambiar valor del select
							
							idSubconfiguracion_sel= $("#idSubconfiguracion").val();
							
							//Si tiene subconfiguracion
							if(idSubconfiguracion_sel == 1){ 
								document.getElementById('div_idTipoCamara').style.display = 'none';
								document.getElementById('div_Config_usuario').style.display = 'none';
								document.getElementById('div_Config_Password').style.display = 'none';
								document.getElementById('div_Config_IP').style.display = 'none';
								document.getElementById('div_Config_Puerto').style.display = 'none';			
								document.getElementById('div_Config_Web').style.display = 'none';			
								//se vacian los datos
								document.getElementById('idTipoCamara').selectedIndex = 0;
								document.getElementById('Config_usuario').value = "";
								document.getElementById('Config_Password').value = "";
								document.getElementById('Config_IP').value = "";
								document.getElementById('Config_Puerto').value = "";
								document.getElementById('Config_Web').value = "";
								
							//No tiene subconfiguracion
							}else if(idSubconfiguracion_sel == 2){ 
								document.getElementById('div_idTipoCamara').style.display = 'block';
								document.getElementById('div_Config_usuario').style.display = 'block';
								document.getElementById('div_Config_Password').style.display = 'block';
								document.getElementById('div_Config_IP').style.display = 'block';
								document.getElementById('div_Config_Puerto').style.display = 'block';
								document.getElementById('div_Config_Web').style.display = 'block';			
								
							//si no en ninguno
							}else{ 
								document.getElementById('div_idTipoCamara').style.display = 'none';
								document.getElementById('div_Config_usuario').style.display = 'none';
								document.getElementById('div_Config_Password').style.display = 'none';
								document.getElementById('div_Config_IP').style.display = 'none';
								document.getElementById('div_Config_Puerto').style.display = 'none';
								document.getElementById('div_Config_Web').style.display = 'none';			
								//se vacian los datos
								document.getElementById('idTipoCamara').selectedIndex = 0;
								document.getElementById('Config_usuario').value = "";
								document.getElementById('Config_Password').value = "";
								document.getElementById('Config_IP').value = "";
								document.getElementById('Config_Puerto').value = "";
								document.getElementById('Config_Web').value = "";
								
							}
							
						});
					
					</script>
					
					

					<div class="form-group">
						<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit"> 		
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
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
