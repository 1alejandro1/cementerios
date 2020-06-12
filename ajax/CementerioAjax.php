<?php



	session_start();



	require_once "../model/Cementerio.php";



	$objCementerio = new Cementerio();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':



			$razonsocial = $_POST["txtRazonSocial"];

			$tipodocumento = $_POST["cboTipoDocumento"];

			$numdocumento = $_POST["txtNumDocumento"];

			$direccion = $_POST["txtDireccion"];

			$telefono = $_POST["txtTelefono"];

			$email = $_POST["txtEmail"];

			$representante = $_POST["txtRepresentante"];

			$imagen = $_FILES["imagenCem"]["tmp_name"];

			$ruta = $_FILES["imagenCem"]["name"];

			$estado = $_POST["cboEstado"];


			if(move_uploaded_file($imagen, "../Files/Cementerio/".$ruta)){



				if(empty($_POST["txtIdCementerio"])){



					if($objCementerio->Registrar($razonsocial,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante,"Files/Cementerio/".$ruta,$estado)){

						echo "Cementerio Registrado correctamente.";

					}else{

						echo "Cementerio no ha podido ser registrado.";

					}

				} else {



					$idcementerio = $_POST["txtIdCementerio"];

					if($objCementerio->Modificar($idcementerio, $razonsocial,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante,"Files/Cementerio/".$ruta,$estado)){

						echo "La información del Cementerio ha sido actualizada.";

					}else{

						echo "La información del Cementerio no ha podido ser actualizada.";

					}

				}

			} else {

				$ruta_img = $_POST["txtRutaImgCem"];

				if(empty($_POST["txtIdCementerio"])){



					if($objCementerio->Registrar($razonsocial,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante, $ruta_img,$estado)){

						echo "Cementerio Registrado correctamente.";

					}else{

						echo "Cementerio no ha podido ser registrado.";

					}

				}else{



					$idcementerio = $_POST["txtIdCementerio"];

					// fACTURACION if($objCementerio->Modificar($idcementerio,$razonsocial,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante, $ruta_img,$estado,$numero_autorizacion,$leyenda_facturacion,$llave_dosificacion,$fecha_limite_emision_facturas)){

						if($objCementerio->Modificar($idcementerio,$razonsocial,$tipodocumento,$numdocumento,$direccion,$telefono,$email,$representante, $ruta_img,$estado)){

						echo "La información del Cementerio ha sido actualizada.";

					}else{

						echo "La información del Cementerio no ha podido ser actualizada.";

					}

				}

			}



			break;



		case "delete":



			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objCementerio->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objCementerio->Listar();



            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {



     			$data[] = array($i,

					$reg->razonsocial,

					$reg->tipodocumento.'&nbsp;'.$reg->numdocumento,

					$reg->direccion,

					$reg->email,

					'<img width=100px height=100px src="./'.$reg->logo.'" />',

					'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataCementerio('.$reg->idcementerio.',\''.$reg->razonsocial.'\',\''.$reg->tipodocumento.'\',\''.$reg->numdocumento.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->email.'\',\''.$reg->representante.'\',\''.$reg->logo.'\',\''.$reg->estado.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarCementerio('.$reg->idcementerio.')"><i class="fa fa-trash"></i> </button>');

				$i++;

			}

			echo json_encode($data);



			break;



		case "listCementerioPersonal":



			require_once "../model/Configuracion.php";



			$objConf = new Configuracion();



			$query_conf = $objConf->Listar();



			$query_Tipo = $objCementerio->ListarCementeriosPersonal($_SESSION["idpersonal"]);



            $i = 1;

            $estadoAdmin = "";

            $idpersonal = "";

            $idusuario = "";

            $idcementerio = "";

            $personal = "";

            $tipodocumento = "";

            $direccion = "";

            $telefono = "";

            $foto = "";

            $email = "";

            $login = "";

			$mnu_cementerio = 1;
			$mnu_sector = 1;
			$mnu_lote = 1;
			$mnu_tipolote = 1;
			$mnu_estadolote = 1;
			$mnu_mantenimiento = 1;
			$mnu_montocuota = 1;
			$mnu_planimetria = 1;

			$mnu_personal = 1;
			$mnu_difunto = 1;
			$mnu_responsable = 1;
			$mnu_inhumacion = 1;
			$mnu_exhumacion = 1;

			$mnu_contrato = 1;
			$mnu_cobranza = 1;
			$mnu_adquiriente = 1;
			$mnu_ejecutivoventa = 1;
			$mnu_comision = 1;

	        $regConf = $query_conf->fetch_object();



     		while ($reg = $query_Tipo->fetch_object()) {

	             echo '<tr>

	             		<td><button type="button" onclick="Acceder('.$reg->idusuario.',\''.$reg->idcementerio.'\',\''.$reg->idpersonal.'\',\''.$reg->personal.'\',\''.$reg->tipodocumento.'\',\''.$reg->tipo_usuario.'\',\''.$reg->numdocumento.'\',\''.$reg->direccion.'\',\''.$reg->telefono.'\',\''.$reg->foto.'\',\''.$reg->logo.'\',\''.$reg->email.'\',\''.$reg->login.'\',\''.$reg->razonsocial.'\',\''.$reg->mnu_cementerio.'\',\''.$reg->mnu_sector.'\',\''.$reg->mnu_lote.'\',\''.$reg->mnu_tipolote.'\',\''.$reg->mnu_estadolote.'\',\''.$reg->mnu_mantenimiento.'\',\''.$reg->mnu_montocuota.'\',\''.$reg->mnu_planimetria.'\',\''.$reg->mnu_personal.'\',\''.$reg->mnu_difunto.'\',\''.$reg->mnu_responsable.'\',\''.$reg->mnu_inhumacion.'\',\''.$reg->mnu_exhumacion.'\',\''.$reg->mnu_contrato.'\',\''.$reg->mnu_cobranza.'\',\''.$reg->mnu_adquiriente.'\',\''.$reg->mnu_ejecutivoventa.'\',\''.$reg->mnu_comision.'\',\''.$reg->mnu_estadolote.'\')" class="btn btn-info pull-left">Acceder</button></td>

		                <td>'.$reg->razonsocial.'</td>

		                <td><img class="img-thumbnail" width="100px" height="100px" src="./'.$reg->logo.'" /></td>

	                   </tr>';

	             $i++;

	             $estadoAdmin = $reg->superadmin;

	             $idpersonal = $reg->idpersonal;

	             $idusuario = $reg->idusuario;

	             $idcementerio = $reg->idcementerio;

	             $personal = $reg->personal;

	             $tipodocumento = $reg->tipodocumento;

	             $direccion = $reg->direccion;

	             $telefono = $reg->telefono;

	             $foto = $reg->foto;

	             $email = $reg->email;

	             $login = $reg->login;

            }



            if ($estadoAdmin == "S") {

            	echo '<tr>

            		<td><button type="button" onclick="AccederSuperAdmin('.$idpersonal.',\''.$idusuario.'\',\''.$idcementerio.'\',\''.$estadoAdmin.'\',\''.$personal.'\',\''.$tipodocumento.'\',\''.$direccion.'\',\''.$telefono.'\',\''.$foto.'\',\''.$email.'\',\''.$login.'\',\''.$reg->mnu_cementerio.'\',\''.$reg->mnu_sector.'\',\''.$reg->mnu_lote.'\',\''.$reg->mnu_tipolote.'\',\''.$reg->mnu_estadolote.'\',\''.$reg->mnu_mantenimiento.'\',\''.$reg->mnu_montocuota.'\',\''.$reg->mnu_planimetria.'\',\''.$reg->mnu_personal.'\',\''.$reg->mnu_difunto.'\',\''.$reg->mnu_responsable.'\',\''.$reg->mnu_inhumacion.'\',\''.$reg->mnu_exhumacion.'\',\''.$reg->mnu_contrato.'\',\''.$reg->mnu_cobranza.'\',\''.$reg->mnu_adquiriente.'\',\''.$reg->mnu_ejecutivoventa.'\',\''.$reg->mnu_comision.'\',\''.$regConf->logo.'\')" class="btn btn-success pull-left">Acceder</button></td>

            		<td>Acceso Administrador</td>

            		<td></td>

            	</tr>';

            }



			break;

		case "listTipoDocumentoPersona":

		        require_once "../model/TipoDocumento.php";


		        $objTipoDocumento = new TipoDocumento();



		        $query_TipoDocumento = $objTipoDocumento->VerTipoDocumentoPersona();



		        while ($reg = $query_TipoDocumento->fetch_object()) {

		            echo '<option value=' . $reg->nombre . '>' . $reg->nombre . '</option>';

		        }



		    break;


	}
