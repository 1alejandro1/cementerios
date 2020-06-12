<?php

	require "Conexion.php";



	class Responsable {





		public function __construct(){

		}


		public function Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$email,$estado,$iddifunto){

			global $conexion;

			$sql = "INSERT INTO responsable(apellidos,nombre,tipodocumento,numdocumento,direccion,telefono,celular,email,estado,iddifunto)

						VALUES('$apellidos','$nombre','$tipodocumento','$numdocumento','$direccion','$telefono','$celular','$email','$estado',$iddifunto)";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idresponsable,$apellidos,$nombre, $tipodocumento,$numdocumento,$direccion,$telefono,$celular,$email,$estado,$iddifunto){

			global $conexion;

			$sql = "UPDATE responsable set apellidos = '$apellidos',nombre = '$nombre',tipodocumento='$tipodocumento',numdocumento='$numdocumento', direccion = '$direccion' ,telefono	='$telefono',celular ='$celular',email='$email',estado='$estado',iddifunto=$iddifunto

						WHERE idresponsable = $idresponsable";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Eliminar($idresponsable){

			global $conexion;

			$sql = "DELETE FROM responsable WHERE idresponsable = $idresponsable";

			$query = $conexion->query($sql);

			return $query;

		}



		public function ListarResponsables(){

			global $conexion;

			$sql = "SELECT * FROM responsable";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listarborrar(){

			global $conexion;

			$sql = "SELECT * FROM responsable WHERE  responsable.estado != 'S' order by idresponsable desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "select r.*, d.nombre as difunto 

				from responsable r left join difunto d on r.iddifunto = d.iddifunto

				where r.estado != 'I' order by idresponsable desc";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM responsable order by apellidos asc";

			$query = $conexion->query($sql);

			return $query;

		}

	}

