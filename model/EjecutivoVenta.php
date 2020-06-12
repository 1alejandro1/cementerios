<?php

	require "Conexion.php";

	class EjecutivoVenta {

		public function __construct(){

		}


		public function Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$estadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$imagen1,$imagen2){

			global $conexion;

			$sql = "INSERT INTO ejecutivoventa (apellidos,nombre,tipodocumento,numdocumento,direccion,telefono,celular,idestadocivil,email,estado, zona,ciudad,observaciones,fechaingreso,imagen1,imagen2)

						VALUES('$apellidos','$nombre','$tipodocumento','$numdocumento','$direccion','$telefono','$celular','$estadocivil','$email','$estado','$zona','$ciudad','$observaciones','$fechaingreso','$imagen1','$imagen2')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idejecutivoventa,$apellidos,$nombre, $tipodocumento,$numdocumento,$direccion,$telefono,$celular,$estadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$imagen1,$imagen2){

			global $conexion;

			$sql = "UPDATE ejecutivoventa set apellidos = '$apellidos',nombre = '$nombre',tipodocumento='$tipodocumento',numdocumento='$numdocumento', direccion = '$direccion' ,telefono	='$telefono',celular ='$celular',idestadocivil='$estadocivil',email='$email',estado='$estado'
			,zona='$zona',ciudad='$ciudad',observaciones='$observaciones',fechaingreso='$fechaingreso',imagen1='$imagen1',imagen2='$imagen2' 

						WHERE idejecutivoventa = $idejecutivoventa";

			$query = $conexion->query($sql);

			return $query;

		}


		public function ModificarGarante($idejecutivoventa,$apellidosgarante,$nombregarante,$numdocumentogarante,$direcciongarante,$telefonoGarante){

			global $conexion;

			$sql = "UPDATE ejecutivoventa set apellidosgarante='$apellidosgarante',nombregarante='$nombregarante',numdocumentogarante='$numdocumentogarante',direcciongarante='$direcciongarante',telefonogarante='$telefonoGarante' 

						WHERE idejecutivoventa = $idejecutivoventa";

			$query = $conexion->query($sql);

			return $query;

		}




		public function Eliminar($idejecutivoventa){

			global $conexion;

			$sql = "DELETE FROM ejecutivoventa WHERE idejecutivoventa = $idejecutivoventa";

			$query = $conexion->query($sql);

			return $query;

		}



		public function ListarEjecutivosVentas(){

			global $conexion;

			$sql = "SELECT * FROM ejecutivoventa";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM ejecutivoventa order by idejecutivoventa desc";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM ejecutivoventa order by apellidos asc";

			$query = $conexion->query($sql);

			return $query;

		}

	}

