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

$maxRows_id = 10;
$pageNum_id = 0;
if (isset($_GET['pageNum_id'])) {
  $pageNum_id = $_GET['pageNum_id'];
}
$startRow_id = $pageNum_id * $maxRows_id;

$colname_id = "-1";
if (isset($_GET['root'])) {
  $colname_id = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_id = sprintf("SELECT * FROM TRNSALIDA_MAT_PRIM WHERE ID_SALIDA = %s ORDER BY ID_SALIDA ASC", GetSQLValueString($colname_id, "int"));
$query_limit_id = sprintf("%s LIMIT %d, %d", $query_id, $startRow_id, $maxRows_id);
$id = mysql_query($query_limit_id, $basepangloria) or die(mysql_error());
$row_id = mysql_fetch_assoc($id);

if (isset($_GET['totalRows_id'])) {
  $totalRows_id = $_GET['totalRows_id'];
} else {
  $all_id = mysql_query($query_id);
  $totalRows_id = mysql_num_rows($all_id);
}
$totalPages_id = ceil($totalRows_id/$maxRows_id)-1;
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
    <td colspan="6" align="center" bgcolor="#999999"><h1>Detalle </h1></td>
  </tr>
  <tr>
    <td>ID_SALIDA</td>
    <td>CANTMAT_PRIMA</td>
    <td>ID_MATPRIMA</td>
    <td>IDENCABEZADOSALMATPRI</td>
    <td>IDUNIDAD</td>
    <td>IDDEPTO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_id['ID_SALIDA']; ?></td>
      <td><?php echo $row_id['CANTMAT_PRIMA']; ?></td>
      <td><?php echo $row_id['ID_MATPRIMA']; ?></td>
      <td><?php echo $row_id['IDENCABEZADOSALMATPRI']; ?></td>
      <td><?php echo $row_id['IDUNIDAD']; ?></td>
      <td><?php echo $row_id['IDDEPTO']; ?></td>
    </tr>
    <?php } while ($row_id = mysql_fetch_assoc($id)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($id);
?>
