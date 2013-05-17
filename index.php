<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="LaRed.Com">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap-responsive.css"> <!-- tener en cuenta el ancho de la pantalla actual 1200-->
  <link rel="stylesheet" href="css/estilos.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/ajaxInicio.js"></script>
</head>
    <style>
       body{
          padding-top: 60px;
          padding-bottom: 40px;
       }
       #centrar{
       	  text-align: center;
          margin-left: 40px;
       }
       #fondo{
       	  background-color: white;
       }
       #mensaje{
          float: left;
          margin-left: 580px;
       }
       .hero-unit{
       	  margin-top: 30px;
       	  text-align: center;
       }
       form{
        margin-left: 30px;
       }
       @media all and (max-width: 480px){ 
           #form{
               margin-left: 10%;
           }
       }
    </style>
    <script>
     $(document).ready(function(){
        $('.carousel').carousel({
          interval: 3000
        });

        $("#menuOpen").mouseout(function(){
            //$(".dropdown").removeClass('open');
        }).mouseover(function(){
            $(".dropdown").addClass('open');
            $("#foco").focus();
        });
    });
    </script>
<body>
    <?php  
       //Iniciar Sesión
       session_start();//iniciamos una session con session_start es necesario para poder definir o usar las variables de session
        //Validar si se está ingresando con sesión correctamente
        if (isset($_SESSION['id_user'])){
            header('Location: menu.php');//si esta bien la session lo mandamos al menu principal...
        }else{
        }    
    ?>
      <aside id="mensaje"></aside>
	<header>
		<div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="container" >
            <a href="" class="brand">Nombre del Gim</a>
            <div class="nav-collapse collapse">
              <ul class="nav" >
                <li class="divider-vertical"></li>
                <li class="dropdown">
                  <a id="menuOpen" class="dropdown-toggle" data-toggle="dropdown">
                      <strong>Iniciar Sesión</strong>
                      <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu pull-right">
                    <div class="span4">
                       <form  action="includes/acciones.php" method="post" id="limpiar">
                          <label for="nombre" class="control-label">Nombre</label>
                          <input type="text" name="nombre" class="respon" id="foco" placeholder="Usuario" autofocus>
                          <label for="clave" class="control-label">Password</label>
                          <input type="password" name="clave" class="respon" placeholder="Contraseña">
                          <div class="control-group" id="form">
                            <div class="controls">
                               <button type="submit" name="login" class="btn btn-primary" data-loading-text="Cargando...">Iniciar Sesión</button>
                            </div>
                          </div>
                      </form>
                    </div>
                  </ul>
                </li>
              </ul>
            </div><!--nav-collapse-->
          </div><!--container-->
        </div><!--navbar-inner-->
      </div><!--navbar-->
	</header>
  <section>
    <div class="container">
      <div class="hero-unit"> 
        <p class="page-header">
            <h1>Nombre del Gim</h1> 
        </p>
      </div>
    </div>
  </section>
	<!-- contenido de la pagina-->
    <article class="container">
        <div class="span11" id="centrar">
            <div class="carousel slide" id="myCarousel">
                <!--indicadores carrusel-->
                 <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <!--Imganes carrusel-->
                <div class="carousel-inner">
                    <div class="active item">
                      <img src="img/gim1.jpg" width="900" height="525">
                    </div>
                    <div class="item">
                      <img src="img/gim3.jpg" width="900" height="525">
                    </div>
                    <div class="item">
                      <img src="img/gim4.jpg" width="900" height="525">
                    </div>
                </div>
                <!--Navegacion carrusel-->
                <a href="#myCarousel" class="left carousel-control" data-slide="prev">&lsaquo;</a>
                <a href="#myCarousel" class="right carousel-control" data-slide="next">&rsaquo;</a>
            </div>
        </div>
    </article>
    <!-- pie de pagina-->
	<footer>
		  <h2 id="centrar"><img src="img/copyright.png" alt="Autor"> John Andrey Serrano - 2013</h2>
      <div id="pie">
          <p>Twitter: @Jandrey15</p>
      </div>
    <br>
	</footer>
</body>
</html>