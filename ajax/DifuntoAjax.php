<?php



	session_start();



	require_once "../model/Difunto.php";



	$objDifunto = new Difunto();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':


			$nombre = $_POST["txtNombre"];

			$tipodocumento = $_POST["cboTipoDocumento"];

			$numdocumento = $_POST["txtNumDocumento"];

			$direcciondepartamento = isset($_POST["txtDireccionDepartamento"])?$_POST["txtDireccionDepartamento"]:"";

			$direccionprovincia = isset($_POST["txtDireccionProvincia"])?$_POST["txtDireccionProvincia"]:"";

			$direcciondistrito = isset($_POST["txtDireccionDistrito"])?$_POST["txtDireccionDistrito"]:"";

			$direccioncalle = isset($_POST["txtDireccionCalle"])?$_POST["txtDireccionCalle"]:"";

			$telefono = isset($_POST["txtTelefono"])?$_POST["txtTelefono"]:"";

			$email = isset($_POST["txtEmail"])?$_POST["txtEmail"]:"";

			$numerocuenta = isset($_POST["txtNumeroCuenta"])?$_POST["txtNumeroCuenta"]:"";

			$estado = $_POST["cboEstado"];


			$imagen1 = $_FILES["imagen1"]["tmp_name"];

			$ruta1 = $_FILES["imagen1"]["name"];

			$imagen2 = $_FILES["imagen2"]["tmp_name"];

			$ruta2 = $_FILES["imagen2"]["name"];

			$imagen3 = $_FILES["imagen3"]["tmp_name"];

			$ruta3 = $_FILES["imagen3"]["name"];

			$ruta1grabar = '';
			if ($ruta1!='') {
				if (move_uploaded_file($imagen1, "../Files/Difunto/".$ruta1)) {
					$ruta1grabar = "../Files/Difunto/" . $ruta1;
				}
			}
			$ruta2grabar = '';
			if ($ruta2!='') {
				if (move_uploaded_file($imagen2, "../Files/Difunto/".$ruta2)) {
					$ruta2grabar = "../Files/Difunto/" . $ruta2;
				}
			}
			$ruta3grabar = '';
			if ($ruta3!='') {
				if (move_uploaded_file($imagen3, "../Files/Difunto/".$ruta3)) {
					$ruta3grabar = "../Files/Difunto/" . $ruta3;
				}
			}


				if(empty($_POST["txtIdDifunto"])){

					if($objDifunto->Registrar($nombre,$tipodocumento,$numdocumento,$direcciondepartamento,$direccionprovincia,$direcciondistrito,$direccioncalle,$telefono,$email,$numerocuenta,$estado,$ruta1grabar,$ruta2grabar,$ruta3grabar)){

						echo "Difunto registrado correctamente";

					}else{

						echo "El Difunto no ha podido ser registrado.";

					}

				}else{



					$iddifunto = $_POST["txtIdDifunto"];

					if($objDifunto->Modificar($iddifunto,$nombre,$tipodocumento,$numdocumento,$direcciondepartamento,$direccionprovincia,$direcciondistrito,$direccioncalle,$telefono,$email,$numerocuenta,$estado,$ruta1grabar,$ruta2grabar,$ruta3grabar)){

						echo "La informacion del Difunto ha sido actualizada";

					}else{

						echo "La informacion del Difunto no ha podido ser actualizada.";

					}

				}

			break;



		case "delete":



			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objDifunto->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objDifunto->ListadoDifunto();

			$data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"id"=>$i,

					"1"=>$reg->nombre,

					"2"=>$reg->tipodocumento.'&nbsp;'.$reg->numdocumento,

					"3"=>$reg->direccionprovincia,

					"4"=>$reg->direcciondepartamento,

					"5"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataDifunto('.$reg->iddifunto.',\''.$reg->nombre.'\',\''.$reg->tipodocumento.'\',\''.$reg->numdocumento.'\',\''.$reg->direcciondepartamento.'\',\''.$reg->direccionprovincia.'\',\''.$reg->direcciondistrito.'\',\''.$reg->direccioncalle.'\',\''.$reg->telefono.'\',\''.$reg->email.'\',\''.$reg->numerocuenta.'\',\''.$reg->estado.'\',\''.$reg->imagen1.'\',\''.$reg->imagen2.'\',\''.$reg->imagen3.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarDifunto('.$reg->iddifunto.')"><i class="fa fa-trash"></i> </button>');

				$i++;



			}

			$results = array(

	            "sEcho" => 1,

	        	"iTotalRecords" => count($data),

	        	"iTotalDisplayRecords" => count($data),

	            "aaData"=>$data);

			echo json_encode($results);


			break;

		case "listTipoDocumentoPersona":

		        require_once "../model/TipoDocumento.php";

		        $objTipoDocumento = new TipoDocumento();

		        $querytipoDocumento = $objTipoDocumento->VerTipoDocumentoPersona();



		        while ($reg = $querytipoDocumento->fetch_object()) {

		            echo '<option value=' . $reg->nombre . '>' . $reg->nombre . '</option>';

		        }



		    break;

}

