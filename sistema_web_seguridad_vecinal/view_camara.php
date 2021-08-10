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
$Identif = simpleDecode($_GET['view'], fecha_actual());	 //identificador
$Client  = simpleDecode($_GET['client'], fecha_actual()); //cliente	
$Chanel  = simpleDecode($_GET['chanel'], fecha_actual()); //canal del dvr								
?>
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo $_SESSION['vecinos_camaras'][$Client]['VecinoDireccion'].' - '.$_SESSION['vecinos_camaras_list'][$Client][$Identif]['Nombre']; ?></h5>
		</header>
		<div class="table-responsive">
			<div class="col-sm-8 fcenter">   
				<?php
				//Variables
				$SIS_Config_usuario   = $_SESSION['vecinos_camaras_list'][$Client][$Identif]['Config_usuario'];
				$SIS_Config_Password  = $_SESSION['vecinos_camaras_list'][$Client][$Identif]['Config_Password'];
				$SIS_Config_IP        = $_SESSION['vecinos_camaras_list'][$Client][$Identif]['Config_IP'];
				$SIS_Config_Puerto    = $_SESSION['vecinos_camaras_list'][$Client][$Identif]['Config_Puerto'];
				
				//se crea la direccion web
				$direccion  = 'http://';
				$direccion .= $SIS_Config_usuario;
				$direccion .= ':'.$SIS_Config_Password;
				$direccion .= '@'.$SIS_Config_IP;
				if(isset($SIS_Config_Puerto)&&$SIS_Config_Puerto!=''){$direccion .= ':'.$SIS_Config_Puerto;}
				
				//si esta configurado
				if($SIS_Config_usuario!=''&&$SIS_Config_Password!=''&&$SIS_Config_IP!=''){
					//Verifico el tipo de camara
					switch ($_SESSION['vecinos_camaras_list'][$Client][$Identif]['idTipoCamara']) {
						//Dahua
						case 1:
							echo '<img class="img-thumbnail" name="main" id="main" border="0" width="100%" height="100%" src="'.$direccion.'/cgi-bin/mjpg/video.cgi?channel='.$Chanel.'&subtype=1">';
							break;
						//otra
						case 2:
							//echo '<img name="main" id="main" border="0" width="640" height="480" >';
							break;
					}
				}else{
					echo '<div class="col-xs-12" style="margin-top:15px;">';
						$Alert_Text = 'La camara compartida no esta completamente configurada';
						alert_post_data(4,3,1, $Alert_Text);
					echo '</div>';
				}
				?>
			
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
