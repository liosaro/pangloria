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

$maxRows_conpermiso = 10;
$pageNum_conpermiso = 0;
if (isset($_GET['pageNum_conpermiso'])) {
  $pageNum_conpermiso = $_GET['pageNum_conpermiso'];
}
$startRow_conpermiso = $pageNum_conpermiso * $maxRows_conpermiso;

$colname_conpermiso = "-1";
if (isset($_GET['q'])) {
  $colname_conpermiso = $_GET['q'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_conpermiso = sprintf("SELECT * FROM CATPERMISOS WHERE IDPERMISO = %s", GetSQLValueString($colname_conpermiso, "int"));
$query_limit_conpermiso = sprintf("%s LIMIT %d, %d", $query_conpermiso, $startRow_conpermiso, $maxRows_conpermiso);
$conpermiso = mysql_query($query_limit_conpermiso, $basepangloria) or die(mysql_error());
$row_conpermiso = mysql_fetch_assoc($conpermiso);

if (isset($_GET['totalRows_conpermiso'])) {
  $totalRows_conpermiso = $_GET['totalRows_conpermiso'];
} else {
  $all_conpermiso = mysql_query($query_conpermiso);
  $totalRows_conpermiso = mysql_num_rows($all_conpermiso);
}
$totalPages_conpermiso = ceil($totalRows_conpermiso/$maxRows_conpermiso)-1;
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
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#999999">Detalle de Consulta de Permisos</td>
  </tr>
  <tr>
    <td colspan="2"><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, 0, $queryString_nombre); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, max(0, $pageNum_nombre - 1), $queryString_nombre); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, min($totalPages_nombre, $pageNum_nombre + 1), $queryString_nombre); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, $totalPages_nombre, $queryString_nombre); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>IDPERMISO</td>
    <td>DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_conpermiso['IDPERMISO']; ?></td>
      <td><?php echo $row_conpermiso['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_conpermiso = mysql_fetch_assoc($conpermiso)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($conpermiso);
?>
