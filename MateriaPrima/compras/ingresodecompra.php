<?php require_once('file:///C|/Users/Connections/basepangloria.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOCOMPRA (ID_DETENCCOM, IDPROVEEDOR, IDORDEN, IDEMPLEADO, ID_TIPO_FACTURA, IDESTAFACTURA, NOFACTURA, FECHACOMPRA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDORDEN'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_TIPO_FACTURA'], "int"),
                       GetSQLValueString($_POST['IDESTAFACTURA'], "int"),
                       GetSQLValueString($_POST['NOFACTURA'], "text"),
                       GetSQLValueString($_POST['FECHACOMPRA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_ComboTipodeFactura = "SELECT ID_TIPO_FACTURA, TIPOFACTURA FROM CATTIPOFACTURA";
$ComboTipodeFactura = mysql_query($query_ComboTipodeFactura, $basepangloria) or die(mysql_error());
$row_ComboTipodeFactura = mysql_fetch_assoc($ComboTipodeFactura);
$totalRows_ComboTipodeFactura = mysql_num_rows($ComboTipodeFactura);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ComboOrdendeCompra = "SELECT IDORDEN FROM TRNENCAORDCOMPRA";
$ComboOrdendeCompra = mysql_query($query_ComboOrdendeCompra, $basepangloria) or die(mysql_error());
$row_ComboOrdendeCompra = mysql_fetch_assoc($ComboOrdendeCompra);
$totalRows_ComboOrdendeCompra = mysql_num_rows($ComboOrdendeCompra);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820">
  <tr>
    <td><table width="99%" border="1">
      <tr>
        <td colspan="4" align="center"><h1>Formulario de Ingreso de Compra</h1></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Fecha</td>
        <td><input type="text" name="FECHACOMPRA" value="" size="32" /></td>
      </tr>
      <tr>
        <td>Codigo de Orden de Compra</td>
        <td><select name="IDORDEN">
          <?php
do {  
?>
          <option value="<?php echo $row_ComboOrdendeCompra['IDORDEN']?>"><?php echo $row_ComboOrdendeCompra['IDORDEN']?></option>
          <?php
} while ($row_ComboOrdendeCompra = mysql_fetch_assoc($ComboOrdendeCompra));
  $rows = mysql_num_rows($ComboOrdendeCompra);
  if($rows > 0) {
      mysql_data_seek($ComboOrdendeCompra, 0);
	  $row_ComboOrdendeCompra = mysql_fetch_assoc($ComboOrdendeCompra);
  }
?>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>ID_TIPO_FACTURA:</td>
        <td><select name="ID_TIPO_FACTURA">
          <?php
do {  
?>
          <option value="<?php echo $row_ComboTipodeFactura['ID_TIPO_FACTURA']?>"><?php echo $row_ComboTipodeFactura['TIPOFACTURA']?></option>
          <?php
} while ($row_ComboTipodeFactura = mysql_fetch_assoc($ComboTipodeFactura));
  $rows = mysql_num_rows($ComboTipodeFactura);
  if($rows > 0) {
      mysql_data_seek($ComboTipodeFactura, 0);
	  $row_ComboTipodeFactura = mysql_fetch_assoc($ComboTipodeFactura);
  }
?>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>No de Factura</td>
        <td><input type="text" name="NOFACTURA" value="" size="32" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      &nbsp;<iframe src="file:///C|/Users/claudia/Desktop/concompras.php" name="conte" width="820" height="400" scrolling="auto" frameborder="0"></iframe>
          
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
</form>
</body>
</html>
<?php
mysql_free_result($ComboTipodeFactura);

mysql_free_result($ComboOrdendeCompra);
?>
