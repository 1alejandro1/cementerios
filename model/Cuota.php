<?php

	require "Conexion.php";

	class Cuota {

		public function __construct(){

		}

		public function ListarCuotasPendientes() {

			global $conexion;

			$sql = "select * from cuota where estado='P' order by nrocuota";
//			$sql = "select * from cuota where idcontrato = $idcontrato and estado='P' order by nrocuota";

			$query = $conexion->query($sql);

			return $query;

		}

	}

