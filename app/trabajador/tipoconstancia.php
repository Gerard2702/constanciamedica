<?php 

	switch ($_POST['id_tipoconstancia']) {
		case '1':
?>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Permaneciendo ingresado hasta el Año/Mes/Dia</label>
	        	<input class="form-control input-sm fecha" type="text" placeholder="Permanecio ingresado hasta el ..." name="permaneciofecha" required="">
	    	</div>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Con diagnostico</label>
	        	<textarea class="form-control" name="diagnosticofinal" id="" cols="30" rows="3"></textarea>
	    	</div>
	    </div>
	</div>
<?php		
			break;
		case '2':
?>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Permanecio ingresado a la fecha con diagnostico</label>
	        	<textarea class="form-control" name="diagnosticoingreso" id="" cols="30" rows="3"></textarea>
	    	</div>
	    </div>
	</div>
<?php
			break;
		case '3':
?>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Permaneciendo ingresado hasta el Año/Mes/Dia</label>
	        	<input class="form-control input-sm fecha" type="text" placeholder="Permanecio ingresado hasta el ..." name="permaneciofecha" required="">
	    	</div>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Fallecimiento por</label>
	        	<textarea class="form-control" name="fallecimientopor" id="" cols="30" rows="3"></textarea>
	    	</div>
	    </div>
	</div>
<?php
			break;
		case '4':
?>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Permaneciendo hasta fecha de alta Año/Mes/Dia</label>
	        	<input class="form-control input-sm fecha" type="text" placeholder="" name="permaneciofecha" required="">
	    	</div>
	    </div>
	    <div class="col-md-5 col-md-offset-1 ">
	    	<div class="form-group">
	        	<label>Partida de defuncion extendida Año/Mes/Dia</label>
	        	<input class="form-control input-sm fecha" type="text" placeholder="" name="partidafecha" required="">
	    	</div>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-6 ">
	    	<div class="form-group">
	        	<label>Lugar de extension de partida</label>
	        	<input class="form-control input-sm" type="text" placeholder="" name="lugarextension" required="" autocomplete="off">
	    	</div>
	    </div>
	    <div class="col-md-5 col-md-offset-1 ">
	    	<div class="form-group">
	        	<label>Fallecimiento en domicilio Año/Mes/Dia</label>
	        	<input class="form-control input-sm fecha" type="text" placeholder="" name="domiciliofecha" required="">
	    	</div>
	    </div>
	</div>
<?php
			break;
		default:
			# code...
			break;
	}

 ?>
 <script>
 	$('.fecha').datepicker({
		    todayBtn: "linked",
		    format: 'yyyy-mm-dd',
		    clearBtn: true,
		    language: "es",
		    autoclose: true,
		    todayHighlight: true,
		    disableTouchKeyboard: true,
	});
 </script>