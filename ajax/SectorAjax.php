<?php



	session_start();



	require_once "../model/Sector.php";



	$objSector = new Sector();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':

			$idcementerio = $_POST["cboCementerio"];

			$nombre = $_POST["txtNombre"];

			$observaciones = $_POST["txtObservaciones"];

			$precioni = $_POST["txtPrecioNI"];

			$precionf = $_POST["txtPrecioNF"];
/*
			echo $idcementerio . '<br>';
			echo $nombre . '<br>';
			echo $observacion . '<br>';
			echo $precioni . '<br>';
			echo $precionf . '<br>';
			return;
*/

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



		case "delete":



			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objSector->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objSector->Listar();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->nombre,

                    "2"=>$reg->precioni,

                    "3"=>$reg->precionf,

                    "4"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataSector('.$reg->idsector.','.$reg->idcementerio.',\''.$reg->nombre.'\',\''.$reg->observaciones.'\','.$reg->precioni.','.$reg->precionf.')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarSector('.$reg->idsector.')"><i class="fa fa-trash"></i> </button>');

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

	        $query = $objCementerio->ListarCementerio();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idcementerio . '>' . $reg->razonsocial . '</option>';

	        }



	        break;



	}

