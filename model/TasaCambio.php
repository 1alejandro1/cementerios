<?php

	require "Conexion.php";

	class TasaCambio {

		public function __construct(){

		}

		public function Registrar($fechavigencia,$monto){

			global $conexion;

			$sql = "INSERT INTO tasacambio (fechavigencia,monto)

						VALUES('$fechavigencia',$monto)";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idtasacambio,$fechavigencia,$monto){

			global $conexion;

			$sql = "UPDATE tasacambio set fechavigencia='$fechavigencia', monto=$monto 
						WHERE idtasacambio = $idtasacambio";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idtasacambio){

			global $conexion;

			$sql = "DELETE FROM tasacambio WHERE idtasacambio = $idtasacambio";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM tasacambio order by fechavigencia desc";

			$query = $conexion->query($sql);

			return $query;

		}

	}

