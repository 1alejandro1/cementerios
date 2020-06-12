<?php



	session_start();



	require_once "../model/Personal.php";



	$objPersonal = new Personal();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$apellidos = $_POST["txtApellidos"];

			$nombre = $_POST["txtNombre"];

			$tipodocumento = $_POST["cboTipoDocumento"];

			$numdocumento = $_POST["txtNumDocumento"];

			$direccion = $_POST["txtDireccion"];

			$telefono = $_POST["txtTelefono"];

			$email = $_POST["txtEmail"];

			$fechanacimiento = $_POST["txtFechaNacimiento"];

			$imagen = $_FILES["imagenPer"]["tmp_name"];

			$ruta = $_FILES["imagenPer"]["name"];

			$login = $_POST["txtLogin"];

			$clave = md5($_POST["txtClave"]);

			$estado = $_POST["cboEstado"];

			



			if(move_uploaded_file($imagen, "../Files/Personal/".$ruta)){



				if(empty($_POST["txtIdPersonal"])){

					

					if($objPersonal->Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento,"Files/Personal/".$ruta, $login, $clave,$estado)){

						echo "Personal Registrado correctamente.";

					}else{

						echo "Personal no ha podido ser registado.";

					}

				}else{

					

					if ($_POST["txtClave"] == "") {

						$idpersonal = $_POST["txtIdPersonal"];

						if($objPersonal->Modificar($idpersonal, $apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento,"Files/Personal/".$ruta, $login, $_POST["txtClaveOtro"], $estado)){

							echo "La información del Personal ha sido actualizada.";

						}else{

							echo "La información del Personal no ha podido ser actualizada.";

						}

					} else {

						$idpersonal = $_POST["txtIdPersonal"];

						if($objPersonal->Modificar($idpersonal, $apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento,"Files/Personal/".$ruta, $login, $clave, $estado)){

							echo "La información del Personal ha sido actualizada.";

						}else{

							echo "La información del Personal no ha podido ser actualizada.";

						}

					}



					

				}

			} else {

				$ruta_img = $_POST["txtRutaImgPer"];

				if(empty($_POST["txtIdPersonal"])){

					

					if($objPersonal->Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento, $ruta_img, $login, $clave, $estado)){

						echo "Personal Registrado correctamente.";

					}else{

						echo "Personal no ha podido ser registado.";

					}

				}else{

					

					$idpersonal = $_POST["txtIdPersonal"];

					

					if ($_POST["txtClave"] == "") {

						$idpersonal = $_POST["txtIdPersonal"];

						if($objPersonal->Modificar($idpersonal, $apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento,$ruta_img, $login, $_POST["txtClaveOtro"], $estado)){

							echo "La información del Personal ha sido actualizada.";

						}else{

							echo "La información del Personal no ha podido ser actualizada.";

						}

					} else {

						$idpersonal = $_POST["txtIdPersonal"];

						if($objPersonal->Modificar($idpersonal, $apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$fechanacimiento, $ruta_img, $login, $clave, $estado)){

							echo "La información del Personal ha sido actualizada.";

						}else{

							echo "La información del Personal no ha podido ser actualizada.";

						}

					}

				}

			}



			break;



		case "delete":			

			

			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objPersonal->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		

		case "list":

			$query_Tipo = $objPersonal->Listar();

			$data= Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {



     			$data[] = array("0"=>$i,

					"1"=>$reg->apellidos.'&nbsp;'.$reg->nombre,

					"2"=>$reg->tipodocumento,

					"3"=>$reg->numdocumento,

					"4"=>$reg->email,

					"5"=>$reg->telefono,

					"6"=>$reg->login,

					"7"=>'<img width=100px height=100px src="./'.$reg->foto.'" />',

					"8"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataPersonal('.$reg->idpersonal.',\''.$reg->apellidos.'\',\''.$reg->nombre.'\',\''.$reg->tipodocumento.'\',\''.$reg->numdocumento.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->email.'\',\''.$reg->fechanacimiento.'\',\''.$reg->foto.'\',\''.$reg->login.'\',\''.$reg->clave.'\',\''.$reg->estado.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarPersonal('.$reg->idpersonal.')"><i class="fa fa-trash"></i> </button>');

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

		