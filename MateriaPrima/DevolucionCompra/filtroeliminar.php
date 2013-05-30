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

$maxRows_filtrodevo = 10;
$pageNum_filtrodevo = 0;
if (isset($_GET['pageNum_filtrodevo'])) {
  $pageNum_filtrodevo = $_GET['pageNum_filtrodevo'];
}
$startRow_filtrodevo = $pageNum_filtrodevo * $maxRows_filtrodevo;

$colname_filtrodevo = "-1";
if (isset($_POST['filtrodevolu'])) {
  $colname_filtrodevo = $_POST['filtrodevolu'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrodevo = sprintf("SELECT * FROM TRNDEVOLUCIONCOMPRA WHERE FECHADEVOLUCION LIKE %s ORDER BY IDDEVOLUCION ASC", GetSQLValueString("%" . $colname_filtrodevo . "%", "date"));
$query_limit_filtrodevo = sprintf("%s LIMIT %d, %d", $query_filtrodevo, $startRow_filtrodevo, $maxRows_filtrodevo);
$filtrodevo = mysql_query($query_limit_filtrodevo, $basepangloria) or die(mysql_error());
$row_filtrodevo = mysql_fetch_assoc($filtrodevo);

if (isset($_GET['totalRows_filtrodevo'])) {
  $totalRows_filtrodevo = $_GET['totalRows_filtrodevo'];
} else {
  $all_filtrodevo = mysql_query($query_filtrodevo);
  $totalRows_filtrodevo = mysql_num_rows($all_filtrodevo);
}
$totalPages_filtrodevo = ceil($totalRows_filtrodevo/$maxRows_filtrodevo)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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
    <td>Eliminar</td>
    <td>IDDEVOLUCION</td>
    <td>IDEMPLEADO</td>
    <td>ID_DETENCCOM</td>
    <td>DOCADEVOLVER</td>
    <td>FECHADEVOLUCION</td>
    <td>IMPORTE</td>
    <td>GASTOGENERADO</td>
    <td>OBSERVACION</td>
    <td>ELIMIN</td>
    <td>EDITA</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminar.php?root=<?php echo $row_devo['IDDEVOLUCION']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtrodevo['IDDEVOLUCION']; ?></td>
      <td><?php echo $row_filtrodevo['IDEMPLEADO']; ?></td>
      <td><?php echo $row_filtrodevo['ID_DETENCCOM']; ?></td>
      <td><?php echo $row_filtrodevo['DOCADEVOLVER']; ?></td>
      <td><?php echo $row_filtrodevo['FECHADEVOLUCION']; ?></td>
      <td><?php echo $row_filtrodevo['IMPORTE']; ?></td>
      <td><?php echo $row_filtrodevo['GASTOGENERADO']; ?></td>
      <td><?php echo $row_filtrodevo['OBSERVACION']; ?></td>
      <td><?php echo $row_filtrodevo['ELIMIN']; ?></td>
      <td><?php echo $row_filtrodevo['EDITA']; ?></td>
    </tr>
    <?php } while ($row_filtrodevo = mysql_fetch_assoc($filtrodevo)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtrodevo);
?>
