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
$query_encacompra = "SELECT * FROM TRNENCABEZADOCOMPRA ORDER BY ID_DETENCCOM DESC";
$encacompra = mysql_query($query_encacompra, $basepangloria) or die(mysql_error());
$row_encacompra = mysql_fetch_assoc($encacompra);
$totalRows_encacompra = mysql_num_rows($encacompra);

$colname_consulTipFac = "-1";
if (isset($_POST['ID_TIPO_FACTURA'])) {
  $colname_consulTipFac = $_POST['ID_TIPO_FACTURA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$tipofac = $row_encacompra['ID_TIPO_FACTURA'];
$query_consulTipFac = sprintf("SELECT TIPOFACTURA FROM CATTIPOFACTURA WHERE ID_TIPO_FACTURA = '$tipofac' ORDER BY TIPOFACTURA ASC");
$consulTipFac = mysql_query($query_consulTipFac, $basepangloria) or die(mysql_error());
$row_consulTipFac = mysql_fetch_assoc($consulTipFac);
$totalRows_consulTipFac = mysql_num_rows($consulTipFac);

$colname_consulEstFac = "-1";
if (isset($_POST['IDESTAFACTURA'])) {
  $colname_consulEstFac = $_POST['IDESTAFACTURA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$estafact = $row_encacompra['IDESTAFACTURA'];
$query_consulEstFac = sprintf("SELECT ESTADO FROM CATESTADOFACTURA WHERE IDESTAFACTURA = '$estafact' ORDER BY ESTADO ASC");
$consulEstFac = mysql_query($query_consulEstFac, $basepangloria) or die(mysql_error());
$row_consulEstFac = mysql_fetch_assoc($consulEstFac);
$totalRows_consulEstFac = mysql_num_rows($consulEstFac);

$colname_ConsulProvee = "-1";
if (isset($_POST['IDPROVEEDOR'])) {
  $colname_ConsulProvee = $_POST['IDPROVEEDOR'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$conprovee=$row_encacompra['IDPROVEEDOR'];
$query_ConsulProvee = sprintf("SELECT NOMBREPROVEEDOR FROM CATPROVEEDOR WHERE IDPROVEEDOR = '$conprovee' ORDER BY NOMBREPROVEEDOR ASC");
$ConsulProvee = mysql_query($query_ConsulProvee, $basepangloria) or die(mysql_error());
$row_ConsulProvee = mysql_fetch_assoc($ConsulProvee);
$totalRows_ConsulProvee = mysql_num_rows($ConsulProvee);

$colname_consulEmple = "-1";
if (isset($_POST['IDEMPLEADO'])) {
  $colname_consulEmple = $_POST['IDEMPLEADO'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$consemplead = $row_encacompra['IDEMPLEADO'];
$query_consulEmple = sprintf("SELECT NOMBREEMPLEADO FROM CATEMPLEADO WHERE IDEMPLEADO = '$consemplead' ORDER BY NOMBREEMPLEADO ASC");
$consulEmple = mysql_query($query_consulEmple, $basepangloria) or die(mysql_error());
$row_consulEmple = mysql_fetch_assoc($consulEmple);
$totalRows_consulEmple = mysql_num_rows($consulEmple);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../css/forms.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820">
  <tr>
    <td align="center" class="encaforms">Ingreso de Compras</td>
  </tr>
  <tr>
    <td><table width="100%">
      <tr>
        <td>Codigo de Compra:</td>
        <td><?php echo $row_encacompra['ID_DETENCCOM']; ?></td>
        <td>Proveedor:</td>
        <td><?php echo $row_ConsulProvee['NOMBREPROVEEDOR']; ?></td>
      </tr>
      <tr>
        <td>Tipo de Factura:</td>
        <td><?php echo $row_consulTipFac['TIPOFACTURA']; ?></td>
        <td>Orden de Compra:</td>
        <td><?php echo $row_encacompra['IDORDEN']; ?></td>
      </tr>
      <tr>
        <td>Estado deFactura:</td>
        <td><?php echo $row_consulEstFac['ESTADO']; ?></td>
        <td>Empleado:</td>
        <td><?php echo $row_consulEmple['NOMBREEMPLEADO']; ?></td>
      </tr>
      <tr>
        <td>Factura de Referencia</td>
        <td><?php echo $row_encacompra['NOFACTURA']; ?></td>
        <td>Fecha de Compra:</td>
        <td><?php echo $row_encacompra['FECHACOMPRA']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><a href="encaingre.php" target="popup" onclick="window.open(this.href, this.target, 'width=810,height=285,resizable = 0'); return false;">Nuevo Encabezado</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Esta Orden no posee orden de Compra: 
      <input type="checkbox" name="chequeo" id="chequeo" />
    <label for="chequeo"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($encacompra);

mysql_free_result($consulTipFac);

mysql_free_result($consulEstFac);

mysql_free_result($ConsulProvee);

mysql_free_result($consulEmple);
?>
