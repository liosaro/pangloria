<?php
    require_once('../../Connections/basepangloria.php');
    $id_cotizacion  = $_POST['id_cotizacion'];
    
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title></title>
    </head>
    <body>
        
        <?php
            
            $q_detalle_cotizacion = "UPDATE TRNDETALLECOTIZACION SET ELIMINA = 1 WHERE IDENCABEZADO = $id_cotizacion";
            mysql_select_db($database_basepangloria, $basepangloria);
            $execute2 = mysql_query($q_detalle_cotizacion, $basepangloria) or die(mysql_error());
        
        
            $q_encabezado_cotizacion = "UPDATE TRNCABEZACOTIZACION SET ELIMIN = 1 WHERE IDENCABEZADO = $id_cotizacion";  
            mysql_select_db($database_basepangloria, $basepangloria);
            $execute1 = mysql_query($q_encabezado_cotizacion, $basepangloria) or die(mysql_error());

            
            echo '<a href="ejemplo_buscar.php">Buscar otra factura.</a>';
            
        ?>
        
    </body>
</html>
