<?php

	require "Conexion.php";

//creacion de la clase difunto

	class Difunto {











		public function __construct(){

		}





// vamos hacer la consulta si existe nuestro difuntos

public function difuntoexiste($nombre,$numdocumento){

		global $conexion;

		$sql="select iddifunto from difunto where nombre='$nombre' and numdocumento ='$numdocumento'";

	$query = $conexion->query($sql);

return $query;











}









		public function Registrar($nombre,$tipodocumento,$numdocumento,$direcciondepartamento,$direccionprovincia,$direcciondistrito,$direccioncalle,$telefono,$email,$numerocuenta,$estado,$ruta1,$ruta2,$ruta3){

			global $conexion;

			$sql = "INSERT INTO difunto(nombre,tipodocumento,numdocumento,direcciondepartamento,direccionprovincia,direcciondistrito,direccioncalle,telefono,email,numerocuenta,estado,imagen1,imagen2,imagen3)

						VALUES('$nombre','$tipodocumento','$numdocumento','$direcciondepartamento','$direccionprovincia','$direcciondistrito','$direccioncalle','$telefono','$email','$numerocuenta','$estado','$ruta1','$ruta2','$ruta3')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($iddifunto,$nombre,$tipodocumento,$numdocumento,$direcciondepartamento,$direccionprovincia,$direcciondistrito,$direccioncalle,$telefono,$email,$numerocuenta,$estado,$ruta1,$ruta2,$ruta3){

			global $conexion;

			$sql = "UPDATE difunto set nombre = '$nombre',tipodocumento='$tipodocumento',numdocumento='$numdocumento', direcciondepartamento = '$direcciondepartamento',direccionprovincia='$direccionprovincia',direcciondistrito='$direcciondistrito',direccioncalle='$direccioncalle' ,telefono='$telefono',email='$email',numerocuenta='$numerocuenta',estado='$estado',imagen1='$ruta1',imagen2='$ruta2',imagen3='$ruta3'

						WHERE iddifunto = $iddifunto";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Eliminar($iddifunto){

			global $conexion;

			$sql = "DELETE FROM difunto WHERE iddifunto = $iddifunto";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar(){

			global $conexion;

			$sql = "SELECT * FROM difunto order by iddifunto desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarDifuntos(){

			global $conexion;
/*
			$sql = "SELECT  *
					FROM    difunto d
					WHERE   NOT EXISTS
        			(
        				SELECT  1
        				FROM    responsable r
        				WHERE   r.iddifunto = d.iddifunto
        			)";

*/
			$sql = 'SELECT * FROM difunto
					WHERE NOT EXISTS (SELECT iddifunto FROM
					responsable WHERE difunto.iddifunto = responsable.iddifunto)';

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarDifuntosconResponsables(){

			global $conexion;
/*
			$sql = "SELECT  * 
					FROM    difunto d
					WHERE   EXISTS
        			(
        				SELECT  1
        				FROM    responsable r
        				WHERE   r.iddifunto = d.iddifunto
        			)";
*/
        	$sql = 'SELECT * FROM difunto';


			$query = $conexion->query($sql);

			return $query;

		}

		public function ReporteDifunto(){

			global $conexion;

			$sql = "SELECT * FROM difunto order by nombre asc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListadoDifunto(){

			global $conexion;

			$sql = "SELECT * FROM difunto order by iddifunto desc";

			$query = $conexion->query($sql);

			return $query;

		}







	}

