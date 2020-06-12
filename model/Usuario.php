<?php

	require "Conexion.php";



	class usuario{





		public function __construct(){

		}

		public function Registrar($idcementerio, $idpersonal, $tipo_usuario, $mnu_cementerio, $mnu_sector, $mnu_lote, $mnu_tipolote, $mnu_estadolote, $mnu_mantenimiento, $mnu_montocuota, $mnu_planimetria, $mnu_personal, $mnu_difunto, $mnu_responsable, $mnu_inhumacion, $mnu_exhumacion, $mnu_contrato, $mnu_cobranza, $mnu_adquiriente, $mnu_ejecutivoventa, $mnu_comision){

			global $conexion;

			$sql = "INSERT INTO usuario(idcementerio, idpersonal, tipo_usuario, fecha_registro, mnu_cementerio, mnu_sector, mnu_lote, mnu_tipolote, mnu_estadolote, mnu_mantenimiento, mnu_montocuota, mnu_planimetria, mnu_personal, mnu_difunto, mnu_responsable, mnu_inhumacion, mnu_exhumacion, mnu_contrato, mnu_cobranza, mnu_adquiriente, mnu_ejecutivoventa, mnu_comision, estado)

						VALUES($idcementerio, $idpersonal, '$tipo_usuario', curdate(), $mnu_cementerio, $mnu_sector, $mnu_lote, $mnu_tipolote, $mnu_estadolote, $mnu_mantenimiento, $mnu_montocuota, $mnu_planimetria, $mnu_personal, $mnu_difunto, $mnu_responsable, $mnu_inhumacion, $mnu_exhumacion, $mnu_contrato, $mnu_cobranza, $mnu_adquiriente, $mnu_ejecutivoventa, $mnu_comision, 'A')";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Modificar($idusuario, $idcementerio, $idpersonal, $tipo_usuario, $mnu_cementerio, $mnu_sector, $mnu_lote, $mnu_tipolote, $mnu_estadolote, $mnu_mantenimiento, $mnu_montocuota, $mnu_planimetria, $mnu_personal, $mnu_difunto, $mnu_responsable, $mnu_inhumacion, $mnu_exhumacion, $mnu_contrato, $mnu_cobranza, $mnu_adquiriente, $mnu_ejecutivoventa, $mnu_comision) {

			global $conexion;

			$sql = "UPDATE usuario set idcementerio = $idcementerio, idpersonal = $idpersonal, tipo_usuario = '$tipo_usuario', mnu_cementerio = $mnu_cementerio, mnu_sector = $mnu_sector, mnu_lote = $mnu_lote, mnu_tipolote = $mnu_tipolote, mnu_estadolote = $mnu_estadolote, mnu_mantenimiento = $mnu_mantenimiento, mnu_montocuota = $mnu_montocuota, mnu_planimetria = $mnu_planimetria, mnu_personal = $mnu_personal, mnu_difunto = $mnu_difunto, mnu_responsable = $mnu_responsable, mnu_inhumacion = $mnu_inhumacion, mnu_exhumacion = $mnu_exhumacion, mnu_contrato = $mnu_contrato, mnu_cobranza = $mnu_cobranza, mnu_adquiriente = $mnu_adquiriente, mnu_ejecutivoventa = $mnu_ejecutivoventa, mnu_comision = $mnu_comision 
						WHERE idusuario = $idusuario";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Eliminar($idusuario){

			global $conexion;

			$sql = "DELETE from usuario WHERE idusuario = $idusuario";

			$query = $conexion->query($sql);

			return $query;

		}


		public function DatosUsuario($idusuario){

			global $conexion;

			$sql = "SELECT * from usuario WHERE idusuario = $idusuario";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Listar(){

			global $conexion;

			$sql = "select u.*, s.razonsocial, concat(e.nombre, ' ', e.apellidos) as personal

	from usuario u inner join cementerio s on u.idcementerio = s.idcementerio

	inner join personal e on u.idpersonal = e.idpersonal

	where u.estado <> 'C' ";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Ingresar_Sistema($user, $pass){

			global $conexion;

			$sql = "select u.*, s.razonsocial, s.logo as logo, concat(e.nombre, ' ', e.apellidos) as personal, e.*, e.estado as superadmin

	from usuario u inner join cementerio s on u.idcementerio = s.idcementerio

	inner join personal e on u.idpersonal = e.idpersonal

	where e.login = '$user' and e.clave = '$pass' and u.estado <> 'C'";

			$query = $conexion->query($sql);

			return $query;

		}



	}

