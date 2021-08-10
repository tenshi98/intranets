<?php 
	echo '
	<header>
		<ul class="nav nav-tabs pull-left">';
			//Inicio
			echo '<li class="active"><a href="#Menu_tab_0" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Principal</a></li>';
			
			//Mapa
			echo '<li class=""><a href="#Menu_tab_1" data-toggle="tab"><i class="fa fa-map-o" aria-hidden="true"></i> Mapa</a></li>';
			
			//Otros
			echo '<li class=""><a href="#Menu_tab_97" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i> Buscar Patente</a></li>';
			echo '<li class=""><a href="#Menu_tab_98" data-toggle="tab"><span class="label label-danger">'.$_SESSION['usuario']['basic_data']['total_canales'].'</span> <i class="fa fa-youtube" aria-hidden="true"></i> Canales</a></li>';
			echo '<li class=""><a href="#Menu_tab_99" data-toggle="tab"><i class="fa fa-file-archive-o" aria-hidden="true"></i> Archivos</a></li>';
			
			
		echo '	
		</ul>
				
					
	</header>';



?>

