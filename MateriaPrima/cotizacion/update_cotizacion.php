<?php
    require_once('../../Connections/basepangloria.php');

    $id_cotizacion  = $_POST['id_cotizacion'];
    $condicion_pago = $_POST['condicion_pago'];
    $validez        = $_POST['validez'];
    $dia_entrega    = $_POST['dia_entrega'];
    // $cot            = $_POST['cot'];
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

            $q_encabezado_cotizacion = "UPDATE TRNCABEZACOTIZACION
                                           SET IDCONDICION             = $condicion_pago,
                                               FECHACOTIZACION         = '$fecha',
                                               VALIDEZOFERTA           = $validez,
                                               PLAZOENTREGA            = $dia_entrega
                                        WHERE  IDENCABEZADO            = $id_cotizacion";

            mysql_select_db($database_basepangloria, $basepangloria);
            $execute1 = mysql_query($q_encabezado_cotizacion, $basepangloria) or die(mysql_error());

            //echo $q_encabezado_cotizacion.'</br><hr>';

            for($c=0; $c<count($mp); $c++){


                            $q_detalle_cotizacion = "UPDATE TRNDETALLECOTIZACION
                                                        SET IDMATPRIMA             = $mp[$c],
                                                            IDUNIDAD               = $um[$c],
                                                            CANTPRODUCTO           = $qtde[$c],
                                                            PRECIOUNITARIO         = $pu[$c]
                                                      WHERE IDENCABEZADO           = $id_cotizacion";

                            mysql_select_db($database_basepangloria, $basepangloria);
                            $execute2 = mysql_query($q_detalle_cotizacion, $basepangloria) or die(mysql_error());


            }


            echo '<a href="update_buscar.php">Ingresar otra factura</a>';

        ?>



    </body>
</html>
