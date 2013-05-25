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

$maxRows_usuario = 10;
$pageNum_usuario = 0;
if (isset($_GET['pageNum_usuario'])) {
  $pageNum_usuario = $_GET['pageNum_usuario'];
}
$startRow_usuario = $pageNum_usuario * $maxRows_usuario;

mysql_select_db($database_basepangloria, $basepangloria);
$query_usuario = "SELECT * FROM CATUSUARIO";
$query_limit_usuario = sprintf("%s LIMIT %d, %d", $query_usuario, $startRow_usuario, $maxRows_usuario);
$usuario = mysql_query($query_limit_usuario, $basepangloria) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);

if (isset($_GET['totalRows_usuario'])) {
  $totalRows_usuario = $_GET['totalRows_usuario'];
} else {
  $all_usuario = mysql_query($query_usuario);
  $totalRows_usuario = mysql_num_rows($all_usuario);
}
$totalPages_usuario = ceil($totalRows_usuario/$maxRows_usuario)-1;
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>IDUSUARIO</td>
    <td>NOMBREUSUARIO</td>
    <td>CONTRASENA</td>
    <td>PRIMERINICIO</td>
    <td>ULTIMOINICIO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php echo $row_usuario['IDUSUARIO']; ?></td>
      <td><?php echo $row_usuario['NOMBREUSUARIO']; ?></td>
      <td><?php echo $row_usuario['CONTRASENA']; ?></td>
      <td><?php echo $row_usuario['PRIMERINICIO']; ?></td>
      <td><?php echo $row_usuario['ULTIMOINICIO']; ?></td>
    </tr>
    <?php } while ($row_usuario = mysql_fetch_assoc($usuario)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($usuario);
?>
