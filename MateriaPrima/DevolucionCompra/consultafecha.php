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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_fecha = 5;
$pageNum_fecha = 0;
if (isset($_GET['pageNum_fecha'])) {
  $pageNum_fecha = $_GET['pageNum_fecha'];
}
$startRow_fecha = $pageNum_fecha * $maxRows_fecha;

$colname_fecha = "-1";
if (isset($_GET['root'])) {
  $colname_fecha = $_GET['root'];
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

$queryString_fecha = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fecha") == false && 
        stristr($param, "totalRows_fecha") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fecha = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fecha = sprintf("&totalRows_fecha=%d%s", $totalRows_fecha, $queryString_fecha);
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
    <td colspan="7" align="center" bgcolor="#999999"><h2>Detalle</h2></td>
  </tr>
  <tr>
    <td colspan="7"><a href="<?php printf("%s?pageNum_fecha=%d%s", $currentPage, 0, $queryString_fecha); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_fecha=%d%s", $currentPage, max(0, $pageNum_fecha - 1), $queryString_fecha); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_fecha=%d%s", $currentPage, min($totalPages_fecha, $pageNum_fecha + 1), $queryString_fecha); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_fecha=%d%s", $currentPage, $totalPages_fecha, $queryString_fecha); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Id Devolucion</td>
    <td>Id Empleado</td>
    <td>Documento a Devolver</td>
    <td>Fecha </td>
    <td>Importe</td>
    <td>Gasto Generado</td>
    <td>Observacion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_fecha['IDDEVOLUCION']; ?></td>
      <td><?php echo $row_fecha['IDEMPLEADO']; ?></td>
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
