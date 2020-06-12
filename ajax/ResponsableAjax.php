<?php



	session_start();



	require_once "../model/Responsable.php";



	$objResponsable = new Responsable();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$iddifunto = $_POST["txtIdDifunto"];

			$apellidos = $_POST["txtApellidos"];

			$nombre = $_POST["txtNombre"];

			$tipodocumento = $_POST["cboTipoDocumento"];

			$numdocumento = $_POST["txtNumDocumento"];

			$direccion = $_POST["txtDireccion"];

			$telefono = $_POST["txtTelefono"];

			$celular = $_POST["txtCelular"];

			$email = $_POST["txtEmail"];

			$estado = $_POST["cboEstado"];

			




				if(empty($_POST["txtIdResponsable"])){

					if($objResponsable->Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$email,$estado,$iddifunto)){

						echo "Responsable Registrado correctamente.";

					}else{

						echo "Responsable no ha podido ser registado.";

					}

				} else {

						$idresponsable = $_POST["txtIdResponsable"];

						if($objResponsable->Modificar($idresponsable, $apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$email,$estado,$iddifunto)){

							echo "La información del Responsable ha sido actualizada.";

						}else{

							echo "La información del Responsable no ha podido ser actualizada.";

						}

				}

			break;

		case "delete":			

			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objResponsable->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		case "list":

			$query_Tipo = $objResponsable->Listar();

			$data= Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {



     			$data[] = array("0"=>$i,

					"1"=>$reg->apellidos.'&nbsp;'.$reg->nombre,

					"2"=>$reg->tipodocumento,

					"3"=>$reg->numdocumento,

					"4"=>$reg->difunto,

					"5"=>$reg->email,

					"6"=>$reg->telefono,

					"7"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataResponsable('.$reg->idresponsable.',\''.$reg->apellidos.'\',\''.$reg->nombre.'\',\''.$reg->tipodocumento.'\',\''.$reg->numdocumento.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->celular.'\',\''.$reg->email.'\',\''.$reg->estado.'\',\''.$reg->iddifunto.'\',\''.$reg->difunto.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarResponsable('.$reg->idresponsable.')"><i class="fa fa-trash"></i> </button>');

				$i++;

			}

			$results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);

			break;



	    case "listDifunto":

	    	require_once "../model/Difunto.php";

	        $objDifunto = new Difunto();

	        $query_Difunto = $objDifunto->ListarDifuntos();

	        $i = 1;

	        while ($reg = $query_Difunto->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optDifuntoBusqueda" data-nombre="'.$reg->nombre.'" id="'.$reg->iddifunto.'" value="'.$reg->iddifunto.'" /></td>

		                <td>'.$i.'</td>

		                <td>'.$reg->nombre.'</td>

		                <td>'.$reg->tipodocumento.'</td>

		                <td>'.$reg->numdocumento.'</td>

	                   </tr>';

	        }



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

		