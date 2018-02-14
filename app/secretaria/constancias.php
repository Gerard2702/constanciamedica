<?php
require('../../assets/plugins/fpdf/fpdf.php');
include("../../config/database.php");
require('conversor.php');


class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../assets/pdf/img/logoseguro.jpg',30, 8, 25, 25);
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
        $this->Image('../../assets/pdf/img/footer.png',null, null, 150, 1);
        $this->SetFont('Arial','B',12);
        // Número de página
        $this->MultiCell(0,5,'"Con una visión más humana al servicio integral de su salud"',0,"C");
        $this->SetFont('Arial','',11);
        $this->MultiCell(0,5,'"Alameda Juan Pablo II y 25  Avenida Norte Tel.  2591 4240"',0,"C");
        $this->SetFont('Arial','BU',10);
        $this->MultiCell(0,5,"email@isss.gob.sv",0,"C");
    }
}


if((!isset($_GET['cal']) || $_GET['cal']=='' || $_GET['cal']==0) && (!isset($_GET['ti']) || $_GET['ti']=='' || $_GET['ti']==0)){
    $id_datosc = $_GET['cal'];
    $tipo = $_GET['ti'];

    switch ($tipo) {
        case "Alta":
            $sql1 = "SELECT dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio, dca.fecha_de_alta, dca.diagnostico FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_alta dca ON dc.id_datosc=dca.id_datosc WHERE dc.id_datosc=?";
            if($stmalta = $conn->prepare($sql1)){
                $stmalta -> bind_param('i',$id_datosc);
                $stmalta -> execute();
                $stmalta -> bind_result($destinoA,$fecha_consultaA,$diagnosticodcA,$nombre_solicitanteA,$parentescoA,$fecha_extensionA,$nombre_pacienteA,$afiliacion_duiA,$nombre_servicioA,$fecha_altaA,$diagnosticoaltaA);
                $stmalta -> fetch();
                $stmalta -> close();
            }

            $fec = explode("-",$fecha_consultaA);
            $mesconsulta = nombremes($fec[1]);
            $diaconsulta = $fec[2];
            $anioconsulta = substr($fec[0],3);
            $fec2 = explode("-",$fecha_altaA);
            $mesalta = nombremes($fec2[1]);
            $diaalta = $fec2[2];
            $anioalta = substr($fec2[0],3);
            $fec3 = explode("-",$fecha_extensionA);
            $mesext = nombremes($fec3[1]);
            $diaext = $fec3[2];
            $anioext = convertir($fec3[0]);
            $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente strtoupper($nombre_pacienteA), con número de afiliación $afiliacion_duiA, consultó el día $diaconsulta de  $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioA de este Centro Hospitalario, con diagnóstico $diagnosticodcA; permaneciendo ingresada/o, hasta el día $diaalta de $mesalta de 201$anioalta, fecha de alta con diagnóstico $diagnosticoaltaA.\n\n A solicitud de Sr. / Sra. $nombre_solicitanteA ($parentescoA), y para ser presentada en $destinoA, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).
                ";

            /*$pdf = new PDF();
            $pdf->SetMargins(30,10,30);
            $pdf->AddPage();
            $pdf->AddFont('trebuc');
            $pdf->SetFont('trebuc','',12);
            $pdf->MultiCell(0,5,$texto,0,'J');
            $pdf->Output();*/
            break;
        case "Ingreso":
            $sql2 = "SELECT dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio,  dci.diagnostico FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_ingreso dci ON dc.id_datosc=dci.id_datosc WHERE dc.id_datosc=?";
            if($stmaing = $conn->prepare($sql2)){
                $stmaing -> bind_param('i',$id_datosc);
                $stmaing -> execute();
                $stmaing -> bind_result($destinoI,$fecha_consultaI,$diagnosticoingresadoI,$nombre_solicitanteI,$parentescoI,$fecha_extensionI,$nombre_pacienteI,$afiliacion_duiI,$nombre_servicioI,$diagnosticoactualI);
                $stmaing -> fetch();
                $stmaing -> close();
            }
            $fec = explode("-",$fecha_consultaI);
            $mesconsulta = nombremes($fec[1]);
            $diaconsulta = $fec[2];
            $anioconsulta = substr($fec[0],3);
            $fec3 = explode("-",$fecha_extensionI);
            $mesext = nombremes($fec3[1]);
            $diaext = $fec3[2];
            $anioext = convertir($fec3[0]);
            $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteI, con número de afiliación $afiliacion_duiI, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioI de este Centro Hospitalario, con diagnóstico $diagnosticoingresadoI; Permanece ingresada /o a la fecha con diagnóstico $diagnosticoactualI.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteI ($parentescoI), y para ser presentada en $destinoI, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).";

            /*$pdf = new PDF();
            $pdf->SetMargins(30,10,30);
            $pdf->AddPage();
            $pdf->AddFont('trebuc');
            $pdf->SetFont('trebuc','',12);
            $pdf->MultiCell(0,5,$texto,0,'J');
            $pdf->Output();*/
            break;
        case "Fallecimiento":
            $sql3 = "SELECT dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio,  dcf.fecha_defuncion, dcf.diagnostico FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_fallecimiento dcf ON dc.id_datosc=dcf.id_datosc WHERE dc.id_datosc=?";
            if($stmfall = $conn->prepare($sql3)){
                $stmfall -> bind_param('i',$id_datosc);
                $stmfall -> execute();
                $stmfall -> bind_result($destinoF,$fecha_consultaF,$diagnosticodcF,$nombre_solicitanteF,$parentescoF,$fecha_extensionF,$nombre_pacienteF,$afiliacion_duiF,$nombre_servicioF,$fecha_defuncionF,$diagnostico_defuncionF);
                $stmfall -> fetch();
                $stmfall -> close();
            }

            $fec = explode("-",$fecha_consultaF);
            $mesconsulta = nombremes($fec[1]);
            $diaconsulta = $fec[2];
            $anioconsulta = substr($fec[0],3);
            $fec2 = explode("-",$fecha_defuncionF);
            $mesdef = nombremes($fec2[1]);
            $diadef = $fec2[2];
            $aniodef = substr($fec2[0],3);
            $fec3 = explode("-",$fecha_extensionF);
            $mesext = nombremes($fec3[1]);
            $diaext = $fec3[2];
            $anioext = convertir($fec3[0]);
            $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteF, con número de afiliación $afiliacion_duiF, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioF de este Centro Hospitalario, con diagnóstico $diagnosticodcF; permaneciendo ingresada/o, hasta el día $diadef de $mesdef de 201$aniodef, fecha de fallecimiento por diagnóstico $diagnostico_defuncionF.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteF ($parentescoF), y para ser presentada en $destinoF, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).
                ";

            /*$pdf = new PDF();
            $pdf->SetMargins(30,10,30);
            $pdf->AddPage();
            $pdf->AddFont('trebuc');
            $pdf->SetFont('trebuc','',12);
            $pdf->MultiCell(0,5,$texto,0,'J');
            $pdf->Output();*/
            break;
        case "Fallecimiento en casa":
            $sql4 = "SELECT dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio,  dcfc.fecha_de_alta, dcfc.fecha_defun_ext, dcfc.lugar_de_extension, dcfc.fecha_fallecimiento FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_fallecimiento_casa dcfc ON dc.id_datosc=dcfc.id_datosc WHERE dc.id_datosc=?";
            if($stmfallcasa = $conn->prepare($sql4)){
                $stmfallcasa -> bind_param('i',$id_datosc);
                $stmfallcasa -> execute();
                $stmfallcasa -> bind_result($destinoFC,$fecha_consultaFC,$diagnosticodcFC,$nombre_solicitanteFC,$parentescoFC,$fecha_extensionFC,$nombre_pacienteFC,$afiliacion_duiFC,$nombre_servicioFC,$fecha_altaFC,$fecha_defun_extFC,$lugar_extFC,$fecha_fallecimientoFC);
                $stmfallcasa -> fetch();
                $stmfallcasa -> close();
            }

            $fec = explode("-",$fecha_consultaFC);
            $mesconsulta = nombremes($fec[1]);
            $diaconsulta = $fec[2];
            $anioconsulta = substr($fec[0],3);
            $fec2 = explode("-",$fecha_fallecimientoFC);
            $mesfall = nombremes($fec2[1]);
            $diafall = $fec2[2];
            $aniofall = substr($fec2[0],3);
            $fec3 = explode("-",$fecha_extensionFC);
            $mesext = nombremes($fec3[1]);
            $diaext = $fec3[2];
            $anioext = convertir($fec[0]);
            $fec4 = explode("-",$fecha_defun_extFC);
            $mespartdef = nombremes($fec4[1]);
            $diapartdef = $fec4[2];
            $aniopartdef = substr($fec4[0],3);
            $fec5 = explode("-",$fecha_altaFC);
            $mesalta = nombremes($fec5[1]);
            $diaalta = $fec5[2];
            $anioalta = substr($fec5[0],3);
            $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteFC, con número de afiliación $afiliacion_duiFC, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioFC de este Centro Hospitalario, con diagnóstico $diagnosticodcFC; área en la que permaneció hasta la fecha de alta el día $diaalta de $mesalta de 201$anioalta. Según Partida de Defunción Extendida el día $diapartdef de $mespartdef de 201$aniopartdef en $lugar_extFC, paciente fallecido en su domicilio el día $diafall de $mesfall de 201$aniofall.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteFC ($parentescoFC), y para ser presentada en $destinoFC, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.
            ";

            /*$pdf = new PDF();
            $pdf->SetMargins(30,10,30);
            $pdf->AddPage();
            $pdf->AddFont('trebuc');
            $pdf->SetFont('trebuc','',12);
            $pdf->MultiCell(0,5,$texto,0,'J');
            $pdf->Output();*/
            break;
    }
}
$pdf = new PDF();
            $pdf->SetMargins(30,10,30);
            $pdf->AddPage();
            $pdf->AddFont('trebuc');
            $pdf->SetFont('trebuc','',12);
            $pdf->MultiCell(0,5,$texto,0,'J');
            $pdf->Output();

/*class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../assets/pdf/img/logoseguro.jpg',30, 8, 25, 25);
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
        $this->Image('../../assets/pdf/img/footer.png',null, null, 150, 1);
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
switch ($tipo) {
    case "Alta":
        $fec = explode("-",$fecha_consultaA);
        $mesconsulta = nombremes($fec[1]);
        $diaconsulta = $fec[2];
        $anioconsulta = substr($fec[0],3);
        $fec2 = explode("-",$fecha_altaA);
        $mesalta = nombremes($fec2[1]);
        $diaalta = $fec2[2];
        $anioalta = substr($fec2[0],3);
        $fec3 = explode("-",$fecha_extensionA);
        $mesext = nombremes($fec3[1]);
        $diaext = $fec3[2];
        $anioext = convertir($fec3[0]);
        $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente strtoupper($nombre_pacienteA), con número de afiliación $afiliacion_duiA, consultó el día $diaconsulta de  $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioA de este Centro Hospitalario, con diagnóstico $diagnosticodcA; permaneciendo ingresada/o, hasta el día $diaalta de $mesalta de 201$anioalta, fecha de alta con diagnóstico $diagnosticoaltaA.\n\n A solicitud de Sr. / Sra. $nombre_solicitanteA ($parentescoA), y para ser presentada en $destinoA, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).
            ";

        $pdf = new PDF();
        $pdf->SetMargins(30,10,30);
        $pdf->AddPage();
        $pdf->AddFont('trebuc');
        $pdf->SetFont('trebuc','',12);
        $pdf->MultiCell(0,5,$texto,0,'J');
        $pdf->Output();
        break;
    case "Ingreso":
        $fec = explode("-",$fecha_consultaI);
        $mesconsulta = nombremes($fec[1]);
        $diaconsulta = $fec[2];
        $anioconsulta = substr($fec[0],3);
        $fec3 = explode("-",$fecha_extensionI);
        $mesext = nombremes($fec3[1]);
        $diaext = $fec3[2];
        $anioext = convertir($fec3[0]);
        $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteI, con número de afiliación $afiliacion_duiI, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioI de este Centro Hospitalario, con diagnóstico $diagnosticoingresadoI; Permanece ingresada /o a la fecha con diagnóstico $diagnosticoactualI.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteI ($parentescoI), y para ser presentada en $destinoI, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).";

        $pdf = new PDF();
        $pdf->SetMargins(30,10,30);
        $pdf->AddPage();
        $pdf->AddFont('trebuc');
        $pdf->SetFont('trebuc','',12);
        $pdf->MultiCell(0,5,$texto,0,'J');
        $pdf->Output();
        break;
    case "Fallecimiento":
        $fec = explode("-",$fecha_consultaF);
        $mesconsulta = nombremes($fec[1]);
        $diaconsulta = $fec[2];
        $anioconsulta = substr($fec[0],3);
        $fec2 = explode("-",$fecha_defuncionF);
        $mesdef = nombremes($fec2[1]);
        $diadef = $fec2[2];
        $aniodef = substr($fec2[0],3);
        $fec3 = explode("-",$fecha_extensionF);
        $mesext = nombremes($fec3[1]);
        $diaext = $fec3[2];
        $anioext = convertir($fec3[0]);
        $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteF, con número de afiliación $afiliacion_duiF, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioF de este Centro Hospitalario, con diagnóstico $diagnosticodcF; permaneciendo ingresada/o, hasta el día $diadef de $mesdef de 201$aniodef, fecha de fallecimiento por diagnóstico $diagnostico_defuncionF.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteF ($parentescoF), y para ser presentada en $destinoF, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).
            ";

        $pdf = new PDF();
        $pdf->SetMargins(30,10,30);
        $pdf->AddPage();
        $pdf->AddFont('trebuc');
        $pdf->SetFont('trebuc','',12);
        $pdf->MultiCell(0,5,$texto,0,'J');
        $pdf->Output();
        break;
    case "Fallecimiento en casa":
        $fec = explode("-",$fecha_consultaFC);
        $mesconsulta = nombremes($fec[1]);
        $diaconsulta = $fec[2];
        $anioconsulta = substr($fec[0],3);
        $fec2 = explode("-",$fecha_fallecimientoFC);
        $mesfall = nombremes($fec2[1]);
        $diafall = $fec2[2];
        $aniofall = substr($fec2[0],3);
        $fec3 = explode("-",$fecha_extensionFC);
        $mesext = nombremes($fec3[1]);
        $diaext = $fec3[2];
        $anioext = convertir($fec[0]);
        $fec4 = explode("-",$fecha_defun_extFC);
        $mespartdef = nombremes($fec4[1]);
        $diapartdef = $fec4[2];
        $aniopartdef = substr($fec4[0],3);
        $fec5 = explode("-",$fecha_altaFC);
        $mesalta = nombremes($fec5[1]);
        $diaalta = $fec5[2];
        $anioalta = substr($fec5[0],3);
        $texto = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteFC, con número de afiliación $afiliacion_duiFC, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioFC de este Centro Hospitalario, con diagnóstico $diagnosticodcFC; área en la que permaneció hasta la fecha de alta el día $diaalta de $mesalta de 201$anioalta. Según Partida de Defunción Extendida el día $diapartdef de $mespartdef de 201$aniopartdef en $lugar_extFC, paciente fallecido en su domicilio el día $diafall de $mesfall de 201$aniofall.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteFC ($parentescoFC), y para ser presentada en $destinoFC, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.
        ";

        $pdf = new PDF();
        $pdf->SetMargins(30,10,30);
        $pdf->AddPage();
        $pdf->AddFont('trebuc');
        $pdf->SetFont('trebuc','',12);
        $pdf->MultiCell(0,5,$texto,0,'J');
        $pdf->Output();
        break;
}*/


//convercion de mes numero a texto
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 
?>
