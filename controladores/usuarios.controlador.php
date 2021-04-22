<?php

	class ControladorUsuarios{

		//crear o hacer una insercion en la bd
		public function create($datos){

					
			/*================
			para validar el nombre, que acepte solo letras, minusculas y mayusculas vocales con acentos, y "ñ"s
			==================*/
			if(isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/',$datos["nombre"])){

				$json = array(
					"status" => 404,
					"detalle" => "Error en campo nombre, solo se aceptan letras");

				echo json_encode($json,true);

				return;
			}

			/*================
			para validar el apellido
			==================*/
			if(isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/',$datos["apellido"])){

				$json = array(
					"status" => 404,
					"detalle" => "Error en campo apellido, solo se aceptan letras");

				echo json_encode($json,true);

				return;
			}

			/*================
			para validar el correo electronico
			==================*/

				if(isset($datos["correo"]) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$datos["correo"])){

					$json = array(
						"status" => 404,
						"detalle" => "Error en campo correo, coloca un correo valido");

					echo json_encode($json,true);

					return;
				}

				/*================
				para validar que el correo no este repetido
				==================*/

				$usuarios = ModeloUsuarios::index("usuarios");



				foreach ($usuarios as $key => $value) {

					if($value["correo"] == $datos["correo"]){
						
						$json = array(
						"status" => 404,
						"detalle" => "Email ya existe");

						echo json_encode($json,true);

					return;
					}

				}

				/*=============================================
				Generar credenciales del usuario
				=============================================*/

				$id_usuario = str_replace("$", "a", crypt($datos["nombre"].$datos["apellido"].$datos["correo"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

				$llave_secreta = str_replace("$", "o", crypt($datos["correo"].$datos["apellido"].$datos["nombre"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

				 //El hash anterior lo sustituimos por una "a" y por una "o" para no tener problemas con el signo "$" cuando generemos el token, estas credenciales se encriptan (el hash puede ser cualquier cadena)



				/*=============================================
					Llevar datos al modelo
				=============================================*/

				$datos = array("nombre"=>$datos["nombre"],
								"apellido"=>$datos["apellido"],
								"correo"=>$datos["correo"],
								"id_usuario"=>$id_usuario,
								"llave_secreta"=>$llave_secreta,
								"creado_en"=>date('Y-m-d h:i:s'),
								"actualizado_en"=>date('Y-m-d h:i:s')
								);

				$create = ModeloUsuarios::create("usuarios", $datos);



				/*=============================================
				Respuesta del modelo
				=============================================*/

				if($create == "ok"){

					$json = array(

							"status"=>200,
							"detalle"=>"Registro exitoso, a continuacion vea sus credenciales y guárdelas",
							"credenciales"=>array("id_usuario"=>$id_usuario, "llave_secreta"=>$llave_secreta)

						);

						echo json_encode($json, true);

						return;

				}


			}

	}