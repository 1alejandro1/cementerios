<?php



	session_start();



	require_once "../model/Lote.php";



	$objLote = new Lote();



	switch ($_GET["op"]) {


		case 'SaveOrUpdate':

			$idsector = $_POST["cboSectorLot"];

			$idcementerio = $_POST["cboCementerioLot"];

			$idtipolote = $_POST["cboTipoLote"];

			$idestadolote = $_POST["cboEstadoLote"];

			$numlote = $_POST["txtNumero"];

			$fila = $_POST["txtFila"];

			$columna = $_POST["txtColumna"];

			$observaciones = $_POST["txtObservaciones"];

			if(empty($_POST["txtIdLote"])){

				if($objLote->Registrar($idsector,$idcementerio,$idtipolote,$idestadolote,$numlote,$fila,$columna,$observaciones)){

					echo "Lote registrado correctamente";

				}else{

					echo "El Lote no ha podido ser registrado.";

				}

			}else{

				$idlote = $_POST["txtIdLote"];

				if($objLote->Modificar($idlote,$idsector,$idcementerio,$idtipolote,$idestadolote,$numlote,$fila,$columna,$observaciones)){

					echo "La informacion del Lote ha sido actualizada";

				}else{

					echo "La informacion del Lote no ha podido ser actualizada.";

				}

			}

			break;



		case "delete":



			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objLote->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objLote->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->sector,

                    "2"=>$reg->tipolote,

                    "3"=>$reg->numlote,

                    "4"=>$reg->fila,

                    "5"=>$reg->columna,

                    "6"=>( $reg->estadolote=='Disponible' ? '<center><label class="btn btn-success">' : ( $reg->estadolote=='Ocupado' ? '<center><label class="btn btn-danger">' : '<center><label class="btn btn-warning">')) . $reg->estadolote . '</center></label>',

                    "7"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataLote('.$reg->idlote.','.$reg->idsector.','.$reg->idcementerio.','.$reg->idtipolote.','.$reg->idestadolote.',\''.$reg->numlote.'\',\''.$reg->fila.'\',\''.$reg->columna.'\',\''.$reg->observacioneslote.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarLote('.$reg->idlote.')"><i class="fa fa-trash"></i> </button>');

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

	        $query = $objCementerio->ListarCementerioconSectores();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idcementerio . '>' . $reg->razonsocial . '</option>';

	        }

	        break;

		case "listSector":

			$idcementerio = $_POST["idcementerio"];

			$idsector = $_POST["idsector"];

			$habilitado = $_POST["habilitado"];

	        require_once ("../model/Sector.php");

	        $objLote = new Sector();

	        $query = $objLote->SectorxCementerio($idcementerio, $idsector, $habilitado);

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idsector . '>' . $reg->nombre . '</option>';

	        }

	        break;
/*
		case "listSector":

	        require_once "../model/Sector.php";

	        $objSector = new Sector();

	        $query = $objSector->Listar();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idsector . '>' . $reg->nombre . '</option>';

	        }


	        break;
*/
		case "listTipoLote":

	        require_once "../model/TipoLote.php";

	        $objTipoLote = new TipoLote();

	        $query = $objTipoLote->Listar();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idtipolote . '>' . $reg->nombre . '</option>';

	        }


	        break;
		case "listEstadoLote":

	        require_once "../model/EstadoLote.php";

	        $objEstadoLote = new EstadoLote();

	        $query = $objEstadoLote->Listar();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idestadolote . '>' . $reg->nombre . '</option>';

	        }


	        break;


	}

