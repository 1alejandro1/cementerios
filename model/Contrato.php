<?php

	require "Conexion.php";
	require "FPdfPlandePagos.php";
	require "FPdfKardex.php";

	class Contrato {

		public function __construct(){

		}

		public function Registrar($nrocontrato,$idlote,$idsector,$idcementerio,$observaciones,$idadquiriente,$idejecutivoventa,$fechacontrato){

			global $conexion;

			$sql = "INSERT INTO contrato (nrocontrato,idlote,idsector,idcementerio,observaciones,idadquiriente,idejecutivoventa,fechacontrato,plandepago)

						VALUES($nrocontrato,$idlote,$idsector,$idcementerio,'$observaciones',$idadquiriente,$idejecutivoventa,'$fechacontrato','N')";

			$query = $conexion->query($sql);

			return $query;

		}


		public function RegistrarPlandePagos($idcontrato,$plazomeses,$cuotamensual,$fechapago){

			global $conexion;

			$sql = "DELETE FROM cuota WHERE idcontrato = $idcontrato AND tipocuota='C'";

			$query = $conexion->query($sql);

			$nrocuota = 1;
			$fechacuota = new DateTime("$fechapago");

			while ($nrocuota <= $plazomeses) {

	            $fechalimite = date_format($fechacuota,"Y/m/d");
				$sql = "INSERT INTO cuota (idcontrato,nrocuota,fechalimite,monto,estado,tipocuota)

							VALUES ($idcontrato,$nrocuota,'$fechalimite',$cuotamensual,'P','C')";

				$query = $conexion->query($sql);
				$fechacuota->add(new DateInterval('P1M'));
				$nrocuota = $nrocuota + 1;
			}

			$sql2 = "UPDATE contrato SET plandepago='N' 
						WHERE idcontrato = $idcontrato";

			$query2 = $conexion->query($sql2);

			return 1;

		}


		public function Modificar($idcontrato,$observaciones,$idadquiriente,$idejecutivoventa,$fechacontrato){

			global $conexion;

			$sql = "UPDATE contrato SET observaciones='$observaciones', idadquiriente=$idadquiriente, idejecutivoventa=$idejecutivoventa, fechacontrato='$fechacontrato'  
						WHERE idcontrato = $idcontrato";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ActualizarLote($idlote,$idestadolote){

			global $conexion;

			$sql = "UPDATE lote set idestadolote=$idestadolote  
						WHERE idlote = $idlote";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ModificarPrecios($idcontrato,$tipoprecio,$precio,$cuotainicial,$plazomeses,$cuotamensual,$incrementoplazo,$fechapago) {

			global $conexion;

			$sql = "UPDATE contrato set tipoprecio='$tipoprecio', precio=$precio, cuotainicial=$cuotainicial, plazomeses=$plazomeses, cuotamensual=$cuotamensual, incrementoplazo=$incrementoplazo, fechapago='$fechapago'  
						WHERE idcontrato = $idcontrato";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Eliminar($idcontrato){

			global $conexion;

			$sql = "DELETE FROM contrato WHERE idcontrato = $idcontrato";

			$query = $conexion->query($sql);

			return $query;

		}

		public function Listar() {

			global $conexion;

			$sql = "SELECT * FROM contrato order by idcontrato desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarContratos() {

			global $conexion;

			$sql = "select c.*, CONCAT(a.nombre,' ',a.apellidos) as adquiriente, CONCAT(a.tipodocumento,' ',a.numdocumento) as documento, CONCAT(e.nombre,' ',e.apellidos) as ejecutivoventa, m.razonsocial, s.nombre as sector, l.numero as nrolote, l.fila as fila, l.columna as columna from contrato c left join adquiriente a on c.idadquiriente = a.idadquiriente left join ejecutivoventa e on c.idejecutivoventa = e.idejecutivoventa left join cementerio m on c.idcementerio = m.idcementerio left join sector s on c.idsector = s.idsector left join lote l on c.idlote = l.idlote order by c.idcontrato desc ";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarPlandePagos($idcontrato) {

			global $conexion;

			$sql = "select * from cuota where idcontrato = $idcontrato order by nrocuota";

			$query = $conexion->query($sql);

			return $query;

		}

		public function CrearPlandePagos($idcontrato) {

			global $conexion;

			$sqldatocontrato = "select * 
								from vcontrato c 
								where idcontrato = $idcontrato";

			$querydatocontrato = $conexion->query($sqldatocontrato);

     		while ($reg = $querydatocontrato->fetch_object()) {
		     			$titulo = utf8_decode('PLAN DE PAGOS');
		     			$titulo2 = utf8_decode('(Expresado en dólares)');
						$pdf = new PDFPP('P','mm','LETTER');
						$pdf->AliasNbPages();
						$pdf->AddPage();

						$pdf->SetFont('Arial','',12);
				        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
				        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro

						$pdf->Cell(35,7,utf8_decode('CEMENTERIO: '),'T',0);
						$pdf->Cell(70,7,utf8_decode(strtoupper($reg->cementerio)),'T',0,'L',true);

						$pdf->Cell(35,7,utf8_decode('SECTOR: '),'T',0);
						$pdf->Cell(0,7,utf8_decode(strtoupper($reg->sector)),'T',1,'L',true);

						$pdf->Cell(35,7,utf8_decode('REF. LOTE: '),'B',0);
						$pdf->Cell(40,7,utf8_decode(strtoupper($reg->numlote)),'B',0,'L',true);

						$pdf->Cell(30,7,utf8_decode('FILA: '),'B',0);
						$pdf->Cell(35,7,utf8_decode(strtoupper($reg->fila)),'B',0,'L',true);

						$pdf->Cell(35,7,utf8_decode('COLUMNA: '),'B',0);
						$pdf->Cell(0,7,utf8_decode(strtoupper($reg->columna)),'B',1,'L',true);


						$pdf->Cell(80,7,utf8_decode('ADQUIRIENTE TITULAR: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->nomadquiriente . ' ' . $reg->apeadquiriente),'T',1,'L',true);


						$pdf->Cell(80,7,utf8_decode('CONTRATO Nº: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->nrocontrato),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('PRECIO US$: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->precio),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('INCREMENTO PLAZO: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->incrementoplazo),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('PLAZO EN MESES: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->plazomeses),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('CUOTA INICIAL: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->cuotainicial),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('FECHA CONTRATO: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->fechacontrato),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('TIPO CAMBIO Bs. /US$: '),0,0);
						$pdf->Cell(0,7,utf8_decode('VALOR DEL DOLAR CONTRA EL BOLIVIANO'),0,1,'L',true);

						$pdf->Cell(80,7,utf8_decode('FECHA DE PAGO: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->fechapago),0,1,'L',true);

					$sql3 = "select *  
						from cuota 
					   where idcontrato = $reg->idcontrato";

					$query3 = $conexion->query($sql3);

					//Títulos que llevará la cabecera
					$miCabecera = array(
									array('encabezado1'=>'CUOTA Nª', 'encabezado2'=>'FECHA LÍMITE DE PAGO', 'encabezado3'=>'MONTO A PAGAR EN USD', 'encabezado4'=>'SALDO DEUDOR EN USD', 'len1' => 25, 'len2' => 50, 'len3' => 60, 'len4' => 60)
								);
					 
					//Métodos llamados con el objeto $pdf
					$x = 115;
					$pdf->cabeceraHorizontal($miCabecera,$x);
					$x = 122;
					$bandera = false;
					$saldo = ($reg->precio + $reg->incrementoplazo - $reg->cuotainicial);
	     			$misDatos = array(array('nrocuota' => 'Inicial','fechalimite' => '', 'monto' => '', 'saldo' => $saldo, 'len1' => 25, 'len2' => 50, 'len3' => 60, 'len4' => 60) );
					$pdf->datosHorizontal($misDatos,$x,$bandera);
					$x = 122 + 7;

		     		while ($reg3 = $query3->fetch_object()) {
		     			$saldo = $saldo - $reg3->monto;
		     			$misDatos = array(array('nrocuota' => $reg3->nrocuota,'fechalimite' => $reg3->fechalimite, 'monto' => $reg3->monto, 'saldo' => $saldo, 'len1' => 25, 'len2' => 50, 'len3' => 60, 'len4' => 60) );
						$pdf->datosHorizontal($misDatos,$x,$bandera);
						$x = $x + 7;
						$bandera = !$bandera;
						if ($x>250) {
							$pdf->AddPage();
							$x = 40;
							$pdf->cabeceraHorizontal($miCabecera,$x);
							$x = 47;
						}

		     		}

					//enviamos cabezales http para no tener problemas
					header("Content-Transfer-Encoding", "binary");
					header('Cache-Control: maxage=3600'); 
					header('Pragma: public');
					//			$pdf->Output('recibos.pdf','D');
					///$pdf->Output();
					$nombrearchivo = '../Files/Pdf/Plan de Pagos. Contrato Nro. ' . $reg->nrocontrato . '.pdf';
					$pdf->Output($nombrearchivo,'F');

					$sql2 = "UPDATE contrato SET plandepago='S' 
								WHERE idcontrato = $idcontrato";

					$query2 = $conexion->query($sql2);
			};

			return;
		}

		public function ListarContratosInhumados() {

			global $conexion;

			$sql = "select c.*, CONCAT(a.nombre,' ',a.apellidos) as adquiriente, CONCAT(e.nombre,' ',e.apellidos) as ejecutivoventa, m.razonsocial, s.nombre as sector, l.numero as numlote, l.fila as fila, l.columna as columna,d.nombre as difunto,i.fechafallecimiento, i.fechainhumacion 
				from contrato c left join adquiriente a on c.idadquiriente = a.idadquiriente 
					 left join ejecutivoventa e on c.idejecutivoventa = e.idejecutivoventa 
					 left join cementerio m on c.idcementerio = m.idcementerio 
					 left join sector s on c.idsector = s.idsector 
					 left join lote l on c.idlote = l.idlote  
					 left join inhumacion i on c.idcontrato = i.idcontrato 
					 left join difunto d on i.iddifunto=d.iddifunto 
				where d.nombre <> '' 
				order by c.idcontrato desc";

			$query = $conexion->query($sql);

			return $query;

		}


		public function CrearKardex($idcontrato) {

			global $conexion;

			$sqldatocontrato = "select * 
								from contrato c 
								where idcontrato = $idcontrato";

			$querydatocontrato = $conexion->query($sqldatocontrato);

     		while ($reg = $querydatocontrato->fetch_object()) {
		     			$titulo = utf8_decode('KARDEX');
		     			$titulo2 = utf8_decode('(Expresado en dólares)');
						$pdf = new PDFKardex('P','mm','LETTER');
						$pdf->AliasNbPages();
						$pdf->AddPage();

						$pdf->SetFont('Arial','',10);
				        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
				        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro

						$pdf->Cell(38,7,utf8_decode('ADQUIRIENTE: '),'T',0);
						$pdf->Cell(91,7,utf8_decode(utf8_decode($reg->nomadquiriente . ' ' . $reg->apeadquiriente)),'T',0,'L',true);

						$pdf->Cell(35,7,utf8_decode('CONTRATO Nº: '),'T',0);
						$pdf->Cell(0,7,utf8_decode($reg->nrocontrato),'T',1,'L',true);

						$pdf->Cell(38,7,utf8_decode('PRECIO US$: '),0,0);
						$pdf->Cell(26,7,utf8_decode($reg->precio),0,0,'L',true);

						$pdf->Cell(43,7,utf8_decode('PLAZO EN MESES: '),0,0);
						$pdf->Cell(22,7,utf8_decode($reg->plazomeses),0,0,'L',true);

						$pdf->Cell(35,7,utf8_decode('CUOTA INICIAL: '),0,0);
						$pdf->Cell(0,7,utf8_decode($reg->cuotainicial),0,1,'L',true);

						$pdf->Cell(38,7,utf8_decode('FECHA CONTRATO: '),'B',0);
						$pdf->Cell(26,7,utf8_decode($reg->fechacontrato),'B',0,'L',true);

						$pdf->Cell(43,7,utf8_decode('INCREMENTO PLAZO: '),'B',0);
						$pdf->Cell(22,7,utf8_decode($reg->incrementoplazo),'B',0,'L',true);

						$pdf->Cell(35,7,utf8_decode('FECHA DE PAGO: '),'B',0);
						$pdf->Cell(0,7,utf8_decode($reg->fechapago),'B',1,'L',true);

					$sql3 = "SELECT cobranza.idcobranza, cobranza.idcontrato, cobranza.fechacobranza, cobranza.nrorecibo, cobranzadetalle.nrocuota, cobranzadetalle.monto, cobranza.concepto, cobranza.tipopago, cobranza.observaciones, cobranza.nombre
					           FROM cobranza
					           INNER JOIN cobranzadetalle ON cobranza.idcobranza = cobranzadetalle.idcobranza 
					           WHERE cobranza.idcontrato = $idcontrato;";

					$query3 = $conexion->query($sql3);

					//Títulos que llevará la cabecera
					$miCabecera = array(
									array('encabezado1'=>'', 'encabezado2'=>'NRO', 'encabezado3'=>'NRO', 'encabezado4'=>'TOTAL', 'encabezado5'=>'OBJETO DEL', 'encabezado6'=>'SALDO','encabezado7'=>'TIPO DE', 'encabezado8'=>'', 'encabezado21'=>'FECHA', 'encabezado22'=>'RECIBO', 'encabezado23'=>'CUOTA', 'encabezado24'=>'PAGO', 'encabezado25'=>'PAGO', 'encabezado26'=>'USD','encabezado27'=>'PAGO', 'encabezado28'=>'OBSERVACIONES', 'len1' => 20, 'len2' => 20, 'len3' => 15, 'len4' => 20, 'len5' => 30,'len6' => 20, 'len7' => 23, 'len8' => 43)
								);
					 
					//Métodos llamados con el objeto $pdf
					$x = 59;
					$pdf->cabeceraHorizontal($miCabecera,$x);

					$x = 73;
					$bandera = false;
					$totalpagado = 0;

					$saldo = ($reg->precio + $reg->incrementoplazo - $reg->cuotainicial);

		     		while ($reg3 = $query3->fetch_object()) {
		     			$saldo = $saldo - $reg3->monto;
		     			$totalpagado = $totalpagado + $reg3->monto;
		     			$misDatos = array(array('fechacobranza' => $reg3->fechacobranza,'nrorecibo' => $reg3->nrorecibo, 'nrocuota' => $reg3->nrocuota, 'monto' => $reg3->monto, 'concepto' => $reg3->concepto, 'saldo' => number_format($saldo,2), 'tipopago' => $reg3->tipopago, 'observacion' => $reg3->observaciones, 'len1' => 20, 'len2' => 20, 'len3' => 15, 'len4' => 20, 'len5' => 30, 'len6' => 20,'len7' => 23, 'len8' => 43) );
						$pdf->datosHorizontal($misDatos,$x,$bandera);
						$x = $x + 7;
						$bandera = !$bandera;
						if ($x>250) {
							$pdf->AddPage();
							$x = 40;
							$pdf->cabeceraHorizontal($miCabecera,$x);
							$x = 53;
						}

		     		}

	     			$misDatos = array(array('totalpagado' => $totalpagado,'saldo' => $saldo) );
					$pdf->datosTotales($misDatos,$x);

					//enviamos cabezales http para no tener problemas
					header("Content-Transfer-Encoding", "binary");
					header('Cache-Control: maxage=3600'); 
					header('Pragma: public');
					//			$pdf->Output('recibos.pdf','D');
					///$pdf->Output();
					$nombrearchivo = '../Files/Pdf/Kardex. Contrato Nro. ' . $reg->nrocontrato . '.pdf';
					$pdf->Output($nombrearchivo,'F');
			};

			return;
		}


		public function ListarContratosCompletos() {

			global $conexion;

			$sql = "select c.*, CONCAT(a.nombre,' ',a.apellidos) as adquiriente, CONCAT(e.nombre,' ',e.apellidos) as ejecutivoventa, m.razonsocial, s.nombre as sector, l.numero as numlote, l.fila as fila, l.columna as columna,d.nombre as difunto,i.fechafallecimiento, i.fechainhumacion 
				from contrato c left join adquiriente a on c.idadquiriente = a.idadquiriente 
					 left join ejecutivoventa e on c.idejecutivoventa = e.idejecutivoventa 
					 left join cementerio m on c.idcementerio = m.idcementerio 
					 left join sector s on c.idsector = s.idsector 
					 left join lote l on c.idlote = l.idlote  
					 left join inhumacion i on c.idcontrato = i.idcontrato 
					 left join difunto d on i.iddifunto=d.iddifunto 
				where c.precio > 0  
				order by c.idcontrato desc";

			$query = $conexion->query($sql);

			return $query;

		}
	}

