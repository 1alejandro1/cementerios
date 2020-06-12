<?php



	session_start();



	require_once "../model/Adquiriente.php";



	$objAdquiriente = new Adquiriente();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$apellidos = $_POST["txtApellidos"];

			$nombre = $_POST["txtNombre"];

			$tipodocumento = $_POST["cboTipoDocumento"];

			$numdocumento = $_POST["txtNumDocumento"];

			$direccion = $_POST["txtDireccion"];

			$zona = $_POST["txtZona"];

			$ciudad = $_POST["txtCiudad"];

			$telefono = $_POST["txtTelefono"];

			$celular = $_POST["txtCelular"];

			$idestadocivil = $_POST["cboEstadoCivil"];

			$email = $_POST["txtEmail"];

			$estado = $_POST["cboEstado"];

			$observaciones = $_POST["txtObservaciones"];

			$fechaingreso = $_POST["txtFechaIngreso"];

			$imagen1 = $_FILES["imagen1"]["tmp_name"];

			$ruta1 = $_FILES["imagen1"]["name"];

			$imagen2 = $_FILES["imagen2"]["tmp_name"];

			$ruta2 = $_FILES["imagen2"]["name"];

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
		

				if(empty($_POST["txtIdAdquiriente"])){

					if($objAdquiriente->Registrar($apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$idestadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$ruta1grabar,$ruta2grabar)){

						echo "Adquiriente Registrado correctamente.";

					}else{

						echo "Adquiriente no ha podido ser registado.";

					}

				} else {

						$idadquiriente = $_POST["txtIdAdquiriente"];

						if($objAdquiriente->Modificar($idadquiriente, $apellidos,$nombre,$tipodocumento,$numdocumento,$direccion,$telefono,$celular,$idestadocivil,$email,$estado,$zona,$ciudad,$observaciones,$fechaingreso,$ruta1grabar,$ruta2grabar)){

							echo "La información del Adquiriente ha sido actualizada.";

						}else{

							echo "La información del Adquiriente no ha podido ser actualizada.";

						}

				}

			break;

		case 'SaveOrUpdateAdjunto':			

			$apellidosadjunto = $_POST["txtApellidosAdjunto"];

			$nombreadjunto = $_POST["txtNombreAdjunto"];

			$numdocumentoadjunto = $_POST["txtNumDocumentoAdjunto"];

			$direccionadjunto = $_POST["txtDireccionAdjunto"];

			$idadquiriente = $_POST["txtIdAdquiriente2"];

			$datosok = 0;
 
			if (empty($apellidosadjunto) and empty($nombreadjunto) and empty($numdocumentoadjunto) and empty($direccionadjunto)) {
				$datosok = 1;
			} else if (!empty($apellidosadjunto) and !empty($nombreadjunto) and !empty($numdocumentoadjunto) and !empty($direccionadjunto)) {
					$datosok = 1;
			}



			if ($datosok == 1) {
				if(empty($idadquiriente)){

							echo "Primero debe registrar el Adquiriente...";

				} else {

						if($objAdquiriente->ModificarAdjunto($idadquiriente, $apellidosadjunto,$nombreadjunto,$numdocumentoadjunto,$direccionadjunto)){

							echo "La información del Adjunto ha sido actualizada.";

						}else{

							echo "Error";

						}

				}
			} else {
					echo "Debe completar la Información del Adjunto.";
			}

			break;

		case "delete":			

			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objAdquiriente->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		case "list":

			$query_Tipo = $objAdquiriente->Listar();

			$data= Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {



     			$data[] = array("0"=>$i,

					"1"=>$reg->apellidos.'&nbsp;'.$reg->nombre,

					"2"=> $reg->tipodocumento.'&nbsp;'.$reg->numdocumento,
					
					"3"=>$reg->email,

					"4"=>$reg->telefono,

					"5"=>$reg->celular,

					"6"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataAdquiriente('.$reg->idadquiriente.',\''.$reg->apellidos.'\',\''.$reg->nombre.'\',\''.$reg->tipodocumento.'\',\''.$reg->numdocumento.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->celular.'\','.$reg->idestadocivil.',\''.$reg->email.'\',\''.$reg->estado.'\',\''.$reg->zona.'\',\''.$reg->ciudad.'\',\''.$reg->observaciones.'\',\''.$reg->fechaingreso.'\',\''.$reg->apellidosadjunto.'\',\''.$reg->nombreadjunto.'\',\''.$reg->numdocumentoadjunto.'\',\''.$reg->direccionadjunto.'\',\''.$reg->imagen1.'\',\''.$reg->imagen2.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarAdquiriente('.$reg->idadquiriente.')"><i class="fa fa-trash"></i> </button>');

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

		case "listEstadoCivil":

		        require_once "../model/EstadoCivil.php";

		        $objEstadoCivil = new EstadoCivil();

		        $queryEstadoCivil = $objEstadoCivil->ListarxNombre();

		        while ($reg = $queryEstadoCivil->fetch_object()) {

		            echo '<option value=' . $reg->idestadocivil . '>' . $reg->nombre . '</option>';

		        }

		    break;


	}

		