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

$maxRows_filtradoproducto = 15;
$pageNum_filtradoproducto = 0;
if (isset($_GET['pageNum_filtradoproducto'])) {
  $pageNum_filtradoproducto = $_GET['pageNum_filtradoproducto'];
}
$startRow_filtradoproducto = $pageNum_filtradoproducto * $maxRows_filtradoproducto;

$colname_filtradoproducto = "-1";
if (isset($_POST['filtroprod'])) {
  $colname_filtradoproducto = $_POST['filtroprod'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradoproducto = sprintf("SELECT * FROM CATPRODUCTO WHERE DESCRIPCIONPRODUC LIKE %s ORDER BY DESCRIPCIONPRODUC ASC", GetSQLValueString("%" . $colname_filtradoproducto . "%", "text"));
$query_limit_filtradoproducto = sprintf("%s LIMIT %d, %d", $query_filtradoproducto, $startRow_filtradoproducto, $maxRows_filtradoproducto);
$filtradoproducto = mysql_query($query_limit_filtradoproducto, $basepangloria) or die(mysql_error());
$row_filtradoproducto = mysql_fetch_assoc($filtradoproducto);

if (isset($_GET['totalRows_filtradoproducto'])) {
  $totalRows_filtradoproducto = $_GET['totalRows_filtradoproducto'];
} else {
  $all_filtradoproducto = mysql_query($query_filtradoproducto);
  $totalRows_filtradoproducto = mysql_num_rows($all_filtradoproducto);
}
$totalPages_filtradoproducto = ceil($totalRows_filtradoproducto/$maxRows_filtradoproducto)-1;
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
}
</style>
<script language="JavaScript">
function aviso(url){
if (!confirm("ALERTA!! va a proceder a eliminar este registro, si desea eliminarlo de click en ACEPTAR\n de lo contrario de click en CANCELAR.")) {
return false;
}
else {
document.location = url;
return true;
}
}
</script>
</head>

<body>
<table width="830" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>Modificacion</td>
    <td>ID de Producto</td>
    <td>Nombre de Producto</td>
    <td>Precio Costo</td>
    <td>Precio Mayoreo</td>
    <td>Precio Menudeo</td>
    <td>Dias Caducidad</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarProducto.php?root=<?php echo $row_filtradoproducto['IDPRODUCTO'];?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtradoproducto['IDPRODUCTO']; ?></td>
      <td><?php echo $row_filtradoproducto['DESCRIPCIONPRODUC']; ?></td>
      <td><?php echo $row_filtradoproducto['PRECIO_COSTO']; ?></td>
      <td><?php echo $row_filtradoproducto['PRECIO_VENTAMAYOREO']; ?></td>
      <td><?php echo $row_filtradoproducto['PRECIO_VENTAMENOR']; ?></td>
      <td><?php echo $row_filtradoproducto['DIAS_CADUCIDAD']; ?></td>
    </tr>
    <?php } while ($row_filtradoproducto = mysql_fetch_assoc($filtradoproducto)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradoproducto);
?>
