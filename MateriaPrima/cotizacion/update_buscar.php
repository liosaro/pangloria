<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
   require_once('../../Connections/basepangloria.php');

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
          WHERE CEN.IDENCABEZADO = CDE.IDENCABEZADO
            AND CEN.ELIMIN       = 0
            AND CDE.ELIMINA      = 0
          ORDER BY CEN.IDENCABEZADO, 
                   CDE.IDDETALLE";
   
    mysql_select_db($database_basepangloria, $basepangloria);
    $res1 = mysql_query($q1, $basepangloria) or die(mysql_error());
    
   
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
                        coluna1.innerHTML = '<td><input type="text" name="um[]"></td>';

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
        <td align="center" bgcolor="#999999"><form name="principal" id="principal" enctype="multipart/form-data" method="post" autocomplete="off" action="update_busqueda.php">
          <h1>&nbsp;</h1>
           
        <h1 style="font-family: verdana; font-size: 0.9em; font-weight: bold; text-align: center;"><h1>Busqueda de Cotizaci&oacute;n</h1>
        </table>
        <table style="font-family: verdana; font-size: 0.9em;">
            <tr>
                <td>Id Cotizacion</td>
                <td><input type="text" id="id_cotizacion"  name="id_cotizacion" size="15" value=""> <input type="submit" value="BUSCAR"></td>
            </tr>
            <!--<tr>
                <td>Empleado</td>
                <td><input type="text" id="empleado"  name="empleado" size="15" value=""></td>
            </tr>
             <tr>
                <td>Proveedor</td>
                <td><input type="text" id="proveedor"  name="proveedor" size="15" value=""></td>
            </tr>

                <tr>
                <td>Vendedor</td>
                <td><input type="text" id="vendedor"  name="vendedor" size="15" value=""></td>
            </tr>-->

        </table>
       

        </br>
        
        <?php
        
        $tabla = '</br>
                  <table border="1" cellspacing="0" cellpadding="3">
                    <tr>
                        <th>ID COTIZACION</th>
                        <th>VENDEDOR</th>
                        <th>PROVEEDOR</th>
                        <th>EMPLEADO</th>
                        <th>CONDICION</th>
                        <th>FECHA COTIZACION</th>
                        <th>VALIDEZ OFERTA</th>
                        <th>PLAZO ENTREGA</th>
                    </tr>';
                      
                  
                  while ($fila = mysql_fetch_assoc($res1)) {
                       
                       $tabla .= '<tr>
                                    <td>'.$fila['IDENCABEZADO'].'</td>
                                    <td>'.$fila['NOMBRE_VENDEDOR'].'</td>
                                    <td>'.$fila['NOMBRE_PROVEEDOR'].'</td>    
                                    <td>'.$fila['NOMBRE_EMPLEADO'].'</td>   
                                    <td>'.$fila['IDCONDICION'].'</td>    
                                    <td>'.$fila['FECHACOTIZACION'].'</td>
                                    <td>'.$fila['VALIDEZOFERTA'].'</td> 
                                    <td>'.$fila['PLAZOENTREGA'].'</td>
                                  </tr>'; 
                       
                       
                  }
                 
                  
                    
         $tabla .= '</table>';
         echo $tabla; 
        
        ?>
        
        </form> 
        <?php
           // put your code here
        ?>
    </body>
</html>
