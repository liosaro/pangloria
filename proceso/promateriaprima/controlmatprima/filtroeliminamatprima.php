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

$maxRows_filtradocontrol = 15;
$pageNum_filtradocontrol = 0;
if (isset($_GET['pageNum_filtradocontrol'])) {
  $pageNum_filtradocontrol = $_GET['pageNum_filtradocontrol'];
}
$startRow_filtradocontrol = $pageNum_filtradocontrol * $maxRows_filtradocontrol;

$colname_filtradocontrol = "-1";
if (isset($_POST['root'])) {
  $colname_filtradocontrol = $_POST['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradocontrol = sprintf("SELECT * FROM TRNCONTROL_MAT_PRIMA WHERE ID_CONTROLMAT LIKE %s", GetSQLValueString("%" . $colname_filtradocontrol . "%", "text"));
$query_limit_filtradocontrol = sprintf("%s LIMIT %d, %d", $query_filtradocontrol, $startRow_filtradocontrol, $maxRows_filtradocontrol);
$filtradocontrol = mysql_query($query_limit_filtradocontrol, $basepangloria) or die(mysql_error());
$row_filtradocontrol = mysql_fetch_assoc($filtradocontrol);

if (isset($_GET['totalRows_filtradocontrol'])) {
  $totalRows_filtradocontrol = $_GET['totalRows_filtradocontrol'];
} else {
  $all_filtradocontrol = mysql_query($query_filtradocontrol);
  $totalRows_filtradocontrol = mysql_num_rows($all_filtradocontrol);
}
$totalPages_filtradocontrol = ceil($totalRows_filtradocontrol/$maxRows_filtradocontrol)-1;
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
      <td><a href="javascript:;" onclick="aviso('eliminarMatprima.php?root=<?php echo $row_filtradocontrol['ID_CONTROLMAT']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtradocontrol['ID_CONTROLMAT']; ?></td>
      <td><?php echo $row_filtradocontrol['IDMATPRIMA']; ?></td>
      <td><?php echo $row_filtradocontrol['ID_SALIDA']; ?></td>
      <td><?php echo $row_filtradocontrol['IDUNIDAD']; ?></td>
      <td><?php echo $row_filtradocontrol['CANT_ENTREGA']; ?></td>
      <td><?php echo $row_filtradocontrol['CANT_DEVUELTA']; ?></td>
      <td><?php echo $row_filtradocontrol['CANT_UTILIZADA']; ?></td>
      <td><?php echo $row_filtradocontrol['FECHA_CONTROL']; ?></td>
    </tr>
    <?php } while ($row_filtradocontrol = mysql_fetch_assoc($filtradocontrol)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradocontrol);
?>
