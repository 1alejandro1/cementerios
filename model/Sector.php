<?php

	require "Conexion.php";

	class Sector {

		public function __construct(){

		}

		public function Registrar($idcementerio,$nombre,$observaciones,$precioni,$precionf){

			global $conexion;

			$sql = "INSERT INTO sector(idcementerio,nombre,observaciones,precioni,precionf)

						VALUES($idcementerio,'$nombre','$observaciones',$precioni,$precionf)";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idsector,$idcementerio,$nombre,$observaciones,$precioni,$precionf){

			global $conexion;

			$sql = "UPDATE sector set idcementerio=$idcementerio, nombre='$nombre', observaciones='$observaciones', precioni=$precioni, precionf = $precionf 
						WHERE idsector = $idsector";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idsector){

			global $conexion;

			$sql = "DELETE FROM sector WHERE idsector = $idsector";

			$query = $conexion->query($sql);

			return $query;

		}

		public function SectorxCementerio($idcementerio, $idsector, $habilitado) {

			global $conexion;

//			$idsector = $_POST["idsector"];

			if ($habilitado) {
				$sql = "SELECT * FROM sector WHERE idcementerio = $idcementerio order by idsector desc";
			} else {
				$sql = "SELECT * FROM sector WHERE idsector = $idsector";
			}

//			$sql = "SELECT * FROM lote WHERE idsector = $idsector order by idlote desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM sector order by idsector desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarSectorconLotes($idsector, $habilitado) {

			global $conexion;

			if ($habilitado) {
				$sql = "SELECT  *
						FROM    sector s
						WHERE   EXISTS
	        			(
	        				SELECT  1
	        				FROM    lote l
	        				WHERE   s.idsector = l.idsector and l.idestadolote=6
	        			)";
			} else {
				$sql = "SELECT  *
						FROM    sector
						WHERE   idsector=$idsector";
			}

//			$sql = "SELECT * FROM sector order by idsector desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function PrecioxSector($idsector) {

			global $conexion;

			$sql = "SELECT * FROM sector WHERE idsector=$idsector";

			$query = $conexion->query($sql);

			return $query;

		}
	}

