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

$maxRows_nombres = 10;
$pageNum_nombres = 0;
if (isset($_GET['pageNum_nombres'])) {
  $pageNum_nombres = $_GET['pageNum_nombres'];
}
$startRow_nombres = $pageNum_nombres * $maxRows_nombres;

$colname_nombres = "-1";
if (isset($_GET['root'])) {
  $colname_nombres = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_nombres = sprintf("SELECT * FROM CATPROVEEDOR WHERE NOMBREPROVEEDOR LIKE %s ORDER BY IDPROVEEDOR ASC", GetSQLValueString("%" . $colname_nombres . "%", "text"));
$query_limit_nombres = sprintf("%s LIMIT %d, %d", $query_nombres, $startRow_nombres, $maxRows_nombres);
$nombres = mysql_query($query_limit_nombres, $basepangloria) or die(mysql_error());
$row_nombres = mysql_fetch_assoc($nombres);

if (isset($_GET['totalRows_nombres'])) {
  $totalRows_nombres = $_GET['totalRows_nombres'];
} else {
  $all_nombres = mysql_query($query_nombres);
  $totalRows_nombres = mysql_num_rows($all_nombres);
}
$totalPages_nombres = ceil($totalRows_nombres/$maxRows_nombres)-1;

$queryString_nombres = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_nombres") == false && 
        stristr($param, "totalRows_nombres") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_nombres = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_nombres = sprintf("&totalRows_nombres=%d%s", $totalRows_nombres, $queryString_nombres);
?>

<table border="1">
  <tr>
    <td colspan="11" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  
  <tr>
    <td colspan="11"><a href="<?php printf("%s?pageNum_nombres=%d%s", $currentPage, 0, $queryString_nombres); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombres=%d%s", $currentPage, max(0, $pageNum_nombres - 1), $queryString_nombres); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombres=%d%s", $currentPage, min($totalPages_nombres, $pageNum_nombres + 1), $queryString_nombres); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombres=%d%s", $currentPage, $totalPages_nombres, $queryString_nombres); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>IDPROVEEDOR</td>
    <td>IDPAIS</td>
    <td>NOMBREPROVEEDOR</td>
    <td>DIRECCIONPROVEEDOR</td>
    <td>TELEFONOPROVEEDOR</td>
    <td>CORREOPROVEEDOR</td>
    <td>FECHAINGRESOPROVE</td>
    <td>GIRO</td>
    <td>NUMEROREGISTRO</td>
    <td>WEB</td>
    <td>DEPTOPAISPROVEEDOR</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_nombres['IDPROVEEDOR']; ?></td>
      <td><?php echo $row_nombres['IDPAIS']; ?></td>
      <td><?php echo $row_nombres['NOMBREPROVEEDOR']; ?></td>
      <td><?php echo $row_nombres['DIRECCIONPROVEEDOR']; ?></td>
      <td><?php echo $row_nombres['TELEFONOPROVEEDOR']; ?></td>
      <td><?php echo $row_nombres['CORREOPROVEEDOR']; ?></td>
      <td><?php echo $row_nombres['FECHAINGRESOPROVE']; ?></td>
      <td><?php echo $row_nombres['GIRO']; ?></td>
      <td><?php echo $row_nombres['NUMEROREGISTRO']; ?></td>
      <td><?php echo $row_nombres['WEB']; ?></td>
      <td><?php echo $row_nombres['DEPTOPAISPROVEEDOR']; ?></td>
    </tr>
    <?php } while ($row_nombres = mysql_fetch_assoc($nombres)); ?>
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
mysql_free_result($nombres);
?>
