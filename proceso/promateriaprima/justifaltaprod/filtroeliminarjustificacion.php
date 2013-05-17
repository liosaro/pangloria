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

$maxRows_filtradojustificacion = 10;
$pageNum_filtradojustificacion = 0;
if (isset($_GET['pageNum_filtradojustificacion'])) {
  $pageNum_filtradojustificacion = $_GET['pageNum_filtradojustificacion'];
}
$startRow_filtradojustificacion = $pageNum_filtradojustificacion * $maxRows_filtradojustificacion;

$colname_filtradojustificacion = "-1";
if (isset($_GET['root'])) {
  $colname_filtradojustificacion = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradojustificacion = sprintf("SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO WHERE FECHAINGRESOJUSFAPROD LIKE %s", GetSQLValueString("%" . $colname_filtradojustificacion . "%", "date"));
$query_limit_filtradojustificacion = sprintf("%s LIMIT %d, %d", $query_filtradojustificacion, $startRow_filtradojustificacion, $maxRows_filtradojustificacion);
$filtradojustificacion = mysql_query($query_limit_filtradojustificacion, $basepangloria) or die(mysql_error());
$row_filtradojustificacion = mysql_fetch_assoc($filtradojustificacion);

if (isset($_GET['totalRows_filtradojustificacion'])) {
  $totalRows_filtradojustificacion = $_GET['totalRows_filtradojustificacion'];
} else {
  $all_filtradojustificacion = mysql_query($query_filtradojustificacion);
  $totalRows_filtradojustificacion = mysql_num_rows($all_filtradojustificacion);
}
$totalPages_filtradojustificacion = ceil($totalRows_filtradojustificacion/$maxRows_filtradojustificacion)-1;
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
    <td>&nbsp;</td>
    <td>ID_JUSTIFICACION</td>
    <td>IDCONTROLPRODUCCION</td>
    <td>CANTIDA_FALTANTE</td>
    <td>IDPRODUCTOFALTA</td>
    <td>ID_MEDIDA</td>
    <td>FECHAINGRESOJUSFAPROD</td>
    <td>JUSTIFICACIONFALTAPROD</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarJustificacion.php?root=<?php echo $row_filtradojustificacion['ID_JUSTIFICACION'];?>'); return false;">Eliminar</td>
      <td><?php echo $row_filtradojustificacion['ID_JUSTIFICACION']; ?></td>
      <td><?php echo $row_filtradojustificacion['IDCONTROLPRODUCCION']; ?></td>
      <td><?php echo $row_filtradojustificacion['CANTIDA_FALTANTE']; ?></td>
      <td><?php echo $row_filtradojustificacion['IDPRODUCTOFALTA']; ?></td>
      <td><?php echo $row_filtradojustificacion['ID_MEDIDA']; ?></td>
      <td><?php echo $row_filtradojustificacion['FECHAINGRESOJUSFAPROD']; ?></td>
      <td><?php echo $row_filtradojustificacion['JUSTIFICACIONFALTAPROD']; ?></td>
    </tr>
    <?php } while ($row_filtradojustificacion = mysql_fetch_assoc($filtradojustificacion)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradojustificacion);
?>
