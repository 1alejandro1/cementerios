<?php

	require "Conexion.php";

	class Lote {

		public function __construct() {

		}

		public function Registrar($idsector,$idcementerio,$idtipolote,$idestadolote,$numlote,$fila,$columna,$observaciones){

			global $conexion;

			$sql = "INSERT INTO lote (idsector,idcementerio,idtipolote,idestadolote,numero,fila,columna,observaciones)

						VALUES($idsector,$idcementerio,$idtipolote,$idestadolote,'$numlote','$fila','$columna','$observaciones')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idlote,$idsector,$idcementerio,$idtipolote,$idestadolote,$numlote,$fila,$columna,$observaciones){

			global $conexion;

			$sql = "UPDATE lote set idsector=$idsector, idcementerio=$idcementerio, idtipolote=$idtipolote, idestadolote=$idestadolote, numero='$numlote', fila='$fila', columna='$columna', observaciones='$observaciones' 
						WHERE idlote = $idlote";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idlote){

			global $conexion;

			$sql = "DELETE FROM lote WHERE idlote = $idlote";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar() {

			global $conexion;

			$sql = "SELECT * FROM vlote order by idlote desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function LotesxSector($idsector, $idlote, $habilitado) {

			global $conexion;

//			$idsector = $_POST["idsector"];

			if ($habilitado) {
				$sql = "SELECT * FROM lote WHERE idsector = $idsector and idestadolote=6 order by idlote desc";
			} else {
				$sql = "SELECT * FROM lote WHERE idlote = $idlote";
			}

//			$sql = "SELECT * FROM lote WHERE idsector = $idsector order by idlote desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function TodosLotesxSector() {

			global $conexion;

			$idsector = $_POST["idsector"];

			$sql = "SELECT * FROM lote WHERE idsector = $idsector order by idlote desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function DetalleLote($idlote) {

			global $conexion;

//			$sql = "SELECT * FROM lote WHERE idlote = $idlote and idestadolote=6";
			$sql = "SELECT * FROM lote WHERE idlote = $idlote";

			$query = $conexion->query($sql);

			return $query;

		}
	}

