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

$maxRows_nombre = 20;
$pageNum_nombre = 0;
if (isset($_GET['pageNum_nombre'])) {
  $pageNum_nombre = $_GET['pageNum_nombre'];
}
$startRow_nombre = $pageNum_nombre * $maxRows_nombre;

$colname_nombre = "-1";
if (isset($_GET['q'])) {
  $colname_nombre = $_GET['q'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_nombre = sprintf("SELECT * FROM CATPRODUCTO WHERE IDPRODUCTO = %s ORDER BY IDPRODUCTO ASC", GetSQLValueString($colname_nombre, "int"));
$query_limit_nombre = sprintf("%s LIMIT %d, %d", $query_nombre, $startRow_nombre, $maxRows_nombre);
$nombre = mysql_query($query_limit_nombre, $basepangloria) or die(mysql_error());
$row_nombre = mysql_fetch_assoc($nombre);

if (isset($_GET['totalRows_nombre'])) {
  $totalRows_nombre = $_GET['totalRows_nombre'];
} else {
  $all_nombre = mysql_query($query_nombre);
  $totalRows_nombre = mysql_num_rows($all_nombre);
}
$totalPages_nombre = ceil($totalRows_nombre/$maxRows_nombre)-1;
?>
<table border="1" cellpadding="0" cellspacing="0" width="820">
  <tr>
    <td colspan="6" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td>Id del Producto</td>
    <td><p>Nombre del Producto</p></td>
    <td>Precio de Costo</td>
    <td>Precio de Mayoreo</td>
    <td>Precio de Venta Menudeo</td>
    <td>Caducidad</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_nombre['IDPRODUCTO']; ?></td>
      <td><?php echo $row_nombre['DESCRIPCIONPRODUC']; ?></td>
      <td><?php echo $row_nombre['PRECIO_COSTO']; ?></td>
      <td><?php echo $row_nombre['PRECIO_VENTAMAYOREO']; ?></td>
      <td><?php echo $row_nombre['PRECIO_VENTAMENOR']; ?></td>
      <td><?php echo $row_nombre['DIAS_CADUCIDAD']; ?></td>
    </tr>
    <?php } while ($row_nombre = mysql_fetch_assoc($nombre)); ?>
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
mysql_free_result($nombre);
?>
