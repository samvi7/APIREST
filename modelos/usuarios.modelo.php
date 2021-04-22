<?php



class ModeloUsuarios
{
	
	static public function index($tabla)
	{
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt->execute();

		return $stmt-> fetchAll();

		$stmt->close();

		$stmt=null;
	}

	/*=============================================
	Crear un registro
	=============================================*/

	static public function create($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, apellido, correo, id_usuario, llave_secreta, creado_en, actualizado_en) VALUES (:nombre, :apellido, :correo, :id_usuario, :llave_secreta, :creado_en, :actualizado_en)");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":llave_secreta", $datos["llave_secreta"], PDO::PARAM_STR);
		$stmt -> bindParam(":creado_en", $datos["creado_en"], PDO::PARAM_STR);
		$stmt -> bindParam(":actualizado_en", $datos["actualizado_en"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}

		$stmt-> close();

		$stmt = null;

	}



}