<?php require_once('Connections/basepangloria.php'); ?>
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

$maxRows_devolucion = 10;
$pageNum_devolucion = 0;
if (isset($_GET['pageNum_devolucion'])) {
  $pageNum_devolucion = $_GET['pageNum_devolucion'];
}
$startRow_devolucion = $pageNum_devolucion * $maxRows_devolucion;

mysql_select_db($database_basepangloria, $basepangloria);
$query_devolucion = "SELECT * FROM TRNDEVOLUCIONCOMPRA";
$query_limit_devolucion = sprintf("%s LIMIT %d, %d", $query_devolucion, $startRow_devolucion, $maxRows_devolucion);
$devolucion = mysql_query($query_limit_devolucion, $basepangloria) or die(mysql_error());
$row_devolucion = mysql_fetch_assoc($devolucion);

if (isset($_GET['totalRows_devolucion'])) {
  $totalRows_devolucion = $_GET['totalRows_devolucion'];
} else {
  $all_devolucion = mysql_query($query_devolucion);
  $totalRows_devolucion = mysql_num_rows($all_devolucion);
}
$totalPages_devolucion = ceil($totalRows_devolucion/$maxRows_devolucion)-1;
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
    <td>IDDEVOLUCION</td>
    <td>IDEMPLEADO</td>
    <td>ID_DETENCCOM</td>
    <td>DOCADEVOLVER</td>
    <td>FECHADEVOLUCION</td>
    <td>IMPORTE</td>
    <td>GASTOGENERADO</td>
    <td>OBSERVACION</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_devolucion['IDDEVOLUCION']; ?></td>
      <td><?php echo $row_devolucion['IDEMPLEADO']; ?></td>
      <td><?php echo $row_devolucion['ID_DETENCCOM']; ?></td>
      <td><?php echo $row_devolucion['DOCADEVOLVER']; ?></td>
      <td><?php echo $row_devolucion['FECHADEVOLUCION']; ?></td>
      <td><?php echo $row_devolucion['IMPORTE']; ?></td>
      <td><?php echo $row_devolucion['GASTOGENERADO']; ?></td>
      <td><?php echo $row_devolucion['OBSERVACION']; ?></td>
      <td>Modificar </td>
    </tr>
    <?php } while ($row_devolucion = mysql_fetch_assoc($devolucion)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($devolucion);
?>
