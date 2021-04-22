<?php
	
	require_once "conexion.php";

	class ModeloLibros
	{
		
		static public function index($tabla)
		{
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt-> fetchAll(PDO::FETCH_CLASS);

			$stmt->close();

			$stmt=null;

		}

		static public function create($tabla, $datos)
		{
			
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(titulo, editorial, area, autor, imagen, precio) VALUES (:titulo, :editorial, :area, :autor, :imagen, :precio)");

					$stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
					$stmt -> bindParam(":editorial", $datos["editorial"], PDO::PARAM_STR);
					$stmt -> bindParam(":area", $datos["area"], PDO::PARAM_STR);
					$stmt -> bindParam(":autor", $datos["autor"], PDO::PARAM_STR);
					$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
					$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);

					if($stmt -> execute()){

						return "ok";

					}else{

						print_r(Conexion::conectar()->errorInfo());
					}

					$stmt-> close();

					$stmt = null;
				
		}


		static public function show($tabla,$id)
		{
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id = :id");

			$stmt -> bindParam(":id", $id, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt-> fetchAll(PDO::FETCH_CLASS);

			$stmt->close();

			$stmt=null;

		}


		static public function update($tabla, $datos)
		{

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET titulo=:titulo, editorial=:editorial, area=:area, autor=:autor, imagen=:imagen, precio=:precio WHERE id=:id");


					$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
					$stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
					$stmt -> bindParam(":editorial", $datos["editorial"], PDO::PARAM_STR);
					$stmt -> bindParam(":area", $datos["area"], PDO::PARAM_STR);
					$stmt -> bindParam(":autor", $datos["autor"], PDO::PARAM_STR);
					$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
					$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);

					if($stmt -> execute()){

						return "ok";

					}else{

						return "fallo";
					}
			
		}

		static public function delete($tabla, $id)
		{

			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");


					$stmt -> bindParam(":id", $id, PDO::PARAM_INT);

					if($stmt -> execute()){

						return "ok";

					}else{

						return "fallo";
					}
			
		}





	}