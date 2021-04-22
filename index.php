<?php

	require_once "controladores/rutas.controlador.php";
	require_once "controladores/usuarios.controlador.php";
	require_once "controladores/libros.controlador.php";
	
	require_once "modelos/libros.modelo.php";
	require_once "modelos/usuarios.modelo.php";




	$rutas = new ControladorRutas();
	$rutas->index();