<head>
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
<table border="1">
  <tr>
    <td>Eliminacion</td>
    <td>IDSUCURSAL</td>
    <td>NOMBRESUCURSAL</td>
    <td>DIRECCIONSUCURSAL</td>
    <td>TELEFONOSUCURSAL</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarSucur.php?root=<?php echo $row_filtrosucur['IDSUCURSAL']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtrosucur['IDSUCURSAL']; ?></td>
      <td><?php echo $row_filtrosucur['NOMBRESUCURSAL']; ?></td>
      <td><?php echo $row_filtrosucur['DIRECCIONSUCURSAL']; ?></td>
      <td><?php echo $row_filtrosucur['TELEFONOSUCURSAL']; ?></td>
    </tr>
    <?php } while ($row_filtrosucur = mysql_fetch_assoc($filtrosucur)); ?>
</table>
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

$maxRows_filtrosucur = 10;
$pageNum_filtrosucur = 0;
if (isset($_GET['pageNum_filtrosucur'])) {
  $pageNum_filtrosucur = $_GET['pageNum_filtrosucur'];
}
$startRow_filtrosucur = $pageNum_filtrosucur * $maxRows_filtrosucur;

$colname_filtrosucur = "-1";
if (isset($_POST['filtrosucu'])) {
  $colname_filtrosucur = $_POST['filtrosucu'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrosucur = sprintf("SELECT * FROM CATSUCURSAL WHERE NOMBRESUCURSAL LIKE %s ORDER BY IDSUCURSAL ASC", GetSQLValueString("%" . $colname_filtrosucur . "%", "text"));
$query_limit_filtrosucur = sprintf("%s LIMIT %d, %d", $query_filtrosucur, $startRow_filtrosucur, $maxRows_filtrosucur);
$filtrosucur = mysql_query($query_limit_filtrosucur, $basepangloria) or die(mysql_error());
$row_filtrosucur = mysql_fetch_assoc($filtrosucur);

if (isset($_GET['totalRows_filtrosucur'])) {
  $totalRows_filtrosucur = $_GET['totalRows_filtrosucur'];
} else {
  $all_filtrosucur = mysql_query($query_filtrosucur);
  $totalRows_filtrosucur = mysql_num_rows($all_filtrosucur);
}
$totalPages_filtrosucur = ceil($totalRows_filtrosucur/$maxRows_filtrosucur)-1;

mysql_free_result($filtrosucur);
?>
