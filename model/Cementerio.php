<?php

	require "Conexion.php";



	class Cementerio{





		public function __construct(){

		}



		public function Registrar($razonsocial,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante,$logo,$estado){

			global $conexion;

			$sql = "INSERT INTO cementerio(razonsocial,tipodocumento,numdocumento,direccion,telefono,email,representante,logo,estado)

						VALUES('$razonsocial','$tipodocumento','$numdocumento','$direccion','$telefono','$email','$representante','$logo','$estado')";

			$query = $conexion->query($sql);

			return $query;

		}



		// facturacion public function Modificar($idcementerio,$razonsocial, $tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante,$logo,$estado

		//,$numero_autorizacion,$leyenda_facturacion,$llave_dosificacion,$fecha_limite_emision_facturas){

		public function Modificar($idcementerio,$razonsocial, $tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante,$logo,$estado){

			global $conexion;

			//  facturacion     $sql = "UPDATE cementerio set razonsocial = '$razonsocial',direccion='$direccion',tipodocumento='$tipodocumento',numdocumento='$numdocumento',telefono	='$telefono',email='$email',representante='$representante',logo='$logo',estado='$estado',numero_autorizacion='$numero_autorizacion',leyenda_facturas='$leyenda_facturacion',llave_dosificacion='$llave_dosificacion',fecha_limite_emision='$fecha_limite_emision_facturas'

				$sql = "UPDATE cementerio set razonsocial = '$razonsocial',direccion='$direccion',tipodocumento='$tipodocumento',numdocumento='$numdocumento',telefono	='$telefono',email='$email',representante='$representante',logo='$logo',estado='$estado'

						WHERE idcementerio = $idcementerio";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Eliminar($idcementerio){

			global $conexion;

			$sql = "DELETE FROM cementerio WHERE idcementerio = $idcementerio";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM cementerio order by idcementerio desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarO(){

			global $conexion;

			$sql = "SELECT * FROM cementerio order by idcementerio desc";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Reporte(){

			global $conexion;

			$sql = "SELECT * FROM cementerio order by razonsocial asc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarCementerio(){

			global $conexion;

			$sql = "SELECT * FROM cementerio";

			$query = $conexion->query($sql);

			return $query;

		}


		public function ListarCementerioconSectores() {

			global $conexion;

				$sql = "SELECT  *
						FROM    cementerio c
						WHERE   EXISTS
	        			(
	        				SELECT  1
	        				FROM    sector s
	        				WHERE   c.idcementerio = s.idcementerio 
	        			)";

//			$sql = "SELECT * FROM sector order by idsector desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarCementeriosPersonal($id){

			global $conexion;

			$sql = "select u.*, s.razonsocial, s.logo as logo, concat(e.nombre, ' ', e.apellidos) as personal, e.*, e.estado as superadmin

	from usuario u inner join personal e on u.idpersonal = e.idpersonal

	inner join cementerio s on u.idcementerio = s.idcementerio

	where u.idpersonal = $id and u.estado='A'";

			$query = $conexion->query($sql);

			return $query;

		}



	}

