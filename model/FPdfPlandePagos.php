<?php

require_once('../fpdf17/fpdf.php');
require "Conexion.php";

class PDFPP extends FPDF
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
            $this->Cell(30,7,utf8_decode($regglobal->linea3),0,1,'C');
            $this->SetFont('Arial','B',14);
            $this->Cell(85);
            $this->Cell(30,7,utf8_decode($regglobal->linea4),0,0,'C');
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
        $this->SetFont('Arial','B',10);
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
        }
    }
    
    function datosHorizontal($datos,$x,$bandera)
    {
        $this->SetXY(10,$x); // 77 = 70 posiciónY_anterior + 7 altura de las de cabecera
        $this->SetFont('Arial','',10); //Fuente, normal, tamaño
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        foreach($datos as $fila)
        {
            //Atención!! el parámetro valor 0, hace que sea horizontal
            if ($fila['nrocuota']=='Inicial') {
                $this->Cell($fila['len1'],7, '',1, 0 , 'C', $bandera );
                $this->Cell($fila['len2'],7, '',1, 0 , 'C', $bandera );
                $this->Cell($fila['len3'],7, 'Inicial',1, 0 , 'C', $bandera );
                $this->Cell($fila['len4'],7, utf8_decode($fila['saldo']),1, 0 , 'C', $bandera );
            } else {
                $this->Cell($fila['len1'],7, utf8_decode($fila['nrocuota']),1, 0 , 'C', $bandera );
                $this->Cell($fila['len2'],7, utf8_decode($fila['fechalimite']),1, 0 , 'C', $bandera );
                $this->Cell($fila['len3'],7, utf8_decode($fila['monto']),1, 0 , 'C', $bandera );
                $this->Cell($fila['len4'],7, utf8_decode($fila['saldo']),1, 0 , 'C', $bandera );
            }
        }
//        $this->Ln();
    }
}
?>
