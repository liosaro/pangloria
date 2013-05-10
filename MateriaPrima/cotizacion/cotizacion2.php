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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNCABEZACOTIZACION (IDENCABEZADO, IDVENDEDOR, IDPROVEEDOR, IDEMPLEADO, IDCONDICION, FECHACOTIZACION, VALIDEZOFERTA, PLAZOENTREGA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDVENDEDOR'], "int"),
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDCONDICION'], "int"),
                       GetSQLValueString($_POST['FECHACOTIZACION'], "date"),
                       GetSQLValueString($_POST['VALIDEZOFERTA'], "int"),
                       GetSQLValueString($_POST['PLAZOENTREGA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO TRNDETALLECOTIZACION (IDDETALLE, IDMATPRIMA, IDENCABEZADO, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDETALLE'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANTPRODUCTO'], "int"),
                       GetSQLValueString($_POST['PRECIOUNITARIO'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_combovendedor = "SELECT IDVENDEDOR, NOM FROM CATVENDEDOR_PROV";
$combovendedor = mysql_query($query_combovendedor, $basepangloria) or die(mysql_error());
$row_combovendedor = mysql_fetch_assoc($combovendedor);
$totalRows_combovendedor = mysql_num_rows($combovendedor);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboproveedor = "SELECT IDPROVEEDOR, NOMBREPROVEEDOR FROM CATPROVEEDOR";
$comboproveedor = mysql_query($query_comboproveedor, $basepangloria) or die(mysql_error());
$row_comboproveedor = mysql_fetch_assoc($comboproveedor);
$totalRows_comboproveedor = mysql_num_rows($comboproveedor);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <p>&nbsp;</p>
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDENCABEZADO:</td>
            <td><input type="text" name="IDENCABEZADO" value="" size="32" />
siguiente
  <input type="button" name="siguiente" id="siguiente" value="next" />
  <?php echo $totalRows_comboproveedor ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDVENDEDOR:</td>
            <td><select name="IDVENDEDOR">
              <?php
do {  
?>
              <option value="<?php echo $row_combovendedor['IDVENDEDOR']?>"><?php echo $row_combovendedor['NOM']?></option>
              <?php
} while ($row_combovendedor = mysql_fetch_assoc($combovendedor));
  $rows = mysql_num_rows($combovendedor);
  if($rows > 0) {
      mysql_data_seek($combovendedor, 0);
	  $row_combovendedor = mysql_fetch_assoc($combovendedor);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDPROVEEDOR:</td>
            <td><select name="IDPROVEEDOR">
              <?php
do {  
?>
              <option value="<?php echo $row_combovendedor['IDVENDEDOR']?>"><?php echo $row_combovendedor['NOM']?></option>
              <?php
} while ($row_combovendedor = mysql_fetch_assoc($combovendedor));
  $rows = mysql_num_rows($combovendedor);
  if($rows > 0) {
      mysql_data_seek($combovendedor, 0);
	  $row_combovendedor = mysql_fetch_assoc($combovendedor);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDEMPLEADO:</td>
            <td><select name="IDEMPLEADO">
              <?php
do {  
?>
              <option value="<?php echo $row_empleado['IDEMPLEADO']?>"><?php echo $row_empleado['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_empleado = mysql_fetch_assoc($empleado));
  $rows = mysql_num_rows($empleado);
  if($rows > 0) {
      mysql_data_seek($empleado, 0);
	  $row_empleado = mysql_fetch_assoc($empleado);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDCONDICION:</td>
            <td><select name="IDCONDICION">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">FECHACOTIZACION:</td>
            <td><input type="text" name="FECHACOTIZACION" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">VALIDEZOFERTA:</td>
            <td><input type="text" name="VALIDEZOFERTA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">PLAZOENTREGA:</td>
            <td><input type="text" name="PLAZOENTREGA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDDETALLE:</td>
            <td><select name="IDDETALLE">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDMATPRIMA:</td>
            <td><select name="IDMATPRIMA">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDENCABEZADO:</td>
            <td><input type="text" name="IDENCABEZADO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDUNIDAD:</td>
            <td><input type="text" name="IDUNIDAD" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CANTPRODUCTO:</td>
            <td><input type="text" name="CANTPRODUCTO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">PRECIOUNITARIO:</td>
            <td><input type="text" name="PRECIOUNITARIO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form3" />
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($combovendedor);

mysql_free_result($comboproveedor);

mysql_free_result($empleado);
?>
