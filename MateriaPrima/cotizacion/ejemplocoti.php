<?php require_once('../../Connections/basepangloria.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_provee = "SELECT IDPROVEEDOR, NOMBREPROVEEDOR FROM CATPROVEEDOR ORDER BY IDPROVEEDOR DESC";
$provee = mysql_query($query_provee, $basepangloria) or die(mysql_error());
$row_provee = mysql_fetch_assoc($provee);
$totalRows_provee = mysql_num_rows($provee);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboemple = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO ORDER BY IDEMPLEADO DESC";
$comboemple = mysql_query($query_comboemple, $basepangloria) or die(mysql_error());
$row_comboemple = mysql_fetch_assoc($comboemple);
$totalRows_comboemple = mysql_num_rows($comboemple);

mysql_select_db($database_basepangloria, $basepangloria);
$query_vende = "SELECT IDVENDEDOR, NOM FROM CATVENDEDOR_PROV ORDER BY IDVENDEDOR DESC";
$vende = mysql_query($query_vende, $basepangloria) or die(mysql_error());
$row_vende = mysql_fetch_assoc($vende);
$totalRows_vende = mysql_num_rows($vende);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combopago = "SELECT IDCONDICION, TIPO FROM CATCONDICIONPAGO ORDER BY IDCONDICION DESC";
$combopago = mysql_query($query_combopago, $basepangloria) or die(mysql_error());
$row_combopago = mysql_fetch_assoc($combopago);
$totalRows_combopago = mysql_num_rows($combopago);
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php    
   require_once('../../Connections/basepangloria.php'); 
   
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
   
   
   $q_matpri = "SELECT * FROM CATMATERIAPRIMA";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res2 = mysql_query($q_matpri, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);
   
   $cmb_matpri = '<select id="mp" name="mp">';
   while ($fila = mysql_fetch_assoc($res2)) {
        $cmb_matpri .= '<option value="'.$fila['IDMATPRIMA'].'">'.$fila['DESCRIPCION'].'</option>'; 
   }
   $cmb_matpri .= '</select>';
    
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
        <form name="principal" id="principal" enctype="multipart/form-data" method="post" autocomplete="off" action="guardar_ejemplo.php">   
        <h1 style="font-family: verdana; font-size: 0.9em; font-weight: bold; text-align: center;">Ingreso de Cotizaci&oacute;n</h1>
        <table style="font-family: verdana; font-size: 0.9em;">
            <tr>
                <td>Id Cotizacion</td>
                <td><input type="text" id="id_cotizacion"  name="id_cotizacion" size="15" value="<?php echo $pk_cotizacion ?>"></td>
            </tr>
            <tr>
                <td>Empleado</td>
                <td><label for="emple"></label>
                  <select name="emple" id="emple">
                    <?php
do {  
?>
                    <option value="<?php echo $row_comboemple['IDEMPLEADO']?>"><?php echo $row_comboemple['NOMBREEMPLEADO']?></option>
                    <?php
} while ($row_comboemple = mysql_fetch_assoc($comboemple));
  $rows = mysql_num_rows($comboemple);
  if($rows > 0) {
      mysql_data_seek($comboemple, 0);
	  $row_comboemple = mysql_fetch_assoc($comboemple);
  }
?>
                </select>                  <label for="comboproveedor"></label></td>
            </tr>
            <tr>
                <td>Proveedor</td>
                <td><select name="comboproveedor" id="comboproveedor">
                  <?php
do {  
?>
                  <option value="<?php echo $row_provee['IDPROVEEDOR']?>"><?php echo $row_provee['NOMBREPROVEEDOR']?></option>
                  <?php
} while ($row_provee = mysql_fetch_assoc($provee));
  $rows = mysql_num_rows($provee);
  if($rows > 0) {
      mysql_data_seek($provee, 0);
	  $row_provee = mysql_fetch_assoc($provee);
  }
?>
                </select></td>
            </tr>
            <tr>
                <td>Vendedor</td>
                <td><label for="combovende"></label>
                  <select name="combovende" id="combovende">
                    <?php
do {  
?>
                    <option value="<?php echo $row_vende['IDVENDEDOR']?>"><?php echo $row_vende['NOM']?></option>
                    <?php
} while ($row_vende = mysql_fetch_assoc($vende));
  $rows = mysql_num_rows($vende);
  if($rows > 0) {
      mysql_data_seek($vende, 0);
	  $row_vende = mysql_fetch_assoc($vende);
  }
?>
                </select></td>
            </tr>
        </table>
        <table style="font-family: verdana; font-size: 0.9em;">
            <tr>
                <td>Tipo de pago</td>
                <td><label for="tpago"></label>
                  <select name="tpago" id="tpago">
                    <?php
do {  
?>
                    <option value="<?php echo $row_combopago['IDCONDICION']?>"><?php echo $row_combopago['TIPO']?></option>
                    <?php
} while ($row_combopago = mysql_fetch_assoc($combopago));
  $rows = mysql_num_rows($combopago);
  if($rows > 0) {
      mysql_data_seek($combopago, 0);
	  $row_combopago = mysql_fetch_assoc($combopago);
  }
?>
                </select></td>
                <td>Validez</td>
                <td><input type="text" id="validez"  name="validez"  size="10"></td>
                <td>Plazo Entrega</td>
                <td><input type="text" id="dia_entrega"  name="dia_entrega"  size="10"></td>
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
                <td align="center"><input type="text" id="um"   name="um[]"></td>
                <td align="center"><input type="text" id="qtde" name="qtde[]"></td>
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
<?php
mysql_free_result($provee);

mysql_free_result($comboemple);

mysql_free_result($vende);

mysql_free_result($combopago);
?>
