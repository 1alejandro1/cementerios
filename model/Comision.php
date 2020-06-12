<?php

	require "Conexion.php";
	require "Usuario.php";

	class Comision {

		public function __construct(){

		}

		public function Registrar($idcontrato,$fechacomision,$porcentaje,$monto,$formadepago,$monto1racuota,$fecha1racuota,$monto2dacuota,$fecha2dacuota,$monto3racuota,$fecha3racuota,$monto4tacuota,$fecha4tacuota){

			global $conexion;

            $fecharegistro   = new DateTime();
            $fecharegistro = date_format($fecharegistro,"Y/m/d");

			$sql = "INSERT INTO comision (idcontrato,fechacomision,fecharegistro,porcentaje,monto,formadepago,monto1racuota,fecha1racuota,monto2dacuota,fecha2dacuota,monto3racuota,fecha3racuota,monto4tacuota,fecha4tacuota)

						VALUES($idcontrato,'$fechacomision','$fecharegistro',$porcentaje,$monto,$formadepago,$monto1racuota,'$fecha1racuota',$monto2dacuota,'$fecha2dacuota',$monto3racuota,'$fecha3racuota',$monto4tacuota,'$fecha4tacuota')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idcomision,$idcontrato,$fechacomision,$porcentaje,$monto,$formadepago,$monto1racuota,$fecha1racuota,$monto2dacuota,$fecha2dacuota,$monto3racuota,$fecha3racuota,$monto4tacuota,$fecha4tacuota){

			global $conexion;

			$sql = "UPDATE comision set idcontrato=$idcontrato, fechacomision='$fechacomision', porcentaje=$porcentaje, monto=$monto, formadepago=$formadepago, monto1racuota=$monto1racuota, fecha1racuota='$fecha1racuota', monto2dacuota=$monto2dacuota, fecha2dacuota='$fecha2dacuota', monto3racuota=$monto3racuota, fecha3racuota='$fecha3racuota', monto4tacuota=$monto4tacuota, fecha4tacuota='$fecha4tacuota' 
						WHERE idcomision = $idcomision";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idcomision){

			global $conexion;

			$sql = "DELETE FROM comision WHERE idcomision = $idcomision";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Listar() {

			global $conexion;

			$sql = "SELECT * FROM comision order by idcomision desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarComisiones() {

			global $conexion;

			$sql = "select com.*, con.nrocontrato, con.fechacontrato, con.precio, concat(con.nomejecutivoventa,' ',con.apeejecutivoventa) as ejecutivoventa, concat(con.tdejecutivoventa,' ',con.ndejecutivoventa) as documento, con.cementerio, con.sector, con.numlote as lote, con.fila, con.columna, con.tipolote 
				from comision com left join vcontrato con on com.idcontrato= con.idcontrato 
				order by com.idcomision desc";
			$query = $conexion->query($sql);

			return $query;

		}

		public function formadePago($formadepago) {
			if ($formadepago==1) {
				return ('1 Cuota');
			}
			if ($formadepago==2) {
				return ('2 Cuotas');
			}
			if ($formadepago==3) {
				return ('3 Cuotas');
			}
			if ($formadepago==4) {
				return ('4 Cuotas');
			}
			return ('No Determinado');
		}

	}

