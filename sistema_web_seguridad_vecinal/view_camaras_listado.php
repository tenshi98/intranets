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
//identificador
$Identif = simpleDecode($_GET['view'], fecha_actual());	
// consulto los datos
$query = "SELECT 
seg_vecinal_camaras_listado.idCamara,
seg_vecinal_camaras_listado.Nombre,
seg_vecinal_camaras_listado.idSubconfiguracion,
seg_vecinal_camaras_listado.N_Camaras,
seg_vecinal_camaras_listado.Config_usuario,
seg_vecinal_camaras_listado.Config_Password,
seg_vecinal_camaras_listado.Config_IP,
seg_vecinal_camaras_listado.Config_Puerto,

core_sistemas.Nombre AS sistema,
core_estados.Nombre AS estado,
core_sistemas_opciones.Nombre AS Subconfiguracion,
core_tipos_camara.Nombre AS TipoCamara

FROM `seg_vecinal_camaras_listado`
LEFT JOIN `core_sistemas`              ON core_sistemas.idSistema             = seg_vecinal_camaras_listado.idSistema
LEFT JOIN `core_estados`               ON core_estados.idEstado               = seg_vecinal_camaras_listado.idEstado
LEFT JOIN `core_sistemas_opciones`     ON core_sistemas_opciones.idOpciones   = seg_vecinal_camaras_listado.idSubconfiguracion
LEFT JOIN `core_tipos_camara`          ON core_tipos_camara.idTipoCamara      = seg_vecinal_camaras_listado.idTipoCamara

WHERE seg_vecinal_camaras_listado.idCamara = ".$Identif;
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Camaras de seguridad</h5>
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					<div class="col-sm-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/camara_seg.jpg">
					</div>
					<div class="col-sm-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
						<p class="text-muted">
							<strong>Nombre del Grupo : </strong><?php echo $rowdata['Nombre']; ?><br/>
							<strong>Numero de Camaras: </strong><?php echo $rowdata['N_Camaras']; ?><br/>
							<strong>Estado : </strong><?php echo $rowdata['estado']; ?><br/>
							<strong>Subconfiguracion : </strong><?php echo $rowdata['Subconfiguracion']; ?>
						</p>
										
						<?php if(isset($rowdata['idSubconfiguracion'])&&$rowdata['idSubconfiguracion']==2){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Subconfiguracion</h2>
							<p class="text-muted">
								<strong>Tipo de Camara : </strong><?php echo $rowdata['TipoCamara']; ?><br/>
								<strong>Usuario : </strong><?php echo $rowdata['Config_usuario']; ?><br/>
								<strong>Password: </strong><?php echo $rowdata['Config_Password']; ?><br/>
								<strong>IP : </strong><?php echo $rowdata['Config_IP']; ?><br/>
								<strong>Puerto : </strong><?php echo $rowdata['Config_Puerto']; ?><br/>
							</p>
						<?php } ?>
						
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
