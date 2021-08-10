<?php

//Creacion del menu
echo '<ul class="nav navbar-nav" id="navbar_nav" >
		<li><a href="principal.php">          <i class="fa fa-dashboard" aria-hidden="true"></i> Principal</a></li>
		<li><a href="principal_datos.php">    <i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos</a></li>';
	
	//Submenu Administrar
	echo '<li class="dropdown">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrar <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			echo '<li><a href="trabajadores_listado.php?pagina=1">Mis Choferes</a></li>';
			echo '<li><a href="vehiculos_listado.php?pagina=1">Mis Vehiculos</a></li>';
			echo '<li><a href="pasajeros_listado.php?pagina=1">Mis Pasajeros</a></li>';
			echo '<li><a href="sistema_planes.php?pagina=1">Mis Planes</a></li>';
		echo '</ul>';  
	echo '</li>';
	
	//Submenu Costos
	echo '<li class="dropdown">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Costos <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			echo '<li><a href="vehiculos_costos.php?pagina=1">Costos Asociados</a></li>';
		echo '</ul>';  
	echo '</li>';
	
	//Submenu Facturacion
	echo '<li class="dropdown">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Facturacion <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			echo '<li><a href="vehiculos_facturacion_listado.php?pagina=1">Facturaciones</a></li>';
			echo '<li><a href="vehiculos_pagos.php?pagina=1">Pagos</a></li>';
		echo '</ul>';  
	echo '</li>';
	
	//Submenu Informes
	echo '<li class="dropdown">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Informes <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			echo '<li><a href="informe_vehiculos_01.php?pagina=1">Informe Costos</a></li>';
			echo '<li><a href="informe_vehiculos_detenciones.php?pagina=1">Detenciones</a></li>';
			echo '<li><a href="informe_vehiculos_registro_kilometraje.php?pagina=1">Kilometros Recorridos</a></li>';
			echo '<li><a href="informe_vehiculos_registro_ruta.php?pagina=1">Rutas Realizadas</a></li>';
			echo '<li><a href="informe_vehiculos_registro_sensores_3.php?pagina=1">Exportar Datos</a></li>';
			echo '<li><a href="informe_vehiculos_registro_velocidad.php?pagina=1">Registro Velocidades</a></li>';
		echo '</ul>';  
	echo '</li>';
	
	                          
echo '</ul>'; 
              
?>
