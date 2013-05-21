<?php
  class funciones{
     private $bd;

     function __construct(){
         require_once('config.php');
         $bd = new conexion();
         $bd->conectar();
     }

    public function login($user,$pass){
         session_start();
         //$truco=sha1($pass);
         $resultado = mysql_query("SELECT * FROM usuarios WHERE nombre='$user' AND clave='$pass'");
         $fila = mysql_fetch_array($resultado);
         if($fila>0){
         	$id_user=$fila['id'];
            $user = $fila['nombre'];
         	$_SESSION['id_user']=$id_user;
            $_SESSION['nombre'] = $user;
         	return true;
         }else{
         	return false;
         }
    }

    public function registrarEstudiante($nom,$edad,$peso,$altura,$fechaI,$fechaV,$pago,$con){/*condicion el 0-> no pago el 1-> debe el 2-> abono*/
           $resultado = mysql_query("INSERT INTO estudiantes (nombre,edad,peso,altura,fechaInicial,fechaFinal,dinero,condicion)
                                      VALUES ('$nom','$edad','$peso','$altura','$fechaI','$fechaV','$pago','$con')")
                                      or die ("problemas con el insert de concepto de internet".mysql_error());
    }

    public function verEstudiantes(){
        $resultado = mysql_query("SELECT * FROM estudiantes ORDER BY condicion, fechaFinal DESC");

        while($fila = mysql_fetch_array($resultado)){
            if($fila['condicion'] == 'Pago'){
                 echo '<tr class="success"> 
                         <td>'.$fila['nombre'].'</td>
                         <td>'.$fila['fechaInicial'].'</td>
                         <td>'.$fila['fechaFinal'].'</td>
                         <td>'.$fila['dinero'].'</td>
                         <td>'.$fila['condicion'].'</td>
                         <td><a disabled class="btn btn-mini btn-info"><strong disabled>Editar</strong></a></td>
                         <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                     </tr>';
            }else{
                if($fila['condicion'] == 'No Pago'){
                    echo '<tr class="error"> 
                         <td>'.$fila['nombre'].'</td>
                         <td>'.$fila['fechaInicial'].'</td>
                         <td>'.$fila['fechaFinal'].'</td>
                         <td>'.$fila['dinero'].'</td>
                         <td>'.$fila['condicion'].'</td>
                         <td><a id="editPago" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                     </tr>';
                }else{
                    if($fila['condicion'] == 'Abono'){
                        echo '<tr class="warning"> 
                                 <td>'.$fila['nombre'].'</td>
                                 <td>'.$fila['fechaInicial'].'</td>
                                 <td>'.$fila['fechaFinal'].'</td>
                                 <td>'.$fila['dinero'].'</td>
                                 <td>'.$fila['condicion'].'</td>
                                 <td><a id="editPago" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                                 <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                             </tr>';
                    }
                }
            }
                          // echo $salida;
        }      
    }

    public function verVensimientos(){
        date_default_timezone_set('America/Bogota'); 
        $fecha = date("Y-m-d");
        $fechaD = date("d");
        $resultado = mysql_query("SELECT * FROM estudiantes WHERE condicion= 'No Pago' OR condicion= 'Abono' ORDER BY fechaFinal DESC");   
        while($fila = mysql_fetch_array($resultado)){
            $dia = substr($fila['fechaFinal'],8,10); 
            $dia = $dia-3;
            if($fecha == $fila['fechaFinal']){
                if($fila['condicion'] == 'No Pago'){
                        echo '<tr class="error"> 
                             <td>'.$fila['nombre'].'</td>
                             <td>'.$fila['fechaInicial'].'</td>
                             <td>'.$fila['fechaFinal'].'</td>
                             <td>'.$fila['dinero'].'</td>
                             <td>'.$fila['condicion'].'</td>
                             <td><a id="editPagoVen" class="btn btn-mini btn-inverse" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         </tr>';
                }else{
                    if($fila['condicion'] == 'Abono'){
                            echo '<tr class="warning"> 
                                     <td>'.$fila['nombre'].'</td>
                                     <td>'.$fila['fechaInicial'].'</td>
                                     <td>'.$fila['fechaFinal'].'</td>
                                     <td>'.$fila['dinero'].'</td>
                                     <td>'.$fila['condicion'].'</td>
                                     <td><a id="editPagoVen" class="btn btn-mini btn-inverse" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                                 </tr>';
                    }
                }
            }else{
                if($fechaD == $dia){
                    if($fila['condicion'] == 'No Pago'){
                        echo '<tr class="error"> 
                             <td>'.$fila['nombre'].'</td>
                             <td>'.$fila['fechaInicial'].'</td>
                             <td>'.$fila['fechaFinal'].'</td>
                             <td>'.$fila['dinero'].'</td>
                             <td>'.$fila['condicion'].'</td>
                             <td><a id="editPagoVen" class="btn btn-mini btn-inverse" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         </tr>';
                    }else{
                        if($fila['condicion'] == 'Abono'){
                                echo '<tr class="warning"> 
                                         <td>'.$fila['nombre'].'</td>
                                         <td>'.$fila['fechaInicial'].'</td>
                                         <td>'.$fila['fechaFinal'].'</td>
                                         <td>'.$fila['dinero'].'</td>
                                         <td>'.$fila['condicion'].'</td>
                                         <td><a id="editPagoVen" class="btn btn-mini btn-inverse" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                                     </tr>';
                        }
                    }
                }
            }
        }
    }
    /*verificamos si hay personas que se les cumplio la fecha de pago*/
    public function verificar(){
        date_default_timezone_set('America/Bogota'); 
        $fecha = date("Y-m-d");//fecha actual bien 
        $fechaD = date("d");

        $resultado = mysql_query("SELECT * FROM estudiantes WHERE condicion='No Pago' OR condicion='Abono'");
        
        while($fila = mysql_fetch_array($resultado)){
            $dia = substr($fila['fechaFinal'],8,10); 
            $dia = $dia-3;
            if($fechaD == $dia){
                return true;
            }else{
                if($fecha == $fila['fechaFinal']){
                    return true;
                }
            }
        }   
    }

    public function verTodosEstudiantes(){
        $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

        if(isset($_GET["pagina"])){
            $num_pag = $_GET["pagina"];//numero de la pagina
        }else{
            $num_pag = 1;
        }

        if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
            $inicio = 0;
            $num_pag = 1;
        }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
            $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
        }
        $resultado = mysql_query("SELECT * FROM estudiantes LIMIT $inicio,$cant_reg");
        while($fila = mysql_fetch_array($resultado)){
              echo '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['edad'].'</td>
                        <td>'.$fila['peso'].'</td>
                        <td>'.$fila['altura'].'</td>
                        <td><a id="editEstudiante" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
        }
    }

    public function modificarPago($pago,$con,$cod){
        mysql_query("UPDATE estudiantes SET dinero='$pago', condicion='$con' WHERE id='$cod'") 
                                    or die ("Error en el update");
    }

     /*metodos para ELIMINAR estudiantes del gim*/
    public function eliminarEstudiante($cod){
        mysql_query("DELETE FROM estudiantes WHERE id='$cod'");
    }

   /*aca comienzo con la partde de actulizar datos de los estudiantes que van al gim*/
    public function actualizarDatosPersonales($cod,$nom,$edad,$peso,$altura){
        mysql_query("UPDATE estudiantes SET nombre='$nom', edad='$edad', peso='$peso', altura='$altura' WHERE id='$cod'") 
                                    or die ("Error en el update");
    }


     //BUSCADOR EN TIEMPO REAL POR  DE CONCEPTO......
    public function buscarEstudiante($palabra){
        if($palabra == ''){
            $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM estudiantes");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='reporteConcepto.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';

            $resultado = mysql_query("SELECT * FROM estudiantes LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['edad'].'</td>
                        <td>'.$fila['peso'].'</td>
                        <td>'.$fila['altura'].'</td>
                        <td><a id="editEstudiante" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            } 
        }else{
             $resultado = mysql_query("SELECT * FROM estudiantes WHERE nombre LIKE'%$palabra%'");
            //echo json_encode($resultado);
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['edad'].'</td>
                        <td>'.$fila['peso'].'</td>
                        <td>'.$fila['altura'].'</td>
                        <td><a id="editEstudiante" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            }  
        }
    }

    /*paginacion de los datos personales..*/
    public function paginacionDatosPersonales(){
            $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM estudiantes");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='actualizarDatos.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';
    }

/*codigo para actulizar el tiempo del estudiante en el gim...... VA VERDATOS, PAGINACION DE LOS DATOS*/
    public function verActualizarTiempo(){
        $resultado = mysql_query("SELECT * FROM estudiantes WHERE condicion='Pago' ORDER BY fechaFinal DESC");

        while($fila = mysql_fetch_array($resultado)){
                 echo '<tr class="success"> 
                         <td>'.$fila['nombre'].'</td>
                         <td>'.$fila['fechaInicial'].'</td>
                         <td>'.$fila['fechaFinal'].'</td>
                         <td>'.$fila['dinero'].'</td>
                         <td>'.$fila['condicion'].'</td>
                         <td><a id="tiempoEstudiante" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                     </tr>';
                          // echo $salida;
        }      
    }

    public function paginacionActulizarTiempo(){
         $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM estudiantes WHERE condicion='Pago'");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='actualizarDatos.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';
    }

    /*buscador en tiempo real para actulizar el tiempo de uso de los estudiantes que ya pagaron*/
    public function buscarEstudiantePago($palabra){
        if($palabra == ''){
            $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM estudiantes WHERE condicion='Pago'");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='reporteConcepto.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';

            $resultado = mysql_query("SELECT * FROM estudiantes WHERE condicion='Pago' LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr class="success"> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['fechaInicial'].'</td>
                        <td>'.$fila['fechaFinal'].'</td>
                        <td>'.$fila['dinero'].'</td>
                        <td>'.$fila['condicion'].'</td>
                        <td><a id="actulizarTiempo" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            } 
        }else{
             $resultado = mysql_query("SELECT * FROM estudiantes WHERE condicion='Pago' AND nombre LIKE'%$palabra%'");
            //echo json_encode($resultado);
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr class="success"> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['fechaInicial'].'</td>
                        <td>'.$fila['fechaFinal'].'</td>
                        <td>'.$fila['dinero'].'</td>
                        <td>'.$fila['condicion'].'</td>
                        <td><a id="actulizarTiempo" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            }  
        }
    }

    public function actulizarTiempo($fechaV,$pago,$con,$cod){
        date_default_timezone_set('America/Bogota'); 
        $fechaI = date("Y-m-d");
        mysql_query("UPDATE estudiantes SET fechaInicial='$fechaI', fechaFinal='$fechaV', dinero='$pago', condicion='$con' WHERE id='$cod'") 
                                    or die ("Error en el update");
    }
























/*codigo viejo __________________________________________________________________________________________*/
    public function consultaRecarga(){
        date_default_timezone_set('America/Bogota'); 
        $fecha = date("Y-m-d");
             
        $resultado = mysql_query("SELECT baseDia,fecha FROM bases WHERE tipoBase='recarga'");
        if($fila=mysql_fetch_array($resultado)){
                   $salida = '<h1> Base del dia es: $'.number_format($fila['baseDia']).' - Fecha: '.$fila['fecha'].'</h1>';           
                   echo $salida;
                   return true;
        }else{
            mysql_query("INSERT INTO bases (baseDia,fecha,tipoBase) VALUES ('0','$fecha','recarga')") 
                   or die ("problemas en el inserte de base recarga".mysql_error());
            $salida ="<h1> Base del Dia: $0  del ".$fecha." </h1>";
            echo $salida;
            return false;
        } 
    }

    public function consultaMinutos(){
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");

        $resultado = mysql_query("SELECT baseDia,fecha FROM bases WHERE tipoBase='minutos'");
        if($fila = mysql_fetch_array($resultado)){
                $salida = '<h1> Base del dia es: $'.number_format($fila['baseDia']).' - Fecha: '.$fila['fecha'].'</h1>';
                echo $salida;
                return true;
        }else{
            mysql_query("INSERT INTO bases (baseDia,fecha,tipoBase) VALUES ('0','$fecha','minutos')") 
                   or die ("problemas en el inserte de base minutos".mysql_error());
            $salida = '<h1> Base del Dia: $0  del  '.$fecha.'</h1>';
            echo $salida;
            return false;
        }
    }

    public function consultaVitrina(){
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");

        $resultado = mysql_query("SELECT baseDia,fecha FROM bases WHERE tipoBase='vitrina'");
        if($fila = mysql_fetch_array($resultado)){
                $salida = '<h1> Base del dia es: $'.number_format($fila['baseDia']).' - Fecha: '.$fila['fecha'].'</h1>';
                echo $salida;
                return true;
        }else{
            mysql_query("INSERT INTO bases (baseDia,fecha,tipoBase) VALUES ('0','$fecha','vitrina')") 
                   or die ("problemas en el inserte de base vitrina".mysql_error());
            $salida = '<h1> Base del Dia: $0  del  '.$fecha.'</h1>';
            echo $salida;
            return false;
        }
    }

    public function totalDiaInternet(){
        date_default_timezone_set('America/Bogota'); 
        $fecha = date("Y-m-d");
        $totalInternet=0;

        $resultado = mysql_query("SELECT sum(dinero) AS total FROM cinternet WHERE fecha='$fecha' AND tipoConcepto='internet'");
        //$base = mysql_query("SELECT baseDia FROM binternet WHERE fecha='$fecha' AND tipoBase='internet'");

        $fila = mysql_fetch_array($resultado);

        $totalInternet = $fila['total'];

        if($fila['total']!=0) {
            $salida = '<h3 class="well"> Total del Dia: $'.number_format($fila['total']).'</h3>
                       <a href="verInternet.php" class="btn btn-inverse btn-large" target="_blank">Ver Por Concepto</a>';
            echo $salida;
        }else{
            $totalInternet=0;
            $salida = '<h3 class="well"> Total del Dia: $0</h3>
                       <a href="verInternet.php" class="btn btn-inverse btn-large" target="_blank">Ver Por Concepto</a>';
            echo $salida;
        }

        $result = mysql_query("SELECT * FROM totalesdia WHERE fecha='$fecha' AND tipo='internet'");

        if($fila = mysql_fetch_array($result)){
            mysql_query("UPDATE totalesdia SET total ='$totalInternet' WHERE tipo='internet' AND fecha='$fecha'") 
                                    or die ("Error en el update");
        }else{
            $totalInternet=0;
            $r = mysql_query("SELECT baseDia FROM bases WHERE tipoBase='internet'");
            $fila = mysql_fetch_array($r);
            $base = $fila['baseDia'];
            mysql_query("INSERT INTO totalesdia (total,base,tipo,fecha) VALUES ('$totalInternet','$base','internet','$fecha')")
                                    or die ("problemas en insert de totales dia...");
        }   
    }

    public function totalDiaRecargas(){
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");
        $totalRecargas=0;

        $resultado = mysql_query("SELECT sum(dinero) AS total FROM cinternet WHERE fecha='$fecha' AND tipoConcepto='recarga'");
        $fila = mysql_fetch_array($resultado);

        $totalRecargas = $fila['total'];

        if($fila['total']!=0) {
            $salida = '<h3 class="well"> Total del Dia: $'.number_format($fila['total']).'</h3>';
            echo $salida;
        }else{
            $totalRecargas=0;
            $salida = '<h3 class="well"> Total del Dia: $0</h3>';
            echo $salida;
        }

        $result = mysql_query("SELECT * FROM totalesdia WHERE fecha='$fecha' AND tipo='recarga'");

        if($fila = mysql_fetch_array($result)){
            mysql_query("UPDATE totalesdia SET total ='$totalRecargas' WHERE tipo='recarga' AND fecha='$fecha'") 
                                    or die ("Error en el update");
        }else{
            $totalRecargas=0;
            $r = mysql_query("SELECT baseDia FROM bases WHERE tipoBase='recarga'");
            $fila = mysql_fetch_array($r);
            $base = $fila['baseDia'];
            mysql_query("INSERT INTO totalesdia (total,base,tipo,fecha) VALUES ('$totalRecargas','$base','recarga','$fecha')")
                                    or die ("problemas en insert de totales dia...");
        }   
    }

    public function totalDiaMinutos(){
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");
        $totalMinutos=0;

        $resultado = mysql_query("SELECT sum(dinero) AS total FROM cinternet WHERE fecha='$fecha' AND tipoConcepto='minutos'");
        $fila = mysql_fetch_array($resultado);

        $totalMinutos = $fila['total'];

        if($fila['total']!=0){
            $salida = '<h3 class="well"> Total del Dia: $'.number_format($fila['total']).'</h3>';
            echo $salida;
        }else{
            $totalMinutos=0;
            $salida = '<h3 class="well"> Total del Dia: $0</h3>';
            echo $salida;
        }

        $result = mysql_query("SELECT * FROM totalesdia WHERE fecha='$fecha' AND tipo='minutos'");

        if($fila = mysql_fetch_array($result)){
            mysql_query("UPDATE totalesdia SET total ='$totalMinutos' WHERE tipo='minutos' AND fecha='$fecha'") 
                                    or die ("Error en el update");
                                   
        }else{
            $totalMinutos=0;
            $r = mysql_query("SELECT baseDia FROM bases WHERE tipoBase='minutos'");
            $fila = mysql_fetch_array($r);
            $base = $fila['baseDia'];
            mysql_query("INSERT INTO totalesdia (total,base,tipo,fecha) VALUES ('$totalMinutos','$base','minutos','$fecha')")
                                    or die ("problemas en insert de totales dia porque...");
        }   
    }

    public function totalDiaVitrina(){
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");
        $totalVitrina=0;

        $resultado = mysql_query("SELECT sum(dinero) AS total FROM cinternet WHERE fecha='$fecha' AND tipoConcepto='vitrina'");
        $fila= mysql_fetch_array($resultado);

        $totalVitrina = $fila['total'];

        if($fila['total']!=0){
            $salida = '<h3 class="well"> Total del Dia: $'.number_format($fila['total']).'</h3>
                        <a href="verVitrina.php" class="btn btn-inverse btn-large" target="_blank">Ver Por Concepto</a>';
            echo $salida;
        }else{
            $totalVitrina=0;
            $salida = '<h3 class="well"> Total del Dia: $0</h3>
                        <a href="verVitrina.php" class="btn btn-inverse btn-large" target="_blank">Ver Por Concepto</a>';
            echo $salida;
        }

        $result = mysql_query("SELECT * FROM totalesdia WHERE fecha='$fecha' AND tipo='vitrina'");

        if($fila = mysql_fetch_array($result)){
            mysql_query("UPDATE totalesdia SET total ='$totalVitrina' WHERE tipo='vitrina' AND fecha='$fecha'") 
                                    or die ("Error en el update");
        }else{
            $totalVitrina=0;
            $r = mysql_query("SELECT baseDia FROM bases WHERE tipoBase='vitrina'");
            $fila = mysql_fetch_array($r);
            $base = $fila['baseDia'];
            mysql_query("INSERT INTO totalesdia (total,base,tipo,fecha) VALUES ('$totalVitrina','$base','vitrina','$fecha')")
                                    or die ("problemas en insert de totales dia...");
        }   
    }

    public function reporteDiario(){
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");

        $resultado = mysql_query("SELECT * FROM cinternet WHERE fecha='$fecha'");

        $sumaInternet=0;  $sumaRecarga=0; $sumaMinutos=0; $sumaVitrina=0;

        while($fila = mysql_fetch_array($resultado)){
            if($fila['tipoConcepto'] == 'internet'){
                 $sumaInternet = $sumaInternet+$fila['dinero'];
            }else{
                if($fila['tipoConcepto'] == 'recarga'){
                    $sumaRecarga = $sumaRecarga+$fila['dinero'];
                }else{
                    if($fila['tipoConcepto'] == 'minutos'){
                        $sumaMinutos = $sumaMinutos+$fila['dinero'];
                    }else{
                        if($fila['tipoConcepto'] == 'vitrina'){
                            $sumaVitrina = $sumaVitrina+$fila['dinero'];
                        }
                    }
                }
            }
        }
         
        $salida ='<tr> 
                        <td> $'.number_format($sumaInternet).'</td>
                        <td> $'.number_format($sumaRecarga).'</td>
                        <td> $'.number_format($sumaMinutos).'</td>
                        <td> $'.number_format($sumaVitrina).'</td>
                  </tr>';
         echo $salida;
    }

    /*public function reporteDiarioBase(){///TENER EN CUENTA NO TIENE RELACION HACER ALGO AL RESPECTO. y el select no debe de ir asi por si acaso...
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d");

        $resultado = mysql_query("SELECT * FROM cinternet,binternet WHERE cinternet.tipoConcepto=binternet.tipoBase AND cinternet.fecha='$fecha' AND binternet.fecha='$fecha'");
        
        $sumaInternet=0;  $sumaRecarga=0; $sumaMinutos=0; $sumaVitrina=0;
        $baseInternet=0;  $baseRecarga=0; $baseMInutos=0; $baseVitrina=0;

        while($fila = mysql_fetch_array($resultado)){
            if($fila['tipoConcepto'] == 'internet'){
                 $baseInternet = $fila['baseDia'];
                 $sumaInternet = $sumaInternet+$fila['dinero'];
            }else{
                if($fila['tipoConcepto'] == 'recarga'){
                    $baseRecarga = $fila['baseDia'];
                    $sumaRecarga = $sumaRecarga+$fila['dinero'];
                }else{
                    if($fila['tipoConcepto'] == 'minutos'){
                        $baseMInutos = $fila['baseDia'];
                        $sumaMinutos = $sumaMinutos+$fila['dinero'];
                    }else{
                        if($fila['tipoConcepto'] == 'vitrina'){
                            $baseVitrina = $fila['baseDia'];
                            $sumaVitrina = $sumaVitrina+$fila['dinero'];
                        }
                    }
                }
            }
        }

        $totalInternet = $sumaInternet + $baseInternet;
        $totalRecargas = $sumaRecarga + $baseRecarga;
        $totalMinutos =  $sumaMinutos + $baseMInutos;
        $totalVitrina =  $sumaVitrina + $baseVitrina;

        $salida ='<tr> 
                        <td> $'.number_format($totalInternet).'</td>
                        <td> $'.number_format($totalRecargas).'</td>
                        <td> $'.number_format($totalMinutos).'</td>
                        <td> $'.number_format($totalVitrina).'</td>
                  </tr>';
         echo $salida;
    }*/

    public function reporteBases(){
        $resultado = mysql_query("SELECT baseDia,tipoBase FROM bases");

        $baseInternet=0; $baseRecarga=0; $baseMinutos=0; $baseVitrina=0;

        while($fila = mysql_fetch_array($resultado)){
            if($fila['tipoBase'] == 'internet'){
                $baseInternet = $fila['baseDia'];
            }else{
                if($fila['tipoBase'] == 'recarga'){
                    $baseRecarga = $fila['baseDia'];
                }else{
                    if($fila['tipoBase'] == 'minutos'){
                        $baseMinutos = $fila['baseDia'];
                    }else{
                        if($fila['tipoBase'] == 'vitrina'){
                            $baseVitrina = $fila['baseDia'];
                        }
                    }
                }
            } 
        }

        $salida = '<tr> 
                       <td> $'.number_format($baseInternet).'</td>
                       <td> $'.number_format($baseRecarga).'</td>
                       <td> $'.number_format($baseMinutos).'</td>
                       <td> $'.number_format($baseVitrina).'</td>
                  </tr>';
        echo $salida;
    }

    public function buscarReporte($tipo,$fecha){
        if($fecha=='0001-01-01'){
            $resultado = mysql_query("SELECT * FROM totalesdia ORDER BY fecha DESC ")
                                        or die ("problemas en el select ".mysql_error());
        }else{
            $resultado = mysql_query("SELECT * FROM totalesdia WHERE tipo='$tipo' AND fecha='$fecha'")
                                        or die ("problemas en el select ".mysql_error());

           // $result = mysql_query("SELECT * FROM binternet WHERE tipoBase='$tipo' AND fecha='$fecha'");
        }

        while($fila = mysql_fetch_array($resultado)){
               $salida ='<tr> 
                        <td> $'.number_format($fila['base']).'</td>
                        <td> $'.number_format($fila['total']).'</td>
                        <td> '.$fila['tipo'].'</td>
                        <td> '.$fila['fecha'].'</td>
                  </tr>';
               echo $salida;
        }
    }
    
    //BUSCAMOS LOS REPORTES DIARIOS ESTAN PAGINADOS DE 10 DATOS POR PAGINA.
    public function buscarReporteInicio(){///TENER EN CUENTA SI SE PIERDEN LOS DATOS O SALEN DONDE NO SON....
            $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $resultado = mysql_query("SELECT * FROM totalesdia ORDER BY fecha DESC LIMIT $inicio,$cant_reg")
                                            or die ("problemas en el select ".mysql_error());

            while($fila = mysql_fetch_array($resultado)){
                    //$fila = mysql_fetch_array($resultado);
                   $salida ='<tr> 
                            <td> $'.number_format($fila['base']).'</td>
                            <td> $'.number_format($fila['total']).'</td>
                            <td> '.$fila['tipo'].'</td>
                            <td> '.$fila['fecha'].'</td>
                      </tr>';
                   echo $salida;
            }
    }

    //BUSCAR DATOS POR CONCEPTO Y DATOS PAGINADOS DE 30 
    public function buscarReporteConcepto(){
            $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $resultado = mysql_query("SELECT * FROM cinternet ORDER BY tipoConcepto,fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
        
            while($fila = mysql_fetch_array($resultado)){
                echo '<tr> 
                             <td>'.$fila['nombre'].'</td>
                             <td>'.$fila['dinero'].'</td>
                             <td>'.$fila['tipoConcepto'].'</td>
                             <td>'.$fila['fecha'].'</td>
                             <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                             <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                           </tr>';
                          // echo $salida;
            }      
    }
    
    

    //ESTA ES LA PAGINACION DE LOS REPORTES DIARIOS OK NO CONFUNDIR CON REPORTES POR CONCEPTO.
    public function paginacionReporte(){
            $cant_reg = 10;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM totalesdia");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);
            echo '<div class="pagination">
                    ';
            if(($num_pag-1)>0){//preguntamos que si el numero de la pagina es mayor a cero ejemplo pagina 1-1 = 0 es > 0 no oasea que no hay paginas anteriores a esta ok.
                echo "<ul><li> <a href='reporte.php?pagina=".($num_pag-1)."'> Prev </a></li></ul>";//mandamos el link de anterior si es el caso.
                echo "<ul><li> <a href='reporte.php?pagina=1'> ... </a></li></ul>";//mandamos el link de anterior si es el caso.
            }
            for($i=1; $i<=$total_paginas; $i++){//vamos listando todas las paginas.
                if($num_pag==$i){//preguntamos si el numero de la pagina es = a la variable $i para imprimirla pero desabilitada.
                     echo "<ul> <li class='disabled'><a href='#'>".$num_pag."</a></li></ul>";
                    // $_SESSION['paginaActual']=$num_pag;
                }else{ //si no imprimimos el numero de la pagina siguiente. 
                   if($i<=10){
                        if($num_pag>=10){
                        }else{
                               echo "<ul> <li> <a  href='reporte.php?pagina=$i'> $i </a></li></ul>";
                        }
                    }else{
                        if($num_pag>=10){
                            echo "<ul> <li> <a  href='reporte.php?pagina=$i'> $i </a></li></ul>";
                        }
                    }
                }
            }
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                echo "<ul><li> <a href='reporte.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                </div>';
    }
    
    //REFRES CUANDO EDITAMOS UN DATO SE REFRESQUE LOS DATOS MODIFICADOS.
    public function refres(){
           $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $resultado = mysql_query("SELECT * FROM cinternet ORDER BY tipoConcepto,fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
           
            while($fila = mysql_fetch_array($resultado)){
                    echo '<tr> 
                             <td>'.$fila['nombre'].'</td>
                             <td>'.$fila['dinero'].'</td>
                             <td>'.$fila['tipoConcepto'].'</td>
                             <td>'.$fila['fecha'].'</td>
                             <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                             <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                           </tr>';
                          // echo $salida;
            }      
    }
    
    //METODO PARA ACTUALIZAR LOS DATOS AL MODIFICAR...
    public function modificarConcepto($cod,$nombre,$dinero){
        $result = mysql_query("UPDATE cinternet SET nombre='$nombre', dinero='$dinero' WHERE id='$cod'");
        if($result){
            return true;
            echo "Bien";
        }else{
            return false;
            echo "Error";
        }
    }
    /*ACTULIZAMOS LAS NOTAS DEL MENU....*/
    public function actualizarNota($nota){
        $resultado = mysql_query("SELECT id FROM notas");
          
        if($fila = mysql_fetch_row($resultado)){
            mysql_query("UPDATE notas SET nota ='$nota' WHERE id='".$fila[0]."'") 
                             or die ("Error en el update");
        }else{
            mysql_query("INSERT INTO notas (nota) VALUES ('$nota')") 
                       or die ("problemas en el inserte de Notas....".mysql_error());
        }
        

    }
    /*NOTAS RAPIDAS DEL MENU........ */
    public function verNota(){
        $resultado = mysql_query("SELECT nota FROM notas");
        $fila = mysql_fetch_array($resultado);
        echo $fila['nota'];
    }


    public function verPrecios(){
        $resultado = mysql_query("SELECT * FROM precios");

        while($fila = mysql_fetch_array($resultado)){
                echo '<tr> 
                         <td>'.$fila['nombre'].'</td>
                         <td>'.$fila['precio'].'</td>
                         <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                     </tr>';
                          // echo $salida;
        }      
    }

    public function registrarPrecio($nom,$pre){
         mysql_query("INSERT INTO precios (nombre,precio) VALUES ('$nom','$pre')") 
                       or die ("problemas en el inserte de Precios....".mysql_error());
    }


    public function modificarPrecio($cod,$nom,$pre){
        $resultado = mysql_query("UPDATE precios SET nombre='$nom', precio='$pre' WHERE id='$cod'");
        if($resultado){
            return true;
            echo "Bien";
        }else{
            return false;
            echo "Error";
        }
    }

    /*CALCULO DE LOS REPORTES DE TODOS LOS DIAS POR FECHA Y TIPO*/
    public function calcularReporte($fecha1,$fecha2,$tipo){
        $resultado = mysql_query("SELECT sum(total) AS total FROM totalesdia WHERE fecha between'$fecha1' AND '$fecha2' AND tipo='$tipo'");
        $fila = mysql_fetch_array($resultado);

        $cierre = mysql_query("SELECT sum(dinero) AS cierre FROM cierre WHERE id between'$fecha1' AND '$fecha2'");
        $filaCierre = mysql_fetch_array($cierre);

        $result = mysql_query("SELECT sum(gasto) AS gasto FROM gastos WHERE fecha between'$fecha1' AND '$fecha2'");
        $row = mysql_fetch_array($result);

        if($tipo == 'internet'){
              $ganancia = $filaCierre['cierre'];
              $gasto = $row['gasto'];
              $total = $ganancia - $gasto;
        }else{
            $total = $fila['total'];
        }

        if($fila['total']>0){
           $salida = '<strong>Fecha Inicial</strong> '.$fecha1.' <strong>- Fecha Final</strong> '. $fecha2.' <h3 class="well" style="text-align: center;"> 
                       Ganancia: <strong style="color: #df0024;">$'.number_format($filaCierre['cierre']).'</strong><br>
                       Gastos: <strong style="color: #df0024;">$'.number_format($row['gasto']).'</strong> <br>
                       Total Ganancia: <strong style="color: #df0024;">$'.number_format($total).'</strong></h3>';
           echo $salida;
           return true;
        }else{
            echo "Error";
            return false;
        }

    }

    public function cierreDia($fecha,$dinero,$dia){
        mysql_query("INSERT INTO cierre (id,dinero,dia) VALUES ('$fecha','$dinero','$dia')") 
                       or die ("Error");   
    }

    public function verCierres(){

        $cant_reg = 7;//definimos la cantidad de datos que deseamos tenes por pagina.

        if(isset($_GET["pagina"])){
            $num_pag = $_GET["pagina"];//numero de la pagina
        }else{
            $num_pag = 1;
        }

        if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
            $inicio = 0;
            $num_pag = 1;
        }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
            $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
        }

         $resultado = mysql_query("SELECT * FROM cierre ORDER BY id DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
        
         while($fila = mysql_fetch_array($resultado)){
                echo '<tr> 
                         <td>'.$fila['dinero'].'</td>
                         <td>'.$fila['dia'].'</td>
                         <td>'.$fila['id'].'</td>
                         <td><a id="editCierre" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                     </tr>';
                          // echo $salida;
        }      
    }

    public function modificarCierre($dia,$dinero,$cod){
         $resultado = mysql_query("UPDATE cierre SET dia='$dia', dinero='$dinero' WHERE id='$cod'");
            if($resultado){
                return true;
                echo "Bien";
            }else{
                return false;
                echo "Error";
            }
    }

    public function calcularCierre($fecha1,$fecha2){
        $resultado = mysql_query("SELECT sum(dinero) AS total FROM cierre WHERE id between '$fecha1' AND '$fecha2'");
        $fila = mysql_fetch_array($resultado);

        if($fila['total']>0){
           $salida = '<h3 class="well"> Calculo: $'.number_format($fila['total']).'</h3>';
           echo $salida;
           return true;
        }else{
            echo "Error";
            return false;
        }
    }


    public function paginacionCierre(){
         $cant_reg = 7;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM cierre");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);
            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag-1)>0){//preguntamos que si el numero de la pagina es mayor a cero ejemplo pagina 1-1 = 0 es > 0 no oasea que no hay paginas anteriores a esta ok.
                //echo "<ul><li> <a id='clic' href='cierreDiario.php?pagina=".($num_pag-1)."'> Prev </a></li></ul>";//mandamos el link de anterior si es el caso.
                //echo "<ul><li> <a id='clic'href='cierreDiario.php?pagina=1'> ... </a></li></ul>";//mandamos el link de anterior si es el caso.
            }
            for($i=1; $i<=$total_paginas; $i++){//vamos listando todas las paginas.
               
            }
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                echo "<ul><li class='next'> <a href='cierreDiario.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ; echo '
                </div>';
    }


    public function gastos($gasto,$tgasto,$fecha){
        mysql_query("INSERT INTO gastos (gasto,tipoGasto,fecha) VALUES ('$gasto','$tgasto','$fecha')") 
                       or die ("Error"); 
    }

    public function verGastos(){
        //sleep(1);
         $cant_reg = 5;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }
         $resultado = mysql_query("SELECT * FROM gastos ORDER BY fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
        
         while($fila = mysql_fetch_array($resultado)){
                echo '<tr> 
                         <td>'.$fila['gasto'].'</td>
                         <td>'.$fila['tipoGasto'].'</td>
                         <td>'.$fila['fecha'].'</td>
                         <td><a id="editGasto" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                         <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                     </tr>';
                          // echo $salida;
        }      
    }

    public function paginacionGastos(){
        $cant_reg = 5;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM gastos");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);
            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag-1)>0){//preguntamos que si el numero de la pagina es mayor a cero ejemplo pagina 1-1 = 0 es > 0 no oasea que no hay paginas anteriores a esta ok.
               // echo "<ul><li> <a href='gastos.php?pagina=".($num_pag-1)."'> Prev </a></li></ul>";//mandamos el link de anterior si es el caso.
            }
            for($i=1; $i<=$total_paginas; $i++){//vamos listando todas las paginas.
                
            }
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                echo "<ul><li class='next'> <a href='gastos.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            }; echo '
                </div>';
    }

    public function modificarGasto($gasto,$tgasto,$cod){
         $resultado = mysql_query("UPDATE gastos SET gasto='$gasto', tipoGasto='$tgasto' WHERE id='$cod'");
            if($resultado){
                return true;
                echo "Bien";
            }else{
                return false;
                echo "Error";
            }
    }

    public function calcularGasto($fecha1,$fecha2){
        $resultado = mysql_query("SELECT sum(gasto) AS total FROM gastos WHERE fecha between '$fecha1' AND '$fecha2'");
        $fila = mysql_fetch_array($resultado);

        if($fila['total']>0){
           $salida = '<h3 class="well"> Calculo: $'.number_format($fila['total']).'</h3>';
           echo $salida;
           return true;
        }else{
            echo "Error";
            return false;
        }
    }

    /*________________________________________________________________*/
   

    /*_______________________________________________________________*/
    /*metodos para ELIMINAR datos*/
    public function deleteConcepto($cod){
        mysql_query("DELETE FROM cinternet WHERE id='$cod'");
    }

    public function deletePrecio($cod){
        mysql_query("DELETE FROM precios WHERE id='$cod'");
    }

    public function deleteCierre($cod){
        mysql_query("DELETE FROM cierre WHERE id='$cod'");
    }

    public function deleteGasto($cod){
        mysql_query("DELETE FROM gastos WHERE id='$cod'");
    }
    /*_______________________________________________________________*/
    public function verInternet(){
        $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $resultado = mysql_query("SELECT * FROM cinternet WHERE tipoConcepto='internet' ORDER BY fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
        
            while($fila = mysql_fetch_array($resultado)){
                echo '<tr> 
                             <td>'.$fila['nombre'].'</td>
                             <td>'.$fila['dinero'].'</td>
                             <td>'.$fila['tipoConcepto'].'</td>
                             <td>'.$fila['fecha'].'</td>
                             <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                             <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                           </tr>';
                          // echo $salida;
            }      
    }

    public function paginacionInternet(){
        $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.
            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM cinternet");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='verInternet.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';
    }

    public function buscarInternet($palabra){
        if($palabra == ''){
            $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.
            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM cinternet");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='verInternet.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';
            $resultado = mysql_query("SELECT * FROM cinternet WHERE tipoConcepto='internet' ORDER BY fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
             //echo json_encode($resultado);
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['dinero'].'</td>
                        <td>'.$fila['tipoConcepto'].'</td>
                        <td>'.$fila['fecha'].'</td>
                        <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            }  
        }else{
            $resultado = mysql_query("SELECT * FROM cinternet WHERE tipoConcepto='internet' AND nombre LIKE'%$palabra%' OR fecha LIKE '%$palabra%' ORDER BY fecha DESC");
            //echo json_encode($resultado);
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['dinero'].'</td>
                        <td>'.$fila['tipoConcepto'].'</td>
                        <td>'.$fila['fecha'].'</td>
                        <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            }  
        }
    }

    public function verVitrina(){
        $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.

            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;
            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $resultado = mysql_query("SELECT * FROM cinternet WHERE tipoConcepto='vitrina' ORDER BY fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
        
            while($fila = mysql_fetch_array($resultado)){
                echo '<tr> 
                             <td>'.$fila['nombre'].'</td>
                             <td>'.$fila['dinero'].'</td>
                             <td>'.$fila['tipoConcepto'].'</td>
                             <td>'.$fila['fecha'].'</td>
                             <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                             <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                           </tr>';
                          // echo $salida;
            }      
    }

    public function paginacionVitrina(){
         $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.
            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM cinternet");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='verVitrina.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';
    }

    public function buscarVitrina($palabra){
        if($palabra == ''){
            $cant_reg = 30;//definimos la cantidad de datos que deseamos tenes por pagina.
            if(isset($_GET["pagina"])){
                $num_pag = $_GET["pagina"];//numero de la pagina
            }else{
                $num_pag = 1;
            }

            if(!$num_pag){//preguntamos si hay algun valor en $num_pag.
                $inicio = 0;
                $num_pag = 1;

            }else{//se activara si la variable $num_pag ha resivido un valor oasea se encuentra en la pagina 2 o ha si susecivamente 
                $inicio = ($num_pag-1)*$cant_reg;//si la pagina seleccionada es la numero 2 entonces 2-1 es = 1 por 10 = 10 empiesa a contar desde la 10 para la pagina 2 ok.
            }

            $result = mysql_query("SELECT * FROM cinternet");///hacemos una consulta de todos los datos de cinternet
           
            $total_registros=mysql_num_rows($result);//obtenesmos el numero de datos que nos devuelve la consulta

            $total_paginas = ceil($total_registros/$cant_reg);

            echo '<div class="pagination" style="display: none;">
                    ';
            if(($num_pag+1)<=$total_paginas){//preguntamos si el numero de la pagina es menor o = al total de paginas para que aparesca el siguiente
                
                echo "<ul><li class='next'> <a href='verVitrina.php?pagina=".($num_pag+1)."'> Next </a></li></ul>";
            } ;echo '
                   </div>';
            $resultado = mysql_query("SELECT * FROM cinternet WHERE tipoConcepto='vitrina' ORDER BY fecha DESC LIMIT $inicio,$cant_reg");//obtenemos los datos ordenados limitado con la variable inicio hasta la variable cant_reg
             //echo json_encode($resultado);
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['dinero'].'</td>
                        <td>'.$fila['tipoConcepto'].'</td>
                        <td>'.$fila['fecha'].'</td>
                        <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            }  
        }else{
            $resultado = mysql_query("SELECT * FROM cinternet WHERE tipoConcepto='vitrina' AND nombre LIKE'%$palabra%' OR fecha LIKE '%$palabra%' ORDER BY fecha DESC");
            //echo json_encode($resultado);
            while($fila = mysql_fetch_array($resultado)){
                   $salida = '<tr> 
                        <td>'.$fila['nombre'].'</td>
                        <td>'.$fila['dinero'].'</td>
                        <td>'.$fila['tipoConcepto'].'</td>
                        <td>'.$fila['fecha'].'</td>
                        <td><a id="edit" class="btn btn-mini btn-info" href="'.$fila['id'].'"><strong>Editar</strong></a></td>
                        <td><a id="delete" class="btn btn-mini btn-danger" href="'.$fila['id'].'"><strong>Eliminar</strong></a></td>
                    </tr>';
                              // echo $salida;
                    echo $salida;
            }  
        }
    }
    /*MODIFICAR DATOS DEL USUAIRO Y CREAR....*/
    public function editarNombreUser($nom,$cod){
        $nom = strtolower($nom);
        mysql_query("UPDATE usuarios SET nombre='$nom' WHERE id='$cod'") or die('problemas en el update de nombre'.mysql_error());
        session_start();
         if($_SESSION['id_user']){
             session_destroy();
         }
        $resultado=mysql_query("SELECT * FROM usuarios WHERE id='$cod'")
              or die('Problemas en el select de nombre usuarios'.mysql_error());
        $row=mysql_fetch_array($resultado);
        echo $row['nombre'];
        /*_______________________________*/
        session_start();
        $id_user=$row['id'];
        $user = $row['nombre'];
        $_SESSION['id_user']=$id_user;
        $_SESSION['nombre'] = $user;
    }

    public function cambiarClave($conA,$conN,$cod){
        $resultado = mysql_query("SELECT clave FROM usuarios WHERE clave='$conA'");
        
        if($row = mysql_fetch_array($resultado)){
            echo "Bien";
            $hash=sha1($conN);//incriptamos la contraseña
            mysql_query("UPDATE usuarios SET clave='$hash' WHERE clave='$conA'");
        }else{
            echo "Error";
        }
    }

    public function registrarUser($nom,$pass){
        $hash=sha1($pass);
         mysql_query("INSERT INTO usuarios (nombre,clave) VALUES ('$nom','$hash')") 
                       or die ("Error"); 
    }

  }//cierre de la clase
?>