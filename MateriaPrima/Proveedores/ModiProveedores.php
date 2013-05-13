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

$maxRows_modiProvee = 10;
$pageNum_modiProvee = 0;
if (isset($_GET['pageNum_modiProvee'])) {
  $pageNum_modiProvee = $_GET['pageNum_modiProvee'];
}
$startRow_modiProvee = $pageNum_modiProvee * $maxRows_modiProvee;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modiProvee = "SELECT * FROM CATPROVEEDOR ORDER BY IDPROVEEDOR DESC";
$query_limit_modiProvee = sprintf("%s LIMIT %d, %d", $query_modiProvee, $startRow_modiProvee, $maxRows_modiProvee);
$modiProvee = mysql_query($query_limit_modiProvee, $basepangloria) or die(mysql_error());
$row_modiProvee = mysql_fetch_assoc($modiProvee);

if (isset($_GET['totalRows_modiProvee'])) {
  $totalRows_modiProvee = $_GET['totalRows_modiProvee'];
} else {
  $all_modiProvee = mysql_query($query_modiProvee);
  $totalRows_modiProvee = mysql_num_rows($all_modiProvee);
}
$totalPages_modiProvee = ceil($totalRows_modiProvee/$maxRows_modiProvee)-1;

$queryString_modiProvee = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modiProvee") == false && 
        stristr($param, "totalRows_modiProvee") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modiProvee = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modiProvee = sprintf("&totalRows_modiProvee=%d%s", $totalRows_modiProvee, $queryString_modiProvee);
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

<body><iframe src="modificarProveedor.php" name="modificar" width="850" height="500" align="middle" scrolling="auto" frameborder="0" id="modiProvee"></iframe>

<table width="820" border="0">
  <tr>
    <td><a href="<?php printf("%s?pageNum_modiProvee=%d%s", $currentPage, 0, $queryString_modiProvee); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modiProvee=%d%s", $currentPage, max(0, $pageNum_modiProvee - 1), $queryString_modiProvee); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modiProvee=%d%s", $currentPage, min($totalPages_modiProvee, $pageNum_modiProvee + 1), $queryString_modiProvee); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modiProvee=%d%s", $currentPage, $totalPages_modiProvee, $queryString_modiProvee); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td colspan="4"><form id="filtro" name="filtro" method="post" action="">
      Ingrese el Nombre
      del Proveedor a Modificar:
      <input type="text" name="txtfiltro" id="txtfiltro" />
      <input type="submit" name="btnfiltrar" id="btnfiltrar" value="Filtro" />
    </form></td>
  </tr>
</table>
<table border="1">
  <tr>
    <td>Modificar</td>
    <td>IDPROVEEDOR</td>
    <td>NOMBREPROVEEDOR</td>
    <td>GIRO</td>
    <td>NUMEROREGISTRO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modificarProveedor.php?root=<?php echo $row_modiProvee['IDPROVEEDOR']; ?>"target="modificar">Modificar</a></td>
      <td><?php echo $row_modiProvee['IDPROVEEDOR']; ?></td>
      <td><?php echo $row_modiProvee['NOMBREPROVEEDOR']; ?></td>
      <td><?php echo $row_modiProvee['GIRO']; ?></td>
      <td><?php echo $row_modiProvee['NUMEROREGISTRO']; ?></td>
    </tr>
    <?php } while ($row_modiProvee = mysql_fetch_assoc($modiProvee)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modiProvee);
?>
