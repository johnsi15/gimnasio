<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>VitrinaConcepto</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/smoothness/jquery-ui.css">
	<!-- <link rel="stylesheet" href="../css/estilos.css"> -->
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="../js/modificar.js"></script>
	<script src="../js/eliminar.js"></script>
	<script src="../js/bootstrap.js"></script>
	<style>
		body{
		   background: rgba(73, 59, 42, 0.8);	
		}
		h1{
			text-align: center;
		}
		th{
			font-size: 23px;
		}
		td{
			font-size: 18px;
		}
		p{
	    	color: #df0024;
	    	font-size: 20px;
	    	text-align: right;
	    }
		#fondo{
			background: #feffff;
		}
        .hero-unit{
        	margin-top: 30px;
        	text-align: center;
        	background-image: url('../img/Tarjeta_mario3.png');
        }
        .menu-fijo {
		    position: fixed;
		    top: 0;
		    width: 145px;
		}
        .span2 aside{
           font-size: 17px;
        }
	</style>
	<script>
      $(document).ready(function() {
		  var menu = $('#bloque');
		  var contenedor = $('#bloque-contenedor');
		  var menu_offset = menu.offset();
		  // Cada vez que se haga scroll en la página
		  // haremos un chequeo del estado del menú
		  // y lo vamos a alternar entre 'fixed' y 'static'.
		  $(window).on('scroll', function() {
		    if($(window).scrollTop() > menu_offset.top) {
		      menu.addClass('menu-fijo');
		    } else {
		      menu.removeClass('menu-fijo');
		    }
		  });

		  /*_________________________________________*/
		  $(window).scroll(function(){
		  	if($(window).scrollTop() >= $(document).height() - $(window).height()){
		  		if($('.pagination ul li.next a').length){
			  		$('#cargando').show();
			  		 /*_____________________________________*/
					$.ajax({
					  	type: 'GET',
					  	url: $('.pagination ul li.next a').attr('href'),
					  	success: function(html){
					  	 		//console.log(html);
					  	 	var nuevosGastos = $(html).find('table tbody'),
					  	 		nuevaPag     = $(html).find('.pagination'),
					  	 		tabla        = $('table');
					  	    tabla.find('tbody').append(nuevosGastos.html());
					  	 	tabla.after(nuevaPag.hide());
					  	 	$('#cargando').hide();
					  	}
					});
					  $('.pagination').remove();
				}
		  	}

		  });

		  /*____________________________________________________-*/
		   $('#IrInicio').click(function () {
		       $('html, body').animate({
		           scrollTop: '0px'
		       },
		       1500);
		           $('#buscar').focus();
		       //return false;
		   });

		  /*________________________________________*/
		  $('#buscar').live('keyup',function(){
		  	   var data = 'buscarVitrina='+$(this).val();
		  	     //console.log(data);
      	       if(data =='buscarVitrina='){
      	       	   $.post('acciones.php',data , function(resp){
			  	   	  //console.log(resp);
			  	   	  $('#result').empty();//limpiar los datos
			  	   	  $('#result').html(resp);
	      	    	  console.log('poraca paso joder....');
			  	   },'text');
      	       }else{
      	       	  $.post('acciones.php',data , function(resp){
			  	   	  //console.log(resp);
			  	   	  $('.pagination').remove();
			  	   	  $('#result').empty();//limpiar los datos
	      	    	  $('#result').html(resp);//mandamos los nuevos datos..
			  	   },'text');
      	       }
		  });

	  });//cierre del document...
	</script>
</head>
<body>
	<?php
      session_start();
      if(isset($_SESSION['id_user'])){
		   /*if(isset($_GET["pagina"])){
		   	    $num_pag = $_GET["pagina"];
		   }else{
		    	$num_pag = 1;
		   }*/
      }else{
      	header('Location: ../index.php');
      }
	?>
	<header class="container">
		<div class="hero-unit">
			<br><br><br><br><br><br><br><br>
		</div>
	</header>
     <!-- Aca va el codigo del modal para modificar los datos-->
    <div class="hide" id="editarRegistro" title="Editar Registro">
     	<form action="acciones.php" method="post">
     		<input type="hidden" id="id_registro" name="id_registro" value="0">
     		<div class="control-group">
     			<label for="nombre" class="control-label">Nombre</label>
     			<div class="controls">
     				<input type="text" name="nombre" id="nombre" required autofocus>
     			</div>
     		</div>
     		<div class="control-group">
     			<label for="dinero" class="control-label">Dinero</label>
     			<div class="controls">
     				<input type="text" name="dinero" id="dinero">
     			</div>
     		</div>
     		<div class="control-group">
     			<label for="gurdar" class="control-label"></label>
     			<div class="controls">
     				 <input type="hidden" name="editConcepto">
     				<button type="submit" class="btn btn-success">Modificar</button>
     			</div>
     		</div>
     	</form>
    </div>
    <!--Aca va el codigo para eliminar-->
    <div class="hide" id="deleteReg" title="Eliminar Concepto">
	    	<form action="acciones.php" method="post">
	    		<fieldset id="datosOcultos">
	    			<input type="hidden" id="id_delete" name="id_delete" value="0"/>
	    		</fieldset>
	    		<div class="control-group">
	    			<label for="activoElim" class="control-label">
	    		    	<div class="alert alert-danger">
	    		    		<strong>Esta seguro de Eliminar este Concepto</strong>
	    		    	</div>
	    		    </label>
	    		    <div class="controls">
	    		        <input type="hidden" name="deleteConcepto"/> 
	    		        <button type="submit" class="btn btn-success">Aceptar</button>
	    		        <button id="cancelar" name="cancelar" class="btn btn-danger">Cancelar</button>
	    		    </div>
	    		</div>
	    	</form>
	    </div>
     
	<article class="container well" id="fondo">
			<input type="text" name="buscar" id="buscar" class="search-query" placeholder="buscar" autofocus>
		<div class="row">
			<aside><h1>Vitrina Por Concepto</h1></aside><br><br>
			<div class="span2"> <div id="bloque"><aside class="well" id="bloque-contenedor" style="text-align: center;"><a href="#" id="IrInicio">LaRed.Com</a></aside></div></div> 
		    <div class="span8">
		    	<div class="mensaje"></div>
		    	<table class="table table-hover table-bordered">
		    		<thead>
		    			<tr>
		    				<th>Concepto</th>
		    				<th>Dinero</th>
		    				<th>Tipo</th>
		    				<th>Fecha</th>
		    			</tr>
		    		</thead>
		    		<tbody id="result">
		    			<?php 
		    			     require_once('funciones.php');
		    	 			 $objeto = new funciones();
         			 		 $objeto->verVitrina();
		    			?>
		    		</tbody>
		    	</table>
		    	 <div id="cargando" style="display: none;"><img src="../img/loader.gif" alt=""></div>
		    	 <div id="paginacion">
		    	 	 <?php 
		    	 	  require_once('funciones.php');
		    	 	  $objeto = new funciones();
		    	 	  $objeto->paginacionVitrina();
			    	 ?>
		    	 </div>
		    </div>
		</div>
		<div class="row">
			
		</div>
	</article>

	<footer class="container well">
		<div class="span7">
		   <h2><img src="../img/copyright.png" alt="Autor"> John Andrey Serrano - 2013</h2>
		</div>
		<div class="span4"> <br>
			<p>Lared.com Version 3.0</p>
		</div>
	</footer>
</body>
</html>