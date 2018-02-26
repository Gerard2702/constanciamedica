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
                <td id="numrecibo<?php echo $id_datos; ?>"><?php echo $nrecibo; ?></td>
                <td><?php echo $nombrepaciente; ?></td>
                <td><?php echo $afiliacion; ?></td>
                <td><?php echo $destinos; ?></td>
                <td><?php echo $cantidad; ?></td>
                <td><?php echo $servicio; ?></td>
                <td><a href="javascript:;" class="btn btn-info btn-sm detalle"  data-placement="left" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Ver detalle"><i class="fa fa-eye"></i></a> <a href="javascript:;" class="btn btn-success btn-sm aceptarsolicitud" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Aceptar Solicitud"><i class="fa fa-check"></i></a></td>
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
    $(".aceptarsolicitud").click(function(e) {
            e.preventDefault();
            var solicitud = $(this).data('solicitud');
            var numrecibo = $("#numrecibo"+solicitud).text();
            swal({
              title: "Desea aceptar la solicitud #"+numrecibo+"?",
              text: "",
              icon: "info",
              buttons: true,
            })
            .then((willDelete) => {
              if (willDelete) {    
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
           } else {
                
              }
            });

        });

    $(".detalle").click(function(e){
            e.preventDefault();
            var id_solicitud = $(this).data('solicitud');
            $.ajax({
            url: "verdetalle.php",
            type: 'POST',
            data: { 
                id_solicitud: id_solicitud
            },
            success: function (data) {
                $("#conten-modal").html(data);
                $("#myModal").modal('show'); 
            },
            error: function () {
                alert("UN ERROR HA OCURRIDO");
            }
        });
        });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Datos Solicitud</h4>
            </div>
            <div class="modal-body">
                <div id="conten-modal">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>