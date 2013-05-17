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

$maxRows_todos = 10;
$pageNum_todos = 0;
if (isset($_GET['pageNum_todos'])) {
  $pageNum_todos = $_GET['pageNum_todos'];
}
$startRow_todos = $pageNum_todos * $maxRows_todos;

mysql_select_db($database_basepangloria, $basepangloria);
$query_todos = "SELECT * FROM CATDEPARTAMENEMPRESA";
$query_limit_todos = sprintf("%s LIMIT %d, %d", $query_todos, $startRow_todos, $maxRows_todos);
$todos = mysql_query($query_limit_todos, $basepangloria) or die(mysql_error());
$row_todos = mysql_fetch_assoc($todos);

if (isset($_GET['totalRows_todos'])) {
  $totalRows_todos = $_GET['totalRows_todos'];
} else {
  $all_todos = mysql_query($query_todos);
  $totalRows_todos = mysql_num_rows($all_todos);
}
$totalPages_todos = ceil($totalRows_todos/$maxRows_todos)-1;
$query_todos = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO ASC";
$todos = mysql_query($query_todos, $basepangloria) or die(mysql_error());
$row_todos = mysql_fetch_assoc($todos);
$totalRows_todos = mysql_num_rows($todos);
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
    <td colspan="3" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td colspan="3"><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, 0, $queryString_nombre); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, max(0, $pageNum_nombre - 1), $queryString_nombre); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, min($totalPages_nombre, $pageNum_nombre + 1), $queryString_nombre); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_nombre=%d%s", $currentPage, $totalPages_nombre, $queryString_nombre); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>IDDEPTO</td>
    <td>DEPARTAMENTO</td>
    <td>NUMEROTELEFONO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_todos['IDDEPTO']; ?></td>
      <td><?php echo $row_todos['DEPARTAMENTO']; ?></td>
      <td><?php echo $row_todos['NUMEROTELEFONO']; ?></td>
    </tr>
    <?php } while ($row_todos = mysql_fetch_assoc($todos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($todos);
?>
