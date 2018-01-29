<?php
    $title = "ADMINISTRAR MEDICO";
    
    include("../core/header.php");

    include("../core/aside.php");
?>
 <!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">ADMINISTRAR MEDICOS</h4>  
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
                                            <th class="col-md-5">Nombre</th>
                                            <th class="col-md-5">Servicio</th>
                                            <th class="col-md-2">Status</th>
                                            <th class="col-md-2 text-right">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-left">Jose Enrique Martines Hernandez</td>
                                            <td class="text-left">Medicina3</td>
                                            <td class="text-left">Inactivo</td>
                                            <td class="text-right"><a href="javascript:;" class="btn btn-default btn-sm "><i class="fa fa-pencil-square-o"></i> Ver Detalle</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-left">Enrique Alejo Ortiz Peña</td>
                                            <td class="text-left">Ortopedia</td>
                                            <td class="text-left">Activo</td>
                                            <td class="text-right"><a href="javascript:;" class="btn btn-default btn-sm "><i class="fa fa-pencil-square-o"></i> Ver Detalle</a></td>
                                        </tr>
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
