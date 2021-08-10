<?php

//Creacion del menu
echo '<ul class="nav navbar-nav" id="navbar_nav" >';
	echo '<li><a href="principal.php">          <i class="fa fa-dashboard" aria-hidden="true"></i> Principal</a></li>';
	echo '<li><a href="principal_datos.php">    <i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos</a></li>';
	
	/******************************************/
	//despliegue de mis datos
	echo '<li class="dropdown ">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars" aria-hidden="true"></i> Mis Registros <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			
			echo '<li><a href="principal_camaras.php?pagina=1">  <i class="fa fa-video-camera" aria-hidden="true"></i> Mis Camaras</a></li>';
			echo '<li><a href="principal_eventos.php?pagina=1">  <i class="fa fa-flag" aria-hidden="true"></i> Mis Eventos</a></li>';
			echo '<li><a href="principal_peligros.php?pagina=1"> <i class="fa fa-ban" aria-hidden="true"></i> Mis Zonas Peligrosas</a></li>';
		
		echo '</ul>';
	echo '</li>';
	
	/******************************************/
	//despliegue de informes
	echo '<li class="dropdown ">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i> Buscar Registros <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			
			echo '<li><a href="buscar_eventos.php">  <i class="fa fa-flag" aria-hidden="true"></i> Buscar Eventos</a></li>';
			echo '<li><a href="buscar_peligros.php"> <i class="fa fa-ban" aria-hidden="true"></i> Buscar Zonas Peligrosas</a></li>';
			
		echo '</ul>';
	echo '</li>';

	                          
echo '</ul>'; 
              
?>
