<?php



	session_start();



	require_once "../model/CuotaMtto.php";



	$objCuotaMtto = new CuotaMtto();



	switch ($_GET["op"]) {

		case "delete":



			$id = $_POST["id"];

			$result = $objCuotaMtto->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objCuotaMtto->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->nrocontrato,

                    "2"=>$reg->adquiriente,

                    "3"=>$reg->fechacontrato,

                    "4"=>substr($reg->fechalimite,0,4),

                    "5"=>$reg->nrocuota,

                    "6"=>$reg->fechalimite,

                    "7"=>$reg->monto,

                    "8"=>'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarCuotaMtto('.$reg->idcuota.')"' . ($reg->estado<>"C" ? '': ' disabled=""') . '><i class="fa fa-trash"></i> </button>&nbsp;');

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);



			break;

		case "create":

			$query_Tipo = $objCuotaMtto->ListarContratos();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

				$valor = $objCuotaMtto->RegistrarCuotaMtto($reg->idcontrato,$reg->fechacontrato);

            }


			break;


	}

