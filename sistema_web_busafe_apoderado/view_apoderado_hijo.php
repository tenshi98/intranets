<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim); }else{set_time_limit(2400);}             
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M'); }else{ini_set('memory_limit', '4096M');}  
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
// consulto los datos
$query = "SELECT  
apoderados_listado_hijos.Nombre, 
apoderados_listado_hijos.ApellidoPat, 
apoderados_listado_hijos.ApellidoMat,
apoderados_listado_hijos.Direccion_img,
core_sexo.Nombre AS Sexo,
sistema_planes.Nombre AS PlanNombre,
sistema_planes.Valor AS PlanValor,
apoderados_listado_hijos.idDia_1,
apoderados_listado_hijos.idDia_2,
apoderados_listado_hijos.idDia_3,
apoderados_listado_hijos.idDia_4,
apoderados_listado_hijos.idDia_5,
apoderados_listado_hijos.idDia_6,
apoderados_listado_hijos.idDia_7,
apoderados_listado.Nombre AS ApoderadoNombre,
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,
apoderados_listado.Fono1,
apoderados_listado.Fono2,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
apoderados_listado.Direccion,

vehiculos_listado.Patente AS VehiculoIda,
VehiculoVuelta.Patente AS VehiculoVuelta,

TrabajadorIda.Nombre AS TrabajadorIdaNombre,
TrabajadorIda.ApellidoPat AS TrabajadorIdaApellidoPat,
TrabajadorVuelta.Nombre AS TrabajadorVueltaNombre,
TrabajadorVuelta.ApellidoPat AS TrabajadorVueltaApellidoPat

FROM `apoderados_listado_hijos`
LEFT JOIN `core_sexo`                              ON core_sexo.idSexo                  = apoderados_listado_hijos.idSexo
LEFT JOIN `sistema_planes`                         ON sistema_planes.idPlan             = apoderados_listado_hijos.idPlan
LEFT JOIN `apoderados_listado`                     ON apoderados_listado.idApoderado    = apoderados_listado_hijos.idApoderado
LEFT JOIN `core_ubicacion_ciudad`                  ON core_ubicacion_ciudad.idCiudad    = apoderados_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`                 ON core_ubicacion_comunas.idComuna   = apoderados_listado.idComuna
LEFT JOIN `vehiculos_listado`                      ON vehiculos_listado.idVehiculo      = apoderados_listado_hijos.idVehiculo
LEFT JOIN `vehiculos_listado` VehiculoVuelta       ON VehiculoVuelta.idVehiculo         = apoderados_listado_hijos.idVehiculoVuelta
LEFT JOIN `trabajadores_listado` TrabajadorIda     ON TrabajadorIda.idTrabajador        = vehiculos_listado.idTrabajador
LEFT JOIN `trabajadores_listado` TrabajadorVuelta  ON TrabajadorVuelta.idTrabajador     = VehiculoVuelta.idTrabajador

WHERE apoderados_listado_hijos.idHijos = ".$_GET['view'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
$rowdata = mysqli_fetch_assoc ($resultado);

?>


<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos del Pasajero</h5>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				
				<div class="wmd-panel">
					
					<div class="col-sm-4">
						<?php if ($rowdata['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_ALT_1 ?>/upload/<?php echo $rowdata['Direccion_img']; ?>">
						<?php }?>
					</div>
					<div class="col-sm-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat']; ?><br/>
							<strong>Fono : </strong><?php echo $rowdata['Fono1']; ?><br/>
							<strong>Fono : </strong><?php echo $rowdata['Fono2']; ?><br/>
							<strong>Direccion : </strong><?php echo $rowdata['Direccion'].', '.$rowdata['nombre_comuna'].', '.$rowdata['nombre_region']; ?><br/>
							<strong>Sexo : </strong><?php echo $rowdata['Sexo']; ?><br/>
							<strong> Apoderado : </strong><?php echo $rowdata['ApoderadoNombre'].' '.$rowdata['ApoderadoApellidoPat'].' '.$rowdata['ApoderadoApellidoMat']; ?><br/>
						</p>
						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Plan</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowdata['PlanNombre']; ?><br/>
							<strong>Valor : </strong><?php echo valores($rowdata['PlanValor'], 0); ?><br/>
							<strong>Vehiculo Ida : </strong><?php echo $rowdata['VehiculoIda'].' (Conductor:'.$rowdata['TrabajadorIdaNombre'].' '.$rowdata['TrabajadorIdaApellidoPat'].')'; ?><br/>
							<strong>Vehiculo Vuelta : </strong><?php echo $rowdata['VehiculoVuelta'].' (Conductor:'.$rowdata['TrabajadorVueltaNombre'].' '.$rowdata['TrabajadorVueltaApellidoPat'].')'; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Dias Contratados</h2>
						<p class="text-muted">
							<?php if(isset($rowdata['idDia_1'])&&$rowdata['idDia_1']!=0){echo '<strong>Lunes</strong><br/>';}?>
							<?php if(isset($rowdata['idDia_2'])&&$rowdata['idDia_2']!=0){echo '<strong>Martes</strong><br/>';}?>
							<?php if(isset($rowdata['idDia_3'])&&$rowdata['idDia_3']!=0){echo '<strong>Miercoles</strong><br/>';}?>
							<?php if(isset($rowdata['idDia_4'])&&$rowdata['idDia_4']!=0){echo '<strong>Jueves</strong><br/>';}?>
							<?php if(isset($rowdata['idDia_5'])&&$rowdata['idDia_5']!=0){echo '<strong>Viernes</strong><br/>';}?>
							<?php if(isset($rowdata['idDia_6'])&&$rowdata['idDia_6']!=0){echo '<strong>Sabado</strong><br/>';}?>
							<?php if(isset($rowdata['idDia_7'])&&$rowdata['idDia_7']!=0){echo '<strong>Domingo</strong><br/>';}?>
						</p>

					</div>	
					<div class="clearfix"></div>
			
				</div>
			</div>
        </div>	
	</div>
</div>

           

<?php 
//si se entrega la opcion de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){ 
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php 
	//para las versiones nuevas que indican donde volver
	}else{ 
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
		
	<?php }		
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
?>
