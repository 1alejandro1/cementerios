<?php

	require "Conexion.php";

	class EstadoCivil {

		public function __construct() {

		}

		public function Registrar($nombre){

			global $conexion;

			$sql = "INSERT INTO estadocivil(nombre)

						VALUES('$nombre')";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Modificar($idestadocivil, $nombre){

			global $conexion;

			$sql = "UPDATE estadocivil set nombre = '$nombre'

						WHERE idestadocivil = $idestadocivil";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Eliminar($idestadocivil){

			global $conexion;

			$sql = "DELETE FROM estadocivil WHERE idestadocivil = $idestadocivil";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM estadocivil order by idestadocivil desc";
			$query = $conexion->query($sql);

			return $query;
		}

		public function ListarxNombre(){

			global $conexion;

			$sql = "SELECT * FROM estadocivil order by nombre";
			$query = $conexion->query($sql);

			return $query;
		}

		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM estadocivil order by nombre asc";
			$query = $conexion->query($sql);

			return $query;
		}
	}

