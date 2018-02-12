<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logoseguro.jpg';
        $this->Image($image_file, 26, 8, 25, 25, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('times', 'B', 12);
        // Title        
        $txt = <<<EOD
        INSTITUTO SALVADOREÑO
                                          DEL SEGURO SOCIAL
                                          HOSPITAL GENERAL
                                          Alameda Juan Pablo II y 25 Av. Norte
                                          San Salvador, El Salvador C.A. Tel 25914178
EOD;
        $this->Write(5, $txt, '', 0, 'L', true, 0, false, false, 0);
    }

    // Page footer
    public function Footer() {
        // Position at 20 mm from bottom
        $this->SetY(-25);
        // Set font
        $this->SetFont('times', 'B', 12);
        $image_files = K_PATH_IMAGES.'imagenfooter.jpg';
        $this->Image($image_files, 20,'', 0, 0, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $txt2 = <<<EOD
        “Con una visión más humana al servicio integral de su salud”
EOD;
        $this->Cell(0,0,'',0,1,'C',0,'',0);
        $this->Cell(0,0,$txt2,0,1,'C',0,'',0);

        $this->SetFont('times', '', 12);

        $txt3 = <<<EOD
        Alameda Juan Pablo II y 25  Avenida Norte Tel.  2591 4240
EOD;

        $this->Cell(0,0,$txt3,0,1,'C',0,'',0);

        $this->SetFont('times','BU',12);

        $txt4 = <<<EOD
email@isss.gob.sv
EOD;

        $this->Cell(0,0,$txt4,0,1,'C',0,'',0);
        $this->Ln(4);
    }
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DarkXav');
$pdf->SetTitle('Constancia Fallecido');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 14);

// add a page
$pdf->AddPage();

$paciente = "FRANCISCO JAVIER CARBALLO MENA";
$afiliacion = "891 50 0127";
$dia = '04';
$mes = "Enero";
$anio = '8';
$servicio = "Departamento de Emergencia ";
$diagnostico = "Bronconeumonía más Diabetes Mellitus Insulinodependiente con Complicaciones Renales";
$dia2 = "2";
$mes2 = "Febrero";
$anio2 = "8";
$diagnostico2 = "Bronconeumonía";
$solicitante = "Jose Perez";
$parentesco = "hijo";
$presentadoen = "ASESUISA";
$diafecha = "25";
$mesfecha = "Febrero";
$aniofecha = "dos mil dieciocho";
// set some text to print
$txt = <<<EOD




El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:

Paciente $paciente, con número de afiliación $afiliacion, consultó el día $dia de $mes de 201$anio en el Servicio de $servicio de este Centro Hospitalario, con diagnóstico ]$diagnostico; permaneciendo ingresada/o, hasta el día $dia2 de $mes2 de 201$anio2, fecha de fallecimiento por diagnóstico $diagnostico2-----------------------------------------------

A solicitud de Sr. / Sra. $solicitante ($parentesco), y para ser presentada en $presentadoen, se extiende la presente constancia en la ciudad de San Salvador, el día $diafecha de $mesfecha de $aniofecha.



Dr.  xxxxxxxxxxxxxxxxxxxx                           Dr. xxxxxxxxxxxxxxxxxxxxxxxx
         Médico tratante                                                Jefe de Servicio

                                                            
 


Licda. Rina Villeda de Loucel                          Dr. Manuel de Jesús Villalobos Parada
      Jefe de Trabajo Social                                            Director Hospital General 


EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'T', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Constancia_Fallecido.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+