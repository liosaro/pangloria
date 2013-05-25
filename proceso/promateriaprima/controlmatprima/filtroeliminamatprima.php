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

$maxRows_filtradomatpri = 10;
$pageNum_filtradomatpri = 0;
if (isset($_GET['pageNum_filtradomatpri'])) {
  $pageNum_filtradomatpri = $_GET['pageNum_filtradomatpri'];
}
$startRow_filtradomatpri = $pageNum_filtradomatpri * $maxRows_filtradomatpri;

$colname_filtradomatpri = "-1";
if (isset($_POST['root'])) {
  $colname_filtradomatpri = $_POST['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradomatpri = sprintf("SELECT * FROM TRNCONTROL_MAT_PRIMA WHERE ID_CONTROLMAT LIKE %s", GetSQLValueString("%" . $colname_filtradomatpri . "%", "text"));
$query_limit_filtradomatpri = sprintf("%s LIMIT %d, %d", $query_filtradomatpri, $startRow_filtradomatpri, $maxRows_filtradomatpri);
$filtradomatpri = mysql_query($query_limit_filtradomatpri, $basepangloria) or die(mysql_error());
$row_filtradomatpri = mysql_fetch_assoc($filtradomatpri);

if (isset($_GET['totalRows_filtradomatpri'])) {
  $totalRows_filtradomatpri = $_GET['totalRows_filtradomatpri'];
} else {
  $all_filtradomatpri = mysql_query($query_filtradomatpri);
  $totalRows_filtradomatpri = mysql_num_rows($all_filtradomatpri);
}
$totalPages_filtradomatpri = ceil($totalRows_filtradomatpri/$maxRows_filtradomatpri)-1;
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
<table width="830" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>Eliminar</td>
    <td>ID Control </td>
    <td>Nombre de Materia Prima</td>
    <td>Id Salida</td>
    <td>Unidad</td>
    <td>Cantidad Entregada</td>
    <td>Cantidad Devuelta</td>
    <td>Cantidad Utilizada</td>
    <td>Fecha</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="<?php echo $row_filtradomatpri['']; ?>?root=<?php echo $row_filtradomatpri['ID_CONTROLMAT']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtradomatpri['ID_CONTROLMAT']; ?></td>
      <td><?php echo $row_filtradomatpri['IDMATPRIMA']; ?></td>
      <td><?php echo $row_filtradomatpri['ID_SALIDA']; ?></td>
      <td><?php echo $row_filtradomatpri['IDUNIDAD']; ?></td>
      <td><?php echo $row_filtradomatpri['CANT_ENTREGA']; ?></td>
      <td><?php echo $row_filtradomatpri['CANT_DEVUELTA']; ?></td>
      <td><?php echo $row_filtradomatpri['CANT_UTILIZADA']; ?></td>
      <td><?php echo $row_filtradomatpri['FECHA_CONTROL']; ?></td>
    </tr>
    <?php } while ($row_filtradomatpri = mysql_fetch_assoc($filtradomatpri)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradomatpri);
?>
