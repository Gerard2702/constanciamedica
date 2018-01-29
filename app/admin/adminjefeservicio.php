<?php
    $title = "ADMINISTRAR JEFE DE SERVICIO";
    
    include("../core/header.php");

    include("../core/aside.php");

    include("../../config/database.php");


    $sql = "SELECT jefe_servicio.id_jefe,jefe_servicio.nombre,status.nombre_status,servicios.nombre_servicio
            FROM ((jefe_servicio
            INNER JOIN status ON jefe_servicio.id_status = status.id_status)
            INNER JOIN servicios ON jefe_servicio.id_servicio = servicios.id_servicio);";

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
        <h4 class="margin0">ADMINISTRAR JEFES DE SERVICIO</h4>  
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
                                                <td class="text-right"><a href="javascript:;" class="btn btn-default btn-sm " data-toggle="tooltip" data-placement="left" title="" data-original-title="Ver"><i class="fa fa-eye"></i></a>  <a href="javascript:;" class="btn btn-default btn-sm " data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></a></td>
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

</script>
