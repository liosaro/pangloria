<?php require_once('../../Connections/basepangloria.php'); ?>
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

$maxRows_modificarsuc = 10;
$pageNum_modificarsuc = 0;
if (isset($_GET['pageNum_modificarsuc'])) {
  $pageNum_modificarsuc = $_GET['pageNum_modificarsuc'];
}
$startRow_modificarsuc = $pageNum_modificarsuc * $maxRows_modificarsuc;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificarsuc = "SELECT * FROM CATSUCURSAL ORDER BY IDSUCURSAL ASC";
$query_limit_modificarsuc = sprintf("%s LIMIT %d, %d", $query_modificarsuc, $startRow_modificarsuc, $maxRows_modificarsuc);
$modificarsuc = mysql_query($query_limit_modificarsuc, $basepangloria) or die(mysql_error());
$row_modificarsuc = mysql_fetch_assoc($modificarsuc);

if (isset($_GET['totalRows_modificarsuc'])) {
  $totalRows_modificarsuc = $_GET['totalRows_modificarsuc'];
} else {
  $all_modificarsuc = mysql_query($query_modificarsuc);
  $totalRows_modificarsuc = mysql_num_rows($all_modificarsuc);
}
$totalPages_modificarsuc = ceil($totalRows_modificarsuc/$maxRows_modificarsuc)-1;

$queryString_modificarsuc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificarsuc") == false && 
        stristr($param, "totalRows_modificarsuc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificarsuc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificarsuc = sprintf("&totalRows_modificarsuc=%d%s", $totalRows_modificarsuc, $queryString_modificarsuc);
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
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table border="1">
  <tr></tr>
  <tr>
    <td colspan="5"><iframe src="modiSucursal.php" name="modificar" width="820" height="400" scrolling="No" id="modificar"></iframe></td>
  </tr>
  <tr>
    <td colspan="5"><label for="FiltroProvee"></label>
      <form action="filtroModiSucur.php" method="post" name="form1" target="modificar" id="form1">
Ingrese el nombre de la Sucursal a Modificar
        <input type="text" name="filtroSucu" id="filtroSucu" />
        <input type="submit" name="button" id="button" value="Filtrar" />
      </form></td>
  </tr>
  <tr>
    <td colspan="5"><a href="<?php printf("%s?pageNum_modificarsuc=%d%s", $currentPage, 0, $queryString_modificarsuc); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificarsuc=%d%s", $currentPage, max(0, $pageNum_modificarsuc - 1), $queryString_modificarsuc); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificarsuc=%d%s", $currentPage, min($totalPages_modificarsuc, $pageNum_modificarsuc + 1), $queryString_modificarsuc); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificarsuc=%d%s", $currentPage, $totalPages_modificarsuc, $queryString_modificarsuc); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Modificacion</td>
    <td>IDSUCURSAL</td>
    <td>NOMBRESUCURSAL</td>
    <td>DIRECCIONSUCURSAL</td>
    <td>TELEFONOSUCURSAL</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><a href="modiSucursal.php?root=<?php echo $row_modificarsuc['IDSUCURSAL']; ?>"target="modificar">Modificar</a></td>
    <td><?php echo $row_modificarsuc['IDSUCURSAL']; ?></td>
    <td><?php echo $row_modificarsuc['NOMBRESUCURSAL']; ?></td>
    <td><?php echo $row_modificarsuc['DIRECCIONSUCURSAL']; ?></td>
    <td><?php echo $row_modificarsuc['TELEFONOSUCURSAL']; ?></td>
  </tr>
  <?php } while ($row_modificarsuc = mysql_fetch_assoc($modificarsuc)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modificarsuc);

mysql_free_result($modificarsuc);
?>
