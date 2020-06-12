<?php

	require "Conexion.php";



	class Adquiriente {



		public function __construct(){

		}


//		public function Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$estadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$apellidosadjunto,$nombreadjunto,$numdocumentoadjunto,$direccionadjunto,$imagen1,$imagen2){

		public function Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$idestadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$imagen1,$imagen2){

			global $conexion;

			$sql = "INSERT INTO adquiriente(apellidos,nombre,tipodocumento,numdocumento,direccion,telefono,celular,idestadocivil,email,estado, zona,ciudad,observaciones,fechaingreso,imagen1,imagen2)

						VALUES('$apellidos','$nombre','$tipodocumento','$numdocumento','$direccion','$telefono','$celular','$idestadocivil','$email','$estado','$zona','$ciudad','$observaciones','$fechaingreso','$imagen1','$imagen2')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idadquiriente,$apellidos,$nombre, $tipodocumento,$numdocumento,$direccion,$telefono,$celular,$idestadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$imagen1,$imagen2){

			global $conexion;

			$sql = "UPDATE adquiriente set apellidos = '$apellidos',nombre = '$nombre',tipodocumento='$tipodocumento',numdocumento='$numdocumento', direccion = '$direccion' ,telefono	='$telefono',celular ='$celular',idestadocivil='$idestadocivil',email='$email',estado='$estado'
			,zona='$zona',ciudad='$ciudad',observaciones='$observaciones',fechaingreso='$fechaingreso',imagen1='$imagen1',imagen2='$imagen2' 

						WHERE idadquiriente = $idadquiriente";

			$query = $conexion->query($sql);

			return $query;

		}


		public function ModificarAdjunto($idadquiriente,$apellidosadjunto,$nombreadjunto,$numdocumentoadjunto,$direccionadjunto){

			global $conexion;

			$sql = "UPDATE adquiriente set apellidosadjunto='$apellidosadjunto',nombreadjunto='$nombreadjunto',numdocumentoadjunto='$numdocumentoadjunto',direccionadjunto='$direccionadjunto' 

						WHERE idadquiriente = $idadquiriente";

			$query = $conexion->query($sql);

			return $query;

		}




		public function Eliminar($idadquiriente){

			global $conexion;

			$sql = "DELETE FROM adquiriente WHERE idadquiriente = $idadquiriente";

			$query = $conexion->query($sql);

			return $query;

		}



		public function ListarAdquirientes(){

			global $conexion;

			$sql = "SELECT * FROM adquiriente";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM adquiriente order by idadquiriente desc";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM adquiriente order by apellidos asc";

			$query = $conexion->query($sql);

			return $query;

		}

	}

