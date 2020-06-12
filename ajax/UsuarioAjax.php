<?php



	session_start();



	require_once "../model/Usuario.php";



	$objusuario = new usuario();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':

			$mnu_cementerio = 0;
			$mnu_sector = 0;
			$mnu_lote = 0;
			$mnu_tipolote = 0;
			$mnu_estadolote = 0;
			$mnu_mantenimiento = 0;
			$mnu_montocuota = 0;
			$mnu_planimetria = 0;

			$mnu_personal = 0;
			$mnu_difunto = 0;
			$mnu_responsable = 0;
			$mnu_inhumacion = 0;
			$mnu_exhumacion = 0;

			$mnu_contrato = 0;
			$mnu_cobranza = 0;
			$mnu_adquiriente = 0;
			$mnu_ejecutivoventa = 0;
			$mnu_comision = 0;

			$idcementerio = $_POST["cboCementerio"];

			$idpersonal = $_POST["txtIdPersonal"];

			$tipo_usuario = $_POST["cboTipoUsuario"];


			if(isset($_POST["chkMnuCementerio"])){

				$mnu_cementerio = true;

			} else {

				$mnu_cementerio = 0;

			}
			if(isset($_POST["chkMnuSector"])){

				$mnu_sector = true;

			} else {

				$mnu_sector = 0;

			}
			if(isset($_POST["chkMnuLote"])){

				$mnu_lote = true;

			} else {

				$mnu_lote = 0;

			}
			if(isset($_POST["chkMnuTipoLote"])){

				$mnu_tipolote = true;

			} else {

				$mnu_tipolote = 0;

			}
			if(isset($_POST["chkMnuEstadoLote"])){

				$mnu_estadolote = true;

			} else {

				$mnu_estadolote = 0;

			}
			if(isset($_POST["chkMnuMantenimiento"])){

				$mnu_mantenimiento = true;

			} else {

				$mnu_mantenimiento = 0;

			}
			if(isset($_POST["chkMnuMontoCuota"])){

				$mnu_montocuota = true;

			} else {

				$mnu_montocuota = 0;

			}
			if(isset($_POST["chkMnuPlanimetria"])){

				$mnu_planimetria = true;

			} else {

				$mnu_planimetria = 0;

			}


			if(isset($_POST["chkMnuPersonal"])){

				$mnu_personal = true;

			} else {

				$mnu_personal = 0;

			}
			if(isset($_POST["chkMnuDifunto"])){

				$mnu_difunto = true;

			} else {

				$mnu_difunto = 0;

			}
			if(isset($_POST["chkMnuResponsable"])){

				$mnu_responsable = true;

			} else {

				$mnu_responsable = 0;

			}
			if(isset($_POST["chkMnuInhumacion"])){

				$mnu_inhumacion = true;

			} else {

				$mnu_inhumacion = 0;

			}
			if(isset($_POST["chkMnuExhumacion"])){

				$mnu_exhumacion = true;

			} else {

				$mnu_exhumacion = 0;

			}

			if(isset($_POST["chkMnuContrato"])){

				$mnu_contrato = true;

			} else {

				$mnu_contrato = 0;

			}
			if(isset($_POST["chkMnuCobranza"])){

				$mnu_cobranza = true;

			} else {

				$mnu_cobranza = 0;

			}
			if(isset($_POST["chkMnuAdquiriente"])){

				$mnu_adquiriente = true;

			} else {

				$mnu_adquiriente = 0;

			}
			if(isset($_POST["chkMnuEjecutivoVenta"])){

				$mnu_ejecutivoventa = true;

			} else {

				$mnu_ejecutivoventa = 0;

			}
			if(isset($_POST["chkMnuComision"])){

				$mnu_comision = true;

			} else {

				$mnu_comision = 0;

			}

				if(empty($_POST["txtIdUsuario"])){



					if($objusuario->Registrar($idcementerio, $idpersonal, $tipo_usuario, $mnu_cementerio, $mnu_sector, $mnu_lote, $mnu_tipolote, $mnu_estadolote, $mnu_mantenimiento, $mnu_montocuota, $mnu_planimetria, $mnu_personal, $mnu_difunto, $mnu_responsable, $mnu_inhumacion, $mnu_exhumacion, $mnu_contrato, $mnu_cobranza, $mnu_adquiriente, $mnu_ejecutivoventa, $mnu_comision)){

						echo "Registrado Exitosamente";

					}else{

						echo "Usuario no ha podido ser registado.";

					}

				}else{



					$idusuario = $_POST["txtIdUsuario"];

					if($objusuario->Modificar($idusuario, $idcementerio, $idpersonal, $tipo_usuario, $mnu_cementerio, $mnu_sector, $mnu_lote, $mnu_tipolote, $mnu_estadolote, $mnu_mantenimiento, $mnu_montocuota, $mnu_planimetria, $mnu_personal, $mnu_difunto, $mnu_responsable, $mnu_inhumacion, $mnu_exhumacion, $mnu_contrato, $mnu_cobranza, $mnu_adquiriente, $mnu_ejecutivoventa, $mnu_comision)){

						echo "Informacion del Usuario ha sido actualizada";

					}else{

						echo "Informacion del usuario no ha podido ser actualizada.";

					}

				}



			break;



		case "delete":



			$id = $_POST["id"];

			$result = $objusuario->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objusuario->Listar();

			$data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->razonsocial,

                    "2"=>$reg->personal,

                    "3"=>$reg->tipo_usuario,

                    "4"=>$reg->fecha_registro,

                    "5"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataUsuario('.$reg->idusuario.',\''.$reg->idcementerio.'\',\''.$reg->idpersonal.'\',\''.$reg->personal.'\',\''.$reg->tipo_usuario.'\',\''.$reg->mnu_cementerio.'\',\''.$reg->mnu_sector.'\',\''.$reg->mnu_lote.'\',\''.$reg->mnu_tipolote.'\',\''.$reg->mnu_estadolote.'\',\''.$reg->mnu_mantenimiento.'\',\''.$reg->mnu_montocuota.'\',\''.$reg->mnu_planimetria.'\',\''.$reg->mnu_personal.'\',\''.$reg->mnu_difunto.'\',\''.$reg->mnu_responsable.'\',\''.$reg->mnu_inhumacion.'\',\''.$reg->mnu_exhumacion.'\',\''.$reg->mnu_contrato.'\',\''.$reg->mnu_cobranza.'\',\''.$reg->mnu_adquiriente.'\',\''.$reg->mnu_ejecutivoventa.'\',\''.$reg->mnu_comision.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

                    '<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarUsuario('.$reg->idusuario.')"><i class="fa fa-trash"></i> </button>');

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);



			break;



		case "listCementerio":

	        require_once "../model/Cementerio.php";

	        $objCementerio = new Cementerio();

	        $query = $objCementerio->ListarCementerio();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idcementerio . '>' . $reg->razonsocial . '</option>';

	        }



	        break;



	    case "listPersonal":



	    	require_once "../model/Personal.php";



	        $objPersonal = new Personal();



	        $query_Personal = $objPersonal->ListarPersonal();



	        $i = 1;



	        while ($reg = $query_Personal->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optPersonalBusqueda" data-nombre="'.$reg->nombre.'" data-apellidos="'.$reg->apellidos.'" id="'.$reg->idpersonal.'" value="'.$reg->idpersonal.'" /></td>

		                <td>'.$i.'</td>

		                <td>'.$reg->apellidos.'</td>

		                <td>'.$reg->nombre.'</td>

		                <td>'.$reg->tipodocumento.'</td>

		                <td>'.$reg->numdocumento.'</td>

		                <td>'.$reg->email.'</td>

		                <td><img width=100px height=100px src="./'.$reg->foto.'" /></td>

	                   </tr>';

	        }



	        break;



	    case "IngresarSistema":

	    	$user = $_REQUEST["user"];
			$pass = $_REQUEST["pass"];


			$query = $objusuario->Ingresar_Sistema($user, md5($pass));

			$fetch = $query->fetch_object();

			echo json_encode($fetch);


			if(isset($fetch)){

				$_SESSION["idusuario"] = $fetch->idusuario;

				$_SESSION["idpersonal"] = $fetch->idpersonal;

				$_SESSION["personal"] = $fetch->personal;

				$_SESSION["tipodocumento"] = $fetch->tipodocumento;

				$_SESSION["tipo_usuario"] = $fetch->tipo_usuario;

				$_SESSION["numdocumento"] = $fetch->numdocumento;

				$_SESSION["direccion"] = $fetch->direccion;

				$_SESSION["telefono"] = $fetch->telefono;

				$_SESSION["foto"] = $fetch->foto;

				$_SESSION["logo"] = $fetch->logo;

				$_SESSION["email"] = $fetch->email;

				$_SESSION["login"] = $fetch->login;

				$_SESSION["razonsocial"] = $fetch->razonsocial;

				$_SESSION["mnu_cementerio"] = $fetch->mnu_cementerio;
				$_SESSION["mnu_sector"] = $fetch->mnu_sector;
				$_SESSION["mnu_lote"] = $fetch->mnu_lote;
				$_SESSION["mnu_tipolote"] = $fetch->mnu_tipolote;
				$_SESSION["mnu_estadolote"] = $fetch->mnu_estadolote;
				$_SESSION["mnu_mantenimiento"] = $fetch->mnu_mantenimiento;
				$_SESSION["mnu_montocuota"] = $fetch->mnu_montocuota;
				$_SESSION["mnu_planimetria"] = $fetch->mnu_planimetria;
				$_SESSION["mnu_personal"] = $fetch->mnu_personal;
				$_SESSION["mnu_difunto"] = $fetch->mnu_difunto;
				$_SESSION["mnu_responsable"] = $fetch->mnu_responsable;
				$_SESSION["mnu_inhumacion"] = $fetch->mnu_inhumacion;
				$_SESSION["mnu_exhumacion"] = $fetch->mnu_exhumacion;
				$_SESSION["mnu_contrato"] = $fetch->mnu_contrato;
				$_SESSION["mnu_cobranza"] = $fetch->mnu_cobranza;
				$_SESSION["mnu_adquiriente"] = $fetch->mnu_adquiriente;
				$_SESSION["mnu_ejecutivoventa"] = $fetch->mnu_ejecutivoventa;
				$_SESSION["mnu_comision"] = $fetch->mnu_comision;

				$_SESSION["mnu_admin"] = $fetch->mnu_admin;

			}

			break;



		case "IngresarPanel" :

				$_SESSION["idusuario"] = $_POST["idusuario"];

				$_SESSION["idcementerio"] = $_POST["idcementerio"];

				$_SESSION["idpersonal"] = $_POST["idpersonal"];

				$_SESSION["superadmin"] = "A";

				$_SESSION["personal"] = $_POST["personal"];

				$_SESSION["tipodocumento"] = $_POST["tipodocumento"];

				$_SESSION["tipo_usuario"] = $_POST["tipo_usuario"];

				$_SESSION["numdocumento"] = $_POST["numdocumento"];

				$_SESSION["direccion"] = $_POST["direccion"];

				$_SESSION["telefono"] = $_POST["telefono"];

				$_SESSION["foto"] = $_POST["foto"];

				$_SESSION["logo"] = $_POST["logo"];

				$_SESSION["email"] = $_POST["email"];

				$_SESSION["login"] = $_POST["login"];

				$_SESSION["cementerio"] = $_POST["razonsocial"];

				$_SESSION["mnu_cementerio"] = $_POST["mnu_cementerio"];
				$_SESSION["mnu_sector"] = $_POST["mnu_sector"];
				$_SESSION["mnu_lote"] = $_POST["mnu_lote"];
				$_SESSION["mnu_tipolote"] = $_POST["mnu_tipolote"];
				$_SESSION["mnu_estadolote"] = $_POST["mnu_estadolote"];
				$_SESSION["mnu_mantenimiento"] = $_POST["mnu_mantenimiento"];
				$_SESSION["mnu_montocuota"] = $_POST["mnu_montocuota"];
				$_SESSION["mnu_planimetria"] = $_POST["mnu_planimetria"];
				$_SESSION["mnu_personal"] = $_POST["mnu_personal"];
				$_SESSION["mnu_difunto"] = $_POST["mnu_difunto"];
				$_SESSION["mnu_responsable"] = $_POST["mnu_responsable"];
				$_SESSION["mnu_inhumacion"] = $_POST["mnu_inhumacion"];
				$_SESSION["mnu_exhumacion"] = $_POST["mnu_exhumacion"];
				$_SESSION["mnu_contrato"] = $_POST["mnu_contrato"];
				$_SESSION["mnu_cobranza"] = $_POST["mnu_cobranza"];
				$_SESSION["mnu_cliente"] = $_POST["mnu_adquiriente"];
				$_SESSION["mnu_ejecutivoventa"] = $_POST["mnu_ejecutivoventa"];
				$_SESSION["mnu_comision"] = $_POST["mnu_comision"];

				$_SESSION["mnu_admin"] = $_POST["mnu_admin"];

		break;



		case "IngresarPanelSuperAdmin" :

				$_SESSION["idusuario"] = $_POST["idusuario"];

				$_SESSION["idcementerio"] = $_POST["idcementerio"];

				$_SESSION["idpersonal"] = $_POST["idpersonal"];

				$_SESSION["superadmin"] = 'B';

				$_SESSION["personal"] = $_POST["personal"];

				$_SESSION["tipodocumento"] = $_POST["tipodocumento"];

				$_SESSION["tipo_usuario"] = $_POST["tipo_usuario"];

				$_SESSION["numdocumento"] = $_POST["numdocumento"];

				$_SESSION["direccion"] = $_POST["direccion"];

				$_SESSION["telefono"] = $_POST["telefono"];

				$_SESSION["foto"] = $_POST["foto"];

				$_SESSION["logo"] = $_POST["logo"];

				$_SESSION["email"] = $_POST["email"];

				$_SESSION["login"] = $_POST["login"];

				$_SESSION["cementerio"] = $_POST["razonsocial"];

				$_SESSION["mnu_cementerio"] = $_POST["mnu_cementerio"];
				$_SESSION["mnu_sector"] = $_POST["mnu_sector"];
				$_SESSION["mnu_lote"] = $_POST["mnu_lote"];
				$_SESSION["mnu_tipolote"] = $_POST["mnu_tipolote"];
				$_SESSION["mnu_estadolote"] = $_POST["mnu_estadolote"];
				$_SESSION["mnu_mantenimiento"] = $_POST["mnu_mantenimiento"];
				$_SESSION["mnu_montocuota"] = $_POST["mnu_montocuota"];
				$_SESSION["mnu_planimetria"] = $_POST["mnu_planimetria"];
				$_SESSION["mnu_personal"] = $_POST["mnu_personal"];
				$_SESSION["mnu_difunto"] = $_POST["mnu_difunto"];
				$_SESSION["mnu_responsable"] = $_POST["mnu_responsable"];
				$_SESSION["mnu_inhumacion"] = $_POST["mnu_inhumacion"];
				$_SESSION["mnu_exhumacion"] = $_POST["mnu_exhumacion"];
				$_SESSION["mnu_contrato"] = $_POST["mnu_contrato"];
				$_SESSION["mnu_cobranza"] = $_POST["mnu_cobranza"];
				$_SESSION["mnu_cliente"] = $_POST["mnu_adquiriente"];
				$_SESSION["mnu_ejecutivoventa"] = $_POST["mnu_ejecutivoventa"];
				$_SESSION["mnu_comision"] = $_POST["mnu_comision"];

				$_SESSION["mnu_admin"] = $_POST["mnu_admin"];
		break;



		case "Salir":

			session_unset();

			session_destroy();

			header("Location:../");

			break;

	}

 