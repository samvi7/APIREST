<?php


	/**
	 * conexion a la base a datos
	 */
	class Conexion
	{
		
		static public function conectar()
		{
			$link  = new PDO("mysql:host=localhost;dbname=apirest", "root", "");

			return $link;
		}
	}