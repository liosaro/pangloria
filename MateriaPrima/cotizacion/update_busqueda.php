<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
   require_once('../../Connections/basepangloria.php');

   $id_cotizacion  = $_POST['id_cotizacion'];
   
   $q1 = "SELECT CEN.IDENCABEZADO, 
                 CEN.IDVENDEDOR,
                 (SELECT NOM from CATVENDEDOR_PROV where CATVENDEDOR_PROV.IDVENDEDOR = CEN.IDVENDEDOR) NOMBRE_VENDEDOR,
                 CEN.IDPROVEEDOR,  
                 (SELECT NOMBREPROVEEDOR from CATPROVEEDOR where CATPROVEEDOR.IDPROVEEDOR = CEN.IDPROVEEDOR) NOMBRE_PROVEEDOR,
                 CEN.IDEMPLEADO,
                 (SELECT NOMBREEMPLEADO from CATEMPLEADO where CATEMPLEADO.IDEMPLEADO = CEN.IDEMPLEADO) NOMBRE_EMPLEADO,
                 CEN.IDCONDICION,
                 CEN.FECHACOTIZACION,
                 CEN.VALIDEZOFERTA,
                 CEN.PLAZOENTREGA,
                 CDE.IDDETALLE,
                 CDE.IDMATPRIMA,
                 (SELECT DESCRIPCION from CATMATERIAPRIMA where CATMATERIAPRIMA.IDMATPRIMA = CDE.IDMATPRIMA)MATERIA_PRIMA,
                 CDE.IDENCABEZADO IDENCABEZADO_DET,
                 CDE.IDUNIDAD,
                 CDE.CANTPRODUCTO,
                 CDE.PRECIOUNITARIO
         FROM TRNCABEZACOTIZACION CEN, TRNDETALLECOTIZACION CDE
         WHERE CEN.IDENCABEZADO = $id_cotizacion
           AND CEN.IDENCABEZADO = CDE.IDENCABEZADO 
           AND CEN.ELIMIN       = 0
           AND CDE.ELIMINA      = 0
         ORDER BY CEN.IDENCABEZADO, 
                  CDE.IDDETALLE";  
   
   mysql_select_db($database_basepangloria, $basepangloria);
   $rrr = mysql_query($q1, $basepangloria) or die(mysql_error());
   
   while ($fila = mysql_fetch_assoc($rrr)) {
       
         $vidven = $fila['IDVENDEDOR'];
         $vidpro = $fila['IDPROVEEDOR'];
         $videmp = $fila['IDEMPLEADO'];
         $vtipopago = $fila['IDCONDICION'];
         $vval = $fila['VALIDEZOFERTA'];
                 $vpla = $fila['PLAZOENTREGA'];
               
   }
   
   
   
   $q2 = "SELECT CEN.IDENCABEZADO,
                 CEN.IDVENDEDOR,
                 (SELECT NOM from CATVENDEDOR_PROV where CATVENDEDOR_PROV.IDVENDEDOR = CEN.IDVENDEDOR) NOMBRE_VENDEDOR,
                 CEN.IDPROVEEDOR,
                 (SELECT NOMBREPROVEEDOR from CATPROVEEDOR where CATPROVEEDOR.IDPROVEEDOR = CEN.IDPROVEEDOR) NOMBRE_PROVEEDOR,
                 CEN.IDEMPLEADO,
                 (SELECT NOMBREEMPLEADO from CATEMPLEADO where CATEMPLEADO.IDEMPLEADO = CEN.IDEMPLEADO) NOMBRE_EMPLEADO,
                 CEN.IDCONDICION,
                 CEN.FECHACOTIZACION,
                 CEN.VALIDEZOFERTA,
                 CEN.PLAZOENTREGA,
                 CDE.IDDETALLE,
                 CDE.IDMATPRIMA,
                 (SELECT DESCRIPCION from CATMATERIAPRIMA where CATMATERIAPRIMA.IDMATPRIMA = CDE.IDMATPRIMA)MATERIA_PRIMA,
                 CDE.IDENCABEZADO IDENCABEZADO_DET,
                 CDE.IDUNIDAD,
                 (SELECT TIPOUNIDAD FROM CATUNIDADES WHERE CATUNIDADES.IDUNIDAD = CDE.IDUNIDAD) DESC_UNIDAD,
                 CDE.CANTPRODUCTO,
                 CDE.PRECIOUNITARIO
         FROM TRNCABEZACOTIZACION CEN, TRNDETALLECOTIZACION CDE
         WHERE CEN.IDENCABEZADO = $id_cotizacion
           AND CEN.IDENCABEZADO = CDE.IDENCABEZADO 
         ORDER BY CEN.IDENCABEZADO,
                  CDE.IDDETALLE";
   
   mysql_select_db($database_basepangloria, $basepangloria);
   $xxx = mysql_query($q2, $basepangloria) or die(mysql_error());


   
   /*$q_max = "SELECT MAX(IDENCABEZADO) AS MAX_IDENCABEZADO FROM TRNCABEZACOTIZACION";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res1 = mysql_query($q_max, $basepangloria) or die(mysql_error());
   $rows = mysql_fetch_assoc($res1);

   $pk_cotizacion = $rows['MAX_IDENCABEZADO'];
            
   if(!$pk_cotizacion){
       $pk_cotizacion = 1;
   }else{
       $pk_cotizacion = $pk_cotizacion + 1;
   }*/
   
   
   $q_matpri = "SELECT * FROM CATMATERIAPRIMA";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res2 = mysql_query($q_matpri, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_matpri = '<select id="mp" name="mp[]">';
   while ($fila = mysql_fetch_assoc($res2)) {
        $cmb_matpri .= '<option value="'.$fila['IDMATPRIMA'].'">'.$fila['DESCRIPCION'].'</option>';
   }
   $cmb_matpri .= '</select>';


    $q_um = "SELECT * FROM CATUNIDADES";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res9 = mysql_query($q_um, $basepangloria) or die(mysql_error());

   $cmb_um = '<select id="mp" name="um[]">';
   while ($fila = mysql_fetch_assoc($res9)) {
        $cmb_um .= '<option value="'.$fila['IDUNIDAD'].'">'.$fila['TIPOUNIDAD'].'</option>';
   }
   $cmb_um .= '</select>';

   
   
   $q_emp = "SELECT * FROM CATEMPLEADO";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res3 = mysql_query($q_emp, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_emp = '<select id="empleado"  name="empleado">';
   while ($fila = mysql_fetch_assoc($res3)) {
       
        if($fila['IDEMPLEADO'] == $videmp){ $selemp = 'selected'; } else { $selemp = ''; }
        $cmb_emp .= '<option value="'.$fila['IDEMPLEADO'].'" '.$selemp.'>'.$fila['NOMBREEMPLEADO'].'</option>';
   }
   $cmb_emp .= '</select>';

   
   
   
   
   $q_prove = "SELECT * FROM CATPROVEEDOR";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res4 = mysql_query($q_prove, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_prove = '<select id="proveedor"  name="proveedor">';
   while ($fila = mysql_fetch_assoc($res4)) {
        if($fila['IDPROVEEDOR'] == $vidpro){ $selprov = 'selected'; } else { $selprov = ''; }
        $cmb_prove .= '<option value="'.$fila['IDPROVEEDOR'].'" '.$selprov.'>'.$fila['NOMBREPROVEEDOR'].'</option>';
   }
   $cmb_prove .= '</select>';

   
   
   
   
   
   $q_vend = "SELECT * FROM CATVENDEDOR_PROV";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res5 = mysql_query($q_vend, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_vend = '<select id="vendedor"  name="vendedor">';
   while ($fila = mysql_fetch_assoc($res5)) {
        if($fila['IDPROVEEDOR'] == $vidven){ $selven = 'selected'; } else { $selven = ''; }
        $cmb_vend .= '<option value="'.$fila['IDVENDEDOR'].'"  '.$selven.'>'.$fila['NOM'].'</option>';
   }
   $cmb_vend .= '</select>';


   
   
   
   $q_tipop = "SELECT * FROM CATCONDICIONPAGO";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res6 = mysql_query($q_tipop, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_tipop = '<select id="condicion_pago"  name="condicion_pago">';     
   while ($fila = mysql_fetch_assoc($res6)) {
        if($fila['IDPROVEEDOR'] == $vtipopago){ $selcon = 'selected'; } else { $selcon = ''; } 
        $cmb_tipop .= '<option value="'.$fila['IDCONDICION'].'"  '.$selcon.'>'.$fila['TIPO'].'</option>';
   }
   $cmb_tipop .= '</select>';

?>




<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Actualizacion de Cotizaci&oacute;n</title>

    </head>
    <body>
    <table width="820" style="font-family: verdana; font-size: 0.9em;">
        <td align="center" bgcolor="#999999">
        <form name="principal" id="principal" enctype="multipart/form-data" method="post" autocomplete="off" action="update_cotizacion.php">
          <h1>&nbsp;</h1>
           
        <h1 style="font-family: verdana; font-size: 0.9em; font-weight: bold; text-align: center;"><h1>Actualizacion de Cotizaci&oacute;n</h1>
        </table>
        <table style="font-family: verdana; font-size: 0.9em;">
            <tr>
                <td>Id Cotizacion</td>
                <td><input type="text" id="id_cotizacion"  name="id_cotizacion" size="15" value="<?php echo $id_cotizacion ?>" readonly></td>
            </tr>
            <tr>
                <td>Empleado</td>
                <td><?php echo $cmb_emp ?></td>
            </tr>
             <tr>
                <td>Proveedor</td>
                <td><?php echo $cmb_prove ?></td>
            </tr>

                <tr>
                <td>Vendedor</td>
                <td><?php echo $cmb_vend ?></td>
            </tr>

        </table>
        <table style="font-family: verdana; font-size: 0.9em;">
            <tr>
                  <tr>
                <td>Tipo de Pago</td>
                <td><?php echo $cmb_tipop ?></td>

                <td>Validez</td>
                <td><input type="text" id="validez"  name="validez"  size="5"  value="<?php echo $vval ?>">Dias &nbsp;&nbsp;</td>
                <td>Plazo Entrega</td>
                <td><input type="text" id="dia_entrega"  name="dia_entrega"  size="5"  value="<?php echo $vpla ?>">Dias</td>
            </tr>
        </table></br>

        <p style="font-family: verdana; font-size: 0.9em; font-weight: bold;">DETALLE DE ITEMS</p>
        
       
        <?php



        $tabla = '</br>
                  <table border="1" cellspacing="0" cellpadding="3">
                    <tr>
                        <th>MATERIA PRIMA</th>
                        <th>UM</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO UNITARIO</th>
                        <th>SUBTOTAL</th>
                    </tr>';


          while ($fila = mysql_fetch_assoc($xxx)) {

                       $subtotal = $fila['CANTPRODUCTO'] * $fila['PRECIOUNITARIO'];

                      $tabla .= '<tr>
                                    <td align="right">'. $cmb_matpri .'</td>
                                    <td align="right"> '.$cmb_um.'    </td>
                                    <td align="right"><input type="text" id="qtde" name="qtde[]" value="'.$fila['CANTPRODUCTO'].'"></td>
                                    <td align="right"><input type="text" id="pu"   name="pu[]" value="'.$fila['PRECIOUNITARIO'].'"></td>
                                    <td align="right">$'.$subtotal.'</td>

                                  </tr>';


                       $total    += $subtotal;

                  }

         $tabla .= '<tr>
                       <td colspan="4" align="right"><strong>TOTAL</strong></td>
                       <td align="right"><strong> $'.$total.'</strong></td>
                    </tr>
                    </table>
                    </br>
                    <input type="submit" value="ACTUALIZAR COTIZACION">';
         
         echo $tabla;

        ?>


        
        </form>
        <?php
            //echo $videmp;
        ?>
    </body>
</html>
