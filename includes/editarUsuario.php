<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Configuración de la cuenta</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="../css/estilos.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/jquery.validate.js"></script>
	<script src="../js/editar.js"></script>
	<!--<script src="../js/funciones.js"></script>-->
	<!--<script src="../js/registrar.js"></script>-->
	<!--<script src="../js/eliminar.js"></script>-->
	<style>
	    h1{
	    	text-align: center;
	    }
	    th{
	    	font-size: 28px;
	    }
	    td{
	    	font-size: 24px;
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
	    textarea{
	    	/*resize: none;*/
	    	font-size: 16px;
	    	width: 250px;
	    }
	    #fondo{
	    	background: #feffff;
	       	/* box-shadow:inset -3px -2px 37px #000000; */
	    }
	    #validate2{
		    margin-left: 17%;
		}
		#userEdit{
			font-weight: bold;
		}
	    .notas{
	    	margin-left: 80px;
	    	position: fixed;
	    	top: 190px;
	    }
        .hero-unit{
        	margin-top: 30px;
        	text-align: center;
        	background-image: url('../img/gim2.jpg');
        }
	</style>

	<script>
      $(document).ready(function(){
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
	  });//cierre del document
	</script>

	<?php
      session_start();
      if(isset($_SESSION['id_user'])){
            $user = $_SESSION['nombre'];
            $id = $_SESSION['id_user'];
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
					<a href="../menu.php" class="brand">Nombre del Gim</a>
					<div class="nav-collapse collapse">
						<ul class="nav" >
							<li class="divider-vertical"></li>
							<li class="active"><a href="../menu.php"><i class="icon-home icon-white"></i>Inicio</a></li>
							<li class="divider-vertical"></li>
							<li><a href="internet.php">Registrar</a></li>
							<li class="divider-vertical"></li>
							<li><a href="recargas.php">Estudiantes</a></li>
							<li class="divider-vertical"></li>
							<li><a href="minutos.php"><i class="icon-book icon-white"></i> Reporte</a></li>
							<li class="divider-vertical"></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-user icon-white"></i> <?php echo $user; ?> <!--Mostramoe el user logeado -->
								    <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="registrarUsuario.php"><i class="icon-plus-sign"></i> Registrar Usuario</a></li>
									<li><a href="#"><i class="icon-wrench"></i> Configuración de la cuenta</a></li>
									<li class="divider"></li>
									<li><a href="includes/cerrar.php">Cerrar Sesion</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
	</header>
	<section>
		<div class="container">
			<div class="hero-unit">
				<br><br><br><br><br><br><br>
			</div>
		</div>
	</section>
    <!--Primer articulo... -->
	<article class="container well" id="fondo">
		<div class="row">
			<div class="span1"></div>
			<div class="span8 well" id="fondo" style="margin-left: 8%;">
				<h1>Configuración de la cuenta</h1><br>
				<div class="mensaje"></div><!--mensaje de confirmacion o de error-->
				<table class="table table-hover">
					<thead>
						
					</thead>
					<tbody>
						<tr>
							<td id="userEdit">Nombre:</td>
							<td id="resul"><?php echo $user?></td>
							<td><a href=<?php echo "$id"; ?> id="editNomUser" class="btn btn-info">Editar</a></td>
						</tr>
						<tr>
							<td id="userEdit">Contraseña:</td>
							<td>********</td>
							<td><a href=<?php echo "$id"; ?> id="editContraUser" class="btn btn-info">Editar</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</article>
     <!--MOdificamos el nombre del usuariooo-->
	<div class="hide" id="formulario" title="Editar Nombre">
     	<form action="acciones.php" method="post" class="limpiar">
     		<input type="hidden" id="id_registro" name="id_registro" value="0">
     		<div class="control-group">
     			<label for="nombre" class="control-label">Nombre</label>
     			<div class="controls">
     				<input type="text" name="nombre" id="nombre" autofocus  MAXLENGTH=5>
     			</div>
     		</div>
     		<div class="control-group">
     			<div class="controls">
     				<input type="hidden" name="editNomUser">
     				<button type="submit" id="UserModificar" name="editNomUser" class="btn btn-success">Modificar</button>
     				<button id="UserCancelar" class="btn btn-danger">Cancelar</button>
     			</div>
     		</div>
     	</form>
     </div>

	<!--Modificamos la contraseña del usuairo-->
	<div class="hide" id="formularioContraseña" title="Editar Nombre">
     	<form action="acciones.php" method="post" id="contraseñaValidar">
     		<input type="hidden" id="id_registro" name="id_registro" value="0">
     		<div class="control-group">
     			<label for="contraseñaActual" class="control-label">Contraseña Actual</label>
     			<div class="controls">
     				<input type="password" name="contraseñaA" id="contraseña"  required autofocus>
     			</div>
     			<div class="controls">
     				<label for="ontraseñaNueva">Contraseña Nueva</label>
     				<input type="password" name="contraseñaN" required>
     			</div>
     		</div>
     		<div class="control-group">
     			<div class="controls">
     				<input type="hidden" name="UserModificarContra">
     				<button type="submit" id="UserModificarContra" class="btn btn-success">Modificar</button>
     				<button id="UserCancelar" class="btn btn-danger">Cancelar</button>
     			</div>
     		</div>
     	</form>
     </div>
	<footer class="container well">
		<div class="span7">
		   <h2><img src="../img/copyright.png" alt="Autor"> John Andrey Serrano - 2013</h2>
		</div>
		<div class="span4"> <br>
			<p>Gim Version 1.0</p>
		</div>
	</footer>
</body>
</html>