<?php

	require "Conexion.php";

	class CuotaMtto {

		public function __construct(){

		}


		public function Eliminar($idcuota){

			global $conexion;

			$sql = "DELETE FROM cuota WHERE idcuota = $idcuota";

			$query = $conexion->query($sql);

			return $query;

		}


		public function ObtieneCuotaMtto($fecha) {

			global $conexion;

			$montocuota = 0;

			$sql2 = "SELECT monto FROM cuotamtto WHERE fechavigencia<='" . $fecha . "' order by fechavigencia desc limit 1";

			$query2 = $conexion->query($sql2);

     		while ($reg2 = $query2->fetch_object()) {

     			$montocuota = $reg2->monto;

            }

            return $montocuota;

		}

		public function ExisteCuotaMtto($idcontrato, $fecha) {

			global $conexion;

			$existe = 0;

			$sql2 = "SELECT idcontrato FROM cuota WHERE idcontrato=" . $idcontrato . " and fechalimite='" . $fecha . "' and tipocuota='M' limit 1";

			$query2 = $conexion->query($sql2);

     		while ($reg2 = $query2->fetch_object()) {

     			$existe = 1;

            }

            return $existe;

		}

		public function ProximoNroCuotaMtto($idcontrato) {

			global $conexion;

			$proximonrocuota = 1;

			$sql2 = "SELECT nrocuota FROM cuota WHERE idcontrato=" . $idcontrato . " and tipocuota='M' order by nrocuota desc limit 1";

			$query2 = $conexion->query($sql2);

     		while ($reg2 = $query2->fetch_object()) {

     			$proximonrocuota = $reg2->nrocuota + 1;

            }

            return $proximonrocuota;

		}


		public function RegistrarCuotaMtto($idcontrato,$fechacontrato) {

			global $conexion;

			$fechaactual   = new DateTime();
            $fechaactual = date_format($fechaactual,"Y/m/d");

			$fechalimite   = new DateTime("$fechacontrato");
			$fechalimite->add(new DateInterval('P2Y'));
			$query = '';


            $fechalimite2 = date_format($fechalimite,"Y/m/d");

			// Obtener el próximo número de cuota de mantenimiento
			$nrocuota = $this->ProximoNroCuotaMtto($idcontrato);

			while ( $fechalimite2 <= $fechaactual) {

				// Verificar que la cuota de mantenimiento no este registrada
				$existecuota = $this->ExisteCuotaMtto($idcontrato,$fechalimite2);
				if ($existecuota==0) {
					// Obtener monto de cuota de mantenimiento anual, según la tarifa vigente a la fecha de vencimiento
					// de la cuota
					$montocuota = $this->ObtieneCuotaMtto($fechalimite2);

					if ($montocuota > 0 ) {

						$sql = "INSERT INTO cuota (idcontrato,nrocuota,fechalimite,monto,estado,tipocuota)

									VALUES ($idcontrato,$nrocuota,'$fechalimite2',$montocuota,'P','M')";

						$query = $conexion->query($sql);

						$nrocuota = $nrocuota + 1;
					}
				}
				$fechalimite->add(new DateInterval('P1Y'));
	            $fechalimite2 = date_format($fechalimite,"Y/m/d");
			}

			return $query;

		}


		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM vcuotamtto order by nrocontrato,nrocuota";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarContratos() {

			global $conexion;

			$sql = "SELECT * FROM vcontrato";

			$query = $conexion->query($sql);

			return $query;

		}

	}

