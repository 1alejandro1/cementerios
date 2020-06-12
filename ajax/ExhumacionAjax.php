<?php



	session_start();



	require_once "../model/Exhumacion.php";



	$objExhumacion = new Exhumacion();



	switch ($_GET["op"]) {


		case 'SaveOrUpdate':

			$idcontrato = $_POST["txtIdContrato"];

			$fechaexhumacion = $_POST["txtFechaExhumacion"];

			$idpersonal = $_POST["txtIdPersonal"];

			$tipo = $_POST["txtTipo"];

			$observaciones = $_POST["txtObservaciones"];

			if(empty($_POST["txtIdExhumacion"])){

				if($objExhumacion->Registrar($idcontrato,$fechaexhumacion,$idpersonal,$tipo,$observaciones)){

					echo "Exhumación registrada correctamente";

				}else{

					echo "La Exhumación no ha podido ser registrada.";

				}

			}else{

				$idexhumacion = $_POST["txtIdExhumacion"];

				if($objExhumacion->Modificar($idexhumacion,$idcontrato,$fechaexhumacion,$idpersonal,$tipo,$observaciones)){

					echo "La informacion de la Exhumación ha sido actualizada";

				}else{

					echo "La informacion de la Exhumación no ha podido ser actualizada.";

				}

			}

			break;


		case "delete":

			$id = $_POST["id"];

			$result = $objExhumacion->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		case "CertificadoExhumacion":
			$id = $_POST["id"];

			$result = $objExhumacion->CrearCertificadoExhumacion($id);

			break;

		case "list":

			$query_Tipo = $objExhumacion->ListarExhumaciones();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->idexhumacion,

                    "2"=>$reg->nrocontrato,

                    "3"=>$reg->difunto,

                    "4"=>$reg->fechaexhumacion,

                    "5"=>$reg->personal,

                    "6"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataExhumacion('.$reg->idexhumacion.','.$reg->idcontrato.',\''.$reg->fechaexhumacion.'\',\''.$reg->fecharegistro.'\',\''.$reg->tipo.'\','.$reg->idpersonal.',\''.$reg->observaciones.'\',\''.$reg->nrocontrato.'\',\''.$reg->fechacontrato.'\',\''.$reg->difunto.'\',\''.$reg->fechafallecimiento.'\',\''.$reg->fechainhumacion.'\',\''.$reg->personal.'\',\''.$reg->cementerio.'\',\''.$reg->sector.'\',\''.$reg->lote.'\',\''.$reg->fila.'\',\''.$reg->columna.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.
     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarExhumacion('.$reg->idexhumacion.')"><i class="fa fa-trash"></i> </button>&nbsp;'.
     				'<button class="btn btn-primary" data-toggle="tooltip" title="Certificado de Exhumación" onclick="certificadoExhumacion('.$reg->idexhumacion . ',\'' . trim($reg->nrocontrato) .'\')"><i class="fa fa-print"></i> </button>');

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

	        $query = $objContrato->ListarContratosInhumados();

	        $i = 1;

	        while ($regContrato = $query->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optContratoBusqueda" data-nombre="' . $regContrato->nrocontrato . 
		                	'" data-cementerio="' . trim($regContrato->razonsocial) . 
		                	'" data-sector="' . trim($regContrato->sector) . 
		                	'" data-lote="' . trim($regContrato->numlote) . 
		                	'" data-fila="' . trim($regContrato->fila) . 
		                	'" data-columna="' . trim($regContrato->columna) . 
		                	'" data-difunto="' . trim($regContrato->difunto) . 
		                	'" data-fechafallecimiento="' . trim($regContrato->fechafallecimiento) . 
		                	'" data-fechainhumacion="' . trim($regContrato->fechainhumacion) . 
		                	'" data-fechacontrato="' . $regContrato->fechacontrato . '" id="cont'.$regContrato->idcontrato.'" value="'.$regContrato->idcontrato.'" /></td>

		                <td>'.$i.'</td>

		                <td>'. $regContrato->nrocontrato .'</td>

		                <td>'.$regContrato->difunto.'</td>

		                <td>'.$regContrato->adquiriente.'</td>

		                <td>'.$regContrato->ejecutivoventa.'</td>

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

