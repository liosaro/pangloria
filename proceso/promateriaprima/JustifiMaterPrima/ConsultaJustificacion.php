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

$maxRows_producto = 10;
$pageNum_producto = 0;
if (isset($_GET['pageNum_producto'])) {
  $pageNum_producto = $_GET['pageNum_producto'];
}
$startRow_producto = $pageNum_producto * $maxRows_producto;

mysql_select_db($database_basepangloria, $basepangloria);
$query_producto = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_producto = sprintf("%s LIMIT %d, %d", $query_producto, $startRow_producto, $maxRows_producto);
$producto = mysql_query($query_limit_producto, $basepangloria) or die(mysql_error());
$row_producto = mysql_fetch_assoc($producto);

if (isset($_GET['totalRows_producto'])) {
  $totalRows_producto = $_GET['totalRows_producto'];
} else {
  $all_producto = mysql_query($query_producto);
  $totalRows_producto = mysql_num_rows($all_producto);
}
$totalPages_producto = ceil($totalRows_producto/$maxRows_producto)-1;

$queryString_producto = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_producto") == false && 
        stristr($param, "totalRows_producto") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_producto = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_producto = sprintf("&totalRows_producto=%d%s", $totalRows_producto, $queryString_producto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Consulta de Justificacion de Perdida de Producto</h1></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td><a href="<?php printf("%s?pageNum_producto=%d%s", $currentPage, 0, $queryString_producto); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_producto=%d%s", $currentPage, max(0, $pageNum_producto - 1), $queryString_producto); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_producto=%d%s", $currentPage, min($totalPages_producto, $pageNum_producto + 1), $queryString_producto); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_producto=%d%s", $currentPage, $totalPages_producto, $queryString_producto); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
</table>
<table border="1">
  <tr>
    <td>Modificar</td>
    <td>Eliminar</td>
    <td>ID_JUSTIFICACION</td>
    <td>ID CONTROL PRODUCCION</td>
    <td>CANTIDA FALTANTE</td>
    <td>IDPRODUCTO FALTA</td>
    <td>ID MEDIDA</td>
    <td>FECHA INGRESO </td>
    <td>JUSTIFICACIONFALTAPROD</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modificacion.php?root=<?php echo $row_producto['ID_JUSTIFICACION']; ?>">Modificar</a></td>
      <td><a href="EliminarJustificacion.php?root=<?php echo $row_producto['ID_JUSTIFICACION']; ?>">Eliminar</a></td>
      <td><?php echo $row_producto['ID_JUSTIFICACION']; ?></td>
      <td><?php echo $row_producto['IDCONTROLPRODUCCION']; ?></td>
      <td><?php echo $row_producto['CANTIDA_FALTANTE']; ?></td>
      <td><?php echo $row_producto['IDPRODUCTOFALTA']; ?></td>
      <td><?php echo $row_producto['ID_MEDIDA']; ?></td>
      <td><?php echo $row_producto['FECHAINGRESOJUSFAPROD']; ?></td>
      <td><?php echo $row_producto['JUSTIFICACIONFALTAPROD']; ?></td>
    </tr>
    <?php } while ($row_producto = mysql_fetch_assoc($producto)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($producto);
?>
