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
}if (!function_exists("GetSQLValueString")) {
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

$maxRows_fecha = 10;
$pageNum_fecha = 0;
if (isset($_GET['pageNum_fecha'])) {
  $pageNum_fecha = $_GET['pageNum_fecha'];
}
$startRow_fecha = $pageNum_fecha * $maxRows_fecha;

$colname_fecha = "-1";
if (isset($_GET['FECHADEVOLUCION'])) {
  $colname_fecha = $_GET['FECHADEVOLUCION'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_fecha = sprintf("SELECT * FROM TRNDEVOLUCIONCOMPRA WHERE FECHADEVOLUCION LIKE %s ORDER BY IDDEVOLUCION ASC", GetSQLValueString("%" . $colname_fecha . "%", "date"));
$query_limit_fecha = sprintf("%s LIMIT %d, %d", $query_fecha, $startRow_fecha, $maxRows_fecha);
$fecha = mysql_query($query_limit_fecha, $basepangloria) or die(mysql_error());
$row_fecha = mysql_fetch_assoc($fecha);

if (isset($_GET['totalRows_fecha'])) {
  $totalRows_fecha = $_GET['totalRows_fecha'];
} else {
  $all_fecha = mysql_query($query_fecha);
  $totalRows_fecha = mysql_num_rows($all_fecha);
}
$totalPages_fecha = ceil($totalRows_fecha/$maxRows_fecha)-1;

$colname_empleado = "-1";
if (isset($_GET['root'])) {
  $colname_empleado = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = sprintf("SELECT * FROM TRNDEVOLUCIONCOMPRA WHERE IDDEVOLUCION LIKE %s ORDER BY IDEMPLEADO ASC", GetSQLValueString("%" . $colname_empleado . "%", "text"));
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
  </tr>
  <tr>
    <td>IDDEVOLUCION</td>
    <td>IDEMPLEADO</td>
    <td>ID_DETENCCOM</td>
    <td>DOCADEVOLVER</td>
    <td>FECHADEVOLUCION</td>
    <td>IMPORTE</td>
    <td>GASTOGENERADO</td>
    <td>OBSERVACION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_fecha['IDDEVOLUCION']; ?></td>
      <td><?php echo $row_fecha['IDEMPLEADO']; ?></td>
      <td><?php echo $row_fecha['ID_DETENCCOM']; ?></td>
      <td><?php echo $row_fecha['DOCADEVOLVER']; ?></td>
      <td><?php echo $row_fecha['FECHADEVOLUCION']; ?></td>
      <td><?php echo $row_fecha['IMPORTE']; ?></td>
      <td><?php echo $row_fecha['GASTOGENERADO']; ?></td>
      <td><?php echo $row_fecha['OBSERVACION']; ?></td>
    </tr>
    <?php } while ($row_fecha = mysql_fetch_assoc($fecha)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($fecha);
?>
