<?php
    $title = "ADMINISTRAR DIRECTOR";
    $mndirector = "active";
    include("../core/header.php");

    include("../core/aside.php");

    include("../../config/database.php");


    $sql = "SELECT director.id_director,director.nombre,status.nombre_status,servicios.nombre_servicio
            FROM ((director
            INNER JOIN status ON director.id_status = status.id_status)
            INNER JOIN servicios ON director.id_servicio = servicios.id_servicio);";

    if ($stmt  = $conn->prepare($sql)) {
        $stmt ->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt ->bind_result($id, $nombre, $status, $servicio);    
    }
    $conn->close();
?>
 <!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">ADMINISTRAR DIRECTOR</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4>Resultados</h4>
                            </div>
                            <div id="contenido" class="table-responsive">
                            	<table class="table table-striped table-condensed" id="mitable">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th class="col-md-1 text-center">#</th>
                                            <th class="col-md-7">Nombre</th>
                                            <th class="col-md-2">Servicio</th>
                                            <th class="col-md-1">Status</th>
                                            <th class="col-md-1 text-right">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?<?php 
                                            if($rows>0) {
                                                while ($stmt->fetch()) {
                                        ?>
                                                <tr>
                                                <td class="text-center"><?php echo $id ?></td>
                                                <td class="text-left"><?php echo $nombre ?></td>
                                                <td class="text-left"><?php echo $servicio ?></td>
                                                <td class="text-left"><span class="label label-default"><?php echo $status ?></span></td>
                                                <td class="text-right"><a href="javascript:;" class="btn btn-default btn-sm verdirector"  data-placement="left" data-director="<?php echo $id ?>" ><i class="fa fa-eye"></i> Editar</a></td>
                                                </tr>    
                                        <?php        
                                                }
                                            }
                                            $stmt->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--main content end-->

<?php
    include("../core/footer.php");
 ?>
 <script>

    $('#mitable').DataTable({
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


    $(document).on("click", ".verdirector", function (e) {
        e.preventDefault();
        var iddirector = $(this).data('director');
        $.ajax({
            url: "modalverdirector.php",
            type: 'POST',
            data: { 
                iddirector: iddirector
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
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Datos Director</h4>
            </div>
            <div class="modal-body">
                <div id="conten-modal">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>