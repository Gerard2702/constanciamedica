<?php 
    $id_servicio = $_POST['id_servicio'];

    include("../../config/database.php");

    $sqlrecibidas= "SELECT datos_iniciales.id_datos,datos_iniciales.fecha,datos_iniciales.numero_recibo,datos_iniciales.afiliacion_dui,datos_iniciales.nombre_paciente,datos_iniciales.destinos,datos_iniciales.cantidad,servicios.nombre_servicio FROM datos_iniciales INNER JOIN servicios ON datos_iniciales.id_servicio=servicios.id_servicio WHERE datos_iniciales.id_estado=2 AND datos_iniciales.id_servicio=?";
    if($stmt = $conn->prepare($sqlrecibidas)){
        $stmt -> bind_param('s',$id_servicio);
        $stmt -> execute();
        $stmt -> store_result();
        $rows = $stmt->num_rows;
        $stmt -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$cantidad,$servicio);
    }

    $conn->close();

 ?>
<div id="contenido" class="table-responsive">
    <table class="table table-striped table-condensed" id="mitable">
        <thead class="thead-inverse">
            <tr>
                <th class="col-md-1 text-center">Fecha</th>
                <th class="col-md-1">N# Recibo</th>
                <th class="col-md-3">Nombre del paciente</th>
                <th class="col-md-1">Afiliacion/DUI</th>
                <th class="col-md-3">A presentar en</th>
                <th class="col-md-1">Cantidad</th>
                <th class="col-md-1">Servicio</th>
                <th class="col-md-1">Opciones</th>
            </tr>
        </thead>
        <tbody> 
        <?php 
            if($rows>0){
                while ($stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $fechacreacion; ?></td>
                <td><?php echo $nrecibo; ?></td>
                <td><?php echo $nombrepaciente; ?></td>
                <td><?php echo $afiliacion; ?></td>
                <td><?php echo $destinos; ?></td>
                <td><?php echo $cantidad; ?></td>
                <td><?php echo $servicio; ?></td>
                <td><a href="javascript:;" class="btn btn-info btn-sm verconstancia"  data-placement="left" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Ver detalle"><i class="fa fa-eye"></i></a> <a href="javascript:;" class="btn btn-success btn-sm" id="aceptarsolicitudotros" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Aceptar Solicitud"><i class="fa fa-check"></i></a></td>
            </tr>   
        <?php 
                }
            }
            $stmt->close();
        ?>    
        </tbody>
    </table>
</div>
<script>
    $("#aceptarsolicitudotros").click(function(e) {
            e.preventDefault();
            var solicitud = $(this).data('solicitud');
            $.ajax({
                url: "../class/trabajador/aceptarsolicitud.php",
                type: 'POST',
                data: { 
                    solicitud: solicitud
                },
                success: function (data) {
                    if(data=="true"){
                        location.href ="infosolicitud.php?con="+solicitud;
                    }
                },
                error: function () {
                    alert("UN ERROR HA OCURRIDO");
                }
            });
        });
</script>