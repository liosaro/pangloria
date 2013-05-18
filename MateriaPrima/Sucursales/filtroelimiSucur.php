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

$maxRows_filtrelimiSucur = 10;
$pageNum_filtrelimiSucur = 0;
if (isset($_GET['pageNum_filtrelimiSucur'])) {
  $pageNum_filtrelimiSucur = $_GET['pageNum_filtrelimiSucur'];
}
$startRow_filtrelimiSucur = $pageNum_filtrelimiSucur * $maxRows_filtrelimiSucur;

$colname_filtrelimiSucur = "-1";
if (isset($_POST['elimisucur'])) {
  $colname_filtrelimiSucur = $_POST['elimisucur'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrelimiSucur = sprintf("SELECT * FROM CATSUCURSAL WHERE NOMBRESUCURSAL LIKE %s ORDER BY NOMBRESUCURSAL ASC", GetSQLValueString("%" . $colname_filtrelimiSucur . "%", "text"));
$query_limit_filtrelimiSucur = sprintf("%s LIMIT %d, %d", $query_filtrelimiSucur, $startRow_filtrelimiSucur, $maxRows_filtrelimiSucur);
$filtrelimiSucur = mysql_query($query_limit_filtrelimiSucur, $basepangloria) or die(mysql_error());
$row_filtrelimiSucur = mysql_fetch_assoc($filtrelimiSucur);

if (isset($_GET['totalRows_filtrelimiSucur'])) {
  $totalRows_filtrelimiSucur = $_GET['totalRows_filtrelimiSucur'];
} else {
  $all_filtrelimiSucur = mysql_query($query_filtrelimiSucur);
  $totalRows_filtrelimiSucur = mysql_num_rows($all_filtrelimiSucur);
}
$totalPages_filtrelimiSucur = ceil($totalRows_filtrelimiSucur/$maxRows_filtrelimiSucur)-1;
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
    <td>eliminacion </td>
    <td>IDSUCURSAL</td>
    <td>NOMBRESUCURSAL</td>
    <td>DIRECCIONSUCURSAL</td>
    <td>TELEFONOSUCURSAL</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarSucur.php?root=<?php echo $row_filtrelimiSucur['IDSUCURSAL']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtrelimiSucur['IDSUCURSAL']; ?></td>
      <td><?php echo $row_filtrelimiSucur['NOMBRESUCURSAL']; ?></td>
      <td><?php echo $row_filtrelimiSucur['DIRECCIONSUCURSAL']; ?></td>
      <td><?php echo $row_filtrelimiSucur['TELEFONOSUCURSAL']; ?></td>
    </tr>
    <?php } while ($row_filtrelimiSucur = mysql_fetch_assoc($filtrelimiSucur)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtrelimiSucur);
?>
