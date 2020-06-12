<?php

require_once('../fpdf17/fpdf.php');
require "Conexion.php";

class PDFKardex extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $conexion;

        $sqlglobal = "select * from global";

        $queryglobal = $conexion->query($sqlglobal);
        while ($regglobal = $queryglobal->fetch_object()) {
            // Logo
//            $this->Image('../Files/Global/descarga.jpg',10,8,33);
            $this->Image('../' . $regglobal->logo,10,8,33);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Movernos a la derecha
            $this->Cell(85);
            // Título
            $this->Cell(30,7,utf8_decode(strtoupper($regglobal->empresa)),0,1,'C');
            $this->SetFont('Arial','B',18);
            $this->Cell(85);
            $this->Cell(30,7,utf8_decode($regglobal->linea5),0,1,'C');
            $this->SetFont('Arial','B',14);
            
            $this->Cell(85);
            $this->Cell(30,7,utf8_decode($regglobal->linea6),0,0,'C');
            // Salto de línea
            $this->Ln(10);
        }
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }

    function cabeceraVertical($cabecera)
    {
        $this->SetXY(10, 10); //Seleccionamos posición
        $this->SetFont('Arial','B',10); //Fuente, Negrita, tamaño
 
        foreach($cabecera as $columna)
        {
            //Parámetro con valor 2, cabecera vertical
            $this->Cell(30,7, utf8_decode($columna),1, 2 , 'L' );
        }
    }
 
    function datosVerticales($datos)
    {
        $this->SetXY(40, 10); //40 = 10 posiciónX_anterior + 30ancho Celdas de cabecera
        $this->SetFont('Arial','',10); //Fuente, Normal, tamaño
        foreach($datos as $columna)
        {
            $this->Cell(30,7, utf8_decode($columna),1, 2 , 'L' );
        }
    }

    function cabeceraHorizontal($cabecera,$x)
    {
        $this->SetXY(10, $x);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        foreach($cabecera as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
//            $this->Cell(24,7, utf8_decode($fila),1, 0 , 'L' );
            $this->Cell($fila['len1'],7, utf8_decode($fila['encabezado1']),1, 0 , 'C', true );
            $this->Cell($fila['len2'],7, utf8_decode($fila['encabezado2']),1, 0 , 'C', true );
            $this->Cell($fila['len3'],7, utf8_decode($fila['encabezado3']),1, 0 , 'C', true );
            $this->Cell($fila['len4'],7, utf8_decode($fila['encabezado4']),1, 0 , 'C', true );
            $this->Cell($fila['len5'],7, utf8_decode($fila['encabezado5']),1, 0 , 'C', true );
            $this->Cell($fila['len6'],7, utf8_decode($fila['encabezado6']),1, 0 , 'C', true );
            $this->Cell($fila['len7'],7, utf8_decode($fila['encabezado7']),1, 0 , 'C', true );
            $this->Cell($fila['len8'],7, utf8_decode($fila['encabezado8']),1, 1 , 'C', true );

            $this->Cell($fila['len1'],7, utf8_decode($fila['encabezado21']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len2'],7, utf8_decode($fila['encabezado22']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len3'],7, utf8_decode($fila['encabezado23']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len4'],7, utf8_decode($fila['encabezado24']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len5'],7, utf8_decode($fila['encabezado25']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len6'],7, utf8_decode($fila['encabezado26']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len7'],7, utf8_decode($fila['encabezado27']),'LRB', 0 , 'C', true );
            $this->Cell($fila['len8'],7, utf8_decode($fila['encabezado28']),'LRB', 0 , 'C', true );
        }
    }
    
    function datosHorizontal($datos,$x,$bandera)
    {
        $this->SetXY(10,$x); // 77 = 70 posiciónY_anterior + 7 altura de las de cabecera
        $this->SetFont('Arial','',8); //Fuente, normal, tamaño
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        foreach($datos as $fila)
        {
            if (strlen(trim($fila['concepto']))>13) {
                $concepto = substr(trim($fila['concepto']),0,12) . '...';
            } else {
                $concepto = trim($fila['concepto']);
            }
            if (strlen(trim($fila['observacion']))>30) {
                $observacion = substr(trim($fila['observacion']),0,29) . '...';
            } else {
                $observacion = trim($fila['observacion']);
            }
            if ($fila['tipopago']=="E") {
                $tipopago = 'EFECTIVO';
            }else{
                if ($fila['tipopago']=="B") {
                    $tipopago = 'BANCO';
                }else{
                    if ($fila['tipopago']=="C") {
                        $tipopago = 'CHEQUE';
                    }
                }  
            }

            $this->Cell($fila['len1'],7, utf8_decode($fila['fechacobranza']),1, 0 , 'C', $bandera );
            $this->Cell($fila['len2'],7, utf8_decode($fila['nrorecibo']),1, 0 , 'C', $bandera );
            $this->Cell($fila['len3'],7, utf8_decode($fila['nrocuota']),1, 0 , 'C', $bandera );
            $this->Cell($fila['len4'],7, utf8_decode($fila['monto']),1, 0 , 'C', $bandera );
            $this->Cell($fila['len5'],7, utf8_decode(strtoupper($concepto)),1, 0 , 'C', $bandera );
            $this->Cell($fila['len6'],7, utf8_decode($fila['saldo']),1, 0 , 'C', $bandera );
            $this->Cell($fila['len7'],7, utf8_decode(strtoupper($tipopago)),1, 0 , 'C', $bandera );
            $this->Cell($fila['len8'],7, utf8_decode(strtoupper($observacion)),1, 0 , 'C', $bandera );
        }
//        $this->Ln();
    }

    function datosTotales($datos,$x)
    {
        $this->SetFont('Arial','',8); 
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        foreach($datos as $fila)
        {
/*
            $this->SetXY(65,$x+10); 
            $this->Cell(60,10, 'TOTAL PAGADO US$: ',1, 0 , 'C', false );
            $this->Cell(30,10, number_format($fila['totalpagado'],2),1, 1 , 'C', false );
            $this->SetXY(65,$x+20); 
            $this->Cell(60,10, 'TOTAL SALDO PENDIENTE US$: ',1, 0 , 'C', true );
            $this->Cell(30,10, number_format($fila['saldo'],2),1, 1 , 'C', true );
*/

            $this->SetXY(10,$x+5); 
            $this->Cell(60,10, 'TOTAL PAGADO US$: ',1, 0 , 'C', false );
            $this->Cell(30,10, number_format($fila['totalpagado'],2),1, 0 , 'C', false );
            $this->SetXY(115,$x+5); 
            $this->Cell(60,10, 'TOTAL SALDO PENDIENTE US$: ',1, 0 , 'C', true );
            $this->Cell(30,10, number_format($fila['saldo'],2),1, 1 , 'C', true );
        }
//        $this->Ln();
    }
}
?>
