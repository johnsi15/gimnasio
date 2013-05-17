<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Reportes</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/estilos.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/buscar.js"></script>
	<script src="../js/calculos.js"></script>
	<!--<script src="../js/calcularReporte.js"></script>-->
	<style>
	    body{
	    	font-family: "Helvetica Neue", "Helvetica", Arial, Verdana, sans-serif;
	    }
		h1{
			text-align: center;
		}
		tr{
			font-size: 21px;
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
		#fuente{
			font-size: 23px;
		}
		#titulo{
			text-align: center;
			font-size: 32px;
			color: #ba0d0d;
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
		  });
	  });
	</script>
	<?php
      session_start();
      if(isset($_SESSION['id_user'])){
         $user = $_SESSION['nombre'];
      }else{
      	header('Location: ../index.php');
      }
	?>
</head>
<body>
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
							<li><a href="cierreDiario.php">Cierre</a></li>
							<li><a href="gastos.php"><i class="icon-bookmark"></i>Gastos</a></li>
							<li class="active"><a href="reporte.php"><i class="icon-book"></i>Reportes</a></li>
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
		<div class="row">
			<aside><h1>Reportes La Red.Com</h1></aside><br><br>
			<aside class="span1"></aside>
			<div class="span9">
				<form action="acciones.php" method="post" class="form-inline">
					<label for="tipo">Tipo de Concepto </label>
					<select name="tipo" id="tipo">
						<option value="internet">Internet</option>
						<option value="recarga">Recargas</option>
						<option value="minutos">Minutos</option>
						<option value="vitrina">Vitrina</option>
					</select>
					<label for="fecha">Fecha</label>
					<input type="date" name="fecha">
					<input type="hidden" name="enviar">
					<button type="submit" name="enviar" class="btn btn-success">Buscar</button>
				</form>
			</div>
		</div>
		<hr>
		<div class="row">
			<aside class="span3"><a href="reporteConcepto.php" class="btn btn-inverse btn-large" target="_blank">Ver Por Concepto</a></aside>
			<div class="span6">
				<div id="mensaje"></div>
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Base</th>
							<th>Total Dia</th>
							<th>Tipo</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody id="resul">
						<?php
						  require_once('funciones.php');
						  $objeto = new funciones();
						  $objeto->buscarReporteInicio();
						?>
					</tbody>
				</table>
				<div>
					<?php
					    require_once('funciones.php');
					    $objeto = new funciones();
					    $objeto->paginacionReporte();
					?>
				</div>
			</div>
		</div>
	</article>

    <!-- Segundo articulo para ver totales de meses y dias-->
	<article class="container well" id="fondo">
		<p id="titulo">Calculo de Cierres Menos Gastos</p><br><br>
		<div id="mensajeCalculo"></div><!--Mensaje de exito o de Error.....-->
		<div class="row">
			<div class="span3 well" id="fondo" style="margin-left: 60px;">
				<form action="acciones.php" method="post">
					<label for="tipo" id="fuente">Tipo</label>
					<select name="tipo" id="tipo">
						<option value="internet">Internet</option>
						<option value="recarga">Recargas</option>
						<option value="minutos">Minutos</option>
						<option value="vitrina">Vitrina</option>
					</select>
					<label for="fecha" id="fuente">Fecha Inicial</label>
					<input type="date" name="fecha1">
					<label for="fecha2" id="fuente">Fecha Final</label>
					<input type="date" name="fecha2">
					<input type="hidden" name="calcular"><br><br>
					<button id="calcularReporte" name="calcular" class="btn btn-success">Calcular</button>
				</form>
			</div>
			<aside class="span1"></aside>
			<div class="span6 well" id="resultado" style="background: #feffff;">
				<h3 class="well" style="text-align: center;"> Calcular Ganancias Y Gastos </h3>
			</div>
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