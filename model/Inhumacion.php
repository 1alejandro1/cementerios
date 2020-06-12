<?php

	require "Conexion.php";
	require "FPdfCertificadoObito.php";
	require "Usuario.php";

	class Inhumacion {

		public function __construct(){

		}

		public function Registrar($idcontrato,$iddifunto,$fechafallecimiento,$fechainhumacion,$idpersonal,$observaciones , $codigo){

			global $conexion;

            $fecharegistro   = new DateTime();
            $fecharegistro = date_format($fecharegistro,"Y/m/d");

			$sql = "INSERT INTO inhumacion (idcontrato,iddifunto,fechafallecimiento,fechainhumacion,idpersonal,observaciones,fecharegistro, codigo)

						VALUES($idcontrato,$iddifunto,'$fechafallecimiento','$fechainhumacion',$idpersonal,'$observaciones','$fecharegistro', '$codigo')";

			$query = $conexion->query($sql);

			return $query;

		}



		public function Modificar($idinhumacion,$idcontrato,$iddifunto,$fechafallecimiento,$fechainhumacion,$idpersonal,$observaciones, $codigo){

			global $conexion;

			$sql = "UPDATE inhumacion set idcontrato=$idcontrato, iddifunto=$iddifunto, fechafallecimiento='$fechafallecimiento', fechainhumacion='$fechainhumacion', idpersonal=$idpersonal, observaciones='$observaciones', codigo = '$codigo' 
						WHERE idinhumacion = $idinhumacion";

			$query = $conexion->query($sql);

			return $query;

		}


		public function Eliminar($idinhumacion){

			global $conexion;

			$sql = "DELETE FROM inhumacion WHERE idinhumacion = $idinhumacion";

			$query = $conexion->query($sql);

			return $query;

		}

		public function CertificadoObito($idinhumacion){

			global $conexion;

			$sql = "SELECT * FROM inhumacion WHERE idinhumacion = $idinhumacion";

			$query = $conexion->query($sql);

			return $query;

		}

		public function CrearCertificadoObito($idinhumacion) {

			global $conexion;

			$sql = "select i.*, c.nrocontrato, c.fechacontrato, d.nombre as difunto, concat(d.tipodocumento,' ',d.numdocumento) as documento, CONCAT(p.nombre,' ',p.apellidos) as personal, m.razonsocial as cementerio, s.nombre as sector, l.numero as lote, l.fila, l.columna, t.nombre as tipolote 
				from inhumacion i left join difunto d on i.iddifunto = d.iddifunto 
					 left join personal p on i.idpersonal = p.idpersonal 
					 left join contrato c on i.idcontrato = c.idcontrato 
					 left join cementerio m on c.idcementerio = m.idcementerio 
					 left join sector s on c.idsector = s.idsector 
					 left join lote l on c.idlote = l.idlote  
					 left join tipolote t ON l.idtipolote = t.idtipolote
			   where idinhumacion = $idinhumacion";

			$query = $conexion->query($sql);

     		while ($reg = $query->fetch_object()) {
				$sql2 = "select concat(r.nombre,' ',r.apellidos) as responsable 
					from responsable r left join difunto d on r.iddifunto = d.iddifunto 
				   where r.iddifunto = $reg->iddifunto";

				$query2 = $conexion->query($sql2);
	     		while ($reg2 = $query2->fetch_object()) {
					$sql3 = "select concat(p.nombre,' ',p.apellidos) as usuario 
						from usuario u left join personal p on u.idpersonal = p.idpersonal 
					   where u.idusuario = " . $_SESSION["idusuario"];

					$query3 = $conexion->query($sql3);
		     		while ($reg3 = $query3->fetch_object()) {
		     			$titulo = utf8_decode('Certificado de Óbito');
						$pdf = new PDFCO('P','mm','LETTER');
						$pdf->AliasNbPages();
						$pdf->AddPage();
						$pdf->SetFont('Arial','B',24);
						$pdf->Cell(0,15,$titulo,'TB',0,'C');
						$pdf->Ln(20);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,10,'DATOS PERSONALES',0,1);
						$pdf->SetFont('Arial','',14);
						$pdf->Ln(3);
						$pdf->Cell(110,5,utf8_decode('Nombre Completo: ' . $reg->difunto),0,0);
						$pdf->Cell(110,5,utf8_decode('Carnet de Identidad: ' . $reg->documento),0,0,'L');
						$pdf->Ln(17);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,17,utf8_decode('UBICACIÓN DE LOTE'),'T',1);
						$pdf->SetFont('Arial','',14);
						$pdf->Cell(0,10,utf8_decode('Sector: ' . $reg->sector),0,1);
						$pdf->Cell(55,10,utf8_decode('Tipo: ' . $reg->tipolote),0,0);
						$pdf->Cell(55,10,utf8_decode('Número: ' . $reg->lote),0,0,'C');
						$pdf->Cell(55,10,utf8_decode('Fila: ' . $reg->fila),0,0,'C');
						$pdf->Cell(55,10,utf8_decode('Columna: ' . $reg->columna),0,0,'L');
						$pdf->Ln(15);

						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(0,18,utf8_decode('DATOS DE INHUMACIÓN'),'T',1);
						$pdf->SetFont('Arial','',14);
						$pdf->Cell(0,10,utf8_decode('Responsable(s): ' . $reg2->responsable),0,1);
						$pdf->Cell(0,10,utf8_decode('Personal: ' . $reg->personal),0,1);
						$fechafallecimiento = date_create($reg->fechafallecimiento);
						$fechainhumacion = date_create($reg->fechainhumacion);
						$pdf->Cell(110,10,utf8_decode('Fecha de Fallecimiento: ' . date_format($fechafallecimiento,"d/m/Y")),0,0);
						$pdf->Cell(110,10,utf8_decode('Fecha de Inhumación: ' . date_format($fechainhumacion,"d/m/Y")),0,1,'L');
						$pdf->Cell(0,10,utf8_decode('Observaciones: ' . $reg->observaciones),0,0);
						$pdf->Ln(30);
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
//						$pdf->Output('../Files/Pdf/Certificado de Obito. Contrato ' . trim($reg->nrocontrato) . '.pdf','F');
//						$pdf->Output('../Files/Pdf/Certificado de Obito. Contrato ' . trim($reg->nrocontrato) . '.pdf','F');
						$pdf->Output('../Files/Pdf/Certificado de Obito. Contrato ' . trim($reg->nrocontrato) . '.pdf','F');

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
	     		}
			};

			return ;
		}


		public function Listar() {

			global $conexion;

			$sql = "SELECT * FROM inhumacion order by idinhumacion desc";

			$query = $conexion->query($sql);

			return $query;

		}

		public function ListarInhumaciones() {

			global $conexion;

			$sql = "select i.*, c.nrocontrato, i.codigo, c.fechacontrato, d.nombre as difunto, CONCAT(p.nombre,' ',p.apellidos) as personal, m.razonsocial as cementerio, s.nombre as sector, l.numero as lote, l.fila, l.columna  
				from inhumacion i left join difunto d on i.iddifunto = d.iddifunto 
					 left join personal p on i.idpersonal = p.idpersonal 
					 left join contrato c on i.idcontrato = c.idcontrato 
					 left join cementerio m on c.idcementerio = m.idcementerio 
					 left join sector s on c.idsector = s.idsector 
					 left join lote l on c.idlote = l.idlote  
				order by i.idinhumacion desc";
/*
					 left join cementerio m on c.idcementerio = m.idcementerio 
					 left join sector s on c.idsector = s.idsector 
					 left join lote l on c.idlote = l.idlote  
*/
			$query = $conexion->query($sql);

			return $query;

		}

	}

