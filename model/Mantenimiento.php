<?php

	require "Conexion.php";

	class Mantenimiento {

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


		public function Listar(){

			global $conexion;

			$sql = "SELECT *,global.cuotamtto as cuotamtto FROM vcontratomtto, global order by nrocontrato";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarMantenimientoconCuota() {

			global $conexion;

			$sql = "SELECT  *
					FROM    vcontratomtto m
					WHERE   EXISTS
        			(
        				SELECT  1
        				FROM    cuota c
        				WHERE   m.idcontrato = c.idcontrato and c.tipocuota='M'
        			)";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarMantenimientosinCuota() {

			global $conexion;

			$sql = "SELECT  *
					FROM    vcontratomtto m
					WHERE   NOT EXISTS
        			(
        				SELECT  1
        				FROM    cuota c
        				WHERE   m.idcontrato = c.idcontrato and c.tipocuota='M'
        			)";

			$query = $conexion->query($sql);

			return $query;

		}

	}

