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
        <td><?php echo $row_encacompra['IDPROVEEDOR']; ?></td>
      </tr>
      <tr>
        <td>Tipo de Factura:</td>
        <td><?php echo $row_encacompra['ID_TIPO_FACTURA']; ?></td>
        <td>Orden de Compra:</td>
        <td><?php echo $row_encacompra['IDORDEN']; ?></td>
      </tr>
      <tr>
        <td>Estado deFactura:</td>
        <td><?php echo $row_encacompra['IDESTAFACTURA']; ?></td>
        <td>Empleado:</td>
        <td><?php echo $row_encacompra['IDEMPLEADO']; ?></td>
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
        <td align="right"><a href="compras.php" target="popup" onclick="window.open(this.href, this.target, 'width=810,height=285,resizable = 0'); return false;">Nuevo Encabezado</a></td>
      </tr>
    </table></td>
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
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($encacompra);
?>
