<?php

	$arrayRutas = explode('/', $_SERVER['REQUEST_URI']);
	//echo '<pre>'; print_r(array_filter($arrayRutas)); echo '</pre>';

	if(count(array_filter($arrayRutas)) == 0){

		// cuando no hay una ruta

		$json = array(
			"detalle"=>"no hay datos disponibles"
		);	

		echo json_encode($json,true);

	}else{

		if(count(array_filter($arrayRutas)) == 1){ //


			//cuando se hace la peticion al registro
			if(array_filter($arrayRutas)[1]=="registro"){ 
				
				if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){

					$datos = array("nombre"=>$_POST["nombre"],
								   "apellido"=>$_POST["apellido"],
								   "correo"=>$_POST["correo"]);

					$registro = new ControladorUsuarios();
					$registro->create($datos);
				}else{

					$json = array(

						"detalle"=>"Datos no encontrados, unicamente funciona con metodo POST"

						);

						echo json_encode($json, true);

						return;

				}				

			}else{

				//cuando se hace la peticion a libros
				if(array_filter($arrayRutas)[1] == "libros"){ //


						if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET" ){
						
							$mostrarLibros = new ControladorLibros();
							$mostrarLibros-> index();

						}

						if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST" ){
						
							$datos = array("titulo"=>$_POST["titulo"],
										   "editorial"=>$_POST["editorial"],
										   "area"=>$_POST["area"],
										   "autor"=>$_POST["autor"],
										   "imagen"=>$_POST["imagen"],
										   "precio"=>$_POST["precio"]);

							$crearLibros = new ControladorLibros();
							$crearLibros-> create($datos);

						}
					
					
				}else{

						$json = array(

						"detalle"=>"Datos no encontrados"

						);

						echo json_encode($json, true);

						return;

				}

			}

			

		}else{

			//cuando se hace una peticion a un solo libro
			if(array_filter($arrayRutas)[1] == "libros" && is_numeric(array_filter($arrayRutas)[2])){

				if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT" ){

					$datos = array(); 
					parse_str(file_get_contents('php://input'), $datos);

					$editarLibro = new ControladorLibros();
					$editarLibro-> update(array_filter($arrayRutas)[2], $datos);

				}


				if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET" ){
				
					$mostrarLibro = new ControladorLibros();
					$mostrarLibro-> show(array_filter($arrayRutas)[2]);

				}

				if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE" ){
				
					$eliminarLibro = new ControladorLibros();
					$eliminarLibro-> delete(array_filter($arrayRutas)[2]);

				}

				

			}else{


					$json = array(

						"detalle"=>"Datos no encontrados"

					);

					echo json_encode($json, true);

					return;
				
			}

		}
	}
