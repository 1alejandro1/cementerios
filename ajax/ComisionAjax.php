<?php



	session_start();



	require_once "../model/Comision.php";



	$objComision = new Comision();



	switch ($_GET["op"]) {


		case 'SaveOrUpdate':

			$idcontrato = $_POST["txtIdContrato"];

			$fechacomision = $_POST["txtFechaComision"];

			$porcentaje = $_POST["txtPorcentaje"];

			$monto = $_POST["txtMonto"];

			$formadepago = $_POST["cboFormadePago"];

			$monto1racuota = $_POST["txtMonto1raCuota"];

			$fecha1racuota = $_POST["txtFecha1raCuota"];

			$monto2dacuota = $_POST["txtMonto2daCuota"];

			$fecha2dacuota = $_POST["txtFecha2daCuota"];

			$monto3racuota = $_POST["txtMonto3raCuota"];

			$fecha3racuota = $_POST["txtFecha3raCuota"];

			$monto4tacuota = $_POST["txtMonto4taCuota"];

			$fecha4tacuota = $_POST["txtFecha4taCuota"];

			$valormonto = strval($monto);

			if ($valormonto>0) {
			if(empty($_POST["txtIdComision"])){

				if($objComision->Registrar($idcontrato,$fechacomision,$porcentaje,$monto,$formadepago,$monto1racuota,$fecha1racuota,$monto2dacuota,$fecha2dacuota,$monto3racuota,$fecha3racuota,$monto4tacuota,$fecha4tacuota)){

					echo "Comisión registrada correctamente";

				}else{

					echo "La Comisión no ha podido ser registrada.";

				}

			}else{

				$idcomision = $_POST["txtIdComision"];

				if($objComision->Modificar($idcomision,$idcontrato,$fechacomision,$porcentaje,$monto,$formadepago,$monto1racuota,$fecha1racuota,$monto2dacuota,$fecha2dacuota,$monto3racuota,$fecha3racuota,$monto4tacuota,$fecha4tacuota)){

					echo "La informacion de la Comisión ha sido actualizada";

				}else{

					echo "La informacion de la Comisión no ha podido ser actualizada.";

				}

			}
			} else {

					echo "Debe indicar el Monto de la Comisión";
			}

			break;


		case "delete":

			$id = $_POST["id"];

			$result = $objComision->Eliminar($id);

			if ($result) {

				echo "Eliminado Exitosamente";

			} else {

				echo "No fue Eliminado";

			}

			break;

		case "list":

			$query_Tipo = $objComision->ListarComisiones();

            $data = Array();

            $i = 1;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->ejecutivoventa,

                    "2"=>$reg->nrocontrato,

                    "3"=>$reg->fechacomision,

                    "4"=>$objComision->FormadePago($reg->formadepago),

/*
                    "5"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataComision('.$reg->idcomision.','.$reg->idcontrato.',\''.$reg->fechacomision.'\',\''.$reg->nrocontrato.'\',\''.$reg->fechacontrato.'\',\''.$reg->ejecutivoventa.'\',\''.$reg->cementerio.'\',\''.$reg->sector.'\',\''.$reg->lote.'\',\''.$reg->fila.'\',\''.$reg->columna.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.
*/
                    "5"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataComision('.$reg->idcomision.','.$reg->idcontrato.',\''.$reg->fechacomision.'\',\''.$reg->nrocontrato.'\',\''.$reg->fechacontrato.'\',\''.$reg->ejecutivoventa.'\',\''.$reg->cementerio.'\',\''.$reg->sector.'\',\''.$reg->lote.'\',\''.$reg->fila.'\',\''.$reg->columna.'\','.$reg->precio.','.$reg->porcentaje.','.$reg->monto.',\''.$reg->formadepago.'\','.$reg->monto1racuota.',\''.$reg->fecha1racuota.'\','.$reg->monto2dacuota.',\''.$reg->fecha2dacuota.'\','.$reg->monto3racuota.',\''.$reg->fecha3racuota.'\','.$reg->monto4tacuota.',\''.$reg->fecha4tacuota.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.

     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarComision('.$reg->idcomision.')"><i class="fa fa-trash"></i> </button>&nbsp;');

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);


			break;

		case "listContrato":

	        require_once "../model/Contrato.php";

	        $objContrato = new Contrato();

	        $query = $objContrato->ListarContratosCompletos();

	        $i = 1;

	        while ($regContrato = $query->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optContratoBusqueda" data-nombre="' . $regContrato->nrocontrato . 
		                	'" data-cementerio="' . trim($regContrato->razonsocial) . 
		                	'" data-sector="' . trim($regContrato->sector) . 
		                	'" data-lote="' . trim($regContrato->numlote) . 
		                	'" data-fila="' . trim($regContrato->fila) . 
		                	'" data-columna="' . trim($regContrato->columna) . 
		                	'" data-precio="' . trim($regContrato->precio) . 
		                	'" data-ejecutivoventa="' . trim($regContrato->ejecutivoventa) . 
		                	'" data-fechacontrato="' . $regContrato->fechacontrato . '" id="cont'.$regContrato->idcontrato.'" value="'.$regContrato->idcontrato.'" /></td>

		                <td>'.$i.'</td>

		                <td>'. $regContrato->nrocontrato .'</td>

		                <td>'.$regContrato->ejecutivoventa.'</td>

	                   </tr>';

	            $i++;
	        }



	        break;

	}

