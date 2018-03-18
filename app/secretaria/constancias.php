<?php 
if(!isset($_SERVER['HTTP_REFERER'])){
        header('Location:index.php');
}
require_once('../../assets/plugins/tcpdf/examples/tcpdf_include.php');
include("../../config/database.php");
require('conversor.php');

 $textoA = array();
 $textoI = array();
 $textoF = array();
 $textoFC = array();

 $cantfirmasI = array();
 $firmasI = array();
 $firmasI2 = array();
 $firmasI3 = array();
 $firmasI4 = array();

 $cantfirmasA = array();
 $firmasA = array();
 $firmasA2 = array();
 $firmasA3 = array();
 $firmasA4 = array();

 $cantfirmasF = array();
 $firmasF = array();
 $firmasF2 = array();
 $firmasF3 = array();
 $firmasF4 = array();

 $cantfirmasFC = array();
 $firmasFC = array();
 $firmasFC2 = array();
 $firmasFC3 = array();
 $firmasFC4 = array();

     $id_datosi = $_GET['contancianum'];

            $sql1 = "SELECT dc.id_medico, dc.id_jefe, dc.id_jefesocial, dc.id_director, dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio, dca.fecha_de_alta, dca.diagnostico FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_alta dca ON dc.id_datosc=dca.id_datosc WHERE di.id_datos=?";
            if($stmalta = $conn->prepare($sql1)){
                $stmalta -> bind_param('i',$id_datosi);
                $stmalta -> execute();
                $stmalta -> store_result();
                $rowsalta = $stmalta->num_rows;
                $stmalta -> bind_result($idmedicoA,$idjefeservicioA,$idjefesocialA,$iddirectorA,$destinoA,$fecha_consultaA,$diagnosticodcA,$nombre_solicitanteA,$parentescoA,$fecha_extensionA,$nombre_pacienteA,$afiliacion_duiA,$nombre_servicioA,$fecha_altaA,$diagnosticoaltaA);                
            }
            
            if($rowsalta>0){                
                while ($stmalta->fetch()) {
                    $sqlopc = "SELECT mt.nombre FROM medico_tratante mt WHERE id_medico=?";
                    if($stmopc = $conn->prepare($sqlopc)){
                        $stmopc -> bind_param('i',$idmedicoA);
                        $stmopc -> execute();
                        $stmopc -> store_result();
                        $rowsopc = $stmopc->num_rows;
                        $stmopc -> bind_result($nombremedico);                        
                    }
                    $sqlopc2 = "SELECT js.nombre FROM jefe_Servicio js WHERE id_jefe=?";
                    if($stmopc2 = $conn->prepare($sqlopc2)){
                        $stmopc2 -> bind_param('i',$idjefeservicioA);
                        $stmopc2 -> execute();
                        $stmopc2 -> store_result();
                        $rowsopc2 = $stmopc2->num_rows;
                        $stmopc2 -> bind_result($nombrejefeservicio);                        
                    }
                    $sqlopc3 = "SELECT jts.nombre FROM jefe_trabajo_social jts WHERE id_jefesocial=?";
                    if($stmopc3 = $conn->prepare($sqlopc3)){
                        $stmopc3 -> bind_param('i',$idjefesocialA);
                        $stmopc3 -> execute();
                        $stmopc3 -> store_result();
                        $rowsopc3 = $stmopc3->num_rows;
                        $stmopc3 -> bind_result($nombrejefesocial);                        
                    }
                    $sqlopc4 = "SELECT d.nombre FROM director d WHERE id_director=?";
                    if($stmopc4 = $conn->prepare($sqlopc4)){
                        $stmopc4 -> bind_param('i',$iddirectorA);
                        $stmopc4 -> execute();
                        $stmopc4 -> store_result();
                        $rowsopc4 = $stmopc4->num_rows;
                        $stmopc4 -> bind_result($nombredirector);                        
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
                    $anioext = strtolower(convertir($fec3[0]));
                    $pacienteA = strtoupper($nombre_pacienteA);
                    $destinoA1 = strtoupper($destinoA);
                    $solicitanteA = strtoupper($nombre_solicitanteA);
                    if(empty($parentescoA)){
                        $textoA[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteA, con número de afiliación $afiliacion_duiA, consultó el día $diaconsulta de  $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioA de este Centro Hospitalario, con diagnóstico $diagnosticodcA; permaneciendo ingresada/o, hasta el día $diaalta de $mesalta de 201$anioalta, fecha de alta con diagnóstico $diagnosticoaltaA.\n\n\nA solicitud de $solicitanteA ($parentescoA), y para ser presentada en $destinoA1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";  
                    }
                    else{
                        $textoA[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteA, con número de afiliación $afiliacion_duiA, consultó el día $diaconsulta de  $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioA de este Centro Hospitalario, con diagnóstico $diagnosticodcA; permaneciendo ingresada/o, hasta el día $diaalta de $mesalta de 201$anioalta, fecha de alta con diagnóstico $diagnosticoaltaA.\n\n\nA solicitud de $solicitanteA, y para ser presentada en $destinoA1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";  
                    }
                    

                   //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[] = 4;
                            $firmasA[] = "$nombremedico,$nombrejefeservicio";
                            $firmasA2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasA3[] = "$nombrejefesocial,$nombredirector";
                            $firmasA4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasA[] = 3;
                            $firmasA[] = "$nombremedico,$nombrejefeservicio";
                            $firmasA2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasA3[] = "$nombrejefesocial, ";
                            $firmasA4[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[] = 3;
                            $firmasA[] = "$nombremedico, ";
                            $firmasA2[] = "Médico Tratante, ";
                            $firmasA3[] = "$nombrejefesocial,$nombredirector";
                            $firmasA4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[] = 3;
                            $firmasA[] = "$nombremedico,$nombrejefeservicio";
                            $firmasA2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasA3[] = "$nombredirector, ";
                            $firmasA4[] = "Director Hospital General, ";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[]=3;
                            $firmasA[] = "$nombrejefeservicio, ";
                            $firmasA2[] = "Jefe de Servicio, ";
                            $firmasA3[] = "$nombrejefesocial,$nombredirector";
                            $firmasA4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $cantfirmasA[] = 2;
                            $firmasA[] = "$nombremedico,$nombrejefeservicio";
                            $firmasA2[] = "Médico Tratante,Jefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasA[] = 2;
                            $firmasA[] = "$nombremedico,$nombrejefesocial";
                            $firmasA2[] = "Médico Tratante,Jefe Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[] = 2;
                            $firmasA[] = "$nombremedico,$nombredirector";
                            $firmasA2[] = "Médico Tratante,Director Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[] = 2;
                            $firmasA[] = "$nombrejefesocial,$nombredirector";
                            $firmasA2[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasA[] = 2;
                            $firmasA[] = "$nombrejefeservicio,$nombrejefesocial";
                            $firmasA2[] = "Jefe de Servicio,Jefe Trabajo Social";                            
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasA[] = 2;
                            $firmasA[] = "$nombrejefeservicio,$nombredirector";
                            $firmasA2[] = "Jefe de Servicio,Director Hospital General";                            
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $cantfirmasA[] = 1;
                            $firmasA[] = "$nombremedico, ";
                            $firmasA2[] = "Médico Tratante, ";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $cantfirmasA[] = 1;
                            $firmasA[] = "$nombrejefeservicio, ";
                            $firmasA2[] = "Jefe de Servicio, ";                            
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                           $cantfirmasA[] = 1;                           
                            $firmasA[] = "$nombrejefesocial, ";
                            $firmasA2[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $cantfirmasA[] = 1;                            
                            $firmasA[] = "$nombredirector, ";
                            $firmasA2[] = "Director Hospital General, ";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 1 ENCARGADO           
                }
                
            }
            $stmalta->close();
            


            $sql2 = "SELECT dc.id_medico, dc.id_jefe, dc.id_jefesocial, dc.id_director, dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio,  dci.diagnostico FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_ingreso dci ON dc.id_datosc=dci.id_datosc WHERE di.id_datos=?";
            if($stmaing = $conn->prepare($sql2)){
                $stmaing -> bind_param('i',$id_datosi);
                $stmaing -> execute();
                $stmaing -> store_result();
                $rowsing = $stmaing->num_rows;
                $stmaing -> bind_result($idmedicoI,$idjefeservicioI,$idjefesocialI,$iddirectorI,$destinoI,$fecha_consultaI,$diagnosticoingresadoI,$nombre_solicitanteI,$parentescoI,$fecha_extensionI,$nombre_pacienteI,$afiliacion_duiI,$nombre_servicioI,$diagnosticoactualI);                
            }
                      
            if($rowsing>0){                
                while ($stmaing->fetch()) {
                    $sqlopc = "SELECT mt.nombre FROM medico_tratante mt WHERE id_medico=?";
                    if($stmopc = $conn->prepare($sqlopc)){
                        $stmopc -> bind_param('i',$idmedicoI);
                        $stmopc -> execute();
                        $stmopc -> store_result();
                        $rowsopc = $stmopc->num_rows;
                        $stmopc -> bind_result($nombremedico);                        
                    }
                    $sqlopc2 = "SELECT js.nombre FROM jefe_Servicio js WHERE id_jefe=?";
                    if($stmopc2 = $conn->prepare($sqlopc2)){
                        $stmopc2 -> bind_param('i',$idjefeservicioI);
                        $stmopc2 -> execute();
                        $stmopc2 -> store_result();
                        $rowsopc2 = $stmopc2->num_rows;
                        $stmopc2 -> bind_result($nombrejefeservicio);                        
                    }
                    $sqlopc3 = "SELECT jts.nombre FROM jefe_trabajo_social jts WHERE id_jefesocial=?";
                    if($stmopc3 = $conn->prepare($sqlopc3)){
                        $stmopc3 -> bind_param('i',$idjefesocialI);
                        $stmopc3 -> execute();
                        $stmopc3 -> store_result();
                        $rowsopc3 = $stmopc3->num_rows;
                        $stmopc3 -> bind_result($nombrejefesocial);                        
                    }
                    $sqlopc4 = "SELECT d.nombre FROM director d WHERE id_director=?";
                    if($stmopc4 = $conn->prepare($sqlopc4)){
                        $stmopc4 -> bind_param('i',$iddirectorI);
                        $stmopc4 -> execute();
                        $stmopc4 -> store_result();
                        $rowsopc4 = $stmopc4->num_rows;
                        $stmopc4 -> bind_result($nombredirector);                        
                    }
                    $fec = explode("-",$fecha_consultaI);
                    $mesconsulta = nombremes($fec[1]);
                    $diaconsulta = $fec[2];
                    $anioconsulta = substr($fec[0],3);
                    $fec3 = explode("-",$fecha_extensionI);
                    $mesext = nombremes($fec3[1]);
                    $diaext = $fec3[2];
                    $anioext = strtolower(convertir($fec3[0]));
                    $pacienteI = strtoupper($nombre_pacienteI);
                    $destinoI1 = strtoupper($destinoI);
                    $solicitanteI = strtoupper($nombre_solicitanteI);
                    if(empty($parentescoI)){
                        $textoI[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteI, con número de afiliación $afiliacion_duiI, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioI de este Centro Hospitalario, con diagnóstico $diagnosticoingresadoI; Permanece ingresada /o a la fecha con diagnóstico $diagnosticoactualI.\n\n\nA solicitud de $solicitanteI, y para ser presentada en $destinoI1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";
                    }else{
                        $textoI[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteI, con número de afiliación $afiliacion_duiI, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioI de este Centro Hospitalario, con diagnóstico $diagnosticoingresadoI; Permanece ingresada /o a la fecha con diagnóstico $diagnosticoactualI.\n\n\nA solicitud de $solicitanteI ($parentescoI), y para ser presentada en $destinoI1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";
                    }
                    

                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[] = 4;
                            $firmasI[] = "$nombremedico,$nombrejefeservicio";
                            $firmasI2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasI3[] = "$nombrejefesocial,$nombredirector";
                            $firmasI4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasI[] = 3;
                            $firmasI[] = "$nombremedico,$nombrejefeservicio";
                            $firmasI2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasI3[] = "$nombrejefesocial, ";
                            $firmasI4[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[] = 3;
                            $firmasI[] = "$nombremedico, ";
                            $firmasI2[] = "Médico Tratante, ";
                            $firmasI3[] = "$nombrejefesocial,$nombredirector";
                            $firmasI4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[] = 3;
                            $firmasI[] = "$nombremedico,$nombrejefeservicio";
                            $firmasI2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasI3[] = "$nombredirector, ";
                            $firmasI4[] = "Director Hospital General, ";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[]=3;
                            $firmasI[] = "$nombrejefeservicio, ";
                            $firmasI2[] = "Jefe de Servicio, ";
                            $firmasI3[] = "$nombrejefesocial,$nombredirector";
                            $firmasI4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $cantfirmasI[] = 2;
                            $firmasI[] = "$nombremedico,$nombrejefeservicio";
                            $firmasI2[] = "Médico Tratante,Jefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasI[] = 2;
                            $firmasI[] = "$nombremedico,$nombrejefesocial";
                            $firmasI2[] = "Médico Tratante,Jefe Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[] = 2;
                            $firmasI[] = "$nombremedico,$nombredirector";
                            $firmasI2[] = "Médico Tratante,Director Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[] = 2;
                            $firmasI[] = "$nombrejefesocial,$nombredirector";
                            $firmasI2[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasI[] = 2;
                            $firmasI[] = "$nombrejefeservicio,$nombrejefesocial";
                            $firmasI2[] = "Jefe de Servicio,Jefe Trabajo Social";                            
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasI[] = 2;
                            $firmasI[] = "$nombrejefeservicio,$nombredirector";
                            $firmasI2[] = "Jefe de Servicio,Director Hospital General";                            
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $cantfirmasI[] = 1;
                            $firmasI[] = "$nombremedico, ";
                            $firmasI2[] = "Médico Tratante, ";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $cantfirmasI[] = 1;
                            $firmasI[] = "$nombrejefeservicio, ";
                            $firmasI2[] = "Jefe de Servicio, ";                            
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                           $cantfirmasI[] = 1;                           
                            $firmasI[] = "$nombrejefesocial, ";
                            $firmasI2[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $cantfirmasI[] = 1;                            
                            $firmasI[] = "$nombredirector, ";
                            $firmasI2[] = "Director Hospital General, ";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 1 ENCARGADO 

                }
                
            }
            $stmaing->close();
            



            $sql3 = "SELECT dc.id_medico, dc.id_jefe, dc.id_jefesocial, dc.id_director, dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio,  dcf.fecha_defuncion, dcf.diagnostico FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_fallecimiento dcf ON dc.id_datosc=dcf.id_datosc WHERE di.id_datos=?";
            if($stmfall = $conn->prepare($sql3)){
                $stmfall -> bind_param('i',$id_datosi);
                $stmfall -> execute();
                $stmfall -> store_result();
                $rowsfall = $stmfall->num_rows;
                $stmfall -> bind_result($idmedicoF,$idjefeservicioF,$idjefesocialF,$iddirectorF,$destinoF,$fecha_consultaF,$diagnosticodcF,$nombre_solicitanteF,$parentescoF,$fecha_extensionF,$nombre_pacienteF,$afiliacion_duiF,$nombre_servicioF,$fecha_defuncionF,$diagnostico_defuncionF);
            }
        
            if($rowsfall>0){                
                while ($stmfall->fetch()) {
                    $sqlopc = "SELECT mt.nombre FROM medico_tratante mt WHERE id_medico=?";
                    if($stmopc = $conn->prepare($sqlopc)){
                        $stmopc -> bind_param('i',$idmedicoF);
                        $stmopc -> execute();
                        $stmopc -> store_result();
                        $rowsopc = $stmopc->num_rows;
                        $stmopc -> bind_result($nombremedico);                        
                    }
                    $sqlopc2 = "SELECT js.nombre FROM jefe_Servicio js WHERE id_jefe=?";
                    if($stmopc2 = $conn->prepare($sqlopc2)){
                        $stmopc2 -> bind_param('i',$idjefeservicioF);
                        $stmopc2 -> execute();
                        $stmopc2 -> store_result();
                        $rowsopc2 = $stmopc2->num_rows;
                        $stmopc2 -> bind_result($nombrejefeservicio);                        
                    }
                    $sqlopc3 = "SELECT jts.nombre FROM jefe_trabajo_social jts WHERE id_jefesocial=?";
                    if($stmopc3 = $conn->prepare($sqlopc3)){
                        $stmopc3 -> bind_param('i',$idjefesocialF);
                        $stmopc3 -> execute();
                        $stmopc3 -> store_result();
                        $rowsopc3 = $stmopc3->num_rows;
                        $stmopc3 -> bind_result($nombrejefesocial);                        
                    }
                    $sqlopc4 = "SELECT d.nombre FROM director d WHERE id_director=?";
                    if($stmopc4 = $conn->prepare($sqlopc4)){
                        $stmopc4 -> bind_param('i',$iddirectorF);
                        $stmopc4 -> execute();
                        $stmopc4 -> store_result();
                        $rowsopc4 = $stmopc4->num_rows;
                        $stmopc4 -> bind_result($nombredirector);                        
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
                    $anioext = strtolower(convertir($fec3[0]));
                    $pacienteF = strtoupper($nombre_pacienteF);
                    $destinoF1 = strtoupper($destinoF);
                    $solicitanteF = strtoupper($nombre_solicitanteF);
                    if(empty($parentescoF)){
                        $textoF[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteF, con número de afiliación $afiliacion_duiF, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioF de este Centro Hospitalario, con diagnóstico $diagnosticodcF; permaneciendo ingresada/o, hasta el día $diadef de $mesdef de 201$aniodef, fecha de fallecimiento por diagnóstico $diagnostico_defuncionF.\n\n\nA solicitud de $solicitanteF, y para ser presentada en $destinoF1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";
                    }else{
                        $textoF[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteF, con número de afiliación $afiliacion_duiF, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioF de este Centro Hospitalario, con diagnóstico $diagnosticodcF; permaneciendo ingresada/o, hasta el día $diadef de $mesdef de 201$aniodef, fecha de fallecimiento por diagnóstico $diagnostico_defuncionF.\n\n\nA solicitud de $solicitanteF ($parentescoF), y para ser presentada en $destinoF1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";
                    }
                    

                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[] = 4;
                            $firmasF[] = "$nombremedico,$nombrejefeservicio";
                            $firmasF2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasF3[] = "$nombrejefesocial,$nombredirector";
                            $firmasF4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasF[] = 3;
                            $firmasF[] = "$nombremedico,$nombrejefeservicio";
                            $firmasF2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasF3[] = "$nombrejefesocial, ";
                            $firmasF4[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[] = 3;
                            $firmasF[] = "$nombremedico, ";
                            $firmasF2[] = "Médico Tratante, ";
                            $firmasF3[] = "$nombrejefesocial,$nombredirector";
                            $firmasF4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[] = 3;
                            $firmasF[] = "$nombremedico,$nombrejefeservicio";
                            $firmasF2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasF3[] = "$nombredirector, ";
                            $firmasF4[] = "Director Hospital General, ";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[]=3;
                            $firmasF[] = "$nombrejefeservicio, ";
                            $firmasF2[] = "Jefe de Servicio, ";
                            $firmasF3[] = "$nombrejefesocial,$nombredirector";
                            $firmasF4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $cantfirmasF[] = 2;
                            $firmasF[] = "$nombremedico,$nombrejefeservicio";
                            $firmasF2[] = "Médico Tratante,Jefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasF[] = 2;
                            $firmasF[] = "$nombremedico,$nombrejefesocial";
                            $firmasF2[] = "Médico Tratante,Jefe Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[] = 2;
                            $firmasF[] = "$nombremedico,$nombredirector";
                            $firmasF2[] = "Médico Tratante,Director Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[] = 2;
                            $firmasF[] = "$nombrejefesocial,$nombredirector";
                            $firmasF2[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasF[] = 2;
                            $firmasF[] = "$nombrejefeservicio,$nombrejefesocial";
                            $firmasF2[] = "Jefe de Servicio,Jefe Trabajo Social";                            
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasF[] = 2;
                            $firmasF[] = "$nombrejefeservicio,$nombredirector";
                            $firmasF2[] = "Jefe de Servicio,Director Hospital General";                            
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $cantfirmasF[] = 1;
                            $firmasF[] = "$nombremedico, ";
                            $firmasF2[] = "Médico Tratante, ";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $cantfirmasF[] = 1;
                            $firmasF[] = "$nombrejefeservicio, ";
                            $firmasF2[] = "Jefe de Servicio, ";                            
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                           $cantfirmasF[] = 1;                           
                            $firmasF[] = "$nombrejefesocial, ";
                            $firmasF2[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $cantfirmasF[] = 1;                            
                            $firmasF[] = "$nombredirector, ";
                            $firmasF2[] = "Director Hospital General, ";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 1 ENCARGADO 
                }
                
            }
            $stmfall->close();

            

            $sql4 = "SELECT dc.id_medico, dc.id_jefe, dc.id_jefesocial, dc.id_director, dc.destino, dc.fecha_consulta, dc.diagnostico, dc.nombre_solicitante, dc.parentesco, dc.fecha_extension, di.nombre_paciente, di.afiliacion_dui, sv.nombre_servicio,  dcfc.fecha_de_alta, dcfc.fecha_defun_ext, dcfc.lugar_de_extension, dcfc.fecha_fallecimiento FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_const_fallecimiento_casa dcfc ON dc.id_datosc=dcfc.id_datosc WHERE di.id_datos=?";
            if($stmfallcasa = $conn->prepare($sql4)){
                $stmfallcasa -> bind_param('i',$id_datosi);
                $stmfallcasa -> execute();
                $stmfallcasa -> store_result();
                $rowsfallcasa = $stmfallcasa->num_rows;
                $stmfallcasa -> bind_result($idmedicoFC,$idjefeservicioFC,$idjefesocialFC,$iddirectorFC,$destinoFC,$fecha_consultaFC,$diagnosticodcFC,$nombre_solicitanteFC,$parentescoFC,$fecha_extensionFC,$nombre_pacienteFC,$afiliacion_duiFC,$nombre_servicioFC,$fecha_altaFC,$fecha_defun_extFC,$lugar_extFC,$fecha_fallecimientoFC);
            }
          
            if($rowsfallcasa>0){                
                while ($stmfallcasa->fetch()) {
                    $sqlopc = "SELECT mt.nombre FROM medico_tratante mt WHERE id_medico=?";
                    if($stmopc = $conn->prepare($sqlopc)){
                        $stmopc -> bind_param('i',$idmedicoFC);
                        $stmopc -> execute();
                        $stmopc -> store_result();
                        $rowsopc = $stmopc->num_rows;
                        $stmopc -> bind_result($nombremedico);                        
                    }
                    $sqlopc2 = "SELECT js.nombre FROM jefe_Servicio js WHERE id_jefe=?";
                    if($stmopc2 = $conn->prepare($sqlopc2)){
                        $stmopc2 -> bind_param('i',$idjefeservicioFC);
                        $stmopc2 -> execute();
                        $stmopc2 -> store_result();
                        $rowsopc2 = $stmopc2->num_rows;
                        $stmopc2 -> bind_result($nombrejefeservicio);                        
                    }
                    $sqlopc3 = "SELECT jts.nombre FROM jefe_trabajo_social jts WHERE id_jefesocial=?";
                    if($stmopc3 = $conn->prepare($sqlopc3)){
                        $stmopc3 -> bind_param('i',$idjefesocialFC);
                        $stmopc3 -> execute();
                        $stmopc3 -> store_result();
                        $rowsopc3 = $stmopc3->num_rows;
                        $stmopc3 -> bind_result($nombrejefesocial);                        
                    }
                    $sqlopc4 = "SELECT d.nombre FROM director d WHERE id_director=?";
                    if($stmopc4 = $conn->prepare($sqlopc4)){
                        $stmopc4 -> bind_param('i',$iddirectorFC);
                        $stmopc4 -> execute();
                        $stmopc4 -> store_result();
                        $rowsopc4 = $stmopc4->num_rows;
                        $stmopc4 -> bind_result($nombredirector);                        
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
                    $anioext = strtolower(convertir($fec[0]));
                    $fec4 = explode("-",$fecha_defun_extFC);
                    $mespartdef = nombremes($fec4[1]);
                    $diapartdef = $fec4[2];
                    $aniopartdef = substr($fec4[0],3);
                    $fec5 = explode("-",$fecha_altaFC);
                    $mesalta = nombremes($fec5[1]);
                    $diaalta = $fec5[2];
                    $anioalta = substr($fec5[0],3);
                    $pacienteFC = strtoupper($nombre_pacienteFC);
                    $destinoFC1 = strtoupper($destinoFC);
                    $solicitanteFC = strtoupper($nombre_solicitanteFC);
                    if(empty($parentescoFC)){
                        $textoFC[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteFC, con número de afiliación $afiliacion_duiFC, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioFC de este Centro Hospitalario, con diagnóstico $diagnosticodcFC; área en la que permaneció hasta la fecha de alta el día $diaalta de $mesalta de 201$anioalta. Según Partida de Defunción Extendida el día $diapartdef de $mespartdef de 201$aniopartdef en $lugar_extFC, paciente fallecido en su domicilio el día $diafall de $mesfall de 201$aniofall.\n\n\nA solicitud de $solicitanteFC, y para ser presentada en $destinoFC1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";
                    }else{
                        $textoFC[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $pacienteFC, con número de afiliación $afiliacion_duiFC, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioFC de este Centro Hospitalario, con diagnóstico $diagnosticodcFC; área en la que permaneció hasta la fecha de alta el día $diaalta de $mesalta de 201$anioalta. Según Partida de Defunción Extendida el día $diapartdef de $mespartdef de 201$aniopartdef en $lugar_extFC, paciente fallecido en su domicilio el día $diafall de $mesfall de 201$aniofall.\n\n\nA solicitud de $solicitanteFC ($parentescoFC), y para ser presentada en $destinoFC1, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.------------------------------------------------------------";
                    }
                    

                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 4;
                            $firmasFC[] = "$nombremedico,$nombrejefeservicio";
                            $firmasFC2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasFC3[] = "$nombrejefesocial,$nombredirector";
                            $firmasFC4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasFC[] = 3;
                            $firmasFC[] = "$nombremedico,$nombrejefeservicio";
                            $firmasFC2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasFC3[] = "$nombrejefesocial, ";
                            $firmasFC4[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 3;
                            $firmasFC[] = "$nombremedico, ";
                            $firmasFC2[] = "Médico Tratante, ";
                            $firmasFC3[] = "$nombrejefesocial,$nombredirector";
                            $firmasFC4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 3;
                            $firmasFC[] = "$nombremedico,$nombrejefeservicio";
                            $firmasFC2[] = "Médico Tratante,Jefe de Servicio";
                            $firmasFC3[] = "$nombredirector, ";
                            $firmasFC4[] = "Director Hospital General, ";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 3;
                            $firmasFC[] = "$nombrejefeservicio, ";
                            $firmasFC2[] = "Jefe de Servicio, ";
                            $firmasFC3[] = "$nombrejefesocial,$nombredirector";
                            $firmasFC4[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $cantfirmasFC[] = 2;
                            $firmasFC[] = "$nombremedico,$nombrejefeservicio";
                            $firmasFC2[] = "Médico Tratante,Jefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasFC[] = 2;
                            $firmasFC[] = "$nombremedico,$nombrejefesocial";
                            $firmasFC2[] = "Médico Tratante,Jefe Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 2;
                            $firmasFC[] = "$nombremedico,$nombredirector";
                            $firmasFC2[] = "Médico Tratante,Director Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 2;
                            $firmasFC[] = "$nombrejefesocial,$nombredirector";
                            $firmasFC2[] = "Jefe Trabajo Social,Director Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $cantfirmasFC[] = 2;
                            $firmasFC[] = "$nombrejefeservicio,$nombrejefesocial";
                            $firmasFC2[] = "Jefe de Servicio,Jefe Trabajo Social";                            
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $cantfirmasFC[] = 2;
                            $firmasFC[] = "$nombrejefeservicio,$nombredirector";
                            $firmasFC2[] = "Jefe de Servicio,Director Hospital General";                            
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $cantfirmasFC[] = 1;
                            $firmasFC[] = "$nombremedico, ";
                            $firmasFC2[] = "Médico Tratante, ";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $cantfirmasFC[] = 1;
                            $firmasFC[] = "$nombrejefeservicio, ";
                            $firmaFC2[] = "Jefe de Servicio, ";                            
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                           $cantfirmasFC[] = 1;                           
                            $firmasFC[] = "$nombrejefesocial, ";
                            $firmasFC2[] = "Jefe Trabajo Social, ";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $cantfirmasFC[] = 1;                            
                            $firmasFC[] = "$nombredirector, ";
                            $firmasFC2[] = "Director Hospital General, ";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 1 ENCARGADO 
                }
                
            }
            $stmfallcasa->close();

            class MYPDF extends TCPDF {

			    //Page header
			    public function Header() {

			    	$id_soli = $_GET['contancianum'];
			    	// Set font
			        $this->SetFont('arialblack', 'B', 12);			        
			        $this->Image('../../assets/pdf/img/logoseguro.jpg',30, 5, 25, 25);			        
			        // Título
			        $this->Cell(30);
			        $this->MultiCell(0,5,"INSTITUTO SALVADOREÑO"."\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t".$id_soli,0,'L');
			        //$this->MultiCell(0,5,$id_soli,0,'R');
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
			        $this->SetFont('arialnarrowb','BU',10);
			        $this->MultiCell(0,5,"email@isss.gob.sv",0,"C");
			    }

			    function ImprovedTable($data)
                {
                    // Anchuras de las columnas
                    $w = array(80, 90);           
                    // Datos                    
                    foreach($data as $row)
                    {
                        $this->Cell($w[0],1,$row[0],0,0,'C');
                        $this->Cell($w[1],1,$row[1],0,0,'C');
                        $this->Ln();                        
                    }                    
                    // Línea de cierre
                    $this->Cell(array_sum($w),0,'','C');
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


			$Ac = count($textoA);
            $Ic = count($textoI);
            $Fc = count($textoF);
            $FCc = count($textoFC);            

            $pdf->SetFont("trebuchet", '', 12);
            if($Ac>0){
                for($i=0;$i<$Ac;$i++){
                    $pdf->AddPage();                    
                    $pdf->setCellHeightRatio(1.5); 
                    $pdf->SetFontSize(12);                                               
                    $pdf->MultiCell(0,5,$textoA[$i],0,'J');                    
                    $pdf->Ln(30);

                    if($cantfirmasA[$i]==4){
                        ${"dataA40".$i}[] = explode(",",$firmasA[$i]);
                        ${"dataA42".$i}[] = explode(",",$firmasA2[$i]);
                        ${"dataA43".$i}[] = explode(",",$firmasA3[$i]);
                        ${"dataA44".$i}[] = explode(",",$firmasA4[$i]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                        	$pdf->ImprovedTable(${"dataA40".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA42".$i});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataA43".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA44".$i});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                        	$pdf->ImprovedTable(${"dataA40".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA42".$i});
	                        $pdf->AddPage();
	                        $pdf->SetFontSize(10);
	                        $pdf->Ln(30);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataA43".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA44".$i});
                        }else{
                        	$pdf->AddPage();	                        
	                        $pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataA40".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA42".$i});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataA43".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA44".$i});
                        }                        
                    }elseif ($cantfirmasA[$i]==3) {
                        ${"dataA30".$i}[] = explode(",",$firmasA[$i]);
                        ${"dataA32".$i}[] = explode(",",$firmasA2[$i]);
                        ${"dataA33".$i}[] = explode(",",$firmasA3[$i]);
                        ${"dataA34".$i}[] = explode(",",$firmasA4[$i]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                        	$pdf->ImprovedTable(${"dataA30".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA32".$i});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataA33".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA34".$i});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                        	$pdf->ImprovedTable(${"dataA30".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA32".$i});
	                        $pdf->AddPage();	                        
	                        $pdf->Ln(30);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataA33".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA34".$i});
                        }else{
                        	$pdf->AddPage();
                        	$pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataA30".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA32".$i});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataA33".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA34".$i});
                        }                        
                    }elseif ($cantfirmasA[$i]==2) {//19                    	
                        ${"dataA20".$i}[] = explode(",",$firmasA[$i]);
                        ${"dataA22".$i}[] = explode(",",$firmasA2[$i]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                        	$pdf->ImprovedTable(${"dataA20".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA22".$i});
                        }else{
                        	$pdf->AddPage();
                        	$pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataA20".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA22".$i});
                        }                        
                    }else{
                        ${"dataA10".$i}[] = explode(",",$firmasA[$i]);
                        ${"dataA12".$i}[] = explode(",",$firmasA2[$i]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                        	$pdf->ImprovedTable(${"dataA10".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA12".$i});
                        }else{
                        	$pdf->AddPage();
                        	$pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataA10".$i});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataA12".$i});
                        }
                    }
                }    
            }
            if($Ic>0){
                for($j=0;$j<$Ic;$j++){
                    $pdf->AddPage();                       
                    $pdf->setCellHeightRatio(1.5);
                    $pdf->SetFontSize(12);      
                    $pdf->MultiCell(0,5,$textoI[$j],0,'J');  
                    $pdf->Ln(30);

                    if($cantfirmasI[$j]==4){
                        ${"dataI40".$j}[] = explode(",",$firmasI[$j]);
                        ${"dataI42".$j}[] = explode(",",$firmasI2[$j]);
                        ${"dataI43".$j}[] = explode(",",$firmasI3[$j]);
                        ${"dataI44".$j}[] = explode(",",$firmasI4[$j]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                        	$pdf->ImprovedTable(${"dataI40".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI42".$j});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataI43".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI44".$j});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                        	$pdf->ImprovedTable(${"dataI40".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI42".$j});
	                        $pdf->AddPage();
	                        $pdf->SetFontSize(10);
	                        $pdf->Ln(30);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataI43".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI44".$j});
                        }else{
                        	$pdf->AddPage();	                        
	                        $pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataI40".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI42".$j});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataI43".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI44".$j});
                        }                        
                    }elseif ($cantfirmasI[$j]==3) {
                        ${"dataI30".$j}[] = explode(",",$firmasI[$j]);
                        ${"dataI32".$j}[] = explode(",",$firmasI2[$j]);
                        ${"dataI33".$j}[] = explode(",",$firmasI3[$j]);
                        ${"dataI34".$j}[] = explode(",",$firmasI4[$j]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                        	$pdf->ImprovedTable(${"dataI30".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI32".$j});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataI33".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI34".$j});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                        	$pdf->ImprovedTable(${"dataI30".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI32".$j});
	                        $pdf->AddPage();	                        
	                        $pdf->Ln(30);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataI33".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI34".$j});
                        }else{
                        	$pdf->AddPage();
                        	$pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataI30".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI32".$j});
	                        $pdf->Ln(20);
	                        $pdf->SetFontSize(10);
	                        $pdf->ImprovedTable(${"dataI33".$j});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataI34".$j});
                        }
                    }elseif ($cantfirmasI[$j]==2) {
                        ${"dataI20".$j}[] = explode(",",$firmasI[$j]);
                        ${"dataI22".$j}[] = explode(",",$firmasI2[$j]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                                $pdf->ImprovedTable(${"dataI20".$j});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataI22".$j});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataI20".$j});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataI22".$j});
                        }
                    }else{
                        ${"dataI10".$j}[] = explode(",",$firmasI[$j]);
                        ${"dataI12".$j}[] = explode(",",$firmasI2[$j]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                                $pdf->ImprovedTable(${"dataI10".$j});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataI12".$j});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataI10".$j});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataI12".$j});
                        }
                    }
                }    
            }
            if($Fc>0){
                for($k=0;$k<$Fc;$k++){
                    $pdf->AddPage();    
                    $pdf->setCellHeightRatio(1.5); 
                    $pdf->SetFontSize(12);                       
                    $pdf->MultiCell(0,5,$textoF[$k],0,'J');
                    $pdf->Ln(30);                   //23 ----> 247.15                    
                    

                    if($cantfirmasF[$k]==4){
                        ${"dataF40".$k}[] = explode(",",$firmasF[$k]);
                        ${"dataF42".$k}[] = explode(",",$firmasF2[$k]);
                        ${"dataF43".$k}[] = explode(",",$firmasF3[$k]);
                        ${"dataF44".$k}[] = explode(",",$firmasF4[$k]);
                       
                        $pdf->SetFontSize(10);                        
                       if($pdf->GetY()<=197.15){
                        	$pdf->ImprovedTable(${"dataF40".$k});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataF42".$k});
	                        $pdf->SetFontSize(10);
	                        $pdf->Ln(20);
	                        $pdf->ImprovedTable(${"dataF43".$k});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataF44".$k});

                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                        	$pdf->ImprovedTable(${"dataF40".$k});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataF42".$k});
	                        $pdf->AddPage();
	                        $pdf->SetFontSize(10);
	                        $pdf->Ln(30);
	                        $pdf->ImprovedTable(${"dataF43".$k});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataF44".$k});                        	
                        }else{
                        	$pdf->AddPage();
                        	$pdf->Ln(30);
                        	$pdf->ImprovedTable(${"dataF40".$k});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataF42".$k});                        
	                        $pdf->SetFontSize(10);
	                        $pdf->Ln(20);
	                        $pdf->ImprovedTable(${"dataF43".$k});
	                        $pdf->Ln(1);
	                        $pdf->SetFontSize(9);
	                        $pdf->ImprovedTable(${"dataF44".$k});                        
                        }
                    }elseif ($cantfirmasF[$k]==3) {
                        ${"dataF30".$k}[] = explode(",",$firmasF[$k]);
                        ${"dataF32".$k}[] = explode(",",$firmasF2[$k]);
                        ${"dataF33".$k}[] = explode(",",$firmasF3[$k]);
                        ${"dataF34".$k}[] = explode(",",$firmasF4[$k]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                                $pdf->ImprovedTable(${"dataF30".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF32".$k});
                                $pdf->Ln(20);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataF33".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF34".$k});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                                $pdf->ImprovedTable(${"dataF30".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF32".$k});
                                $pdf->AddPage();                                
                                $pdf->Ln(30);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataF33".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF34".$k});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataF30".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF32".$k});
                                $pdf->Ln(20);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataF33".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF34".$k});
                        }
                    }elseif ($cantfirmasF[$k]==2) {
                        ${"dataF20".$k}[] = explode(",",$firmasF[$k]);
                        ${"dataF22".$k}[] = explode(",",$firmasF2[$k]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                                $pdf->ImprovedTable(${"dataF20".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF22".$k});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataF20".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF22".$k});
                        }
                    }else{
                        ${"dataF10".$k}[] = explode(",",$firmasF[$k]);
                        ${"dataF12".$k}[] = explode(",",$firmasF2[$k]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                                $pdf->ImprovedTable(${"dataF10".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF12".$k});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataF10".$k});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataF12".$k});
                        }
                    }
                }    
            }
            if($FCc>0){
                for($l=0;$l<$FCc;$l++){
                    $pdf->AddPage();                      
                    $pdf->setCellHeightRatio(1.5); 
                    $pdf->SetFontSize(12);         
                    $pdf->MultiCell(0,5,$textoFC[$l],0,'J');
                    $pdf->Ln(30); 

                    if($cantfirmasFC[$l]==4){
                        ${"dataFC40".$l}[] = explode(",",$firmasFC[$l]);
                        ${"dataFC42".$l}[] = explode(",",$firmasFC2[$l]);
                        ${"dataFC43".$l}[] = explode(",",$firmasFC3[$l]);
                        ${"dataFC44".$l}[] = explode(",",$firmasFC4[$l]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                                $pdf->ImprovedTable(${"dataFC40".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC42".$l});
                                $pdf->Ln(20);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataFC43".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC44".$l});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                                $pdf->ImprovedTable(${"dataFC40".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC42".$l});
                                $pdf->AddPage();
                                $pdf->SetFontSize(10);
                                $pdf->Ln(30);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataFC43".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC44".$l});
                        }else{
                                $pdf->AddPage();                                
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataFC40".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC42".$l});
                                $pdf->Ln(20);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataFC43".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC44".$l});
                        }
                    }elseif ($cantfirmasFC[$l]==3) {
                        ${"dataFC30".$l}[] = explode(",",$firmasFC[$l]);
                        ${"dataFC32".$l}[] = explode(",",$firmasFC2[$l]);
                        ${"dataFC33".$l}[] = explode(",",$firmasFC3[$l]);
                        ${"dataFC34".$l}[] = explode(",",$firmasFC4[$l]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=197.15){
                                $pdf->ImprovedTable(${"dataFC30".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC32".$l});
                                $pdf->Ln(20);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataFC33".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC34".$l});
                        }elseif($pdf->GetY()<=228.745 && $pdf->GetY()>197.15){
                                $pdf->ImprovedTable(${"dataFC30".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC32".$l});
                                $pdf->AddPage();                                
                                $pdf->Ln(30);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataFC33".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC34".$l});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataFC30".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC32".$l});
                                $pdf->Ln(20);
                                $pdf->SetFontSize(10);
                                $pdf->ImprovedTable(${"dataFC33".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC34".$l});
                        }
                    }elseif ($cantfirmasFC[$l]==2) {
                        ${"dataFC20".$l}[] = explode(",",$firmasFC[$l]);
                        ${"dataFC22".$l}[] = explode(",",$firmasFC2[$l]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                                $pdf->ImprovedTable(${"dataFC20".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC22".$l});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataFC20".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC22".$l});
                        }
                    }else{
                        ${"dataFC10".$l}[] = explode(",",$firmasFC[$l]);
                        ${"dataFC12".$l}[] = explode(",",$firmasFC2[$l]);

                        $pdf->SetFontSize(10);
                        if($pdf->GetY()<=228.745){
                                $pdf->ImprovedTable(${"dataFC10".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC12".$l});
                        }else{
                                $pdf->AddPage();
                                $pdf->Ln(30);
                                $pdf->ImprovedTable(${"dataFC10".$l});
                                $pdf->Ln(1);
                                $pdf->SetFontSize(9);
                                $pdf->ImprovedTable(${"dataFC12".$l});
                        }
                    }
                }    
            }
            $pdf->Output('pdf.pdf', 'I');


//convercion de mes numero a texto
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 

?>