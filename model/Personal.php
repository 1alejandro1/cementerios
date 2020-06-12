<?php

	require "Conexion.php";



	class Personal{





		public function __construct(){

		}



		public function Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento,$foto, $login, $clave,$estado){

			global $conexion;

			$sql = "INSERT INTO personal(apellidos,nombre,tipodocumento,numdocumento,direccion,telefono,email,fechanacimiento,foto, login, clave,estado)

						VALUES('$apellidos','$nombre','$tipodocumento','$numdocumento','$direccion','$telefono','$email','$fechanacimiento','$foto', '$login', '$clave','$estado')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idpersonal,$apellidos,$nombre, $tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento,$foto, $login, $clave,$estado){

			global $conexion;

			$sql = "UPDATE personal set apellidos = '$apellidos',nombre = '$nombre',tipodocumento='$tipodocumento',numdocumento='$numdocumento', direccion = '$direccion' ,telefono	='$telefono',email='$email',fechanacimiento='$fechanacimiento',foto='$foto',

					login = '$login', clave = '$clave' ,estado='$estado'

						WHERE idpersonal = $idpersonal";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Eliminar($idpersonal){

			global $conexion;

			$sql = "DELETE FROM personal WHERE idpersonal = $idpersonal";

			$query = $conexion->query($sql);

			return $query;

		}



		public function ListarPersonal(){

			global $conexion;

			$sql = "SELECT * FROM personal";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM personal WHERE  personal.estado != 'I' order by idpersonal desc";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM personal order by apellidos asc";

			$query = $conexion->query($sql);

			return $query;

		}







	}

