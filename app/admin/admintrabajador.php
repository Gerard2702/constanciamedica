<?php
    $title = "ADMINISTRAR TRABAJADOR";
    
    include("../core/header.php");

    include("../core/aside.php");
?>
 <!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">ADMINISTRAR TRABAJADORES</h4>  
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
                                            <th class="col-md-1">Partida</th>
                                            <th class="col-md-7">Producto</th>
                                            <th class="col-md-1 text-right">Cantidad</th>
                                            <th class="col-md-2 text-right">Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-left">2</td>
                                            <td class="text-left">3</td>
                                            <td class="text-right">4</td>
                                            <td class="text-right"><a href="javascript:;" class="btn btn-default btn-sm "><i class="fa fa-pencil-square-o"></i> Ver Detalle</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">232</td>
                                            <td class="text-left">2312</td>
                                            <td class="text-left">2323</td>
                                            <td class="text-right">2323</td>
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
    $('#mimenu li').removeClass('active');
    $('#mimenu li ul').removeClass('nav-sub--open');
    $('#mimenu li ul li').removeClass('active');
    $('#trabajadores').addClass('active');
    $('#trabajadores ul').addClass('nav-sub--open');
    $('#trabajadores ul #admin').addClass('active');

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
