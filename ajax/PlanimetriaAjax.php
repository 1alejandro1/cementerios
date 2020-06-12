<?php



	session_start();



	require_once "../model/Planimetria.php";



	$objPlan = new Planimetria();



	switch ($_GET["op"]) {

        case 'SaveOrUpdate':

            $idlote = $_POST["txtIdLote"];

            $nombrereserva = $_POST["txtNombreReserva"];

            $montoreserva = $_POST["txtMontoReserva"];

            $idestadolote = $_POST["txtIdEstadoLote"];

            $tipomovimiento = $_POST["txtTipoMovimiento"];

            if($objPlan->ModificarReserva($idlote,$nombrereserva,$montoreserva,$idestadolote,$tipomovimiento)) {

                if ($tipomovimiento=='M') {
                    echo "Datos de reserva del Lote Actualizados";
                } else {
                    echo ($idestadolote==6 ? "El Lote ha sido Reservado" : "El Lote esta Disponible");
                }

            }else{

                if ($tipomovimiento=='M') {
                    echo "Los datos de la Reserva del Lote no han podido ser actualizados";
                } else {
                    echo "El Estado del Lote no ha podido ser actualizado.";
                }

            }


            break;

        case 'Update':
            $idlote = $_POST["id"];

            $nombrereserva = $_POST["nombrereserva"];

            $montoreserva = $_POST["montoreserva"];

            $idestadolote = $_POST["idestadolote"];

            if($objPlan->ModificarReserva($idlote,$nombrereserva,$montoreserva,$idestadolote,'A')){

                echo ($idestadolote==6 ? "El Lote ha sido Reservado" : "El Lote esta Disponible");

            }else{

                echo "El Estado del Lote no ha podido ser actualizado.";

            }


            break;

		case "list":

			$query_Tipo = $objPlan->Listar();

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

                    "7"=>$reg->nombrereserva,

                    "8"=>($reg->montoreserva==0 ? ' ':$reg->montoreserva),

                    "9"=>'<button data-toggle="tooltip" ' . ( $reg->estadolote=='Ocupado' ? 'class="btn btn-danger" disabled="" title="No puede Reservar"' : ( $reg->estadolote=='Disponible' ? 'class="btn btn-success" title="Reservar el Lote"' : 'class="btn btn-warning" title="Eliminar Reserva del Lote"') ) . ' onclick="cargarDataPlan(' . $reg->idlote . ',\'' . trim($reg->nombrereserva) . '\',\'' . $reg->login . '\',\'' . $reg->loginactualizo . '\',' . $reg->idestadolote . ',' . (is_null($reg->montoreserva) ? 0:$reg->montoreserva ) . ',\'A\')"><i ' . ( $reg->estadolote=='Disponible' ? 'class="fa fa-unlock"' : 'class="fa fa-lock"') . '></i></button>&nbsp;'.
                    '<button data-toggle="tooltip" class="btn btn-warning"' . ( $reg->estadolote<>'Reservado' ? ' disabled="" title="Lote No tiene Reservación"' : ' title="Editar Datos Reservación"' ) . ' onclick="cargarDataPlan(' . $reg->idlote . ',\'' . trim($reg->nombrereserva) . '\',\'' . $reg->login . '\',\'' . $reg->loginactualizo . '\',' . $reg->idestadolote . ',' . (is_null($reg->montoreserva) ? 0:$reg->montoreserva ) . ',\'M\')"><i class="fa fa-pencil"></i> </button>&nbsp;');
/*
                    "7"=>'<button data-toggle="tooltip" ' . ( $reg->estadolote=='Ocupado' ? 'class="btn btn-danger" disabled="" title="No puede Reservar"' : ( $reg->estadolote=='Disponible' ? 'class="btn btn-success" title="Reservar el Lote"' : 'class="btn btn-warning" title="Eliminar Reserva del Lote"') ) . ' onclick="actualizarLote(' . $reg->idlote . ',' . $reg->idestadolote . ')"><i class="fa fa-pencil"></i> </button>&nbsp;');
*/
                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);

			break;

	}

