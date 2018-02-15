<?php
require('../../assets/plugins/fpdf/fpdf.php');
include("../../config/database.php");
require('conversor.php');


 $textoA = array();
 $textoI = array();
 $textoF = array();
 $textoFC = array();
 $firmasA = array();
 $firmasI = array();
 $firmasF = array();
 $firmasFC = array();

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
                    $anioext = convertir($fec3[0]);
                    $textoA[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente strtoupper($nombre_pacienteA), con número de afiliación $afiliacion_duiA, consultó el día $diaconsulta de  $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioA de este Centro Hospitalario, con diagnóstico $diagnosticodcA; permaneciendo ingresada/o, hasta el día $diaalta de $mesalta de 201$anioalta, fecha de alta con diagnóstico $diagnosticoaltaA.\n\n A solicitud de Sr. / Sra. $nombre_solicitanteA ($parentescoA), y para ser presentada en $destinoA, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).";  
                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJDirector Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasA[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $firmasA[] = "\n\n\n\n\n$nombremedico\n\t\t\t\t\t\t\t\tMédico Tratante";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $firmasA[] = "\n\n\n\n\n$nombrejefeservicio\n\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                            $firmasA[] = "\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $firmasA[] = "\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
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
                    $anioext = convertir($fec3[0]);
                    $textoI[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteI, con número de afiliación $afiliacion_duiI, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioI de este Centro Hospitalario, con diagnóstico $diagnosticoingresadoI; Permanece ingresada /o a la fecha con diagnóstico $diagnosticoactualI.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteI ($parentescoI), y para ser presentada en $destinoI, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).";

                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJDirector Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasI[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $firmasI[] = "\n\n\n\n\n$nombremedico\n\t\t\t\t\t\t\t\tMédico Tratante";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $firmasI[] = "\n\n\n\n\n$nombrejefeservicio\n\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                            $firmasI[] = "\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $firmasI[] = "\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
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
                    $anioext = convertir($fec3[0]);
                    $textoF[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteF, con número de afiliación $afiliacion_duiF, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioF de este Centro Hospitalario, con diagnóstico $diagnosticodcF; permaneciendo ingresada/o, hasta el día $diadef de $mesdef de 201$aniodef, fecha de fallecimiento por diagnóstico $diagnostico_defuncionF.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteF ($parentescoF), y para ser presentada en $destinoF, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de strtolower($anioext).";
                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJDirector Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasF[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $firmasF[] = "\n\n\n\n\n$nombremedico\n\t\t\t\t\t\t\t\tMédico Tratante";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $firmasF[] = "\n\n\n\n\n$nombrejefeservicio\n\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                            $firmasF[] = "\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $firmasF[] = "\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
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
                        $stmopc2 -> bind_param('i',$idjefeservicioFc);
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
                    $anioext = convertir($fec[0]);
                    $fec4 = explode("-",$fecha_defun_extFC);
                    $mespartdef = nombremes($fec4[1]);
                    $diapartdef = $fec4[2];
                    $aniopartdef = substr($fec4[0],3);
                    $fec5 = explode("-",$fecha_altaFC);
                    $mesalta = nombremes($fec5[1]);
                    $diaalta = $fec5[2];
                    $anioalta = substr($fec5[0],3);
                    $textoFC[] = "El Infrascrito Médico Director del Hospital General del Instituto Salvadoreño del Seguro Social, Hace Constar Que:\n\nPaciente $nombre_pacienteFC, con número de afiliación $afiliacion_duiFC, consultó el día $diaconsulta de $mesconsulta de 201$anioconsulta en el Servicio de $nombre_servicioFC de este Centro Hospitalario, con diagnóstico $diagnosticodcFC; área en la que permaneció hasta la fecha de alta el día $diaalta de $mesalta de 201$anioalta. Según Partida de Defunción Extendida el día $diapartdef de $mespartdef de 201$aniopartdef en $lugar_extFC, paciente fallecido en su domicilio el día $diafall de $mesfall de 201$aniofall.\n\nA solicitud de Sr. / Sra. $nombre_solicitanteFC ($parentescoFC), y para ser presentada en $destinoFC, se extiende la presente constancia en la ciudad de San Salvador, el día $diaext de $mesext de $anioext.";
                    //INICIO FIRMAS REQUERIDAS DE 4 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 4 ENCARGADOS

                    //FIRMAS REQUERIDAS DE 3 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN DE FIRMAS DE 3 ENCARGADOS

                    //INICIO FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    if(($rowsopc>0) && ($rowsopc2>0) ){
                        while (($stmopc->fetch()) && ($stmopc2->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefeservicio\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc3>0)){
                        while (($stmopc->fetch()) && ($stmopc3->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc>0) && ($rowsopc4>0)){
                        while (($stmopc->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tMédico Tratante\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJDirector Hospital General";
                        }
                    }
                    if(($rowsopc3>0) && ($rowsopc4>0)){
                        while (($stmopc3->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombrejefesocial\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Trabajo Social\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc3>0)){
                        while (($stmopc2->fetch()) && ($stmopc3->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if(($rowsopc2>0) && ($rowsopc4>0)){
                        while (($stmopc2->fetch()) && ($stmopc4->fetch())) {
                            $firmasFC[] = "\n\n\n\n\n$nombrejefeservicio\t\t\t\t\t$nombredirector\n\t\t\t\t\t\t\t\tJefe de Servicio\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 2 ENCARGADOS
                    
                    //INICIO FIRMAS REQUERIDAS DE 1 ENCARGADO
                    if($rowsopc>0){
                        while ($stmopc->fetch()) {
                            $firmasFC[] = "\n\n\n\n\n$nombremedico\n\t\t\t\t\t\t\t\tMédico Tratante";
                        }
                    }
                    if($rowsopc2>0){
                        while ($stmopc2->fetch()) {
                            $firmasFC[] = "\n\n\n\n\n$nombrejefeservicio\n\t\t\t\t\t\t\t\tJefe de Servicio";
                        }
                    }
                    if($rowsopc3>0 ){
                        while ($stmopc3->fetch()) {
                            $firmasFC[] = "\n\n\n\n\n$nombrejefesocial\n\t\t\t\t\t\t\t\tJefe de Trabajo Social";
                        }
                    }
                    if($rowsopc4>0){
                        while ($stmopc4->fetch()) {
                            $firmasFC[] = "\n\n\n\n\n$nombredirector\n\t\t\t\t\t\t\t\tDirector Hospital General";
                        }
                    }
                    //FIN FIRMAS REQUERIDAS DE 1 ENCARGADO
                }
                
            }
            $stmfallcasa->close();



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

            $Ac = count($textoA);
            $Ic = count($textoI);
            $Fc = count($textoF);
            $FCc = count($textoFC);

            $pdf = new PDF();
            $pdf->SetMargins(30,10,30);
            if($Ac>0){
                for($i=0;$i<$Ac;$i++){
                    $pdf->AddPage();
                    $pdf->AddFont('trebuc');
                    $pdf->SetFont('trebuc','',12);            
                    $pdf->MultiCell(0,5,$textoA[$i],0,'J');
                }    
            }
            if($Ic>0){
                for($j=0;$j<$Ic;$j++){
                    $pdf->AddPage();
                    $pdf->AddFont('trebuc');
                    $pdf->SetFont('trebuc','',12);            
                    $pdf->MultiCell(0,5,$textoI[$j].$firmasI[$j],0,'J');
                }    
            }
            if($Fc>0){
                for($k=0;$k<$Fc;$k++){
                    $pdf->AddPage();
                    $pdf->AddFont('trebuc');
                    $pdf->SetFont('trebuc','',12);            
                    $pdf->MultiCell(0,5,$textoF[$k],0,'J');
                }    
            }
            if($FCc>0){
                for($l=0;$l<$FCc;$l++){
                    $pdf->AddPage();
                    $pdf->AddFont('trebuc');
                    $pdf->SetFont('trebuc','',12);            
                    $pdf->MultiCell(0,5,$textoFC[$l],0,'J');
                }    
            }      
                           
            $pdf->Output();  


//convercion de mes numero a texto
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 
?>
