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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td>Modificar</td>
    <td>Eliminar</td>
    <td>ID_JUSTIFICACION</td>
    <td>IDCONTROLPRODUCCION</td>
    <td>CANTIDA_FALTANTE</td>
    <td>IDPRODUCTOFALTA</td>
    <td>ID_MEDIDA</td>
    <td>FECHAINGRESOJUSFAPROD</td>
    <td>JUSTIFICACIONFALTAPROD</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="<?php echo $row_producto['']; ?>?root=<?php echo $row_producto['ID_JUSTIFICACION']; ?>">Modificar</a></td>
      <td>Eliminar</td>
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
</body>
</html>
<?php
mysql_free_result($producto);
?>
