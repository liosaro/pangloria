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

$maxRows_registro = 20;
$pageNum_registro = 0;
if (isset($_GET['pageNum_registro'])) {
  $pageNum_registro = $_GET['pageNum_registro'];
}
$startRow_registro = $pageNum_registro * $maxRows_registro;

mysql_select_db($database_basepangloria, $basepangloria);
$query_registro = "SELECT * FROM CATCARGO";
$query_limit_registro = sprintf("%s LIMIT %d, %d", $query_registro, $startRow_registro, $maxRows_registro);
$registro = mysql_query($query_limit_registro, $basepangloria) or die(mysql_error());
$row_registro = mysql_fetch_assoc($registro);

if (isset($_GET['totalRows_registro'])) {
  $totalRows_registro = $_GET['totalRows_registro'];
} else {
  $all_registro = mysql_query($query_registro);
  $totalRows_registro = mysql_num_rows($all_registro);
}
$totalPages_registro = ceil($totalRows_registro/$maxRows_registro)-1;

$queryString_registro = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_registro") == false && 
        stristr($param, "totalRows_registro") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_registro = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_registro = sprintf("&totalRows_registro=%d%s", $totalRows_registro, $queryString_registro);
?>
<table border="1" cellpadding="0" cellspacing="0" width="820">
  <tr>
    <td colspan="2" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="<?php printf("%s?pageNum_registro=%d%s", $currentPage, 0, $queryString_registro); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_registro=%d%s", $currentPage, max(0, $pageNum_registro - 1), $queryString_registro); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_registro=%d%s", $currentPage, min($totalPages_registro, $pageNum_registro + 1), $queryString_registro); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_registro=%d%s", $currentPage, $totalPages_registro, $queryString_registro); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Id Cardo</td>
    <td><p>Nombre del Cargo</p></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_registro['IDCARGO']; ?></td>
      <td><?php echo $row_registro['CARGO']; ?></td>
    </tr>
    <?php } while ($row_registro = mysql_fetch_assoc($registro)); ?>
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
mysql_free_result($registro);
?>
