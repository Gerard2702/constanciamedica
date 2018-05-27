<?php
	$title = "Resportes de Constancias";
    if(!isset($_SERVER['HTTP_REFERER'])){
        header('Location:index.php');
    }

    
    include("../core/header.php");
    include("../core/aside.php"); 
    include("../../config/database.php");

    if(!empty($_POST['tipo'])){
        $var = $_POST['tipo'];

        if(isset($_POST['fec']) && $_POST['fec']==1){
            $fechainicial = $_POST['fecha1'];
            if(!empty($_POST['fecha2'])){
                $fechafinal = $_POST['fecha2'];
            }
        }
        
        if($var=="servicio"){

            $sql = "SELECT DISTINCT(dc.id_servicio),sv.nombre_servicio FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio WHERE dc.estado=0 ORDER BY dc.id_servicio ASC";
            if($stm = $conn->prepare($sql)){                
                        $stm->execute();
                        $stm->store_result();
                        $rows = $stm->num_rows;
                        $stm->bind_result($idservicio,$nombre);                
            }

            $i=0;
            $r=0;
            if(!empty($fechainicial) && empty($fechafinal)){
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_servicio=? AND di.fecha=?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND dc.id_servicio=? AND di.fecha=?";
                if(isset($_POST['detail']) && $_POST['detail']==1){
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('is',$idservicio,$fechainicial);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('is',$idservicio,$fechainicial);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }

                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('is',$idservicio,$fechainicial);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }
                
            }else if (!empty($fechainicial) && !empty($fechafinal)) {
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_servicio=? AND di.fecha BETWEEN ? AND ?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND dc.id_servicio=? AND di.fecha BETWEEN ? AND ?";
                if(isset($_POST['detail']) && $_POST['detail']==1){
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('iss',$idservicio,$fechainicial,$fechafinal);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('iss',$idservicio,$fechainicial,$fechafinal);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                                                                            
                            }
                            $r++;
                        }
                    }

                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('iss',$idservicio,$fechainicial,$fechafinal);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }   
                }
                
            }else{
                $sql2 = "SELECT COUNT(id_datos) FROM datos_complementarios WHERE estado=0 AND id_servicio=?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia , dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND dc.id_servicio=?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('i',$idservicio);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('i',$idservicio);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('i',$idservicio);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                        }
                    }
                }
            }
            
        }elseif ($var=="tipo de constancias") {     
            $sql="SELECT DISTINCT(dc.id_constancia),c.tipo_constancia FROM datos_complementarios dc JOIN constancias c ON dc.id_constancia=c.id_constancia WHERE dc.estado=0 ORDER BY dc.id_constancia ASC";
            if($stm = $conn->prepare($sql)){                
                        $stm->execute();
                        $stm->store_result();
                        $rows = $stm->num_rows;
                        $stm->bind_result($idconstancia,$nombre);
            }

            $i=0;
            $r=0;
            if(!empty($fechainicial) && empty($fechafinal)){
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_constancia=? AND di.fecha=?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND dc.id_constancia=? AND di.fecha=?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('is',$idconstancia,$fechainicial);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('is',$idconstancia,$fechainicial);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('is',$idconstancia,$fechainicial);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }
            }else if (!empty($fechainicial) && !empty($fechafinal)) {
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_constancia=? AND di.fecha BETWEEN ? AND ?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND dc.id_constancia=? AND di.fecha BETWEEN ? AND ?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('iss',$idconstancia,$fechainicial,$fechafinal);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('iss',$idconstancia,$fechainicial,$fechafinal);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('iss',$idconstancia,$fechainicial,$fechafinal);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }

            }else{
                $sql2 = "SELECT COUNT(id_datos) FROM datos_complementarios WHERE estado=0 AND id_constancia=?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND dc.id_constancia=?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('i',$idconstancia);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('i',$idconstancia);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('i',$idconstancia);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }
                
            }

        }elseif ($var=="trabajador") {
            $sql="SELECT DISTINCT(di.id_trabajador),u.name FROM datos_iniciales di JOIN usuario u ON di.id_trabajador=u.id_user ORDER BY di.id_trabajador ASC";
            if($stm = $conn->prepare($sql)){                
                        $stm->execute();
                        $stm->store_result();
                        $rows = $stm->num_rows;
                        $stm->bind_result($idtrabajador,$nombre);
            }

            $i=0;
            $r=0;
            if(!empty($fechainicial) && empty($fechafinal)){
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_datos IN (SELECT id_datos FROM datos_iniciales WHERE id_trabajador=?) AND di.fecha=?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND di.id_trabajador=? AND di.fecha=?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('is',$idtrabajador,$fechainicial);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('is',$idtrabajador,$fechainicial);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r}); 
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('is',$idtrabajador,$fechainicial);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }
            }else if (!empty($fechainicial) && !empty($fechafinal)) {
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_datos IN (SELECT id_datos FROM datos_iniciales WHERE id_trabajador=?) AND di.fecha BETWEEN ? AND ?";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND di.id_trabajador=? AND di.fecha BETWEEN ? AND ?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('iss',$idtrabajador,$fechainicial,$fechafinal);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('iss',$idtrabajador,$fechainicial,$fechafinal);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('iss',$idtrabajador,$fechainicial,$fechafinal);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }
            }else{
                $sql2 = "SELECT COUNT(dc.id_datos) FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos WHERE dc.estado=0 AND dc.id_datos IN (SELECT id_datos FROM datos_iniciales WHERE id_trabajador=?);";
                $sql3 = "SELECT us.name, di.nombre_paciente, dc.nombre_solicitante, cs.tipo_constancia, dc.destino, dc.fecha_extension, sv.nombre_servicio  FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN usuario us ON di.id_trabajador=us.id_user JOIN constancias cs ON dc.id_constancia=cs.id_constancia WHERE dc.estado=0 AND di.id_trabajador=?";
                if(isset($_POST['detail']) && $_POST['detail']==1){                 
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('i',$idtrabajador);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;
                            if(${"stms".$r} = $conn->prepare($sql3)){
                                    ${"stms".$r}->bind_param('i',$idtrabajador);
                                    ${"stms".$r}->execute();
                                    ${"stms".$r}->store_result();    
                                    ${"rowss".$r} = ${"stms".$r}->num_rows;                       
                                    ${"stms".$r}->bind_result(${"usuario".$r},${"paciente".$r},${"soli".$r},${"type".$r},${"desti".$r},${"fechaext".$r},${"serv".$r});
                            }
                            $r++;
                        }
                    }   
                }else{
                    if($rows>0){
                        while($stm->fetch()){
                            ${"name".$i}=$nombre;
                            if(${"stm".$i} = $conn->prepare($sql2)){
                                    ${"stm".$i}->bind_param('i',$idtrabajador);
                                    ${"stm".$i}->execute();
                                    ${"stm".$i}->store_result();    
                                    ${"rows".$i} = ${"stm".$i}->num_rows;                       
                                    ${"stm".$i}->bind_result(${"total".$i}); 
                                    ${"stm".$i}->fetch();                                         
                            }
                            $i++;   
                        }
                    }
                }
            }

        }
    }

?>

<!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">REPORTES CONSTANCIAS PENDIENTES</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="contenido">
                            	<form class="form-horizontal form-variance" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Reporte Por</label>
                                        <div class="col-sm-2">
                                            <select name="tipo" id="tipo" class="form-control">
                                            	<option  value="servicio">Servicio</option>
                                            	<option  value="tipo de constancias">Tipo de Constancia</option>
                                            	<option  value="trabajador">Trabajador</option>
                                            </select>
                                        </div>              
                                        <label class="col-sm-1 control-label">Fechas</label>
                                    	<div class="col-sm-1">
                                    		<input type="checkbox" id="fec" name="fec" value="1">
                                    	</div>
                                        <label class="col-sm-1 control-label">Detallado</label>
                                        <div class="col-sm-1">
                                            <input type="checkbox" id="detail" name="detail" value="1">
                                        </div>
                                    </div> 
                                    <div class="form-group" id="hidden_fields">                                    	
                                    		<label class="col-sm-1 control-label">Inicio</label>
                                    		<div class="col-sm-2">
                                    			<input class="form-control fecha" type="text" placeholder="Fecha Inicio / Dia" id="fecha1" name="fecha1" data-date-end-date="0d">	
                                    		</div>
                                    		<label class="col-sm-1 control-label">Fin</label>
                                    		<div class="col-sm-2">
                                    			<input class="form-control fecha" type="text" placeholder="Fecha Fin" id="fecha2" name="fecha2" data-date-end-date="0d">
                                    		</div>                                    	
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-1 control-label">
                                    		<button type="submit" id="search" name="search" class="btn btn-primary">Buscar</button>
                                    	</div>
                                    </div>
                                </form>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($_POST['search']) && (!empty($_POST['tipo'])) ){
                if(isset($_POST['detail']) && $_POST['detail']==1){?>
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                                <h4>REPORTE CONSTANCIAS PENDIENTES POR <?php echo strtoupper($_POST['tipo']) ?></h4>
                            </div>
                                <div id="contenido" class="table-responsive" style="display:none">
                                        <table class="table table-striped table-condensed" id="mitable">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th class="col-md-1" style="display:none;"></th>
                                                    <?php for ($ind=0; $ind < $i ; $ind++) { ?>
                                                        <th class="col-md-1"><?php echo ${"name".$ind} ?></th>  
                                                    <?php } ?>                                            
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                    <th class="col-md-1" style="display:none;"></th>
                                                    <?php
                                                    for ($n=0; $n < $i ; $n++) { ?>
                                                        <td class="text-left"><?php echo ${"total".$n} ?></td>
                                                    <?php
                                                    }?>
                                                    </tr>
                                                    <?php                                                    
                                                    for ($w=0; $w < $i ; $w++) { 
                                                        ${"stm".$w}->close();
                                                    }
                                                ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="clear:both; margin:10px"></div>
                                    <div id="container" class="ui-container">                                       
                                </div>  
                        </div>
                        <div class="line-separator">                            
                        </div>
                        <div class="panel-body">
                            <div id="contenido" class="table-responsive">
                                <table class="table table-striped table-condensed" id="tables">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th class="col-md-2">Trabajador</th>            
                                            <th class="col-md-2">Paciente</th>                                
                                            <th class="col-md-2">Nombre Solicitante</th>
                                            <th class="col-md-2">Tipo</th>
                                            <th class="col-md-2">Destino</th>
                                            <th class="col-md-1">Fecha Extension</th>
                                            <th class="col-md-1">Servicio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for ($n=0; $n < $i ; $n++) { 
                                                if(${"rowss".$n}>0){
                                                    while (${"stms".$n}->fetch()) {                                                     
                                                    ?>
                                                        <tr>
                                                            <td class="text-left"><?php echo ${"usuario".$n} ?></td>
                                                            <td class="text-left"><?php echo ${"paciente".$n} ?></td>
                                                            <td class="text-left"><?php echo ${"soli".$n} ?></td>
                                                            <td class="text-left"><?php echo ${"type".$n} ?></td>
                                                            <td class="text-left"><?php echo ${"desti".$n} ?></td>
                                                            <td class="text-left"><?php echo ${"fechaext".$n} ?></td>
                                                            <td class="text-left"><?php echo ${"serv".$n} ?></td>                                               
                                                        </tr>
                                        <?php
                                                    }
                                                }
                                            }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                <?php 
                    }else{
                 ?>
                        <div class="panel">
                                <div class="panel-body">
                                    <div id="titulo">
                                        <h4>REPORTE CONSTANCIAS PENDIENTES POR <?php echo strtoupper($_POST['tipo']) ?></h4>
                                    </div>
                                    <div id="contenido" class="table-responsive" style="display:none;">
                                        <table class="table table-striped table-condensed" id="mitable">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th  class="col-md-1" style="display:none;"></th>
                                                    <?php for ($ind=0; $ind < $i ; $ind++) { ?>
                                                        <th class="col-md-1"><?php echo ${"name".$ind} ?></th>  
                                                    <?php } ?>                                            
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                    <th class="col-md-1" style="display:none;"></th>
                                                    <?php
                                                    for ($n=0; $n < $i ; $n++) { ?>
                                                        <td class="text-left"><?php echo ${"total".$n} ?></td>
                                                    <?php
                                                    }?>
                                                    </tr>
                                                    <?php                                                    
                                                    for ($w=0; $w < $i ; $w++) { 
                                                        ${"stm".$w}->close();
                                                    }
                                                ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="clear:both; margin:10px"></div>
                                    <div id="container" class="ui-container">
                                    </div>  
                                </div>
                        </div>                    
                <?php }
            } ?>
        </div>
    </div>
</div>
<!--main content end-->

<?php
    include("../core/footer.php");
 ?>

<script>
    window.onload = function(){document.getElementById("tipo").value = "<?=$_POST['tipo']?>" }
    
    Highcharts.chart('container', {
    data: {
        table: 'mitable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text:''
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Cantidad'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});

    $('#tables').DataTable({
        //"pagingType": "full_numbers",
        "paging": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraton registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros ",
            "infoEmpty": "No se encontraton registros",
            "infoFiltered": "(Filtrado de _MAX_ registros)",
            "paginate": {
                "first": "Primera",
                "last": "Ultima",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "search": "Buscar: "
        }
    });
</script>

<script>
	$('.fecha').datepicker({
		    todayBtn: "linked",
		    clearBtn: true,
		    language: "es",
		    format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true,
		    disableTouchKeyboard: true,
		});
 </script>
 <script type="text/javascript">
 	$(function() { 
	  var checkbox = $("#fec");
	  var hidden = $("#hidden_fields");
  
  hidden.hide();
  
  // Setup an event listener for when the state of the 
  // checkbox changes.
  checkbox.change(function() {
    // Check to see if the checkbox is checked.
    // If it is, show the fields and populate the input.
    // If not, hide the fields.
    if (checkbox.is(':checked')) {
      // Show the hidden fields.
      hidden.show();
      document.getElementById("fecha1").required=true;
      // Populate the input.
    } else {
      // Make sure that the hidden fields are indeed
      // hidden.
      hidden.hide();
      document.getElementById("fecha1").required=false;
      // You may also want to clear the value of the 
      // hidden fields here. Just in case somebody 
      // shows the fields, enters data to them and then 
      // unticks the checkbox.
       $("#hidden_field").val("");
    }
  });
});
 </script>