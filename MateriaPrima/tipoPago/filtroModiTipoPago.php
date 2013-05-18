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

$maxRows_filtroTipoPago = 10;
$pageNum_filtroTipoPago = 0;
if (isset($_GET['pageNum_filtroTipoPago'])) {
  $pageNum_filtroTipoPago = $_GET['pageNum_filtroTipoPago'];
}
$startRow_filtroTipoPago = $pageNum_filtroTipoPago * $maxRows_filtroTipoPago;

$colname_filtroTipoPago = "-1";
if (isset($_POST['filtropago'])) {
  $colname_filtroTipoPago = $_POST['filtropago'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtroTipoPago = sprintf("SELECT * FROM CATCONDICIONPAGO WHERE TIPO LIKE %s ORDER BY TIPO ASC", GetSQLValueString("%" . $colname_filtroTipoPago . "%", "text"));
$query_limit_filtroTipoPago = sprintf("%s LIMIT %d, %d", $query_filtroTipoPago, $startRow_filtroTipoPago, $maxRows_filtroTipoPago);
$filtroTipoPago = mysql_query($query_limit_filtroTipoPago, $basepangloria) or die(mysql_error());
$row_filtroTipoPago = mysql_fetch_assoc($filtroTipoPago);

if (isset($_GET['totalRows_filtroTipoPago'])) {
  $totalRows_filtroTipoPago = $_GET['totalRows_filtroTipoPago'];
} else {
  $all_filtroTipoPago = mysql_query($query_filtroTipoPago);
  $totalRows_filtroTipoPago = mysql_num_rows($all_filtroTipoPago);
}
$totalPages_filtroTipoPago = ceil($totalRows_filtroTipoPago/$maxRows_filtroTipoPago)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<p><iframe src="mdiTipoPago.php" name="modificar" width="820" height="200" scrolling="no" id="modipago"></iframe>&nbsp;</p>
<table border="1">
  <tr>
    <td>Modificacion</td>
    <td>IDCONDICION</td>
    <td>TIPO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="mdiTipoPago.php?root=<?php echo $row_filtroTipoPago['IDCONDICION']; ?>"target="modificar">Modificar</a></td>
      <td><?php echo $row_filtroTipoPago['IDCONDICION']; ?></td>
      <td><?php echo $row_filtroTipoPago['TIPO']; ?></td>
    </tr>
    <?php } while ($row_filtroTipoPago = mysql_fetch_assoc($filtroTipoPago)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtroTipoPago);
?>
