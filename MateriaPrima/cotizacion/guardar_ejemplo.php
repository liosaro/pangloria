<?php
    require_once('../../Connections/basepangloria.php');
    $id_cotizacion  = $_POST['id_cotizacion'];
    $empleado       = $_POST['empleado'];
    $proveedor      = $_POST['proveedor'];
    $vendedor       = $_POST['vendedor'];
    $condicion_pago = $_POST['condicion_pago'];
    $validez        = $_POST['validez'];
    $dia_entrega    = $_POST['dia_entrega'];
    $cot            = $_POST['cot'];
    //$seq            = $_POST['seq'];
    $mp             = $_POST['mp'];
    $dp             = $_POST['dp'];
    $um             = $_POST['um'];
    $qtde           = $_POST['qtde'];
    $pu             = $_POST['pu'];

    $fecha = date('Y/m/d');
    $referenciaq  = "'0'";
    $filas        = 0;
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title></title>
    </head>
    <body>
        
        <?php
        
            $q_max = "SELECT MAX(IDENCABEZADO) AS MAX_IDENCABEZADO FROM TRNCABEZACOTIZACION";
            mysql_select_db($database_basepangloria, $basepangloria);
            $res1 = mysql_query($q_max, $basepangloria) or die(mysql_error());
            $rows = mysql_fetch_assoc($res1);
            
            $pk_cotizacion = $rows['MAX_IDENCABEZADO'];
            
            if(!$pk_cotizacion){
                $pk_cotizacion = 1;
            }else{
                $pk_cotizacion = $pk_cotizacion + 1;
            }
     
            $q_encabezado_cotizacion = "INSERT 
                                        INTO TRNCABEZACOTIZACION
                                            (
                                             IDENCABEZADO,
                                             IDVENDEDOR,
                                             IDPROVEEDOR,
                                             IDEMPLEADO,
                                             IDCONDICION,
                                             FECHACOTIZACION,
                                             VALIDEZOFERTA,
                                             PLAZOENTREGA
                                             )
                                       VALUES(
                                              $pk_cotizacion,
                                              $vendedor,
                                              $proveedor,
                                              $empleado, 
                                              $condicion_pago,
                                              '$fecha',
                                              $validez,
                                              $dia_entrega
                                              )";
            
            mysql_select_db($database_basepangloria, $basepangloria);
            $execute1 = mysql_query($q_encabezado_cotizacion, $basepangloria) or die(mysql_error());

            //echo $q_encabezado_cotizacion.'</br><hr>';
            
            for($c=0; $c<count($cot); $c++){


                        if(!$cot[$c]){
                        
                            //echo 'NO REGISTRAR</br><hr>';
                            
                        }else{

                            $q_detalle_cotizacion = "INSERT 
                                                     INTO TRNDETALLECOTIZACION
                                                           (
                                                            IDMATPRIMA,
                                                            IDENCABEZADO,
                                                            IDUNIDAD,
                                                            CANTPRODUCTO,
                                                            PRECIOUNITARIO)
                                                     VALUES(
                                                            $mp[$c],
                                                            $pk_cotizacion,
                                                            $um[$c],
                                                            $qtde[$c],
                                                            $pu[$c]
                                                            )";

                            mysql_select_db($database_basepangloria, $basepangloria);
                            $execute2 = mysql_query($q_detalle_cotizacion, $basepangloria) or die(mysql_error());
                            
                            //echo $q_detalle_cotizacion.'</br><hr>';
                            
                            
                        }
        
            }
            
           
            echo '<a href="ejemplo.php">Ingresar otra Cotiacion</a>'; 
			
			echo '<td><tr><a href="www.liosarpc.info/pan/MateriaPrima/proceso/promateriaprima/base.php">Salir</a></tr></td>';
			
            
        ?>
        
    </body>
</html>
