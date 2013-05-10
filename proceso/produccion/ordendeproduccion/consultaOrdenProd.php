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

$maxRows_encabOrdenProd = 10;
$pageNum_encabOrdenProd = 0;
if (isset($_GET['pageNum_encabOrdenProd'])) {
  $pageNum_encabOrdenProd = $_GET['pageNum_encabOrdenProd'];
}
$startRow_encabOrdenProd = $pageNum_encabOrdenProd * $maxRows_encabOrdenProd;

mysql_select_db($database_basepangloria, $basepangloria);
$query_encabOrdenProd = "SELECT * FROM TRNENCABEZADOENTREPROD";
$query_limit_encabOrdenProd = sprintf("%s LIMIT %d, %d", $query_encabOrdenProd, $startRow_encabOrdenProd, $maxRows_encabOrdenProd);
$encabOrdenProd = mysql_query($query_limit_encabOrdenProd, $basepangloria) or die(mysql_error());
$row_encabOrdenProd = mysql_fetch_assoc($encabOrdenProd);

if (isset($_GET['totalRows_encabOrdenProd'])) {
  $totalRows_encabOrdenProd = $_GET['totalRows_encabOrdenProd'];
} else {
  $all_encabOrdenProd = mysql_query($query_encabOrdenProd);
  $totalRows_encabOrdenProd = mysql_num_rows($all_encabOrdenProd);
}
$totalPages_encabOrdenProd = ceil($totalRows_encabOrdenProd/$maxRows_encabOrdenProd)-1;
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
    <td height="21" align="center" bgcolor="#999999"><h1>Consultar Orden de Produccion</h1></td>
  </tr>
</table>


<table border="1">
  <tr>
    <td>IDENCAENTREPROD</td>
    <td>IDORDENPRODUCCION</td>
    <td>IDEMPLEADO</td>
    <td>FECHA</td>
    <td>FECHAHORAUSUA</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_encabOrdenProd['IDENCAENTREPROD']; ?></td>
      <td><?php echo $row_encabOrdenProd['IDORDENPRODUCCION']; ?></td>
      <td><?php echo $row_encabOrdenProd['IDEMPLEADO']; ?></td>
      <td><?php echo $row_encabOrdenProd['FECHA']; ?></td>
      <td><?php echo $row_encabOrdenProd['FECHAHORAUSUA']; ?></td>
    </tr>
    <?php } while ($row_encabOrdenProd = mysql_fetch_assoc($encabOrdenProd)); ?>
</table><iframe src="conDetOrdeProd.php" width="820" height="400" scrolling="auto"></iframe>
</body>
</html>
<?php
mysql_free_result($encabOrdenProd);
?>
