<?php
require('../plugins/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logoseguro.jpg',30, 8, 25, 25);
        // Arial bold 15
        $this->SetFont('Arial','B',12);
        // Movernos a la derecha
        $this->Cell(30);
        // Título
        $this->MultiCell(0,5,"INSTITUTO SALVADOREÑO");
        $this->Cell(30);
        $this->MultiCell(0,5,"DEL SEGURO SOCIAL");
        $this->Cell(30);
        $this->MultiCell(0,5,"HOSPITAL GENERAL");
        $this->SetFontSize(10);
        $this->Cell(30);
        $this->MultiCell(0,4,"Alameda Juan Pablo II y 25 Av. Norte");
        $this->Cell(30);
        $this->MultiCell(0,4,"San Salvador, El Salvador C. A. Tel 25914178");
        // Salto de línea
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 2 cm del final
        $this->SetY(-20);
        $this->Image('img/footer.png',null, null, 150, 1);
        $this->SetFont('Arial','B',12);
        // Número de página
        $this->MultiCell(0,5,'"Con una visión más humana al servicio integral de su salud"',0,"C");
        $this->SetFont('Arial','',11);
        $this->MultiCell(0,5,'"Alameda Juan Pablo II y 25  Avenida Norte Tel.  2591 4240"',0,"C");
        $this->SetFont('Arial','BU',10);
        $this->MultiCell(0,5,"email@isss.gob.sv",0,"C");
    }
}

// Creación del objeto de la clase heredada

$paciente = "FRANCISCO JAVIER CARBALLO MENA";
$afiliacion = "891 50 0127";
$dia = '04';
$mes = "Enero";
$anio = '8';
$servicio = "Departamento de Emergencia ";
$diagnostico = "Bronconeumonía más Diabetes Mellitus Insulinodependiente con Complicaciones Renales";
$diagnostico2 = "Bronconeumonía";
$solicitante = "Jose Perez";
$parentesco = "hijo";
$presentadoen = "ASESUISA";
$diafecha = "25";
$mesfecha = "Febrero";
$aniofecha = "dos mil dieciocho";
$texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $paciente, con número de afiliación $afiliacion, consultó el día $dia de $mes de 201$anio en el Servicio de $servicio de este Centro Hospitalario, con diagnóstico $diagnostico; Permanece ingresada /o a la fecha con diagnóstico $diagnostico2.\n\nA solicitud de Sr. / Sra. $solicitante ($parentesco), y para ser presentada en $presentadoen, se extiende la presente constancia en la ciudad de San Salvador, el día $diafecha de $mesfecha de $aniofecha.";


$pdf = new PDF();
$pdf->SetMargins(30,10,30);
$pdf->AddPage();
$pdf->AddFont('trebuc');
$pdf->SetFont('trebuc','',12);
$pdf->MultiCell(0,5,$texto,0,'J');
$pdf->Output();
?>
