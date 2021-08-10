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
?>

<style>.tab-content {min-height: 250px !important;}</style>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Vecino</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="col-sm-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-sm-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Imagen de Perfil</h2>
							<div class="row">
								<div class="col-sm-4">
									<?php
									if ($_SESSION['vecinos'][$Identif]['Direccion_img']=='') {
										echo '<img alt="User Picture" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png">';
									}else{
										echo '<img alt="User Picture" src="'.DB_SITE_ALT_1.'/upload/'.$_SESSION['vecinos'][$Identif]['Direccion_img'].'" width="100%" class="img-thumbnail" >';
									}
									?>
								</div>
							</div>
							
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
							<p class="text-muted word_break">
								<?php 
								//Si el cliente es una empresa
								if(isset($_SESSION['vecinos'][$Identif]['idTipo'])&&$_SESSION['vecinos'][$Identif]['idTipo']==1){
									if($_SESSION['vecinos'][$Identif]['Nombre']!=''){       echo '<strong>Nombre Fantasia: </strong>'.$_SESSION['vecinos'][$Identif]['Nombre'].'<br/>';}
									if($_SESSION['vecinos'][$Identif]['RazonSocial']!=''){  echo '<strong>Razon Social : </strong>'.$_SESSION['vecinos'][$Identif]['RazonSocial'].'<br/>';}
								//si es una persona
								}else{
									if($_SESSION['vecinos'][$Identif]['Nombre']!=''){echo '<strong>Nombre: </strong>'.$_SESSION['vecinos'][$Identif]['Nombre'].'<br/>';} 
								}
								if($_SESSION['vecinos'][$Identif]['Ciudad']!=''){    echo '<strong>Ciudad : </strong>'.$_SESSION['vecinos'][$Identif]['Ciudad'].'<br/>';} 
								if($_SESSION['vecinos'][$Identif]['Comuna']!=''){    echo '<strong>Comuna : </strong>'.$_SESSION['vecinos'][$Identif]['Comuna'].'<br/>';}
								if($_SESSION['vecinos'][$Identif]['Direccion']!=''){ echo '<strong>Direccion : </strong>'.$_SESSION['vecinos'][$Identif]['Direccion'].'<br/>';} 
								?>
							</p>
										
							<?php 
							//Si el cliente esta compartiendo sus datos
							if(isset($_SESSION['vecinos'][$Identif]['idCompartir'])&&$_SESSION['vecinos'][$Identif]['idCompartir']==1){?>	
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
								<p class="text-muted word_break">
									<?php 
									if($_SESSION['vecinos'][$Identif]['Fono1']!=''){  echo '<strong>Telefono Fijo : </strong>'.$_SESSION['vecinos'][$Identif]['Fono1'].'<br/>';} 
									if($_SESSION['vecinos'][$Identif]['Fono2']!=''){  echo '<strong>Telefono Movil : </strong>'.$_SESSION['vecinos'][$Identif]['Fono2'].'<br/>';} 
									if($_SESSION['vecinos'][$Identif]['Fax']!=''){    echo '<strong>Fax : </strong>'.$_SESSION['vecinos'][$Identif]['Fax'].'<br/>';}  
									if($_SESSION['vecinos'][$Identif]['email']!=''){ ?><strong>Email : </strong><a href="mailto:<?php echo $_SESSION['vecinos'][$Identif]['email']; ?>"><?php echo $_SESSION['vecinos'][$Identif]['email']; ?></a><br/><?php } ?>
								</p>
											
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Persona de Contacto</h2>
								<p class="text-muted word_break">
									<?php 
									if($_SESSION['vecinos'][$Identif]['PersonaContacto']!=''){       echo '<strong>Persona de Contacto : </strong>'.$_SESSION['vecinos'][$Identif]['PersonaContacto'].'<br/>';} 
									if($_SESSION['vecinos'][$Identif]['PersonaContacto_Fono']!=''){  echo '<strong>Telefono : </strong>'.$_SESSION['vecinos'][$Identif]['PersonaContacto_Fono'].'<br/>';} 
									if($_SESSION['vecinos'][$Identif]['PersonaContacto_email']!=''){ ?><strong>Email : </strong><a href="mailto:<?php echo $_SESSION['vecinos'][$Identif]['PersonaContacto_email']; ?>"><?php echo $_SESSION['vecinos'][$Identif]['PersonaContacto_email']; ?></a><br/><?php } ?>
								</p>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<?php 
						//se arma la direccion
						$direccion = "";
						if(isset($_SESSION['vecinos'][$Identif]["Direccion"])&&$_SESSION['vecinos'][$Identif]["Direccion"]!=''){  $direccion .= $_SESSION['vecinos'][$Identif]["Direccion"];}
						if(isset($_SESSION['vecinos'][$Identif]["Comuna"])&&$_SESSION['vecinos'][$Identif]["Comuna"]!=''){        $direccion .= ', '.$_SESSION['vecinos'][$Identif]["Comuna"];}
						if(isset($_SESSION['vecinos'][$Identif]["Ciudad"])&&$_SESSION['vecinos'][$Identif]["Ciudad"]!=''){        $direccion .= ', '.$_SESSION['vecinos'][$Identif]["Ciudad"];}
						//se despliega mensaje en caso de no existir direccion
						if($direccion!=''){
							echo mapa_from_gps($_SESSION['vecinos'][$Identif]["GeoLatitud"], $_SESSION['vecinos'][$Identif]["GeoLongitud"], 'Direccion', 'Calle', $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 20, 2);
						}else{
							$Alert_Text  = 'No tiene una direccion definida';
							alert_post_data(4,2,2, $Alert_Text);
						} ?>
					</div>
				</div>
				<div class="clearfix"></div>
				
				
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
