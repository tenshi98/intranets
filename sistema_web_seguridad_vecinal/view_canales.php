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
$Identif    = simpleDecode($_GET['view'], fecha_actual());	//Channel_ID
$myApiKey   = "AIzaSyBiqkXLqrRyQejcL8cEBXxuCqSwTYMeeb4";    // Provide your API Key
$maxResults = "20";                                         // Number of results to display

$myChannelID  = $Identif; // Provide your Channel ID 
$myQuery      = "https://www.googleapis.com/youtube/v3/search?key=".$myApiKey."&channelId=".$myChannelID."&part=snippet,id&order=date&maxResults=".$maxResults;
$videoList    = file_get_contents($myQuery);
$decoded      = json_decode($videoList, true);
														
?>


<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Vecino</h5>	
		</header>
        <div id="div-3" class="tab-content">
			
			<?php 
			// Run a loop to display list of videos
			foreach ($decoded['items'] as $items){
				$id           = $items['id']['videoId'];
				$title        = $items['snippet']['title'];
				$description  = $items['snippet']['description'];
				$thumbnail    = $items['snippet']['thumbnails']['default']['url']; ?>
				
				<div class="col-md-2" style="float: left;">
					<div class="thumbnail">
						<a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=<?php echo $id; ?>" title="<?php echo $title; ?>" class="tooltip" style="position: initial;">
							<img src="<?php echo $thumbnail; ?>" width="100%">
						</a>							
					</div>
				</div>
			<?php } ?>
			
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
