<?php



	session_start();



	require_once "../model/EstadoCivil.php";



	$objEstadoCivil = new EstadoCivil();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$nombre = $_POST["txtNombre"]; // Llamamos al input txtNombre


			if(empty($_POST["txtIdEstadoCivil"])){
				

				if($objEstadoCivil->Registrar($nombre)){

					echo "Estado Civil Registrado.";

				}else{

					echo "Estado Civil no ha podido ser registado.";

				}

			}else{

				

				$idEstadoCivil = $_POST["txtIdEstadoCivil"];

				if($objEstadoCivil->Modificar($idEstadoCivil, $nombre)){

					echo "Estado Civil actualizado.";

				}else{

					echo "Informacion del Estado Civil no ha podido ser actualizada.";

				}

			}

			break;



		case "delete":			

			

			$id = $_POST["id"];

			$result = $objEstadoCivil->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		

		case "list":

			$query_Tipo = $objEstadoCivil->Listar();

			$data = Array();

			$i = 1;

			while ($reg = $query_Tipo->fetch_object()) {

				$data[] = array(

					"id"=>$i,

					"1"=>$reg->nombre,

					"2"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataEstadoCivil('.$reg->idestadocivil.',\''.$reg->nombre.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

					'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarEstadoCivil('.$reg->idestadocivil.')"><i class="fa fa-trash"></i> </button>');

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

	