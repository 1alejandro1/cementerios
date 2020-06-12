<?php



	session_start();



	require_once "../model/TasaCambio.php";



	$objTasaCambio = new TasaCambio();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':

			$fechavigencia = $_POST["txtFechaVigencia"];

			$monto = $_POST["txtMontoTC"];

			if(empty($_POST["txtIdTasaCambio"])){

				if($objTasaCambio->Registrar($fechavigencia,$monto)){

					echo "Tasa de Cambio registrada correctamente";

				}else{

					echo "La Tasa de Cambio no ha podido ser registrada.";

				}

			}else{

				$idtasacambio = $_POST["txtIdTasaCambio"];

				if($objTasaCambio->Modificar($idtasacambio,$fechavigencia,$monto)){

					echo "La informacion de la Tasa de Cambio ha sido actualizada";

				}else{

					echo "La informacion de la Tasa de Cambio no ha podido ser actualizada.";

				}

			}

			break;



		case "delete":



			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objTasaCambio->Eliminar($id);

			if ($result) {

				echo "Eliminada Exitosamente";

			} else {

				echo "No fue Eliminada";

			}

			break;



		case "list":

			$query_Tipo = $objTasaCambio->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>substr($reg->fechavigencia,0,4),

                    "2"=>$reg->fechavigencia,

                    "3"=>$reg->monto,

                    "4"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataTasaCambio('.$reg->idtasacambio.',\''.$reg->fechavigencia.'\','.$reg->monto.')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarTasaCambio('.$reg->idtasacambio.')"><i class="fa fa-trash"></i> </button>');

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

