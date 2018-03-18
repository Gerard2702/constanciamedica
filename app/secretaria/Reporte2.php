<?php
   
    include("../../config/database.php");    
    header('Content-Type: application/x-msexcel');
    header("Content-Disposition: attachment; filename=Control_Constancias_Canceladas.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    if(!empty($_GET['fec'])){
    	$fechau=$_GET['fec'];
    	$sql="SELECT fecha,numero_recibo,nombre_paciente,afiliacion_dui,destinos,cantidad,precio,(precio*cantidad) as total FROM `datos_iniciales` WHERE fecha=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('s',$fechau);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($fecha,$recibo,$paciente,$afiliacion,$destino,$cantidad,$precio,$total);                
            }
    }elseif(!empty($_GET['fecini']) && !empty($_GET['fecf'])){
    	$fechaini=$_GET['fecini'];
    	$fechafin=$_GET['fecf'];
    	$sql="SELECT fecha,numero_recibo,nombre_paciente,afiliacion_dui,destinos,cantidad,precio,(precio*cantidad) as total FROM datos_iniciales WHERE fecha BETWEEN ? AND ?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('ss',$fechaini,$fechafin);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($fecha,$recibo,$paciente,$afiliacion,$destino,$cantidad,$precio,$total);                
            }
    }
    $monto=0;

?>
<!DOCTYPE html>
<html>
<head>
    <meta hhtp-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body style="text-align: center">
    <div style="font-family: 'Times New Roman', Times, serif; font-size:12; font-style: inherit; color: #A9A9A9; text-align: center;"></div>
    <p><strong>CONTROL DE CONSTANCIAS CANCELADAS - HOSPITAL GENERAL</strong></p>

<table border="1" cellpadding="0" cellspacing="0">
    <th bgcolor="#A9A9A9" height="75" style="color:#000000">Fecha</th>
    <th bgcolor="#A9A9A9" height="75" style="color:#000000">N° Recibo</th>
    <th bgcolor="#A9A9A9" height="75" style="color:#000000">Nombre Paciente</th>
    <th bgcolor="#A9A9A9" height="75" width="80" style="color:#000000">N° Afiliacion / DUI</th>
    <th bgcolor="#A9A9A9" height="75" style="color:#000000">Constancia a Presentar en</th>
    <th bgcolor="#A9A9A9" height="75" style="color:#000000">Cantidad</th>
    <th bgcolor="#A9A9A9" height="75" style="color:#000000">Total</th>
    <th bgcolor="#A9A9A9" height="75" width="90" style="color:#000000">Monto Total al Mes</th>

    <?php                                                                                                                                          
                                                    if($rows>0) {
                                                        while ($stm->fetch()) {
                                                ?>
                                                        <tr>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo $fecha ?></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo $recibo ?></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo $paciente ?></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo $afiliacion ?></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo $destino ?></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo $cantidad ?></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"><?php echo "$".$total ?></td>                                                     
                                                    <?php   $monto= $monto + $total; ?>
                                                        </tr>                                                   
                                                    <?php
                                                        }?>
                                                        <tr>                                                        
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#FFFFFF" height="50" style="color:#000000"></td>
                                                        <td bgcolor="#A9A9A9" height="50" style="color:#000000"><strong><?php echo "$".$monto ?></strong></td>
                                                        </tr>   
                                                    <?php
                                                    } 
                                                    $stm->close();
                                                ?> 
    
</table>
</body>
</html>