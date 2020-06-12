<?php

	require "Conexion.php";

	class EstadoLote{

		public function __construct() {

		}

		public function Registrar($nombre){

			global $conexion;

			$sql = "INSERT INTO estadolote(nombre, estado)

						VALUES('$nombre', 'A')";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Modificar($idestadolote, $nombre){

			global $conexion;

			$sql = "UPDATE estadolote set nombre = '$nombre'

						WHERE idestadolote = $idestadolote";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Eliminar($idestadolote){

			global $conexion;

			$sql = "DELETE FROM estadolote WHERE idestadolote = $idestadolote";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM estadolote order by nombre";
			$query = $conexion->query($sql);

			return $query;
		}

		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM estadolote order by nombre asc";
			$query = $conexion->query($sql);

			return $query;
		}
	}

