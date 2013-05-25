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

$maxRows_conmatpri = 10;
$pageNum_conmatpri = 0;
if (isset($_GET['pageNum_conmatpri'])) {
  $pageNum_conmatpri = $_GET['pageNum_conmatpri'];
}
$startRow_conmatpri = $pageNum_conmatpri * $maxRows_conmatpri;

mysql_select_db($database_basepangloria, $basepangloria);
$query_conmatpri = "SELECT * FROM TRNCONTROL_MAT_PRIMA";
$query_limit_conmatpri = sprintf("%s LIMIT %d, %d", $query_conmatpri, $startRow_conmatpri, $maxRows_conmatpri);
$conmatpri = mysql_query($query_limit_conmatpri, $basepangloria) or die(mysql_error());
$row_conmatpri = mysql_fetch_assoc($conmatpri);

if (isset($_GET['totalRows_conmatpri'])) {
  $totalRows_conmatpri = $_GET['totalRows_conmatpri'];
} else {
  $all_conmatpri = mysql_query($query_conmatpri);
  $totalRows_conmatpri = mysql_num_rows($all_conmatpri);
}
$totalPages_conmatpri = ceil($totalRows_conmatpri/$maxRows_conmatpri)-1;

$queryString_conmatpri = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_conmatpri") == false && 
        stristr($param, "totalRows_conmatpri") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_conmatpri = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_conmatpri = sprintf("&totalRows_conmatpri=%d%s", $totalRows_conmatpri, $queryString_conmatpri);
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
}
</style>
</head>

<body>
<table width="820" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8" bgcolor="#999999">Detalle de Consultar Control de Materia Prima</td>
  </tr>
  <tr>
    <td colspan="8"><a href="<?php printf("%s?pageNum_conmatpri=%d%s", $currentPage, 0, $queryString_conmatpri); ?>"><img src="../../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_conmatpri=%d%s", $currentPage, max(0, $pageNum_conmatpri - 1), $queryString_conmatpri); ?>"><img src="../../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_conmatpri=%d%s", $currentPage, min($totalPages_conmatpri, $pageNum_conmatpri + 1), $queryString_conmatpri); ?>"><img src="../../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_conmatpri=%d%s", $currentPage, $totalPages_conmatpri, $queryString_conmatpri); ?>"><img src="../../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Codigo Control Materia Prima</td>
    <td>Materia Prima</td>
    <td>Salida</td>
    <td>Unidad</td>
    <td>C</td>
    <td>Cantida Devuelta</td>
    <td>Cantidad Utilizada</td>
    <td>Fecha</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_conmatpri['ID_CONTROLMAT']; ?></td>
      <td><?php echo $row_conmatpri['IDMATPRIMA']; ?></td>
      <td><?php echo $row_conmatpri['ID_SALIDA']; ?></td>
      <td><?php echo $row_conmatpri['IDUNIDAD']; ?></td>
      <td><?php echo $row_conmatpri['CANT_ENTREGA']; ?></td>
      <td><?php echo $row_conmatpri['CANT_DEVUELTA']; ?></td>
      <td><?php echo $row_conmatpri['CANT_UTILIZADA']; ?></td>
      <td><?php echo $row_conmatpri['FECHA_CONTROL']; ?></td>
    </tr>
    <?php } while ($row_conmatpri = mysql_fetch_assoc($conmatpri)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($conmatpri);
?>
