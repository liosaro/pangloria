<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$maxRows_consulta_sucursal = 10;
$pageNum_consulta_sucursal = 0;
if (isset($_GET['pageNum_consulta_sucursal'])) {
  $pageNum_consulta_sucursal = $_GET['pageNum_consulta_sucursal'];
}
$startRow_consulta_sucursal = $pageNum_consulta_sucursal * $maxRows_consulta_sucursal;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulta_sucursal = "SELECT * FROM CATSUCURSAL ORDER BY IDSUCURSAL ASC";
$query_limit_consulta_sucursal = sprintf("%s LIMIT %d, %d", $query_consulta_sucursal, $startRow_consulta_sucursal, $maxRows_consulta_sucursal);
$consulta_sucursal = mysql_query($query_limit_consulta_sucursal, $basepangloria) or die(mysql_error());
$row_consulta_sucursal = mysql_fetch_assoc($consulta_sucursal);

if (isset($_GET['totalRows_consulta_sucursal'])) {
  $totalRows_consulta_sucursal = $_GET['totalRows_consulta_sucursal'];
} else {
  $all_consulta_sucursal = mysql_query($query_consulta_sucursal);
  $totalRows_consulta_sucursal = mysql_num_rows($all_consulta_sucursal);
}
$totalPages_consulta_sucursal = ceil($totalRows_consulta_sucursal/$maxRows_consulta_sucursal)-1;

$queryString_consulta_sucursal = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consulta_sucursal") == false && 
        stristr($param, "totalRows_consulta_sucursal") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consulta_sucursal = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consulta_sucursal = sprintf("&totalRows_consulta_sucursal=%d%s", $totalRows_consulta_sucursal, $queryString_consulta_sucursal);
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
<table width="820" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Consulta de Sucursales</h1></td>
  </tr>
  <tr>
    <td><iframe src=  "modificar_sucursal.php" width="820" height="400
    " wscrolling="Auto">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </iframe></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <label for="root"></label>
      <input type="text" name="root" id="root" />
      <input type="submit" name="enviar" id="enviar" value="Filtrar" />
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_consulta_sucursal=%d%s", $currentPage, 0, $queryString_consulta_sucursal); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consulta_sucursal=%d%s", $currentPage, max(0, $pageNum_consulta_sucursal - 1), $queryString_consulta_sucursal); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consulta_sucursal=%d%s", $currentPage, min($totalPages_consulta_sucursal, $pageNum_consulta_sucursal + 1), $queryString_consulta_sucursal); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consulta_sucursal=%d%s", $currentPage, $totalPages_consulta_sucursal, $queryString_consulta_sucursal); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td align="center" bgcolor="#999999">Eliminacion</td>
    <td align="center" bgcolor="#999999">Modificacion</td>
    <td align="center" bgcolor="#999999"><strong>Id sucursal</strong></td>
    <td align="center" bgcolor="#999999"><strong>Nombre de la Sucursal</strong></td>
    <td align="center" bgcolor="#999999"><strong>Direccion de la Sucursal</strong></td>
    <td align="center" bgcolor="#999999"><strong>Telefono de la Sucursal</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td>Eliminar</td>
      <td><a href="midificar_sucursal.php?IDSUCURSAL=<?php echo $row_consulta_sucursal['IDSUCURSAL']; ?>">Modificar</a></a></td>
      <td><?php echo $row_consulta_sucursal['IDSUCURSAL']; ?></td>
      <td><?php echo $row_consulta_sucursal['NOMBRESUCURSAL']; ?></td>
      <td><?php echo $row_consulta_sucursal['DIRECCIONSUCURSAL']; ?></td>
      <td><?php echo $row_consulta_sucursal['TELEFONOSUCURSAL']; ?></td>
    </tr>
    <?php } while ($row_consulta_sucursal = mysql_fetch_assoc($consulta_sucursal)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($consulta_sucursal);
?>
