<?php

	require "Conexion.php";



	class TipoDocumento {

	

		

		public function __construct(){

		}



		public function Registrar($nombre,$operacion){

			global $conexion;

			$sql = "INSERT INTO tipodocumento(nombre,operacion)

						VALUES('$nombre','$operacion')";

			$query = $conexion->query($sql);

			return $query;

		}

		

		public function Modificar($idtipodocumento, $nombre,$operacion){

			global $conexion;

			$sql = "UPDATE tipodocumento set nombre = '$nombre',operacion='$operacion'

						WHERE idtipodocumento = $idtipodocumento";

			$query = $conexion->query($sql);

			return $query;

		}

		

		public function Eliminar($idtipodocumento){

			global $conexion;

			$sql = "DELETE FROM tipodocumento WHERE idtipodocumento = $idtipodocumento";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM tipodocumento order by idtipodocumento desc";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM tipodocumento order by nombre asc";

			$query = $conexion->query($sql);

			return $query;

		}



		public function ListarPersona(){

			global $conexion;

			$sql = "SELECT nombre FROM tipodocumento where operacion='Persona'";

			$query = $conexion->query($sql);

			return $query;

		}



		public function ListarComprobante(){

			global $conexion;

			$sql = "SELECT nombre FROM tipodocumento where operacion='Comprobante'";

			$query = $conexion->query($sql);

			return $query;

		}

		public function VerTipoDocumentoPersona(){

			global $conexion;

			$sql = "select nombre from tipodocumento where operacion='Persona' order by nombre";

			$query = $conexion->query($sql);

			return $query;

		}

	}

