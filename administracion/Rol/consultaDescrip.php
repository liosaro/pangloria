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

$maxRows_descripcion = 10;
$pageNum_descripcion = 0;
if (isset($_GET['pageNum_descripcion'])) {
  $pageNum_descripcion = $_GET['pageNum_descripcion'];
}
$startRow_descripcion = $pageNum_descripcion * $maxRows_descripcion;

$colname_descripcion = "-1";
if (isset($_GET['root'])) {
  $colname_descripcion = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_descripcion = sprintf("SELECT * FROM CATROL WHERE IDROL = %s ORDER BY IDROL ASC", GetSQLValueString($colname_descripcion, "int"));
$query_limit_descripcion = sprintf("%s LIMIT %d, %d", $query_descripcion, $startRow_descripcion, $maxRows_descripcion);
$descripcion = mysql_query($query_limit_descripcion, $basepangloria) or die(mysql_error());
$row_descripcion = mysql_fetch_assoc($descripcion);

if (isset($_GET['totalRows_descripcion'])) {
  $totalRows_descripcion = $_GET['totalRows_descripcion'];
} else {
  $all_descripcion = mysql_query($query_descripcion);
  $totalRows_descripcion = mysql_num_rows($all_descripcion);
}
$totalPages_descripcion = ceil($totalRows_descripcion/$maxRows_descripcion)-1;
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
    <td align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
</table>
<table border="1">
  <tr>
    <td>IDROL</td>
    <td>DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_descripcion['IDROL']; ?></td>
      <td><?php echo $row_descripcion['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_descripcion = mysql_fetch_assoc($descripcion)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($descripcion);
?>
