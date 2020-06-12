<?php

require_once('../fpdf17/fpdf.php');
require "Conexion.php";

class PDFCO extends FPDF
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
            $this->SetFont('Arial','B',13);
            $this->Cell(85);
            $this->Cell(30,7,utf8_decode($regglobal->linea1),0,1,'C');
            $this->Cell(85);
            $this->Cell(30,7,utf8_decode($regglobal->linea2),0,0,'C');
            // Salto de línea
            $this->Ln(20);
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

}
?>
