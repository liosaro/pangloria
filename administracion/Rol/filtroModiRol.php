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

$maxRows_filtroModiRol = 15;
$pageNum_filtroModiRol = 0;
if (isset($_GET['pageNum_filtroModiRol'])) {
  $pageNum_filtroModiRol= $_GET['pageNum_filtroModiRol'];
  
}
$startRow_filtroModiRol = $pageNum_filtroModiRol * $maxRows_filtroModiRol;

$colname_filtroModiRol = "-1";
if (isset($_POST['filmodro'])) {
  $colname_filtradoproducto = $_POST['filmodro'];
}
mysql_select_db($database_basepangloria, $basepangloria);

$query_filtroModiRol = sprintf("SELECT * FROM CATROL WHERE IDROL = %s ORDER BY IDROL ASC", GetSQLValueString($colname_filtroModiRol, "int"));
$filtroModiRol = mysql_query($query_filtroModiRol, $basepangloria) or die(mysql_error());
$row_filtroModiRol = mysql_fetch_assoc($filtroModiRol);
$maxRows_filtroModiRol = 10;
$pageNum_filtroModiRol = 0;
if (isset($_GET['pageNum_filtroModiRol'])) {
  $pageNum_filtroModiRol = $_GET['pageNum_filtroModiRol'];
}
$startRow_filtroModiRol = $pageNum_filtroModiRol * $maxRows_filtroModiRol;

$totalRows_filtroModiRol = "-1";
if (isset($_POST['DESCRIPCION'])) {
  $totalRows_filtroModiRol = $_POST['DESCRIPCION'];
}

$colname_filtroModiRol = "-1";
if (isset($_POST['filmodro'])) {
  $colname_filtroModiRol = $_POST['filmodro'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtroModiRol = sprintf("SELECT * FROM CATROL WHERE DESCRIPCION LIKE %s ORDER BY IDROL ASC", GetSQLValueString("%" . $colname_filtroModiRol . "%", "text"));
$filtroModiRol = mysql_query($query_filtroModiRol, $basepangloria) or die(mysql_error());
$row_filtroModiRol = mysql_fetch_assoc($filtroModiRol);
$totalRows_filtroModiRol = mysql_num_rows($filtroModiRol);$colname_filtroModiRol = "-1";
if (isset($_POST['filmodro'])) {
  $colname_filtroModiRol = $_POST['filmodro'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtroModiRol = sprintf("SELECT * FROM CATROL WHERE DESCRIPCION LIKE %s ORDER BY IDROL ASC", GetSQLValueString("%" . $colname_filtroModiRol . "%", "text"));
$filtroModiRol = mysql_query($query_filtroModiRol, $basepangloria) or die(mysql_error());
$row_filtroModiRol = mysql_fetch_assoc($filtroModiRol);
$totalRows_filtroModiRol = mysql_num_rows($filtroModiRol);
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
<p><iframe src="modificarRol.php" name="modiRole" width="820" height="200" scrolling="No" frameborder="0" id="modiRol"></iframe>&nbsp;</p>
<table border="1">
  <tr>
    <td>Modificacion</td>
    <td>IDROL</td>
    <td>DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modificarRol.php?root=<?php echo $row_filtroModiRol['IDROL']; ?>" target="modiRole">Modificar</a></td>
      <td><?php echo $row_filtroModiRol['IDROL']; ?></td>
      <td><?php echo $row_filtroModiRol['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_filtroModiRol = mysql_fetch_assoc($filtroModiRol)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtroModiRol);
?>
