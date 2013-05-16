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

$maxRows_todo = 10;
$pageNum_todo = 0;
if (isset($_GET['pageNum_todo'])) {
  $pageNum_todo = $_GET['pageNum_todo'];
}
$startRow_todo = $pageNum_todo * $maxRows_todo;

mysql_select_db($database_basepangloria, $basepangloria);
$query_todo = "SELECT * FROM CATROL ORDER BY IDROL ASC";
$query_limit_todo = sprintf("%s LIMIT %d, %d", $query_todo, $startRow_todo, $maxRows_todo);
$todo = mysql_query($query_limit_todo, $basepangloria) or die(mysql_error());
$row_todo = mysql_fetch_assoc($todo);

if (isset($_GET['totalRows_todo'])) {
  $totalRows_todo = $_GET['totalRows_todo'];
} else {
  $all_todo = mysql_query($query_todo);
  $totalRows_todo = mysql_num_rows($all_todo);
}
$totalPages_todo = ceil($totalRows_todo/$maxRows_todo)-1;

$queryString_todo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_todo") == false && 
        stristr($param, "totalRows_todo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_todo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_todo = sprintf("&totalRows_todo=%d%s", $totalRows_todo, $queryString_todo);


?>
<table border="1">
  <tr>
    <td colspan="2" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="<?php printf("%s?pageNum_todo=%d%s", $currentPage, 0, $queryString_todo); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todo=%d%s", $currentPage, max(0, $pageNum_todo - 1), $queryString_todo); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todo=%d%s", $currentPage, min($totalPages_todo, $pageNum_todo + 1), $queryString_todo); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todo=%d%s", $currentPage, $totalPages_todo, $queryString_todo); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>IDROL</td>
    <td>DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_todo['IDROL']; ?></td>
      <td><?php echo $row_todo['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_todo = mysql_fetch_assoc($todo)); ?>
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
mysql_free_result($todo);
 ?>