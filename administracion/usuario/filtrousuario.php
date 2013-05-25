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

$maxRows_filtro = 10;
$pageNum_filtro = 0;
if (isset($_GET['pageNum_filtro'])) {
  $pageNum_filtro = $_GET['pageNum_filtro'];
}
$startRow_filtro = $pageNum_filtro * $maxRows_filtro;

$colname_filtro = "-1";
if (isset($_POST['filtro'])) {
  $colname_filtro = $_POST['filtro'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtro = sprintf("SELECT * FROM CATUSUARIO WHERE NOMBREUSUARIO LIKE %s ORDER BY NOMBREUSUARIO ASC", GetSQLValueString("%" . $colname_filtro . "%", "text"));
$query_limit_filtro = sprintf("%s LIMIT %d, %d", $query_filtro, $startRow_filtro, $maxRows_filtro);
$filtro = mysql_query($query_limit_filtro, $basepangloria) or die(mysql_error());
$row_filtro = mysql_fetch_assoc($filtro);

if (isset($_GET['totalRows_filtro'])) {
  $totalRows_filtro = $_GET['totalRows_filtro'];
} else {
  $all_filtro = mysql_query($query_filtro);
  $totalRows_filtro = mysql_num_rows($all_filtro);
}
$totalPages_filtro = ceil($totalRows_filtro/$maxRows_filtro)-1;
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
<script language="JavaScript">
function aviso(url){
if (!confirm("ALERTA!! va a proceder a eliminar este registro, si desea eliminarlo de click en ACEPTAR\n de lo contrario de click en CANCELAR.")) {
return false;
}
else {
document.location = url;
return true;
}
}
</script>
</head>

<body>
<table border="1">
  <tr>
    <td>modificaion</td>
    <td>IDUSUARIO</td>
    <td>NOMBREUSUARIO</td>
    <td>CONTRASENA</td>
    <td>PRIMERINICIO</td>
    <td>ULTIMOINICIO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarconsulta.php?root=<?php echo $row_filtro['IDUSUARIO'];?>');return false;">Eliminar</a></td>
      <td><?php echo $row_filtro['IDUSUARIO']; ?></td>
      <td><?php echo $row_filtro['NOMBREUSUARIO']; ?></td>
      <td><?php echo $row_filtro['CONTRASENA']; ?></td>
      <td><?php echo $row_filtro['PRIMERINICIO']; ?></td>
      <td><?php echo $row_filtro['ULTIMOINICIO']; ?></td>
    </tr>
    <?php } while ($row_filtro = mysql_fetch_assoc($filtro)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtro);
?>
