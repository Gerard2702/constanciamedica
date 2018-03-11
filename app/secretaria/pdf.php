<?php

// Include the main TCPDF library (search for installation path).
require_once('../../assets/plugins/tcpdf/examples/tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->Image('../../assets/pdf/img/logoseguro.jpg',30, 5, 25, 25);
        $this->SetFont('arialblack', 'B', 12);
        // Título
        $this->Cell(30);
        $this->MultiCell(0,5,"INSTITUTO SALVADOREÑO",0,'L');
        $this->Cell(30);
        $this->MultiCell(0,5,"DEL SEGURO SOCIAL",0,'L');
        $this->Cell(30);
        $this->MultiCell(0,5,"HOSPITAL GENERAL",0,'L');
        $this->SetFontSize(10);
        $this->Cell(30);
        $this->MultiCell(0,4,"Alameda Juan Pablo II y 25 Av. Norte",0,'L');
        $this->Cell(30);
        $this->MultiCell(0,4,"San Salvador, El Salvador C. A. Tel 25914178",0,'L');
    }

    // Page footer
    public function Footer() {
        // Position at 20 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->Image('../../assets/pdf/img/footer.png',null, null, 170, 1);
        $this->SetFont('arialblack','B',12);
        $this->MultiCell(0,5,'"Con una visión más humana al servicio integral de su salud"',0,"C");
        $this->SetFont('arialnarrow','',12);
        $this->MultiCell(0,5,'"Alameda Juan Pablo II y 25  Avenida Norte Tel.  2591 4240"',0,"C");
        $this->SetFont('arialnarrowb','',10);
        $this->MultiCell(0,5,"email@isss.gob.sv",0,"C");
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$pdf->SetFont("trebuchet", 'B', 12);


// add a page
$pdf->AddPage();
$pdf->Ln(20);
// set color for background
$pdf->SetFillColor(255, 255, 255);
$pdf->setCellHeightRatio(1.5);

// set some text to print
$txt = 'El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:


Paciente xxxx NOMBRE DE PACIENTE CON LETRA MAYUSCULA xxxx, con número de afiliación xxxxxxx, consultó el día xx de     xxxx de 201x en el Servicio de xxxxxx de este Centro Hospitalario, con diagnóstico xxxxxxxxxxx; permaneciendo ingresada/o, hasta el día xx de xxxx de 201x, fecha de alta con diagnóstico xxxxxxxxxxxxxxxx.-----------------


A solicitud de Sr. / Sra. Xxxx NOMBRE DE SOLICITANTE CON LETRA MAYUSCULA xxxx (xxxx parentesco con el solicitante hijo / hija / esposa de paciente / paciente xxxx), y para ser presentada en xxx LETRA MAYUSCULA xxx, se extiende la presente constancia en la ciudad de San Salvador, el día xx de xxxx de dos mil diecissiete.
';

// print a block of text using Write()

$pdf->MultiCell(0, 5,$txt, 0, 'J');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('pdf.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+