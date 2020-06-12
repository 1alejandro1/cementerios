<?php



	session_start();



	require_once "../model/Configuracion.php";



	$objGlobal = new Configuracion();



	switch ($_GET["op"]) {



		case 'SaveOrUpdate':			



			$empresa = $_POST["txtEmpresa"]; // Llamamos al input txtNombre

			$imagen = $_FILES["imagenGlobal"]["tmp_name"];

			$ruta = $_FILES["imagenGlobal"]["name"];



			if(move_uploaded_file($imagen, "../Files/Global/".$ruta)){

				if(empty($_POST["txtIdGlobal"])){

					

					if($objGlobal->Registrar($empresa, "Files/Global/".$ruta)){

						echo "Configuración Global registrada, se utilizará esta configuración.";

					}else{

						echo "La configuración global no ha podido ser registada.";

					}

				}else{

					

					$idglobal = $_POST["txtIdGlobal"];

					if($objGlobal->Modificar($idglobal, $empresa, "Files/Global/".$ruta)){

						echo "La configuración Global ha sido actualizada";

					}else{

						echo "la Informacion de la configuración global no ha podido ser actualizada.";

					}

				}

			} else {

				$ruta_img = $_POST["txtRutaImgLogo"];

				if(empty($_POST["txtIdGlobal"])){

					

					if($objGlobal->Registrar($empresa, $ruta_img)){

						echo "Configuración Global registrada, se utilizará esta configuración.";

					}else{

						echo "La configuración global no ha podido ser registada.";

					}

				}else{

					

					$idglobal = $_POST["txtIdGlobal"];

					if($objGlobal->Modificar($idglobal, $empresa, $ruta_img)){

						echo "La configuración Global ha sido actualizada";

					}else{

						echo "la Informacion de la configuración global no ha podido ser actualizada.";

					}

				}

			}

			break;



		case "delete":			

			

			$id = $_POST["id"];// Llamamos a la variable id del js que mandamos por $.post (Categoria.js (Linea 62))

			$result = $objGlobal->Eliminar($id);

			if ($result) {

				echo "Configuración global eliminada Exitosamente";

			} else {

				echo "La configuración global no fue Eliminada";

			}

			break;

		

		case "list":

			$query_Tipo = $objGlobal->Listar();



            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array($i,

					$reg->empresa,

					'<img width=100px height=100px src="./'.$reg->logo.'" />',

					'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataGlobal('.$reg->idglobal.',\''.$reg->empresa.'\',\''.$reg->logo.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'

					);

				$i++;

			}

			echo json_encode($data);

            

			break;



	}

	