<?php

	require "Conexion.php";

	class MontoCuotaMtto {

		public function __construct(){

		}

		public function Registrar($fechavigencia,$monto){

			global $conexion;

			$sql = "INSERT INTO cuotamtto (fechavigencia,monto)

						VALUES('$fechavigencia',$monto)";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idcuotamtto,$fechavigencia,$monto){

			global $conexion;

			$sql = "UPDATE cuotamtto set fechavigencia='$fechavigencia', monto=$monto 
						WHERE idcuotamtto = $idcuotamtto";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idcuotamtto){

			global $conexion;

			$sql = "DELETE FROM cuotamtto WHERE idcuotamtto = $idcuotamtto";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM cuotamtto order by fechavigencia desc";

			$query = $conexion->query($sql);

			return $query;

		}

	}

