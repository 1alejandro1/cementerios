<?php



	session_start();


	require_once "../model/Mantenimiento.php";



	$objMantenimiento = new Mantenimiento();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':

			$idcementerio = $_POST["cboCementerio"];

			$nombre = $_POST["txtNombre"];

			$observaciones = $_POST["txtObservaciones"];

			$precioni = $_POST["txtPrecioNI"];

			$precionf = $_POST["txtPrecioNF"];

			if(empty($_POST["txtIdSector"])){

				if($objSector->Registrar($idcementerio,$nombre,$observaciones,$precioni,$precionf)){

					echo "Sector registrado correctamente";

				}else{

					echo "El Sector no ha podido ser registrado.";

				}

			}else{

				$idsector = $_POST["txtIdSector"];

				if($objSector->Modificar($idsector,$idcementerio,$nombre,$observaciones,$precioni,$precionf)){

					echo "La informacion del Sector ha sido actualizada";

				}else{

					echo "La informacion del Sector no ha podido ser actualizada.";

				}

			}

			break;



		case "list":

			$query_Tipo = $objMantenimiento->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->nrocontrato,

                    "2"=>$reg->nomadquiriente . ' ' . $reg->apeadquiriente,

                    "3"=>$reg->fechacontrato,

                    "4"=>substr($reg->fechaestimada,0,4),

                    "5"=>$reg->fechaestimada,

                    "6"=>$reg->cuotamtto);

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);



			break;

		case "update":

			$query_Tipo = $objMantenimiento->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->nrocontrato,

                    "2"=>$reg->nomadquiriente . ' ' . $reg->apeadquiriente,

                    "3"=>$reg->fechacontrato,

                    "4"=>$reg->fechaestimada,

                    "5"=>$reg->cuotamtto);
                $i++;

            }
	}

