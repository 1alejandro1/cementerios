<?php



	session_start();



	require_once "../model/TipoLote.php";



	$objTipoLote = new TipoLote();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$nombre = $_POST["txtNombre"]; // Llamamos al input txtNombre



			if(empty($_POST["txtIdTipoLote"])){

				

				if($objTipoLote->Registrar($nombre)){

					echo "Tipo de Lote Registrado.";

				}else{

					echo "Tipo de Lote no ha podido ser registado.";

				}

			}else{

				

				$idTipoLote = $_POST["txtIdTipoLote"];

				if($objTipoLote->Modificar($idTipoLote, $nombre)){

					echo "Tipo de Lote actualizado.";

				}else{

					echo "Informacion del Tipo de Lote no ha podido ser actualizada.";

				}

			}

			break;



		case "delete":			

			

			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (TipoLote.js (Linea 62))

			$result = $objTipoLote->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		

		case "list":



			$query_Tipo = $objTipoLote->Listar();

			$data = Array();

			$i = 1;

			while ($reg = $query_Tipo->fetch_object()) {

				$data[] = array(

					"id"=>$i,

					"1"=>$reg->nombre,

					"2"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataTipoLote('.$reg->idtipolote.',\''.$reg->nombre.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarTipoLote('.$reg->idtipolote.')"><i class="fa fa-trash"></i> </button>');

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

	