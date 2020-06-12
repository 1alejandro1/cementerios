<?php

	require "Conexion.php";



	class Configuracion{

	

		

		public function __construct(){

		}



		public function Registrar($empresa, $logo){

			global $conexion;

			$sql = "INSERT INTO global(empresa, logo)

						VALUES('$empresa', '$logo')";

			$query = $conexion->query($sql);

			return $query;

		}

		

		public function Modificar($idglobal, $empresa, $logo){

			global $conexion;

			$sql = "UPDATE global set empresa = '$empresa', logo = '$logo'

						WHERE idglobal = $idglobal";

			$query = $conexion->query($sql);

			return $query;

		}

		

		public function Eliminar($idglobal){

			global $conexion;

			$sql = "DELETE FROM global WHERE idglobal = $idglobal";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM global";

			$query = $conexion->query($sql);

			return $query;

		}

	}

