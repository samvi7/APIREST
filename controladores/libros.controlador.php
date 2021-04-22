<?php

	class ControladorLibros{


		//Mostrar todos los datos de los libros
		public function index(){

			//validar las credenciales del cliente

			$usuarios = ModeloUsuarios::index("usuarios");
			//echo '<pre>'; print_r($usuarios); echo '</pre>';

			if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"]) ){

				foreach ($usuarios as $key => $valueUsuarios) {
					
					if("Basic ".base64_encode($_SERVER["PHP_AUTH_USER"].":".$_SERVER["PHP_AUTH_PW"]) == "Basic ".base64_encode($valueUsuarios["id_usuario"].":".$valueUsuarios["llave_secreta"])){

						$libros = ModeloLibros::index("libros");

						if(!empty($libros)){
							$json = array(
							"status"=>200,
							"total_registros"=>count($libros),
							"detalle"=>$libros
							);	

							echo json_encode($json, true);
							return;


						}else{

							$json = array(
							"status"=>200,
							"total_registros"=>0,
							"detalle"=>"No hay registros en la base de datos"
							);	

							echo json_encode($json, true);
							return;

						}

						

					}else{

						$json = array(
								"detalle"=>"No coinciden las credenciales proporcionadas"
								);	

					}

				}

				


			}else{

				$json = array(
				"detalle"=>"No se ingresaron credenciales de acceso"
				);	

				echo json_encode($json,true);
				return;


			}

			echo json_encode($json,true);
			return;

			
		}


		//crear un nuevo registro de libros

		public function create($datos){

			//validar las credenciales del usuario

			$usuarios = ModeloUsuarios::index("usuarios");

			if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"]) ){

				foreach ($usuarios as $key => $valueUsuarios) {
					
					if("Basic ".base64_encode($_SERVER["PHP_AUTH_USER"].":".$_SERVER["PHP_AUTH_PW"]) == "Basic ".base64_encode($valueUsuarios["id_usuario"].":".$valueUsuarios["llave_secreta"])){

						//validar los datos que vienen del postman

						foreach ($datos as $key => $valueDatos) {

								if(isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)){

									$json = array(

										"status"=>404,
										"detalle"=>"Error en el campo ".$key

									);

									echo json_encode($json, true);

									return;
								}

							}



						//validar que el titulo del libro no este repetido


							$libros = ModeloLibros::index("libros");
					
							foreach ($libros as $key => $value) {
								
								if($value->titulo == $datos["titulo"]){

									$json = array(

										"status"=>404,
										"detalle"=>"El título ya existe en la base de datos");

									echo json_encode($json, true);	

									return;

								}
							}

						//enviar los datos al modelo


							$datos = array( "titulo"=>$datos["titulo"],
									"editorial"=>$datos["editorial"],
									"area"=>$datos["area"],
									"autor"=>$datos["autor"],
									"imagen"=>$datos["imagen"],
									"precio"=>$datos["precio"]);

							$create = ModeloLibros::create("libros", $datos);

						//recibir la respuesta del modelo

							if($create == "ok"){

							    	$json = array(
						        	 	"status"=>200,
							    		"detalle"=>"Registro exitoso, el libro ha sido guardado"); 
							    	
							    	echo json_encode($json, true); 

							    	return;    	

								}
							}
					}

				}else{

						$json = array(
								"detalle"=>"No coinciden las credenciales proporcionadas"
								);	

					}

			echo json_encode($json,true);
			return;

	}	




		// para mostrar un libro en especifico
		public function show($id){

			$usuarios = ModeloUsuarios::index("usuarios");
			//echo '<pre>'; print_r($usuarios); echo '</pre>';

			if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"]) ){

				foreach ($usuarios as $key => $valueUsuarios) {
					
					if("Basic ".base64_encode($_SERVER["PHP_AUTH_USER"].":".$_SERVER["PHP_AUTH_PW"]) == "Basic ".base64_encode($valueUsuarios["id_usuario"].":".$valueUsuarios["llave_secreta"])){

						$libro = ModeloLibros::show("libros",$id);

						if(!empty($libro)){
							$json = array(
							"status"=>200,
							"detalle"=>$libro
							);	

							echo json_encode($json, true);
							return;


						}else{

							$json = array(
							"status"=>200,
							"total_registros"=>0,
							"detalle"=>"No hay registros en la base de datos"
							);	

							echo json_encode($json, true);
							return;

						}

						

					}else{

						$json = array(
								"detalle"=>"No coinciden las credenciales proporcionadas"
								);	

					}

				}

			}else{

				$json = array(
				"detalle"=>"No se ingresaron credenciales de acceso"
				);	

				echo json_encode($json,true);
				return;


			}

			echo json_encode($json,true);
			return;


		}


		//Actualizacion de un registro de libros

		public function update($id, $datos){

			$usuarios = ModeloUsuarios::index("usuarios");

			if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"]) ){

				foreach ($usuarios as $key => $valueUsuarios) {
					
					if("Basic ".base64_encode($_SERVER["PHP_AUTH_USER"].":".$_SERVER["PHP_AUTH_PW"]) == "Basic ".base64_encode($valueUsuarios["id_usuario"].":".$valueUsuarios["llave_secreta"])){

						//validar los datos que vienen del postman
						
						foreach ($datos as $key => $valueDatos) {

								if(isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)){

									$json = array(

										"status"=>404,
										"detalle"=>"Error en el campo ".$key

									);

									echo json_encode($json, true);

									return;
								}

							}

							$libro = ModeloLibros::show("libros", $id);

							foreach ($libro as $key => $valueLibro) {
								
							$datos = array( "id"=>$id,
												"titulo"=>$datos["titulo"],
												"editorial"=>$datos["editorial"],
												"area"=>$datos["area"],
												"autor"=>$datos["autor"],
												"imagen"=>$datos["imagen"],
												"precio"=>$datos["precio"]);

								
								$update = ModeloLibros::update("libros", $datos);

								//recibimos datos del modelo
								if($update == "ok"){

							    	$json = array(
						        	 	"status"=>200,
							    		"detalle"=>"Registro exitoso, el libro se ha actualizado"); 
							    	
							    	echo json_encode($json, true); 

							    	return;    	

								}else{
									
									$json = array(
						        	 	"status"=>404,
							    		"detalle"=>"Error en la actualizacion"); 
							    	
							    	echo json_encode($json, true); 

							    	return;    	

								}



							}//foreach
						}//if

					}//foreach

				}else{

						$json = array("detalle"=>"No coinciden las credenciales proporcionadas");	
						echo json_encode($json,true);
						return;
				}

			
		}

		//Eliminar  un registro de libro

		public function delete($id){


			$usuarios = ModeloUsuarios::index("usuarios");

			if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"]) ){

				foreach ($usuarios as $key => $valueUsuarios) {
					
					if("Basic ".base64_encode($_SERVER["PHP_AUTH_USER"].":".$_SERVER["PHP_AUTH_PW"]) == "Basic ".base64_encode($valueUsuarios["id_usuario"].":".$valueUsuarios["llave_secreta"])){

								
								$delete = ModeloLibros::delete("libros", $id);

								//recibimos datos del modelo
								if($delete == "ok"){

							    	$json = array(
						        	 	"status"=>200,
							    		"detalle"=>"Se ha eliminado el registro exitosamente"); 
							    	
							    	echo json_encode($json, true); 

							    	return;    	

								}else{
									
									$json = array(
						        	 	"status"=>404,
							    		"detalle"=>"Error en la eliminacion"); 
							    	
							    	echo json_encode($json, true); 

							    	return;    	

								}

						}//if

					}//foreach

				}else{

						$json = array("detalle"=>"No coinciden las credenciales proporcionadas");	
						echo json_encode($json,true);
						return;
				}

			
		}


	}
	