<?php

	require "Conexion.php";
	require "FPdfReciboPago.php";
	require "Usuario.php";

	class Cobranza {

		public function __construct(){

		}

		public function Registrar($idcontrato,$fechacobranza){

			global $conexion;

            $fecharegistro   = new DateTime();
            $fecharegistro = date_format($fecharegistro,"Y/m/d");

			$sql = "INSERT INTO cobranza (idcontrato,fechacobranza,fecharegistro)

						VALUES($idcontrato,'$fechacobranza','$fecharegistro')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idcobranza,$idcontrato,$fechacobranza){

			global $conexion;

			$sql = "UPDATE cobranza set idcontrato=$idcontrato, fechacobranza='$fechacobranza' 
						WHERE idcobranza = $idcobranza";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idcobranza){

			global $conexion;

			$sql = "DELETE FROM cobranza WHERE idcobranza = $idcobranza";

			$query = $conexion->query($sql);

			$get_id_cobranza ="select  * from cobranzadetalle where idcobranza = $idcobranza";
			$consulta=  $conexion->query($get_id_cobranza);

			return $consulta;

		}

		public function EliminarCobranza($idcobranza, $idcuota){

			global $conexion;

			$sql = "UPDATE cuota SET estado='P' WHERE idcuota = $idcuota";

			$query = $conexion->query($sql);

			$sql = "DELETE FROM cobranzadetalle WHERE idcobranza = $idcobranza and idcuota = $idcuota";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Listar() {

			global $conexion;

			$sql = "SELECT * FROM cobranza order by idcobranza desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ObtenerTasaCambio() {

			global $conexion;

			$sql = "SELECT monto FROM tasacambio order by fechavigencia desc limit 1";

			$query = $conexion->query($sql);

			$tasacambio = 0;

     		while ($reg = $query->fetch_object()) {
     			$tasacambio = $reg->monto;
     		}

			return $tasacambio;

		}

		public function ListarCobranzas() {

			global $conexion;

			$sql = "select cob.*, c.nrocontrato, c.fechacontrato, concat(c.nomadquiriente,' ',c.apeadquiriente) adquiriente, concat(c.tdadquiriente,' ',c.ndadquiriente) as documento, c.cementerio, c.sector, c.numlote as lote, c.fila, c.columna, c.tipolote 
				from cobranza cob left join vcontrato c on cob.idcontrato= c.idcontrato 
				order by cob.idcobranza desc";
			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarCuotasPendientes($idcontrato) {

			global $conexion;

			$sql = "select * from cuota where idcontrato = $idcontrato and (estado='P' or estado='V') order by nrocuota";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarCuotasPagadas($idcobranza,$idcontrato) {

			global $conexion;

			$sql = "select * from cobranzadetalle where idcobranza = $idcobranza and idcontrato = $idcontrato order by nrocuota";

			$query = $conexion->query($sql);

			return $query;

		}







public function valorEnLetras($x,$moneda) 
{ 
	if ($x<0) { 
		$signo = "menos ";
	} else { 
		$signo = "";
	} 
	$x = abs ($x); 
	$C1 = $x; 


	$G6 = floor($x/(1000000));  // 7 y mas 

	$E7 = floor($x/(100000)); 
	$G7 = $E7-$G6*10;   // 6 

	$E8 = floor($x/1000); 
	$G8 = $E8-$E7*100;   // 5 y 4 

	$E9 = floor($x/100); 
	$G9 = $E9-$E8*10;  //  3 

	$E10 = floor($x); 
	$G10 = $E10-$E9*100;  // 2 y 1 

	$G11 = round(($x-$E10)*100,0);  // Decimales 
	////////////////////// 

	$H6 = $this->unidades($G6); 


	if ($G7==1 AND $G8==0) { 
		$H7 = "Cien "; 
	} else { 
		$H7 = $this->decenas($G7); 
	} 

	$H8 = $this->unidades($G8); 

	if ($G9==1 AND $G10==0) { 
		$H9 = "Cien "; 
	} else {
		$H9 = $this->decenas($G9); 
	} 

	$H10 = $this->unidades($G10); 


	if ($G11 < 10) { 
		$H11 = "0".$G11; 
	} else { 
		$H11 = $G11; 
	} 


	///////////////////////////// 
	if($G6==0) { 
		$I6=" "; 
	} elseif ($G6==1) { 
			$I6="Millón "; 
		} else { 
			$I6="Millones "; 
		} 
	          
	if ($G8==0 AND $G7==0) { 
		$I8=" "; 
	} else { 
		$I8="Mil "; 
	} 
	          
	$I10 = $moneda; 
	$I11 = "/100 Centimos "; 
//	$I11 = "/100 M.N. "; 

	$C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10.$I10.' con '.$H11.$I11; 

	return $C3; //Retornar el resultado 
} 

public function unidades($u) 
{ 
    if ($u==0)  {$ru = " ";} 
elseif ($u==1)  {$ru = "Un ";} 
elseif ($u==2)  {$ru = "Dos ";} 
elseif ($u==3)  {$ru = "Tres ";} 
elseif ($u==4)  {$ru = "Cuatro ";} 
elseif ($u==5)  {$ru = "Cinco ";} 
elseif ($u==6)  {$ru = "Seis ";} 
elseif ($u==7)  {$ru = "Siete ";} 
elseif ($u==8)  {$ru = "Ocho ";} 
elseif ($u==9)  {$ru = "Nueve ";} 
elseif ($u==10) {$ru = "Diez ";} 

elseif ($u==11) {$ru = "Once ";} 
elseif ($u==12) {$ru = "Doce ";} 
elseif ($u==13) {$ru = "Trece ";} 
elseif ($u==14) {$ru = "Catorce ";} 
elseif ($u==15) {$ru = "Quince ";} 
elseif ($u==16) {$ru = "Dieciseis ";} 
elseif ($u==17) {$ru = "Decisiete ";} 
elseif ($u==18) {$ru = "Dieciocho ";} 
elseif ($u==19) {$ru = "Diecinueve ";} 
elseif ($u==20) {$ru = "Veinte ";} 

elseif ($u==21) {$ru = "Veintiun ";} 
elseif ($u==22) {$ru = "Veintidos ";} 
elseif ($u==23) {$ru = "Veintitres ";} 
elseif ($u==24) {$ru = "Veinticuatro ";} 
elseif ($u==25) {$ru = "Veinticinco ";} 
elseif ($u==26) {$ru = "Veintiseis ";} 
elseif ($u==27) {$ru = "Veintisiente ";} 
elseif ($u==28) {$ru = "Veintiocho ";} 
elseif ($u==29) {$ru = "Veintinueve ";} 
elseif ($u==30) {$ru = "Treinta ";} 

elseif ($u==31) {$ru = "Treinta y un ";} 
elseif ($u==32) {$ru = "Treinta y dos ";} 
elseif ($u==33) {$ru = "Treinta y tres ";} 
elseif ($u==34) {$ru = "Treinta y cuatro ";} 
elseif ($u==35) {$ru = "Treinta y cinco ";} 
elseif ($u==36) {$ru = "Treinta y seis ";} 
elseif ($u==37) {$ru = "Treinta y siete ";} 
elseif ($u==38) {$ru = "Treinta y ocho ";} 
elseif ($u==39) {$ru = "Treinta y nueve ";} 
elseif ($u==40) {$ru = "Cuarenta ";} 

elseif ($u==41) {$ru = "Cuarenta y un ";} 
elseif ($u==42) {$ru = "Cuarenta y dos ";} 
elseif ($u==43) {$ru = "Cuarenta y tres ";} 
elseif ($u==44) {$ru = "Cuarenta y cuatro ";} 
elseif ($u==45) {$ru = "Cuarenta y cinco ";} 
elseif ($u==46) {$ru = "Cuarenta y seis ";} 
elseif ($u==47) {$ru = "Cuarenta y siete ";} 
elseif ($u==48) {$ru = "Cuarenta y ocho ";} 
elseif ($u==49) {$ru = "Cuarenta y nueve ";} 
elseif ($u==50) {$ru = "Cincuenta ";} 

elseif ($u==51) {$ru = "Cincuenta y un ";} 
elseif ($u==52) {$ru = "Cincuenta y dos ";} 
elseif ($u==53) {$ru = "Cincuenta y tres ";} 
elseif ($u==54) {$ru = "Cincuenta y cuatro ";} 
elseif ($u==55) {$ru = "Cincuenta y cinco ";} 
elseif ($u==56) {$ru = "Cincuenta y seis ";} 
elseif ($u==57) {$ru = "Cincuenta y siete ";} 
elseif ($u==58) {$ru = "Cincuenta y ocho ";} 
elseif ($u==59) {$ru = "Cincuenta y nueve ";} 
elseif ($u==60) {$ru = "Sesenta ";} 

elseif ($u==61) {$ru = "Sesenta y un ";} 
elseif ($u==62) {$ru = "Sesenta y dos ";} 
elseif ($u==63) {$ru = "Sesenta y tres ";} 
elseif ($u==64) {$ru = "Sesenta y cuatro ";} 
elseif ($u==65) {$ru = "Sesenta y cinco ";} 
elseif ($u==66) {$ru = "Sesenta y seis ";} 
elseif ($u==67) {$ru = "Sesenta y siete ";} 
elseif ($u==68) {$ru = "Sesenta y ocho ";} 
elseif ($u==69) {$ru = "Sesenta y nueve ";} 
elseif ($u==70) {$ru = "Setenta ";} 

elseif ($u==71) {$ru = "Setenta y un ";} 
elseif ($u==72) {$ru = "Setenta y dos ";} 
elseif ($u==73) {$ru = "Setenta y tres ";} 
elseif ($u==74) {$ru = "Setenta y cuatro ";} 
elseif ($u==75) {$ru = "Setenta y cinco ";} 
elseif ($u==76) {$ru = "Setenta y seis ";} 
elseif ($u==77) {$ru = "Setenta y siete ";} 
elseif ($u==78) {$ru = "Setenta y ocho ";} 
elseif ($u==79) {$ru = "Setenta y nueve ";} 
elseif ($u==80) {$ru = "Ochenta ";} 

elseif ($u==81) {$ru = "Ochenta y un ";} 
elseif ($u==82) {$ru = "Ochenta y dos ";} 
elseif ($u==83) {$ru = "Ochenta y tres ";} 
elseif ($u==84) {$ru = "Ochenta y cuatro ";} 
elseif ($u==85) {$ru = "Ochenta y cinco ";} 
elseif ($u==86) {$ru = "Ochenta y seis ";} 
elseif ($u==87) {$ru = "Ochenta y siete ";} 
elseif ($u==88) {$ru = "Ochenta y ocho ";} 
elseif ($u==89) {$ru = "Ochenta y nueve ";} 
elseif ($u==90) {$ru = "Noventa ";} 

elseif ($u==91) {$ru = "Noventa y un ";} 
elseif ($u==92) {$ru = "Noventa y dos ";} 
elseif ($u==93) {$ru = "Noventa y tres ";} 
elseif ($u==94) {$ru = "Noventa y cuatro ";} 
elseif ($u==95) {$ru = "Noventa y cinco ";} 
elseif ($u==96) {$ru = "Noventa y seis ";} 
elseif ($u==97) {$ru = "Noventa y siete ";} 
elseif ($u==98) {$ru = "Noventa y ocho ";} 
else            {$ru = "Noventa y nueve ";} 
return $ru; //Retornar el resultado 
} 

public function decenas($d) 
{ 
    if ($d==0)  {$rd = "";} 
	elseif ($d==1)  {$rd = "Ciento ";} 
	elseif ($d==2)  {$rd = "Doscientos ";} 
	elseif ($d==3)  {$rd = "Trescientos ";} 
	elseif ($d==4)  {$rd = "Cuatrocientos ";} 
	elseif ($d==5)  {$rd = "Quinientos ";} 
	elseif ($d==6)  {$rd = "Seiscientos ";} 
	elseif ($d==7)  {$rd = "Setecientos ";} 
	elseif ($d==8)  {$rd = "Ochocientos ";} 
	else            {$rd = "Novecientos ";} 
	return $rd; //Retornar el resultado 
}



		public function CrearReciboPago($idcobranza) {

			global $conexion;
			global $fechacobranza;
			global $nrcobranza;


			$sqlcontrato = "select idcontrato from vcobranza where idcobranza = $idcobranza";

			$querycontrato = $conexion->query($sqlcontrato);

     		while ($regcontrato = $querycontrato->fetch_object()) {
     			$idcontrato = $regcontrato->idcontrato;
     		}

     		echo $idcontrato;

			$sqlsaldo = "select * from cuota where idcontrato = $idcontrato and estado<>'C'";

			$querysaldo = $conexion->query($sqlsaldo);
			$saldo = 0;

     		while ($regsaldo = $querysaldo->fetch_object()) {
     			$saldo = $saldo + $regsaldo->monto;
     		}


			$sql = "select * from vcobranza where idcobranza = $idcobranza";

			$query = $conexion->query($sql);

     		while ($reg = $query->fetch_object()) {
					$sql3 = "select concat(p.nombre,' ',p.apellidos) as usuario 
						from usuario u left join personal p on u.idpersonal = p.idpersonal 
					   where u.idusuario = " . $_SESSION["idusuario"];

					$query3 = $conexion->query($sql3);
		     		while ($reg3 = $query3->fetch_object()) {
		     			$fechacobranza = $reg->fechacobranza;
		     			$nrcobranza = $reg->nrcobranza;
		     			$titulo = utf8_decode('Recibo Oficial');
//						$pdf = new PDFRP('P','mm',array(240,180));
						$pdf = new PDFRP('P','mm','LETTER');
						$pdf->AliasNbPages();
						$pdf->AddPage();
						$pdf->SetFont('Arial','B',24);
						$pdf->Cell(0,15,$titulo,'TB',0,'C');
						$pdf->Ln(20);
						$nfila = 25;

						$pdf->SetFont('Arial','',14);
						$pdf->Cell(0,10,utf8_decode('Pago de ' . $reg->concobranza ),0,1,'C');
						$pdf->Ln(2);
						$pdf->Cell(20,10,utf8_decode('Hemos recibido de: '),0,0);
			            $pdf->Cell($nfila);
						$pdf->Cell(10,10,utf8_decode($reg->nomadquiriente . ' ' . $reg->apeadquiriente),0,1);

						$pdf->Cell(20,10,utf8_decode('La suma de:'),0,0);
			            $pdf->Cell($nfila);

						if ($reg->emiterecibo=='D') {
//							$pdf->Cell(0,10,utf8_decode('' . $reg->montocobranza ),0,1);
							$pdf->Cell(10,10,trim($this->valorEnLetras($reg->montocobranza,'Dolares')),0,1);
				            $pdf->Cell($nfila+20);
							$pdf->Cell(10,10,'(USD ' . $reg->montocobranza . ')' ,0,1,'L');
 						} else {
							$pdf->Cell(10,10,trim($this->valorEnLetras($reg->montobs,'Bolivianos')),0,1);
				            $pdf->Cell($nfila+20);
							$pdf->Cell(10,10,'(Bs. ' . $reg->montobs . ')',0,1,'L');
							$pdf->Cell(10,10,utf8_decode('Tasa de Cambio:'),0,0);
				            $pdf->Cell($nfila+10);
							$pdf->Cell(10,10,utf8_decode($reg->tasacambio . ' Bs./USD' ),0,1);
//							$pdf->Cell(0,10,utf8_decode('') . $this->valorEnLetras($reg->montobs,'Bolivianos') ,0,1);
						}
//						$pdf->Cell(0,10,utf8_decode('                   ' ),0,1);
						$pdf->Cell(20,10,utf8_decode('Tipo de Pago:'),0,0);
			            $pdf->Cell($nfila);
						$pdf->Cell(10,10,utf8_decode($reg->tpcobranza=='E' ? 'EFECTIVO' : ($reg->tpcobranza=='C' ? 'CHEQUE' : 'BANCO') ),0,0);
			            $pdf->Cell(80);
						$pdf->Cell(10,10,utf8_decode('Contrato Nro: ' . $reg->nrocontrato ),0,1);
						$pdf->Cell(20,10,utf8_decode('Monto Pendiente:'),0,0);
			            $pdf->Cell($nfila);
						$pdf->Cell(10,10,'USD ' . number_format($saldo, 2),0,1);
						$pdf->Cell(20,10,utf8_decode('Observaciones:'),0,0);
			            $pdf->Cell($nfila);
						$pdf->Cell(10,10,utf8_decode($reg->obscobranza ),0,1);
						$pdf->Ln(20);

						$pdf->Cell(110,10,'USUARIO',0,0,'C');
						$pdf->Cell(80,10,'CLIENTE ',0,1,'C');
						$pdf->Cell(110,10,utf8_decode($reg3->usuario),0,1,'C');
						//enviamos cabezales http para no tener problemas
						header("Content-Transfer-Encoding", "binary");
						header('Cache-Control: maxage=3600'); 
						header('Pragma: public');
						//			$pdf->Output('recibos.pdf','D');
						///$pdf->Output();
						$pdf->Output('../Files/Pdf/Recibo de Pago. Cobranza ' . trim($reg->idcobranza) . '.pdf','F');
/*						
						$enlace = '../Files/Pdf/Certificado de Obito.pdf'; 
						$tam = filesize($enlace);
						header("Content-type: application/pdf");
						header("Content-Length: $tam"); 
						header("Content-Disposition: inline; filename=proyecto.pdf");
						$file='./ficheros/proyecto.pdf';
						readfile($enlace);
*/
	     		}
			};

			return;
		}





		public function RegistrarCobranza($idcontrato, $nrorecibo, $tipopago, $incremento, $objetoincremento, $concepto, $observaciones, $nombre, $fechacobranza, $detalle, $monto, $tiporecibo, $emiterecibo, $montobs, $tasacambio){
			global $conexion;

			$sw = true;
//			$idcobranza = "89899";
            $fecharegistro   = new DateTime();
            $fecharegistro = date_format($fecharegistro,"Y/m/d");

			try {
// Obtener el número del recibo si es automático.

				if ($tiporecibo=='A') {
					$get_nrorecibo ="select txtrecibo,nrorecibo from global";
					$consultax=  $conexion->query($get_nrorecibo);

					while ($regx = $consultax->fetch_object()) {
						$txtrecibo = $regx->txtrecibo;
						$nrorecibo = $regx->nrorecibo + 1;
					}
					$nrorecibo2 = $txtrecibo . ' ' . str_pad($nrorecibo, 5, "0", STR_PAD_LEFT);

					$set_nrorecibo ="update global set nrorecibo=$nrorecibo";
					$consultax=  $conexion->query($set_nrorecibo);
				} else {
					$nrorecibo2 = $nrorecibo;
				}

// Registramos los productos en la tabla cobranza
				$sql = "INSERT INTO cobranza ( idcontrato, fechacobranza, fecharegistro, nrorecibo, tipopago, incremento, objetoincremento, concepto, observaciones, nombre, monto, tiporecibo, emiterecibo, montobs, tasacambio) 
						VALUES($idcontrato, '$fechacobranza', '$fecharegistro', '$nrorecibo2', '$tipopago', $incremento, '$objetoincremento', '$concepto', '$observaciones', '$nombre', $monto, '$tiporecibo', '$emiterecibo', $montobs, $tasacambio)";
				$conexion->query($sql);

// recuperamos el idcobranza de la tabla cobranza
				 $get_id_cobranza ="select  idcobranza  from cobranza where idcontrato = $idcontrato and  nrorecibo = '$nrorecibo2' ";
				$consulta=  $conexion->query($get_id_cobranza);

				while ($reg = $consulta->fetch_object()) {
						$idcobranza = $reg->idcobranza;
				}
// ahora agregamos lo que falta en la tabla venta despues de recuperar el idVenta
				$conexion->autocommit(true);
				foreach($detalle as $indice => $valor) {
					$sql_detalle = "INSERT INTO cobranzadetalle (idcontrato, idcobranza, idcuota, nrocuota, tipocuota, fechalimite, monto , estado)
											VALUES($idcontrato, $idcobranza, ".$valor[0].", '".$valor[1]."','".$valor[2]."','".$valor[3]."',".$valor[4].",'C')";
					$conexion->query($sql_detalle);

					$sqlcuota = "UPDATE cuota set estado = 'C' where idcuota = " . $valor[0];
					//var_dump($sql);
					$conexion->query($sqlcuota);
				}
/*
// actualizamos la tabla de idingreso de los productos
// [5] es igual  al sotk actual del producto  [3] cantidad  que estoy comprando entonces restamos y colocamos el nuevo stock
				foreach($detalle as $indice => $valor) {
					$sql_detalle = "UPDATE detalle_ingreso set stock_actual = ".$valor[5]." - ".$valor[3]." where iddetalle_ingreso = ".$valor[0]."";
					$conexion->query($sql_detalle) ;
				}
				// ahora por ultimo vamos a actualziar el valor  del ticket   +1 cada ves que compre
				$entero = intval($numero_TF);

				$cant_letra = strlen($entero);

				$parte_izquierda = substr($numero_TF, 0, -$cant_letra);

				$suma = $entero + 1;

				$numero = $parte_izquierda."".$suma;
				//Recuperamos el id  de ticket
				$get_id_ticket ="select  idtipo_documento  from tipo_documento where nombre = '$tipo_comprobante'";
				$consultax=  $conexion->query($get_id_ticket);

				while ($regx = $consultax->fetch_object()) {
					$iddo =		 $regx->idtipo_documento;
				}

				$sql_detalle_doc = "UPDATE detalle_documento_sucursal set ultimo_numero = '$numero' where idtipo_documento = '$iddo'";
				//var_dump($sql);
				$conexion->query($sql_detalle_doc);
				//or $sw = false;

*/
				if ($conexion != null) {
					$conexion->close();
				}

			} catch (Exception $e) {
				$conexion->rollback();
			}
			return $idcobranza;
		}








	}

