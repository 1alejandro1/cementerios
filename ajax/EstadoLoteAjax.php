<?php



	session_start();



	require_once "../model/EstadoLote.php";



	$objEstadoLote = new EstadoLote();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$nombre = $_POST["txtNombre"]; // Llamamos al input txtNombre



			if(empty($_POST["txtIdEstadoLote"])){

				

				if($objEstadoLote->Registrar($nombre)){

					echo "Estado del Lote Registrado.";

				}else{

					echo "Estado del Lote no ha podido ser registado.";

				}

			}else{

				

				$idEstadoLote = $_POST["txtIdEstadoLote"];

				if($objEstadoLote->Modificar($idEstadoLote, $nombre)){

					echo "Estado del Lote actualizado.";

				}else{

					echo "Informacion del Estado del Lote no ha podido ser actualizada.";

				}

			}

			break;



		case "delete":			

			

			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (EstadoLote.js (Linea 62))

			$result = $objEstadoLote->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		

		case "list":



			$query_Estado = $objEstadoLote->Listar();

			$data = Array();

			$i = 1;

			while ($reg = $query_Estado->fetch_object()) {

				$data[] = array(

					"id"=>$i,

					"1"=>$reg->nombre,

					"2"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataEstadoLote('.$reg->idestadolote.',\''.$reg->nombre.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarEstadoLote('.$reg->idestadolote.')"><i class="fa fa-trash"></i> </button>');

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

	