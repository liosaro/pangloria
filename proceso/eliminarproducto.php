<?php require_once('../Connections/basepangloria.php'); ?>
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

$maxRows_consultaproductos = 10;
$pageNum_consultaproductos = 0;
if (isset($_GET['pageNum_consultaproductos'])) {
  $pageNum_consultaproductos = $_GET['pageNum_consultaproductos'];
}
$startRow_consultaproductos = $pageNum_consultaproductos * $maxRows_consultaproductos;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaproductos = "SELECT * FROM CATPRODUCTO ORDER BY DESCRIPCIONPRODUC ASC";
$query_limit_consultaproductos = sprintf("%s LIMIT %d, %d", $query_consultaproductos, $startRow_consultaproductos, $maxRows_consultaproductos);
$consultaproductos = mysql_query($query_limit_consultaproductos, $basepangloria) or die(mysql_error());
$row_consultaproductos = mysql_fetch_assoc($consultaproductos);

if (isset($_GET['totalRows_consultaproductos'])) {
  $totalRows_consultaproductos = $_GET['totalRows_consultaproductos'];
} else {
  $all_consultaproductos = mysql_query($query_consultaproductos);
  $totalRows_consultaproductos = mysql_num_rows($all_consultaproductos);
}
$totalPages_consultaproductos = ceil($totalRows_consultaproductos/$maxRows_consultaproductos)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<h1>Listado de Productos
</h1>
<table width="100%" border="1">
  <tr>
    <td align="center" bgcolor="#999999"><strong>Id Del producto</strong></td>
    <td align="center" bgcolor="#999999"><strong>Nombre del Producto</strong></td>
    <td align="center" bgcolor="#999999"><strong>Precio de costo</strong></td>
    <td align="center" bgcolor="#999999"><strong>Precio Mayoreo</strong></td>
    <td align="center" bgcolor="#999999"><strong>Precio Menudeo</strong></td>
    <td align="center" bgcolor="#999999"><strong>Dias de caducidad</strong></td>
    <td align="center" bgcolor="#999999"><strong>Modificacion</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_consultaproductos['IDPRODUCTO']; ?></td>
      <td><?php echo $row_consultaproductos['DESCRIPCIONPRODUC']; ?></td>
      <td><?php echo $row_consultaproductos['PRECIO_COSTO']; ?></td>
      <td><?php echo $row_consultaproductos['PRECIO_VENTAMAYOREO']; ?></td>
      <td><?php echo $row_consultaproductos['PRECIO_VENTAMENOR']; ?></td>
      <td><?php echo $row_consultaproductos['DIAS_CADUCIDAD']; ?></td>
      <td><a href="modificarproducto.php?IdProducto=<?php echo $row_consultaproductos['IDPRODUCTO']; ?>">Modificar</a></td>
    </tr>
    <?php } while ($row_consultaproductos = mysql_fetch_assoc($consultaproductos)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultaproductos);
?>
