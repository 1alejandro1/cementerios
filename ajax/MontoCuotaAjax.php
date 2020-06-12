<?php



	session_start();



	require_once "../model/MontoCuota.php";



	$objMontoCuotaMtto = new MontoCuotaMtto();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':

			$fechavigencia = $_POST["txtFechaVigencia"];

			$monto = $_POST["txtMonto"];

			if(empty($_POST["txtIdCuotaMtto"])){

				if($objMontoCuotaMtto->Registrar($fechavigencia,$monto)){

					echo "Cuota de Mantenimiento registrada correctamente";

				}else{

					echo "La Cuota de Mantenimiento no ha podido ser registrado.";

				}

			}else{

				$idcuotamtto = $_POST["txtIdCuotaMtto"];

				if($objMontoCuotaMtto->Modificar($idcuotamtto,$fechavigencia,$monto)){

					echo "La informacion de la Cuota de Mantenimiento ha sido actualizada";

				}else{

					echo "La informacion de la Cuota de Mantenimiento no ha podido ser actualizada.";

				}

			}

			break;



		case "delete":



			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objMontoCuotaMtto->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objMontoCuotaMtto->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>substr($reg->fechavigencia,0,4),

                    "2"=>$reg->fechavigencia,

                    "3"=>$reg->monto,

                    "4"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataMontoCuotaMtto('.$reg->idcuotamtto.',\''.$reg->fechavigencia.'\','.$reg->monto.')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarMontoCuotaMtto('.$reg->idcuotamtto.')"><i class="fa fa-trash"></i> </button>');

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

