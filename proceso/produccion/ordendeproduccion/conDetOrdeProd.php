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

$maxRows_DetOrdeProd = 10;
$pageNum_DetOrdeProd = 0;
if (isset($_GET['pageNum_DetOrdeProd'])) {
  $pageNum_DetOrdeProd = $_GET['pageNum_DetOrdeProd'];
}
$startRow_DetOrdeProd = $pageNum_DetOrdeProd * $maxRows_DetOrdeProd;

mysql_select_db($database_basepangloria, $basepangloria);
$query_DetOrdeProd = "SELECT * FROM TRNDETORDENPRODUCCION";
$query_limit_DetOrdeProd = sprintf("%s LIMIT %d, %d", $query_DetOrdeProd, $startRow_DetOrdeProd, $maxRows_DetOrdeProd);
$DetOrdeProd = mysql_query($query_limit_DetOrdeProd, $basepangloria) or die(mysql_error());
$row_DetOrdeProd = mysql_fetch_assoc($DetOrdeProd);

if (isset($_GET['totalRows_DetOrdeProd'])) {
  $totalRows_DetOrdeProd = $_GET['totalRows_DetOrdeProd'];
} else {
  $all_DetOrdeProd = mysql_query($query_DetOrdeProd);
  $totalRows_DetOrdeProd = mysql_num_rows($all_DetOrdeProd);
}
$totalPages_DetOrdeProd = ceil($totalRows_DetOrdeProd/$maxRows_DetOrdeProd)-1;
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
    <td>IDORDENPRODUCCION</td>
    <td>IDENCABEORDPROD</td>
    <td>CANTIDADORPROD</td>
    <td>ID_MEDIDA</td>
    <td>PRODUCTOORDPRODUC</td>
    <td>FECHAHORAUSUA</td>
    <td>USUARIO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_DetOrdeProd['IDORDENPRODUCCION']; ?></td>
      <td><?php echo $row_DetOrdeProd['IDENCABEORDPROD']; ?></td>
      <td><?php echo $row_DetOrdeProd['CANTIDADORPROD']; ?></td>
      <td><?php echo $row_DetOrdeProd['ID_MEDIDA']; ?></td>
      <td><?php echo $row_DetOrdeProd['PRODUCTOORDPRODUC']; ?></td>
      <td><?php echo $row_DetOrdeProd['FECHAHORAUSUA']; ?></td>
      <td><?php echo $row_DetOrdeProd['USUARIO']; ?></td>
    </tr>
    <?php } while ($row_DetOrdeProd = mysql_fetch_assoc($DetOrdeProd)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($DetOrdeProd);
?>
