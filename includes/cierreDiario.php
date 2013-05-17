<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Cierre del Dia</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="../css/estilos.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="../js/jquery.validate.js"></script>
	<script src="../js/funciones.js"></script>
	<script src="../js/editar.js"></script>
	<script src="../js/calculos.js"></script>
	<script src="../js/eliminar.js"></script>
	<script src="../js/bootstrap.js"></script>
	<!--<script src="../js/editarCierre.js"></script>-->
	<!--<script src="../js/calcularCierre.js"></script>-->
</head>
<body>
	<style>
		h1{
			text-align: center;
		}
		label.error{
			float: none; 
			color: red; 
			padding-left: .5em;
		    vertical-align: middle;
		    font-size: 12px;
		}
		p{
	    	color: #df0024;
	    	font-size: 20px;
	    	text-align: right;
	    }
	    tr,td{
	    	font-size: 20px;
	    }
		#fondo{
			background: #feffff;
		}
		#formulario{
			background: #feffff;
		}
        .hero-unit{
        	margin-top: 30px;
        	text-align: center;
        	background-image: url('../img/Tarjeta_mario3.png');
        }
	</style>	
	<script>
      $(document).ready(function() {
		  var menu = $('#menu');
		  var contenedor = $('#menu-contenedor');
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
		    $('#foco').focus();
		  });  	 

		  /*_________________________________*/
		  $(window).scroll(function(){
		  	if($(window).scrollTop() >= $(document).height() - $(window).height()){
		            //console.log("has llegado al final de la pagina");
		       	if($('.pagination ul li.next a').length){
			  		//alert("poraca apso ");
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
				  	   $('.pagination').remove();//removemos la clase paginacion para que no me vuelva a cargar datos repetidos
			    } 		
			}
		  
		  });//fin del scroll
          /*________________________________*/
            $('#arriba').click(function () {
		       $('html, body').animate({
		           scrollTop: '0px'
		       },
		       1500);
		       //return false;
		   });

	  });//fin de document
	</script>
	<?php
      session_start();
      if(isset($_SESSION['id_user'])){
           $user = $_SESSION['nombre'];
      }else{
      	header('Location: ../index.php');
      }
	?>
	
	<header class="container">
		<div class="hero-unit">
			<br><br><br><br><br><br><br>
		</div>
	</header>

	<article class="container well" id="fondo">
		<div class="navbar" id="menu-contenedor">
			<div class="navbar-inner" id="menu">
				<div class="container">
					<a  class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a href="../menu.php" class="brand">LaRed.Com</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li><a href="../menu.php"><i class="icon-home"></i>Home</a></li>
							<li><a href="internet.php">Internet</a></li>
							<li><a href="recargas.php">Recargas</a></li>
							<li><a href="minutos.php">Minutos</a></li>
							<li><a href="vitrina.php">Vitrina</a></li>
							<li class="active"><a href="#" id="arriba">Cierre</a></li>
							<li><a href="gastos.php"><i class="icon-bookmark"></i>Gastos</a></li>
							<li><a href="reporte.php"><i class="icon-book"></i>Reportes</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-user"></i> <?php echo $user; ?> <!--Mostramoe el user logeado -->
								    <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="registrarUsuario.php"><i class="icon-plus-sign"></i> Registrar Usuario</a></li>
									<li><a href="editarUsuario.php"><i class="icon-wrench"></i> Configuración de la cuenta</a></li>
									<li class="divider"></li>
									<li><a href="cerrar.php">Cerrar Sesion</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
         <h1>Cierre del Dia </h1><br><br>
         <div id="mensajeCalculo"></div><!--Mensaje de exito o de error del calculo realizado-->
		 <div class="mensaje"></div><!--Mensaje de exito del dato modificado-->
		 <div id="mensaje"></div><!--mensaje de exito o de error al realizar cierre-->
		<div class="tabbale tabs-left well" id="fondo">
			<ul class="nav nav-tabs">
				<li  class="active"><a href="#tab1" data-toggle="tab" id="clic"> <strong>Hacer Cierre</strong></a></li>
				<li><a href="#tab2" data-toggle="tab"><strong>Ver Cierres</strong></a></li>
				<li><a href="#tab3" data-toggle="tab"><strong>Calcular Cierres</strong></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<div class="span3 well" id="fondo">
						<?php  date_default_timezone_set('America/Bogota');
                                           $fecha = date("Y-m-d");
                                           $dia = date("l");
                                           if($dia=="Monday"){
                                           	echo "<strong>Hoy es Lunes / </strong>";
                                           	$dia = "Lunes";
                                           }else if($dia=="Tuesday"){
                                           	echo "<strong>Hoy es Martes / </strong>";
                                           	$dia = "Martes";
                                           }else if($dia=="Wednesday"){
                                           	echo "<strong>Hoy es Miercoles / </strong>";
                                           	$dia = "Miercoles";
                                           }else if($dia=="Thursday"){
                                           	echo "<strong>Hoy es Jueves / </strong>";
                                           	$dia = "Jueves";
                                           }else if($dia=="Friday"){
                                           	echo "<strong>Hoy es Viernes / </strong>";
                                           	$dia = "Viernes";
                                           }else if($dia=="Saturday"){
                                           	echo "<strong>Hoy es Sabado / </strong>";
                                           	$dia = "Sabado";
                                           }else if($dia=="Sunday"){
                                           	echo "<strong> Hoy es Domingo / </strong>";
                                           	$dia = "Domingo";
                                           }
                                           echo $fecha;?><br><br>
						<form action="acciones.php" method="post" id="cierre" class="limpiar">
							<label for="dinero">Dinero</label>
							<input type="text" name="dinero" id="foco" required autofocus>
							<label for="fecha">Fecha</label>
							<input type="date" name="fecha">
							<input type="hidden" name="cierre"><br>
							<button type="submit" name="cierre" class="btn btn-inverse">Hacer Cierre</button>
						</form>
					</div>
					<div class="span5">
						<ul class="thumbnails" style="margin-left: 15px;">
		    				<li class="span5">
		    					<a href="#" class="thumbnail">
		    			           <img src="../img/Tarjeta_mario3.png" alt="Tarjeta">
		    					</a>
		    				</li>
    					</ul>
					</div>
				</div>
				<!-- Seccion numero Dos-->
				<div class="tab-pane" id="tab2">
					<div class="span7">
						 <table class="table table-hover table-bordered">
						 	<thead>
						 		<tr>
						 			<th>Dinero</th>
						 			<th>Dia</th>
						 			<th>Fecha</th>
						 		</tr>
						 	</thead>
						 	<tbody id="resul">
						 		<?php
						 		  require_once('funciones.php');
						 		  $objeto = new funciones();
						 		  $objeto->verCierres();
						 		?>
						 	</tbody>
						 </table>
						 <div>
						 	<div id="cargando" style="display: none;"><img src="../img/loader.gif" alt=""></div>
							<?php
							 	require_once('funciones.php');
							 	$objeto = new funciones();
							    $objeto->paginacionCierre();
							?>
						 </div>
					</div>
					<div class="span4">
  					<!-- Aca va el codigo del modal para modificar los datos-->
						<div class="hide" id="formulario" title="Editar Cierre">
							<form action="acciones.php" method="post">
					     		<input type="hidden" id="id_registro" name="id_registro" value="0">
					     		<div class="control-group">
					     			<label for="nombre" class="control-label">Dia</label>
					     			<div class="controls">
					     				<input type="text" name="dia" id="dia">
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
					     				 <input type="hidden" name="editCierre">
					     				<button id="bienCierre" class="btn btn-success">Modificar</button>
					     			</div>
					     		</div>
					     	</form>
						</div>
					</div>
				</div>
				 <!--Aca va el codigo para eliminar-->
			    <div class="hide" id="deleteReg" title="Eliminar Cierre">
				    <form action="acciones.php" method="post">
				    	<fieldset id="datosOcultos">
				    		<input type="hidden" id="id_delete" name="id_delete" value="0"/>
				    	</fieldset>
				    	<div class="control-group">
				    		<label for="activoElim" class="control-label">
				    		    <div class="alert alert-danger">
				    		    	<strong>Esta seguro de Eliminar este Cierre</strong>
				    		    </div>
				    		</label>
					    	<div class="controls">
					    		<input type="hidden" name="deleteCierre"/> 
					    		<button type="submit" class="btn btn-success">Aceptar</button>
					    		<button id="cancelar" name="cancelar" class="btn btn-danger">Cancelar</button>
					    	</div>
				    	</div>
				    </form>
				</div>

                <!-- Seccion numero Tres-->
                <div class="tab-pane" id="tab3">
                	<div class="span3 well" id="calculo" style="background: #feffff;">
						<form action="acciones.php" method="post">
							<label for="fecha" id="fuente">Fecha Inicial</label>
							<input type="date" name="fecha1">
							<label for="fecha2" id="fuente">Fecha Final</label>
							<input type="date" name="fecha2">
							<input type="hidden" name="calcularCierre"><br><br>
							<button type="submit" name="calcularCierre" id="calcularCierre" class="btn btn-success">Calcular</button>
						</form>
					</div>
					<div class="span5 well" id="resultado" style="background: #feffff;">
						<h3 class="well"> Calculo: </h3>
					</div>
                </div>
			</div><!--Final de tab del contenido -->
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