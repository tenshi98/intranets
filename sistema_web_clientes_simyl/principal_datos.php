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
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Perfil creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Perfil editado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Perfil borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// consulto los datos
$query = "SELECT  
clientes_listado.email, 
clientes_listado.Nombre, 
clientes_listado.Rut, 
clientes_listado.RazonSocial, 
clientes_listado.fNacimiento, 
clientes_listado.Direccion, 
clientes_listado.Fono1, 
clientes_listado.Fono2, 
clientes_listado.Fax,
clientes_listado.PersonaContacto,
clientes_listado.PersonaContacto_Fono,
clientes_listado.PersonaContacto_email,
clientes_listado.Web,
clientes_listado.Giro,
clientes_listado.idTipo,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
clientes_tipos.Nombre AS tipoCliente,
core_rubros.Nombre AS Rubro

FROM `clientes_listado`
LEFT JOIN `core_ubicacion_ciudad`      ON core_ubicacion_ciudad.idCiudad        = clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`     ON core_ubicacion_comunas.idComuna       = clientes_listado.idComuna
LEFT JOIN `clientes_tipos`             ON clientes_tipos.idTipo                 = clientes_listado.idTipo
LEFT JOIN `core_rubros`                ON core_rubros.idRubro                   = clientes_listado.idRubro
WHERE clientes_listado.idCliente = '".$_SESSION['usuario']['basic_data']['idCliente']."'";
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

<style>.tab-content {min-height: 250px !important;}</style>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Cliente', $rowdata['Nombre'], 'Resumen');?>
</div>
<div class="clearfix"></div> 

<?php
/****************************************************************************/
//mensaje en caso de no haber cambiado la contraseña
if(isset($_SESSION['usuario']['basic_data']['password'])&&$_SESSION['usuario']['basic_data']['password']=='81dc9bdb52d04dc20036dbd8313ed055'){
	echo '<div class="col-sm-12">';
	$Alert_Text  = '<strong>Cambio de contraseña: </strong> ';
	$Alert_Text .= 'Por motivos de seguridad, se recomienda <strong>cambiar</strong> la contraseña';
	$Alert_Text .= '<a href="principal_datos_datos_password.php" title="Cambio de contraseña" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cambio de contraseña</a>';
	alert_post_data(2,1,2, $Alert_Text);
	echo '</div>';
} ?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'principal_datos.php';?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php';?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_contacto.php';?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_datos_persona_contacto.php';?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<?php if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
							<li class=""><a href="<?php echo 'principal_datos_datos_comerciales.php';?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'principal_datos_datos_password.php';?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="col-sm-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-sm-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Cliente : </strong><?php echo $rowdata['tipoCliente']; ?><br/>
								<?php 
								//Si el cliente es una empresa
								if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
									<strong>Nombre Fantasia: </strong><?php echo $rowdata['Nombre']; ?><br/>
								<?php 
								//si es una persona
								}else{ ?>
									<strong>Nombre: </strong><?php echo $rowdata['Nombre']; ?><br/>
									<strong>Rut : </strong><?php echo $rowdata['Rut']; ?><br/>
								<?php } ?>
								<strong>Fecha de Ingreso Sistema : </strong><?php echo Fecha_completa($rowdata['fNacimiento']); ?><br/>
								<strong>Region : </strong><?php echo $rowdata['nombre_region']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowdata['nombre_comuna']; ?><br/>
								<strong>Direccion : </strong><?php echo $rowdata['Direccion']; ?>
							</p>
									
							<?php 
							//Si el cliente es una empresa
							if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
								<p class="text-muted">
									<strong>Rut : </strong><?php echo $rowdata['Rut']; ?><br/>
									<strong>Razon Social : </strong><?php echo $rowdata['RazonSocial']; ?><br/>
									<strong>Giro de la empresa: </strong><?php echo $rowdata['Giro']; ?><br/>
									<strong>Rubro : </strong><?php echo $rowdata['Rubro']; ?><br/>
								</p>
							<?php } ?>
										
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
							<p class="text-muted">
								<strong>Telefono Fijo : </strong><?php echo $rowdata['Fono1']; ?><br/>
								<strong>Telefono Movil : </strong><?php echo $rowdata['Fono2']; ?><br/>
								<strong>Fax : </strong><?php echo $rowdata['Fax']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowdata['email']; ?>"><?php echo $rowdata['email']; ?></a><br/>
								<strong>Web : </strong><a target="_blank" rel="noopener noreferrer" href="https://<?php echo $rowdata['Web']; ?>"><?php echo $rowdata['Web']; ?></a>
							</p>
									
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Persona de Contacto</h2>
							<p class="text-muted">
								<strong>Persona de Contacto : </strong><?php echo $rowdata['PersonaContacto']; ?><br/>
								<strong>Telefono : </strong><?php echo $rowdata['PersonaContacto_Fono']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowdata['PersonaContacto_email']; ?>"><?php echo $rowdata['PersonaContacto_email']; ?></a><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<?php 
						//se arma la direccion
						$direccion = "";
						if(isset($rowdata["Direccion"])&&$rowdata["Direccion"]!=''){           $direccion .= $rowdata["Direccion"];}
						if(isset($rowdata["nombre_comuna"])&&$rowdata["nombre_comuna"]!=''){   $direccion .= ', '.$rowdata["nombre_comuna"];}
						if(isset($rowdata["nombre_region"])&&$rowdata["nombre_region"]!=''){   $direccion .= ', '.$rowdata["nombre_region"];}
						//se despliega mensaje en caso de no existir direccion
						if($direccion!=''){
							echo mapa_from_direccion($direccion, $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 20, 2);
						}else{
							$Alert_Text = 'No tiene una direccion definida';
							alert_post_data(4,2,2, $Alert_Text);
						}
						?>
					</div>
				</div>
				<div class="clearfix"></div>
			
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
