<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Menu</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/estilos.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/funciones.js"></script>
	<script src="js/editar.js"></script>
	<script src="js/eliminar.js"></script>
	<!--<script src="js/registrarPrecios.js"></script>-->
	<!--<script src="js/notas.js"></script>-->
	<style>
	    h1{
	    	text-align: center;
	    }
	    th{
	    	font-size: 24px;
	    }
	    td{
	    	font-size: 20px;
	    }
	    label.error{
			float: none; 
			color: red; 
			padding-left: .5em;
		    vertical-align: middle;
		    font-size: 12px;
		}
		form, label{
			font-size: 14px;
			font-weight: bold;
		}
	    p{
	    	color: #df0024;
	    	font-size: 20px;
	    }
	    textarea{
	    	/*resize: none;*/
	    	font-size: 16px;
	    	width: 250px;
	    }
	    #aviso{
	    	float: left;
	    	margin-left: 29%;
	    	position: fixed;
	    	top: 18%;
	    	display: block;
	    	background: rgba(255,255,255,0.9);
	    	box-shadow: 1px 1px 5px #000;
	    	width: 45%;
	    	height: 40%;
	    	border-radius: 25px;
	    }
	    #cerrar{
	        padding: 35px; 
	    	/* margin: auto; */
	    	text-align: right;
	    	font-weight: bold;
	    	font-size: 38px;
	    }
	    #fondo{
	    	background: #feffff;
	       	/* box-shadow:inset -3px -2px 37px #000000; */
	    }
	    #validate2{
		    margin-left: 17%;
		}
		#mensaje{
	        float: left;
	        margin-left: 480px;
	        position: fixed;
       	}
       	#mensajeError{
       		float: left;
	        margin-left: 680px;
	        position: fixed;
       	}
       	#ver{
       		margin-left: 43%;
       		margin-top: 6%;
       	}
	    .notas{
	    	margin-left: 80px;
	    	position: fixed;
	    	top: 190px;
	    }
        .hero-unit{
        	margin-top: 30px;
        	text-align: center;
        	background-image: url('img/gim2.jpg');
        }
	</style>

	<script>
      $(document).ready(function(){

      	var menu = $('#bloque');
		var contenedor = $('#bloque-contenedor');
		var menu_offset = menu.offset();
		  // Cada vez que se haga scroll en la página
		  // haremos un chequeo del estado del menú
		  // y lo vamos a alternar entre 'fixed' y 'static'.
		  menu.css("display", "none");
		$(window).on('scroll', function() {
		    if($(window).scrollTop() > menu_offset.top) {
		      menu.addClass('bloqueFijo');
		      menu.css("display", "block");
		    } else {
		      menu.removeClass('bloqueFijo');
		      menu.css("display", "none");
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

		
         /*____________________________________________-*/
         $('.cerrar').click(function(){
         	 //$('#aviso').css("display","none");
         	$('#aviso').fadeOut("slow");

         	/*var data = 'verEstu='+'bien';
             console.log(data);
      	    $.post('includes/acciones.php',data , function(resp){
			  	   	  //console.log(resp);
			  	$('#verEstu').empty();//limpiar los datos
			  	$('#verEstu').html(resp);
			  	console.log(resp);
	      	    console.log('poraca paso joder....');
			},'html');
         	// alert("Bien");*/
         });

           /*_______________________________________________*/
	    $('#buscar').live('keyup',function(){
		  	var data = 'queryMenu='+$(this).val();
		  	//console.log(data);
      	    if(data =='queryMenu=' ){
      	       	$.post('includes/acciones.php',data , function(resp){
			  	   	//console.log(resp);
			  	   	$('#verEstu').empty();//limpiar los datos
			  	   	$('#verEstu').html(resp);
	      	    	console.log('poraca paso joder....');
			  	},'html');
      	    }else{
      	       	$.post('includes/acciones.php',data , function(resp){
			  	   	  //console.log(resp);
			  	   	$('.pagination').remove();
			  	   	$('#verEstu').empty();//limpiar los datos
			  	   	$('#verEstu').html(resp);
	      	    	console.log(resp);
			  	},'html');
      	    }
		});

         /*______________________________________________*/
        $("#menuOpen").mouseout(function(){
            //$("#formMenu").removeClass('open');
	    }).mouseover(function(){
	        $("#formMenu").addClass('open');
	        $("#foco").focus();
	    });

	   /*________________________________________________________________________*/
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

	  });//cierre del document
	</script>
	<?php
      session_start();
      if(isset($_SESSION['id_user'])){
            $user = $_SESSION['nombre'];
      }else{
      	header('Location: index.php');
      }
	?>
</head>
<body>
	<header>
		<div class="navbar navbar-fixed-top navbar-inverse">
			<div class="navbar-inner">
				<div class="container" >
					<a  class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a href="menu.php" class="brand">Nombre del Gim</a>
					<div class="nav-collapse collapse">
						<ul class="nav" >
							<li class="divider-vertical"></li>
							<li class="active"><a href="#"><i class="icon-home icon-white"></i>Inicio</a></li>
							<li class="divider-vertical"></li>
								<li id="formMenu" class="dropdown">
									<a id="menuOpen" class="dropdown-toggle" data-toggle="dropdown">
										Registrar
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu pull-right">
										<div class="span4" id="registrarNew">
											<form action="includes/acciones.php" method="post" id="registrarEstudiante" style="margin-left: 30px;" class="limpiar">
												<label>N° Identificación:</label>
												<input type="text" name="codigo" id="foco" autofocus required>
												<label>Nombre:</label>
												<input type="text" name="nombre" required/>
												<label>Edad:</label>
												<input type="text" name="edad" required/>
												<label>Peso - Kg:</label>
												<input type="text" name="peso" required/>
												<label>Altura - M:</label>
												<input type="text" name="altura" required/>
												<label>Fecha Vencimiento:</label>
												<input type="date" name="fecha2" required/>
												<label>Pago:</label>
												<input type="text" name="pago" value="0"/>
												<label>Condición:</label>
												<select name="condicion" id="recar">
							    					<option value="No Pago">No Pago</option>
							    					<option value="Pago">Pago</option>
							    					<option value="Abono">Abono</option>
							    				</select>
							    				<input type="hidden" name="registrarEstudiante">
							    				<button type="submit" class="btn btn-success">Registrar</button>
											</form>
										</div>
									</ul>
								</li>
							<li class="divider-vertical"></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Clientes
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="includes/actualizarDatos.php">Actualizar Datos Personales</a></li>
									<li><a href="includes/actualizarTiempo.php">Actualizar Tiempo</a></li>
									<li><a href="includes/pagoTiempo.php">Deben Pagar</a></li>
								</ul>
							</li>
							<li class="divider-vertical"></li>
							<li><a href="includes/reporte.php"><i class="icon-book icon-white"></i> Reporte</a></li>
							<li class="divider-vertical"></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-user icon-white"></i> <?php echo $user; ?> <!--Mostramoe el user logeado -->
								    <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="includes/registrarUsuario.php"><i class="icon-plus-sign"></i> Registrar Usuario</a></li>
									<li><a href="includes/editarUsuario.php"><i class="icon-wrench"></i> Configuración de la cuenta</a></li>
									<li class="divider"></li>
									<li><a href="includes/cerrar.php">Cerrar Sesion</a></li>
								</ul>
							</li>
							<li class="divider-vertical"></li>
							<?php 
								date_default_timezone_set('America/Bogota'); 
						        $fecha = date("Y-m-d");
						        echo '<li><a href="#" style="font-weight: bold;">Fecha: '.$fecha.'</a></li>';
					        ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
		<aside id="mensaje"></aside><!--menssaje de exito del registro o de error-->
		<aside id="mensajeError"></aside><!--menssaje de exito del registro o de error-->

	<section>
		<div class="container">
			<div class="hero-unit">
				<br><br><br><br><br><br><br>
			</div>
		</div>
	</section>

   <div class="span2"> <div id="bloque"><aside class="well" id="bloque-contenedor" style="text-align: center; "><a href="#" id="IrInicio">Volver Arriba</a></aside></div></div> 

    <!--Primer articulo... -->
	<article class="container well" id="fondo">
		<input type="text" name="buscar" id="buscar" class="search-query" placeholder="Buscar Nombre" autofocus>
		<div class="row">         
			<h1>Fechas de vencimientos y Pagos</h1><br>
			<div class="span12">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Fecha Inicial</th>
							<th>Fecha Vencimiento</th>
							<th>Pago</th>
							<th>Condición</th>
							<th>Dias</th>
						</tr>
					</thead>
					<tbody id="verEstu">
						<?php 
						   require_once('includes/funciones.php');
						   $objeto = new funciones();
						   $objeto->verEstudiantes();
						?>
					</tbody>
				</table>
				<div id="cargando" style="display: none;"><img src="img/loader.gif" alt=""></div>
		        <div id="paginacion">
		    	 	 <?php 
		    	 	  require_once('includes/funciones.php');
		    	 	  $objeto = new funciones();
		    	 	  $objeto->paginacionEstudianteMenu();
			    	 ?>
		    	</div>
			</div>
		</div>
		<div class="row">
			
		</div>
	</article>

     <!--Codigo para modificar pago-->
     <div class="hide" id="editarPago" title="Editar Registro">
     	<form action="includes/acciones.php" method="post">
     		<input type="hidden" id="id_registro" name="id_registro" value="0">
     			<label>Nombre:</label>
				<input type="text" name="nombre" id="nombre" disabled/>
     			<label>Pago:</label>
				<input type="text" name="pago" id="pago" autofocus/>
				<label>Condición:</label>
				<select name="condicion" id="con">
					<option value="No Pago">No Pago</option>
					<option value="Pago">Pago</option>
					<option value="Abono">Abono</option>
				</select>
				<input type="hidden" name="modificarPago">
				<button id="modificarPago" class="btn btn-success">Modificar</button>
				<button id="cancelar" class="btn btn-danger">Cancelar</button>
     	</form>
     </div>

    <!--Aca va el codigo para eliminar-->
    <div class="hide" id="deleteReg" title="Eliminar Estudiante">
	    <form action="includes/acciones.php" method="post">
	    	<fieldset id="datosOcultos">
	    		<input type="hidden" id="id_delete" name="id_delete" value="0"/>
	    	</fieldset>
	    	<div class="control-group">
	    		<label for="activoElim" class="alert alert-danger">
	    		    <strong>Esta seguro de Eliminar este estudiante</strong><br>
	    		</label>
	    		<input type="hidden" name="deleteEstudianteMenu"/> 
			    <button type="submit" class="btn btn-success">Aceptar</button>
			    <button id="cancelar" name="cancelar" class="btn btn-danger">Cancelar</button>
	    	</div>
	    </form>
	</div>
	<!--vencimiento de tiempo en pago de los clientes o gimnastas-->
	<?php 
		require_once('includes/funciones.php');
		$objeto = new funciones();
		if($objeto->verificar()){
			?>

			<div id="aviso">
				<div id="cerrar"><a class="btn btn-inverse cerrar">X</a></div>
				<h1 style='color: #df0024;'>Clientes que deben Pagar</h1>
				<a href="includes/pagoTiempo.php" id="ver" class="btn btn-inverse btn-large cerrar">VER</a>
			</div>
	<?php
		}
	?>
	 
	<footer>
		<h2 id="pie"><img src="img/copyright.png" alt="Autor"> John Andrey Serrano - 2013</h2>
		<div id="pie"> <br>
			<p>Gim Version 1.0</p>
		</div>
	</footer>
</body>
</html>