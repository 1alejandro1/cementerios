<?php

	require "Conexion.php";

	class TipoLote{

		public function __construct() {

		}

		public function Registrar($nombre){

			global $conexion;

			$sql = "INSERT INTO tipolote(nombre, estado)

						VALUES('$nombre', 'A')";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Modificar($idtipolote, $nombre){

			global $conexion;

			$sql = "UPDATE tipolote set nombre = '$nombre'

						WHERE idtipolote = $idtipolote";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Eliminar($idtipolote){

			global $conexion;

			$sql = "DELETE FROM tipolote WHERE idtipolote = $idtipolote";

			$query = $conexion->query($sql);

			return $query;
		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM tipolote order by idtipolote desc";
			$query = $conexion->query($sql);

			return $query;
		}

		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM tipolote order by nombre asc";
			$query = $conexion->query($sql);

			return $query;
		}
	}

