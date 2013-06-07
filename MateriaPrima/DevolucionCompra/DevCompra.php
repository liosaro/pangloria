<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
   require_once('../../Connections/basepangloria.php');
   
   $q_max = "SELECT MAX(IDDEVOLUCION) AS MAX_IDDEVOLUCION FROM TRNDEVOLUCIONCOMPRA";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res1 = mysql_query($q_max, $basepangloria) or die(mysql_error());
   $rows = mysql_fetch_assoc($res1);

   $pk_devolucion = $rows['MAX_IDDEVOLUCION'];
            
   if(!$pk_devolucion){
       $pk_devolucion = 1;
   }else{
       $pk_devolucion = $pk_devolucion + 1;
   }
   
   
   $q_matpri = "SELECT * FROM CATMATERIAPRIMA where ELIMIN = 0";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res2 = mysql_query($q_matpri, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_matpri = '<select id="mp" name="mp[]">';
   while ($fila = mysql_fetch_assoc($res2)) {
        $cmb_matpri .= '<option value="'.$fila['IDMATPRIMA'].'">'.$fila['DESCRIPCION'].'</option>';
   }
   $cmb_matpri .= '</select>';

   $q_uni = "SELECT * FROM CATUNIDADES where ELIMIN = 0";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res3 = mysql_query($q_uni, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_um = '<select id="um" name="um[]">';
   while ($fila = mysql_fetch_assoc($res3)) {
        $cmb_um .= '<option value="'.$fila['IDUNIDAD'].'">'.$fila['TIPOUNIDAD'].'</option>';
   }
   $cmb_um .= '</select>';
   

   $q_emp = "SELECT * FROM CATEMPLEADO where ELIMIN = 0";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res4 = mysql_query($q_emp, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_emp = '<select id="empleado"  name="empleado">';
   while ($fila = mysql_fetch_assoc($res4)) {
        $cmb_emp .= '<option value="'.$fila['IDEMPLEADO'].'">'.$fila['NOMBREEMPLEADO'].'</option>';
   }
   $cmb_emp .= '</select>';

    $q_prove = "SELECT * FROM CATPROVEEDOR where ELIMIN = 0";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res5 = mysql_query($q_prove, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_prove = '<select id="proveedor"  name="proveedor">';
   while ($fila = mysql_fetch_assoc($res5)) {
        $cmb_prove .= '<option value="'.$fila['IDPROVEEDOR'].'">'.$fila['NOMBREPROVEEDOR'].'</option>';
   }
   $cmb_prove .= '</select>';

     $q_vend = "SELECT * FROM CATVENDEDOR_PROV";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res6 = mysql_query($q_vend, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_vend = '<select id="vendedor"  name="vendedor">';
   while ($fila = mysql_fetch_assoc($res6)) {
        $cmb_vend .= '<option value="'.$fila['IDVENDEDOR'].'">'.$fila['NOM'].'</option>';
   }
   $cmb_vend .= '</select>';


     $q_tipop = "SELECT * FROM CATCONDICIONPAGO where ELIMIN = 0";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res7 = mysql_query($q_tipop, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_tipop = '<select id="condicion_pago"  name="condicion_pago">';
   while ($fila = mysql_fetch_assoc($res7)) {
        $cmb_tipop .= '<option value="'.$fila['IDCONDICION'].'">'.$fila['TIPO'].'</option>';
   }
   $cmb_tipop .= '</select>';
   
 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Ingreso de Cotizacion</title>

        <script language="javascript" type="text/javascript">
                  function addLinha(){

                        var tab      = document.getElementById("detalle");
                        var pkcot    = document.getElementById("id_cotizacion").value;

                        var linha        = tab.insertRow(tab.rows.length);
                        var lin          = (tab.rows.length - 2);


                        coluna1 = linha.insertCell(0);
                        coluna1.align = "center";
                        coluna1.innerHTML = '<tr><td><input type="text" name="cot[]"  value="'+ pkcot +'"></td>';

                        coluna1 = linha.insertCell(1);
                        coluna1.align = "center";
                        coluna1.innerHTML = '<td><?php echo $cmb_matpri ?></td>';

                        coluna1 = linha.insertCell(2);
                        coluna1.align = "center";
                        coluna1.innerHTML = '<td><?php echo $cmb_um ?></td>';

                        coluna1 = linha.insertCell(3);
                        coluna1.align = "center";
                        coluna1.innerHTML = '<td><input type="text" name="qtde[]"></td>';

                        coluna1 = linha.insertCell(4);
                        coluna1.align = "center";
                        coluna1.innerHTML = '<td><input type="text" name="pu[]"></td>';

                        coluna1 = linha.insertCell(5);
                        coluna1.align = "center";
                        coluna1.innerHTML = '<td><input type="button"  onClick="addLinha()"  value="+"></td>';


                 return true;
                }
        </script>

    </head>
    <body>
    <table width="820" style="font-family: verdana; font-size: 0.9em;">
        <td align="center" bgcolor="#999999"><form name="principal" id="principal" enctype="multipart/form-data" method="post" autocomplete="off" action="guardar_ejemplo.php">
          <h1>&nbsp;</h1>
           
        <h1 style="font-family: verdana; font-size: 0.9em; font-weight: bold; text-align: center;">
        <h1>Ingreso de Devolucion de Compra</h1>
        </table>
        <table style="font-family: verdana; font-size: 0.9em;">
            <tr>
                <td>Id Devolucion:</td>
                <td><input type="text" id="id_devolucion"  name="id_devolucion" size="15" value="<?php echo $pk_devolucion ?>"></td>
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
                <td><input type="text" id="validez"  name="validez"  size="5">Dias &nbsp;&nbsp;</td>
                <td>Plazo Entrega</td>
                <td><input type="text" id="dia_entrega"  name="dia_entrega"  size="5">Dias</td>
            </tr>
        </table></br>

        <p style="font-family: verdana; font-size: 0.9em; font-weight: bold;">DETALLE DE ITEMS</p>
        
        <table  id="detalle"  name="detalle"  style="font-family: verdana; font-size: 0.9em;">
            <tr>
                <th>COT.</th> 
                <th>MATERIA PRIMA</th>
                <th>UM</th>
                <th>CANTIDAD</th>
                <th>PRECIO UNITARIO</th>
            </tr>
            <tr>
                <td align="center"><input type="text" id="cot"  name="cot[]"  value="<?php echo $pk_cotizacion ?>" readonly></td>
                <!--<td><input type="text" id="seq"  name="seq[]" readonly></td>-->
                <!--<td><input type="text" id="mp"   name="mp[]"></td>-->
                <td align="center"><?php echo $cmb_matpri ?></td>
                <td align="center"><?php echo $cmb_um ?></td> 
                              
                <!--<td align="center"><input type="text" id="um"   name="um[]"></td>-->        <td align="center"><input type="text" id="qtde" name="qtde[]"></td>
                <td align="center"><input type="text" id="pu"   name="pu[]"></td>
                <td align="center"><input type="button" onClick="addLinha()" value="+"</td>
            </tr>
         </table></br>

        <input type="submit" value="GUARDAR COTIZACION"> 
        </form> 
        <?php
           // put your code here
        ?>
    </body>
</html>
