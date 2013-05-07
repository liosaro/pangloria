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

$maxRows_caducidad = 20;
$pageNum_caducidad = 0;
if (isset($_GET['pageNum_caducidad'])) {
  $pageNum_caducidad = $_GET['pageNum_caducidad'];
}
$startRow_caducidad = $pageNum_caducidad * $maxRows_caducidad;

mysql_select_db($database_basepangloria, $basepangloria);
$query_caducidad = "SELECT * FROM TRNENTRADA_INVENTARIO WHERE DATE_ADD( FECHAEXPIRACION, INTERVAL - 14 DAY ) <= CURDATE( )";
$query_limit_caducidad = sprintf("%s LIMIT %d, %d", $query_caducidad, $startRow_caducidad, $maxRows_caducidad);
$caducidad = mysql_query($query_limit_caducidad, $basepangloria) or die(mysql_error());
$row_caducidad = mysql_fetch_assoc($caducidad);

if (isset($_GET['totalRows_caducidad'])) {
  $totalRows_caducidad = $_GET['totalRows_caducidad'];
} else {
  $all_caducidad = mysql_query($query_caducidad);
  $totalRows_caducidad = mysql_num_rows($all_caducidad);
}
$totalPages_caducidad = ceil($totalRows_caducidad/$maxRows_caducidad)-1;

$colname_matprima = "-1";
if (isset($_POST['IDMATPRIMA'])) {
  $colname_matprima = $_POST['IDMATPRIMA'];
}

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
    <td bgcolor="#999999">Medida</td>
    <td bgcolor="#999999">Materia Prima</td>
    <td bgcolor="#999999">Cantidad</td>
    <td bgcolor="#999999">Fecha de expiracion</td>
  </tr>
  <?php do { ?>
 <?php mysql_select_db($database_basepangloria, $basepangloria);
 $cadumat = $row_caducidad['IDMATPRIMA'];
$query_matprima = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$cadumat'", GetSQLValueString($colname_matprima, "int"));
$matprima = mysql_query($query_matprima, $basepangloria) or die(mysql_error());
$row_matprima = mysql_fetch_assoc($matprima);
$totalRows_matprima = mysql_num_rows($matprima);

mysql_select_db($database_basepangloria, $basepangloria);
$cadunida = $row_caducidad['IDUNIDAD'];
$query_medi = sprintf("SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$cadunida'", GetSQLValueString($colname_medi, "int"));
$medi = mysql_query($query_medi, $basepangloria) or die(mysql_error());
$row_medi = mysql_fetch_assoc($medi);
$totalRows_medi = mysql_num_rows($medi);
?>
    <tr>
      <td><?php echo $row_medi['TIPOUNIDAD']; ?></td>
      <td><?php echo $row_matprima['DESCRIPCION']; ?></td>
      <td><?php echo $row_caducidad['CANTIDAD']; ?></td>
      <td><?php echo $row_caducidad['FECHAEXPIRACION']; ?></td>
    </tr>
    <?php } while ($row_caducidad = mysql_fetch_assoc($caducidad)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($caducidad);

mysql_free_result($matprima);

mysql_free_result($medi);
?>
