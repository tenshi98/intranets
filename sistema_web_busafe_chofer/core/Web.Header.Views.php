<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">
		
		<!-- Informacion del sitio-->
		<title>Maqueta</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">
		
		<!-- WEB FONT -->
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/bs3.form.input.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/bs3.form.border.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_73.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/elegant_font/css/style.css">
		
		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/modernizr/modernizr.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		
		<!-- Favicons-->
		<?php
		//Favicon Personalizado
		$nombre_fichero = 'img/mifavicon.png';
		if (file_exists($nombre_fichero)) { ?>
			<link rel="icon"             type="image/png"                    href="img/mifavicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="img/mifavicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="img/mifavicon-57x57.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="img/mifavicon-72x72.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/mifavicon-114x114.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/mifavicon-144x144.png">
		<?php 
		//Favicon predefinido	
		}else{ ?>
			<link rel="icon"             type="image/png"                    href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-57x57-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-72x72-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-114x114-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-144x144-precomposed.png">
		<?php } ?>
		
		<!-- Correcciones CSS -->
		<style>
			body {background-color: #414745 !important;}
		</style>
	</head>
	<body>
		<div id="loader-wrapper">
			<div id="loader"></div>
			<div class="loader-section section-left"></div>
			<div class="loader-section section-right"></div>
		</div>
