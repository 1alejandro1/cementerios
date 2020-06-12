<?php


	session_start();


	require_once "../model/Contrato.php";



	$objContrato = new Contrato();



	switch ($_GET["op"]) {



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

                    "7"=>'<button class="btn btn-primary" data-toggle="tooltip" title="Ver Reporte de Kardex" onclick="verKardex('. $reg->idcontrato . ',' . $reg->nrocontrato  .')"><i class="fa fa-print"></i> </button>');

                $i++;

            }

            $results = array(

            "sEcho" => 1,

        	"iTotalRecords" => count($data),

        	"iTotalDisplayRecords" => count($data),

            "aaData"=>$data);

			echo json_encode($results);



			break;

		case "creaReporteKardex":

			$idcontrato = $_POST["idcontrato"];
//			$idcontrato = 10;

			$query_Tipo = $objContrato->CrearKardex($idcontrato);

			break;

	}

