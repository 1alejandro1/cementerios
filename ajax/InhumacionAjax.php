<?php



	session_start();



	require_once "../model/Inhumacion.php";



	$objInhumacion = new Inhumacion();



	switch ($_GET["op"]) {


		case 'SaveOrUpdate':

			$idcontrato = $_POST["txtIdContrato"];

			$iddifunto = $_POST["txtIdDifunto"];
			$codigo = $_POST["txtCodigo"];

			$fechafallecimiento = $_POST["txtFechaFallecimiento"];

			$fechainhumacion = $_POST["txtFechaInhumacion"];

			$idpersonal = $_POST["txtIdPersonal"];

			$observaciones = $_POST["txtObservaciones"];

			if(empty($_POST["txtIdInhumacion"])){

				if($objInhumacion->Registrar($idcontrato,$codigo, $iddifunto,$fechafallecimiento,$fechainhumacion,$idpersonal,$observaciones)){

					echo "Inhumación registrada correctamente";

				}else{

					echo "La Inhumación no ha podido ser registrada.";

				}

			}else{

				$idinhumacion = $_POST["txtIdInhumacion"];

				if($objInhumacion->Modificar($idinhumacion, $codigo, $idcontrato,$iddifunto,$fechafallecimiento,$fechainhumacion,$idpersonal,$observaciones)){

					echo "La informacion de la Inhumación ha sido actualizada";

				}else{

					echo "La informacion de la Inhumación no ha podido ser actualizada.";

				}

			}

			break;


		case "delete":

			$id = $_POST["id"];

			$result = $objInhumacion->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		case "CertificadoObito":
			$id = $_POST["id"];

			$result = $objInhumacion->CrearCertificadoObito($id);

			break;

		case "list":

			$query_Tipo = $objInhumacion->ListarInhumaciones();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->idinhumacion,

                    "2"=>$reg->nrocontrato,

                    "3"=>$reg->difunto,

                    "4"=>$reg->fechafallecimiento,

                    "5"=>$reg->fechainhumacion,

                    "6"=>$reg->personal,

                    "7"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataInhumacion('.$reg->idinhumacion.','.$reg->codigo.','.$reg->idcontrato.','.$reg->iddifunto.',\''.$reg->fechafallecimiento.'\',\''.$reg->fechainhumacion.'\',\''.$reg->fecharegistro.'\','.$reg->idpersonal.',\''.$reg->observaciones.'\',\''.$reg->nrocontrato.'\',\''.$reg->fechacontrato.'\',\''.$reg->difunto.'\',\''.$reg->personal.'\',\''.$reg->cementerio.'\',\''.$reg->sector.'\',\''.$reg->lote.'\',\''.$reg->fila.'\',\''.$reg->columna.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.
     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarInhumacion('.$reg->idinhumacion.')"><i class="fa fa-trash"></i> </button>&nbsp;'.
     				'<button class="btn btn-primary" data-toggle="tooltip" title="Certificado de Óbito" onclick="certificadoObito('.$reg->idinhumacion . ',\'' . trim($reg->nrocontrato) .'\')"><i class="fa fa-print"></i> </button>');

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);


			break;

		case "listContrato":

	        require_once "../model/Contrato.php";

	        $objContrato = new Contrato();

	        $query = $objContrato->ListarContratos();

	        $i = 1;

	        while ($regContrato = $query->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optContratoBusqueda" data-nombre="' . $regContrato->nrocontrato . 
		                	'" data-cementerio="' . trim($regContrato->razonsocial) . 
		                	'" data-sector="' . trim($regContrato->sector) . 
		                	'" data-lote="' . trim($regContrato->nrolote) . 
		                	'" data-fila="' . trim($regContrato->fila) . 
		                	'" data-columna="' . trim($regContrato->columna) . 
		                	'" data-fechacontrato="' . $regContrato->fechacontrato . '" id="cont'.$regContrato->idcontrato.'" value="'.$regContrato->idcontrato.'" /></td>

		                <td>'.$i.'</td>

		                <td>'. $regContrato->nrocontrato .'</td>

		                <td>'.$regContrato->adquiriente.'</td>

		                <td>'.$regContrato->ejecutivoventa.'</td>

	                   </tr>';

	            $i++;
	        }



	        break;

	    case "listDifunto":

	    	require_once "../model/Difunto.php";

	        $objDifunto = new Difunto();

	        $query_Difunto = $objDifunto->ListarDifuntosconResponsables();

	        $i = 1;

	        while ($regDifunto = $query_Difunto->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optDifuntoBusqueda" data-nombre="'.$regDifunto->nombre .'"    id="dif'.$regDifunto->iddifunto.'" value="'.$regDifunto->iddifunto.'" /></td>

		                <td>'.$i.'</td>

		                <td>'.$regDifunto->tipodocumento . ' ' . $regDifunto->numdocumento .'</td>

		                <td>'. $regDifunto->nombre .'</td>

	                   </tr>';

	            $i++;
	        }



	        break;
	    case "listPersonal":

	    	require_once "../model/Personal.php";

	        $objPersonal = new Personal();

	        $query_Personal = $objPersonal->ListarPersonal();

	        $i = 1;

	        while ($regPersonal = $query_Personal->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optPersonalBusqueda" data-nombre="'.$regPersonal->nombre . ' ' . $regPersonal->apellidos.'" id="per'.$regPersonal->idpersonal.'" value="'.$regPersonal->idpersonal.'" /></td>

		                <td>'.$i.'</td>

		                <td>'.$regPersonal->tipodocumento . ' ' . $regPersonal->numdocumento .'</td>

		                <td>'. $regPersonal->nombre . ' ' . $regPersonal->apellidos .'</td>

	                   </tr>';
	            $i++;

	        }



	        break;
	}

