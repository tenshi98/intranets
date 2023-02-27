<?php
/**************************************************************************/
echo '<div class="tab-pane fade" id="Menu_tab_1">';

	//verifico la existencia del rut
	if(isset($_SESSION['usuario']['basic_data']['Rut'])&&$_SESSION['usuario']['basic_data']['Rut']!=''){
		$Rut = $_SESSION['usuario']['basic_data']['Rut'];
		$Rut = str_replace(' ', '', $Rut);//elimino espacios
		$Rut = str_replace('-', '', $Rut);//elimino los guines
		$Rut = str_replace('.', '', $Rut);//elimino los puntos
		
		$s_folder = DB_SITE_ALT_1.'/ClientFiles/index.php?Rut='.$Rut;
		
		echo '
		<style>
			.iframe_elfinder{height: 1500px; margin-top:15px;}
			iframe{float:right;width: 100%;height: 100%;padding: 0;margin: 0;border:none;}
		</style>
		<div class="iframe_elfinder">
			<iframe class="embed-responsive-item" src="'.$s_folder.'" allowfullscreen></iframe>
		</div>';
	//si no existe mando error	
	}else{
		$Alert_Text = 'No tiene un rut guardado, favor de poner su rut en los datos basicos';
		alert_post_data(4,2,2, $Alert_Text);
	}
	
	
	
							
					
echo '</div>';

?>

