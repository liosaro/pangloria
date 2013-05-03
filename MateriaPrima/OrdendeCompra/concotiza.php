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

$maxRows_concoti = 15;
$pageNum_concoti = 0;
if (isset($_GET['pageNum_concoti'])) {
  $pageNum_concoti = $_GET['pageNum_concoti'];
}
$startRow_concoti = $pageNum_concoti * $maxRows_concoti;

$colname_concoti = "-1";
if (isset($_GET['coti'])) {
  $colname_concoti = $_GET['coti'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_concoti = sprintf("SELECT * FROM TRNDETALLECOTIZACION WHERE IDENCABEZADO = %s", GetSQLValueString($colname_concoti, "int"));
$query_limit_concoti = sprintf("%s LIMIT %d, %d", $query_concoti, $startRow_concoti, $maxRows_concoti);
$concoti = mysql_query($query_limit_concoti, $basepangloria) or die(mysql_error());
$row_concoti = mysql_fetch_assoc($concoti);

if (isset($_GET['totalRows_concoti'])) {
  $totalRows_concoti = $_GET['totalRows_concoti'];
} else {
  $all_concoti = mysql_query($query_concoti);
  $totalRows_concoti = mysql_num_rows($all_concoti);
}
$totalPages_concoti = ceil($totalRows_concoti/$maxRows_concoti)-1;

$colname_materia = "-1";
if (isset($_POST['IDMATPRIMA'])) {
  $colname_materia = $_POST['IDMATPRIMA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$datas = $row_consultacotiza['IDMATPRIMA'];
$query_materia = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$datas'", GetSQLValueString($colname_materia, "int"));
$materia = mysql_query($query_materia, $basepangloria) or die(mysql_error());
$row_materia = mysql_fetch_assoc($materia);
$totalRows_materia = mysql_num_rows($materia);
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
</head>

<body>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>Material</td>
    <td>Unidad de Medida</td>
    <td>Cantidad de producto</td>
    <td>Precio uunitario</td>
    <td>Costo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_concoti['IDMATPRIMA']; ?></td>
      <td><?php echo $row_concoti['IDUNIDAD']; ?></td>
      <td><?php echo $row_concoti['CANTPRODUCTO']; ?></td>
      <td><?php echo $row_concoti['PRECIOUNITARIO']; ?></td>
      <td><?php echo ($row_concoti['PRECIOUNITARIO']* $row_concoti['CANTPRODUCTO'] ); ?></td>
    </tr>
    <?php } while ($row_concoti = mysql_fetch_assoc($concoti)); ?>
</table>
<table width="820" border="0">
  <tr>
    <td width="642" align="right">Total de la orden de compra:</td>
    <td width="168"><?php 
	$col = $_request['coti'];
	$result = mysql_query("Select sum(CANTPRODUCTO * PRECIOUNITARIO ) as total from TRNDETALLECOTIZACION where IDENCABEZADO =" . $_GET['coti']);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	echo $row['total'];
	 ?></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($concoti);

mysql_free_result($materia);
?>
