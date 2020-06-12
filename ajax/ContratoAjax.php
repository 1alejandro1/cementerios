<?php



	session_start();



	require_once "../model/Contrato.php";



	$objContrato = new Contrato();



	switch ($_GET["op"]) {


		case 'SaveOrUpdate':

			$idadquiriente = $_POST["txtIdAdquiriente"];

			$idejecutivoventa = $_POST["txtIdEjecutivoVenta"];

			$observaciones = $_POST["txtObservaciones"];

			$fechacontrato = $_POST["txtFechaContrato"];

			if (empty($_POST["txtIdContrato"])){

				$nrocontrato = $_POST["txtNroContrato"];

				$idsector = $_POST["cboSectorSelCto"];

				$idcementerio = $_POST["cboCementerioLot"];

				$idlote = $_POST["cboLoteSelCto"];

				if($objContrato->Registrar($nrocontrato,$idlote,$idsector,$idcementerio,$observaciones,$idadquiriente,$idejecutivoventa,$fechacontrato)) {

					if ($objContrato->ActualizarLote($idlote,5)) { // Marcar Lote como Ocupado

						echo "Contrato registrado correctamente";

					} else {

						echo "El Contrato no ha podido ser registrado. Error Actualizando Lote";
					}
				} else {

					echo "El Contrato no ha podido ser registrado.";

				}

			}else{

				$idcontrato = $_POST["txtIdContrato"];

				if($objContrato->Modificar($idcontrato,$observaciones,$idadquiriente,$idejecutivoventa,$fechacontrato)){

					echo "La informacion del Contrato ha sido actualizada";

				}else{

					echo "La informacion del Contrato no ha podido ser actualizada.";

				}

			}

			break;

		case 'SaveOrUpdatePrecios':

			$tipoprecio = $_POST["cboTipoPrecio"];

			$precio = $_POST["txtPrecio"];

			$cuotainicial = $_POST["txtCuotaInicial"];

			$plazomeses = $_POST["txtPlazoMeses"];

			$cuotamensual = $_POST["txtCuotaMensualh"];

			$incrementoplazo = $_POST["txtIncrementoPlazo"];

			$idcontrato = $_POST["txtIdContrato2"];

			$fechapago = $_POST["txtFechaPago"];

			if(empty($_POST["txtIdContrato2"])) {

				echo "Primero debe registrar los Datos Generales el Contrato ...";

			} else {

				if($objContrato->ModificarPrecios($idcontrato,$tipoprecio,$precio,$cuotainicial,$plazomeses,$cuotamensual,$incrementoplazo,$fechapago)){

					if ($objContrato->RegistrarPlandePagos($idcontrato,$plazomeses,$cuotamensual,$fechapago)) {

						echo "Contrato registrado correctamente";

					} else {

						echo "La informacion del Contrato no ha podido ser actualizada. Error al Registrar Plan de Pagos";

					}


				}else{

					echo "La informacion del Contrato no ha podido ser actualizada.";

				}

			}

			break;


		case "delete":


			$id = $_POST["id"];

			$idlote = $_POST["idlote"];

			$result = $objContrato->Eliminar($id);

			if ($result) {

				if ($objContrato->ActualizarLote($idlote,6)) { // Marcar Lote como Disponible

					echo "Eliminado Exitosamente";

				} else {

					echo "No fue Eliminado. Error Actualizando Lote";
				}

			} else {

				echo "No fue Eliminado";

			}

			break;



		case "list":

			$query_Tipo = $objContrato->ListarContratos();

            $data = Array();

            $i = 1;
            $verReporte = true;

     		while ($reg = $query_Tipo->fetch_object()) {

     			$data[] = array(

     				"0"=>$i,

                    "1"=>$reg->nrocontrato,

                    "2"=>$reg->razonsocial,

                    "3"=>$reg->sector,

                    "4"=>$reg->nrolote,

                    "5"=>$reg->adquiriente,

                    "6"=>$reg->ejecutivoventa,

                    "7"=>'<button class="btn btn-warning" data-toggle="tooltip" title="Editar" onclick="cargarDataContrato('.$reg->idcontrato.',\''.$reg->nrocontrato.'\','.$reg->idlote.','.$reg->idsector.','.$reg->idcementerio.',\''.$reg->observaciones.'\','.$reg->idadquiriente.',\''.$reg->adquiriente.'\','.$reg->idejecutivoventa.',\''.$reg->ejecutivoventa.'\',\''.$reg->fila.'\',\''.$reg->columna.'\',\''.$reg->tipoprecio.'\','.$reg->precio.','.$reg->cuotainicial.','.$reg->plazomeses.','.$reg->cuotamensual.','.$reg->incrementoplazo.',\''.$reg->fechacontrato.'\',\''.$reg->fechapago.'\')"><i class="fa fa-pencil"></i> </button>&nbsp;'.
     				'<button class="btn btn-danger" data-toggle="tooltip" title="Eliminar" onclick="eliminarContrato('.$reg->idcontrato.',' . $reg->idlote .')"><i class="fa fa-trash"></i> </button>&nbsp;' .
     				'<button class="btn btn-primary" data-toggle="tooltip" title=' . ($reg->plandepago=="S" ? '"Ver Plan de Pagos"': '"Debe generar Reporte Plan de Pagos"' ). ' ' . ($reg->plandepago=="S" ? '': 'disabled=""' ). ' onclick="consultarPlandePagos('. $reg->nrocontrato .')"><i class="fa fa-print"></i> </button>');

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);



			break;

		case "impPlandePagos":

			$idcontrato = $_POST["idcontrato"];
//			$idcontrato = 10;

			$query_Tipo = $objContrato->CrearPlandePagos($idcontrato);

			break;

		case "PlandePagos":

			$idcontrato = $_POST["idcontrato"];

			$result = $objContrato->CrearPlandePagos($idcontrato);
/*
			if ($result) {

				echo "Plan de Pagos Impreso Exitosamente";

			} else {

				echo "No se genero el Plan de Pagos";

			}
*/
			break;

		case "listPlandePagos":

			$idcontrato = $_POST["idcontrato"];
//			$idcontrato = 10;

			$query_Tipo = $objContrato->ListarPlandePagos($idcontrato);

            $data = Array();

	        $i = 1;
	        $saldo = 0;

	        while ($reg = $query_Tipo->fetch_object()) {

	        	$saldo = $saldo + $reg->monto;

	            echo '<tr>

		                <td><center>'. $reg->nrocuota .'</center></td>

		                <td><center>'. $reg->fechalimite .'</center></td>

		                <td><center>'. number_format ($reg->monto,2) .'</center></td>

		                <td><center>'. number_format ($saldo,2) .'</center></td>
	                   </tr>';
	            $i++;

	        }

			break;
		case "listCementerio":

	        require_once "../model/Cementerio.php";

	        $objCementerio = new Cementerio();

	        $query = $objCementerio->ListarCementerio();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idcementerio . '>' . $reg->razonsocial . '</option>';

	        }

	        break;

		case "listSector":

			$idsector = $_POST["idsector"];

			$habilitado = $_POST["habilitado"];

	        require_once "../model/Sector.php";

	        $objSector = new Sector();

	        $query = $objSector->ListarSectorconLotes($idsector, $habilitado);

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idsector . '>' . $reg->nombre . '</option>';

	        }

	        break;
		case "listLote":

			$idsector = $_POST["idsector"];

			$idlote = $_POST["idlote"];

			$habilitado = $_POST["habilitado"];

	        require_once ("../model/Lote.php");

	        $objLote = new Lote();

	        $query = $objLote->LotesxSector($idsector, $idlote, $habilitado);

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idlote . '>' . $reg->numero . '</option>';

	        }

	        break;
		case "listTodosLote":

	        require_once "../model/Lote.php";

	        $objLote = new Lote();

	        $query = $objLote->TodosLotesxSector();

	        while ($reg = $query->fetch_object()) {

	            echo '<option value=' . $reg->idlote . '>' . $reg->numero . '</option>';

	        }

	        break;
		case "listDetalleLote":

			$idlote = $_POST["idlote"];

			if ( is_null($idlote) or empty($idlote) or $idlote==0 ) {
				echo ' ';

			} else {

		        require_once "../model/Lote.php";

		        $objLote = new Lote();

		        $query = $objLote->DetalleLote($idlote);

		        while ($reg = $query->fetch_object()) {
		        	echo $reg->fila . '-' . $reg->columna;
		        }
	    	}

			break;
		case "listPrecioSector":

	        require_once "../model/Sector.php";

			$idsector = $_POST["idsector"];

	        $objSector = new Sector();

	        $query = $objSector->PrecioxSector($idsector);

	        while ($reg = $query->fetch_object()) {

	        	echo $reg->precioni . '-' . $reg->precionf;

	        }

			break;

	    case "listAdquiriente":

	    	require_once "../model/Adquiriente.php";

	        $objAdquiriente = new Adquiriente();

	        $query_Adquiriente = $objAdquiriente->ListarAdquirientes();

	        $i = 1;

	        while ($reg = $query_Adquiriente->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optAdquirienteBusqueda" data-nombre="'.$reg->nombre . ' ' . $reg->apellidos.'" id="'.$reg->idadquiriente.'" value="'.$reg->idadquiriente.'" /></td>

		                <td>'.$i.'</td>

		                <td>'. $reg->nombre . ' ' . $reg->apellidos .'</td>

		                <td>'.$reg->tipodocumento.'</td>

		                <td>'.$reg->numdocumento.'</td>

	                   </tr>';

	            $i++;
	        }



	        break;
	    case "listEjecutivoVenta":

	    	require_once "../model/EjecutivoVenta.php";

	        $objEjecutivoVenta = new EjecutivoVenta();

	        $query_EjecutivoVenta = $objEjecutivoVenta->ListarEjecutivosVentas();

	        $i = 1;

	        while ($reg = $query_EjecutivoVenta->fetch_object()) {

	            echo '<tr>

		                <td><input type="radio" name="optEjecutivoVentaBusqueda" data-nombre="'.$reg->nombre . ' ' . $reg->apellidos.'" id="'.$reg->idejecutivoventa.'" value="'.$reg->idejecutivoventa.'" /></td>

		                <td>'.$i.'</td>

		                <td>'. $reg->nombre . ' ' . $reg->apellidos .'</td>

		                <td>'.$reg->tipodocumento.'</td>

		                <td>'.$reg->numdocumento.'</td>

	                   </tr>';
	            $i++;

	        }



	        break;
	}

