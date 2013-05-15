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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_descripcion = 10;
$pageNum_descripcion = 0;
if (isset($_GET['pageNum_descripcion'])) {
  $pageNum_descripcion = $_GET['pageNum_descripcion'];
}
$startRow_descripcion = $pageNum_descripcion * $maxRows_descripcion;

$colname_descripcion = "-1";
if (isset($_GET['root'])) {
  $colname_descripcion = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_descripcion = sprintf("SELECT * FROM CATROL WHERE DESCRIPCION LIKE %s ORDER BY IDROL ASC", GetSQLValueString("%" . $colname_descripcion . "%", "text"));
$query_limit_descripcion = sprintf("%s LIMIT %d, %d", $query_descripcion, $startRow_descripcion, $maxRows_descripcion);
$descripcion = mysql_query($query_limit_descripcion, $basepangloria) or die(mysql_error());
$row_descripcion = mysql_fetch_assoc($descripcion);

if (isset($_GET['totalRows_descripcion'])) {
  $totalRows_descripcion = $_GET['totalRows_descripcion'];
} else {
  $all_descripcion = mysql_query($query_descripcion);
  $totalRows_descripcion = mysql_num_rows($all_descripcion);
}
$totalPages_descripcion = ceil($totalRows_descripcion/$maxRows_descripcion)-1;

$queryString_descripcion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_descripcion") == false && 
        stristr($param, "totalRows_descripcion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_descripcion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_descripcion = sprintf("&totalRows_descripcion=%d%s", $totalRows_descripcion, $queryString_descripcion);
?>
<table border="1" cellpadding="0" cellspacing="0" width="820">
  <tr>
    <td colspan="6" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
   <td colspan="6"><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, 0, $queryString_nombre); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, max(0, $pageNum_nombre - 1), $queryString_nombre); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, min($totalPages_nombre, $pageNum_nombre + 1), $queryString_nombre); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, $totalPages_nombre, $queryString_nombre); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>IDROL</td>
    <td>DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_descripcion['IDROL']; ?></td>
      <td><?php echo $row_descripcion['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_descripcion = mysql_fetch_assoc($descripcion)); ?>
</table>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?php
mysql_free_result($descripcion);
?>
