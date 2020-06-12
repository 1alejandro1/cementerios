<?php

	require "Conexion.php";
	require "FPdfCertificadoExhumacion.php";
	require "Usuario.php";

	class Exhumacion {

		public function __construct(){

		}

		public function Registrar($idcontrato,$fechaexhumacion,$idpersonal,$tipo,$observaciones){

			global $conexion;

            $fecharegistro   = new DateTime();
            $fecharegistro = date_format($fecharegistro,"Y/m/d");

			$sql = "INSERT INTO exhumacion (idcontrato,fechaexhumacion,idpersonal,tipo,observaciones,fecharegistro)

						VALUES($idcontrato,'$fechaexhumacion',$idpersonal,'$tipo','$observaciones','$fecharegistro')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idexhumacion,$idcontrato,$fechaexhumacion,$idpersonal,$tipo,$observaciones){

			global $conexion;

			$sql = "UPDATE exhumacion set idcontrato=$idcontrato, fechaexhumacion='$fechaexhumacion', idpersonal=$idpersonal, tipo='$tipo', observaciones='$observaciones' 
						WHERE idexhumacion = $idexhumacion";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idexhumacion){

			global $conexion;

			$sql = "DELETE FROM exhumacion WHERE idexhumacion = $idexhumacion";

			$query = $conexion->query($sql);

			return $query;

		}

		public function CertificadoExhumacion($idexhumacion){

			global $conexion;

			$sql = "SELECT * FROM exhumacion WHERE idexhumacion = $idexhumacion";

			$query = $conexion->query($sql);

			return $query;

		}

		public function CrearCertificadoExhumacion($idexhumacion) {

			global $conexion;

			$sql = "select e.*, c.nrocontrato, c.fechacontrato, i.difunto, concat(i.tddifunto,' ',i.nddifunto) as documento, i.fechafallecimiento, i.fechainhumacion, CONCAT(i.nompersonal,' ',i.apepersonal) as personal, c.cementerio, c.sector, c.numlote as lote, c.fila, c.columna, c.tipolote 
				from vexhumacion e left join vcontrato c on e.idcontrato= c.idcontrato 
					 left join vinhumacion i on c.idcontrato = i.idcontrato 
			   where idexhumacion = $idexhumacion";

			$query = $conexion->query($sql);

     		while ($reg = $query->fetch_object()) {
					$sql3 = "select concat(p.nombre,' ',p.apellidos) as usuario 
						from usuario u left join personal p on u.idpersonal = p.idpersonal 
					   where u.idusuario = " . $_SESSION["idusuario"];

					$query3 = $conexion->query($sql3);
		     		while ($reg3 = $query3->fetch_object()) {
		     			$titulo = utf8_decode('Certificado de Exhumación');
						$pdf = new PDFCE('P','mm','LETTER');
						$pdf->AliasNbPages();
						$pdf->AddPage();
						$pdf->SetFont('Arial','B',24);
						$pdf->Cell(0,15,$titulo,'TB',0,'C');
						$pdf->Ln(20);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,10,'DATOS PERSONALES',0,1);
						$pdf->SetFont('Arial','',12);
						$pdf->Ln(3);
						$pdf->Cell(100,10,utf8_decode('Nombre Completo: ' . $reg->difunto),0,0);
						$pdf->Cell(90,10,utf8_decode('Carnet de Identidad: ' . $reg->documento),0,1,'R');
						$pdf->Ln(13);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,17,utf8_decode('UBICACIÓN DE LOTE'),'T',1);
						$pdf->SetFont('Arial','',12);
						$pdf->Cell(0,10,utf8_decode('Sector: ' . $reg->sector),0,1);
						$pdf->Cell(55,10,utf8_decode('Tipo: ' . $reg->tipolote),0,0);
						$pdf->Cell(55,10,utf8_decode('Número: ' . $reg->lote),0,0,'C');
						$pdf->Cell(55,10,utf8_decode('Fila: ' . $reg->fila),0,0,'C');
						$pdf->Cell(55,10,utf8_decode('Columna: ' . $reg->columna),0,0,'L');
						$pdf->Ln(11);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,18,utf8_decode('DATOS DE INHUMACIÓN'),'T',1);
						$pdf->SetFont('Arial','',12);
						$pdf->Cell(0,10,utf8_decode('Personal: ' . $reg->personal),0,1);
						$fechafallecimiento = date_create($reg->fechafallecimiento);
						$fechainhumacion = date_create($reg->fechainhumacion);
						$pdf->Cell(90,10,utf8_decode('Fecha de Fallecimiento: ' . date_format($fechafallecimiento,"d/m/Y")),0,0);
						$pdf->Cell(100,10,utf8_decode('Fecha de Inhumación: ' . date_format($fechainhumacion,"d/m/Y")),0,1,'R');
						$pdf->Cell(0,10,utf8_decode('Observaciones: ' . $reg->observaciones),0,0);
						$pdf->Ln(11);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,18,utf8_decode('DATOS DE EXHUMACIÓN'),'T',1);
						$pdf->SetFont('Arial','',12);
						$pdf->Cell(100,10,utf8_decode('Personal: ' . $reg->nompersonal . ' ' . $reg->apepersonal),0,0);
						$fechaexhumacion = date_create($reg->fechaexhumacion);
						$pdf->Cell(90,10,utf8_decode('Fecha de Exhumación: ' . date_format($fechaexhumacion,"d/m/Y")),0,1,'R');
						$pdf->Cell(0,10,utf8_decode('Observaciones: ' . $reg->observaciones),0,0);
						$pdf->Ln(20);
						$pdf->Cell(110,10,'Fecha: ' . date('d/m/Y'),0,0);
						$pdf->Cell(110,10,utf8_decode($reg3->usuario),0,1,'C');
						$pdf->Cell(110,10,' ',0,0);
						$pdf->Cell(110,10,'USUARIO',0,1,'C');
						//enviamos cabezales http para no tener problemas
						header("Content-Transfer-Encoding", "binary");
						header('Cache-Control: maxage=3600'); 
						header('Pragma: public');
						//			$pdf->Output('recibos.pdf','D');
						///$pdf->Output();
						$pdf->Output('../Files/Pdf/Certificado de Exhumacion. Contrato ' . trim($reg->nrocontrato) . '.pdf','F');
					}
			};

			return;
		}


		public function Listar() {

			global $conexion;

			$sql = "SELECT * FROM exhumacion order by idexhumacion desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarExhumaciones() {

			global $conexion;

			$sql = "select e.*, c.nrocontrato, c.fechacontrato, i.difunto, concat(i.tddifunto,' ',i.nddifunto) as documento, i.fechafallecimiento, i.fechainhumacion, CONCAT(i.nompersonal,' ',i.apepersonal) as personal, c.cementerio, c.sector, c.numlote as lote, c.fila, c.columna, c.tipolote 
				from exhumacion e left join vcontrato c on e.idcontrato= c.idcontrato 
					 left join vinhumacion i on c.idcontrato = i.idcontrato 
				order by e.idexhumacion desc";
			$query = $conexion->query($sql);

			return $query;

		}

	}

