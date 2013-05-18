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

$maxRows_filtroelimiSucur = 10;
$pageNum_filtroelimiSucur = 0;
if (isset($_GET['pageNum_filtroelimiSucur'])) {
  $pageNum_filtroelimiSucur = $_GET['pageNum_filtroelimiSucur'];
}
$startRow_filtroelimiSucur = $pageNum_filtroelimiSucur * $maxRows_filtroelimiSucur;

$colname_filtroelimiSucur = "-1";
if (isset($_POST['elimisucur'])) {
  $colname_filtroelimiSucur = $_POST['elimisucur'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtroelimiSucur = sprintf("SELECT * FROM CATSUCURSAL WHERE NOMBRESUCURSAL LIKE %s ORDER BY IDSUCURSAL ASC", GetSQLValueString("%" . $colname_filtroelimiSucur . "%", "text"));
$query_limit_filtroelimiSucur = sprintf("%s LIMIT %d, %d", $query_filtroelimiSucur, $startRow_filtroelimiSucur, $maxRows_filtroelimiSucur);
$filtroelimiSucur = mysql_query($query_limit_filtroelimiSucur, $basepangloria) or die(mysql_error());
$row_filtroelimiSucur = mysql_fetch_assoc($filtroelimiSucur);

if (isset($_GET['totalRows_filtroelimiSucur'])) {
  $totalRows_filtroelimiSucur = $_GET['totalRows_filtroelimiSucur'];
} else {
  $all_filtroelimiSucur = mysql_query($query_filtroelimiSucur);
  $totalRows_filtroelimiSucur = mysql_num_rows($all_filtroelimiSucur);
}
$totalPages_filtroelimiSucur = ceil($totalRows_filtroelimiSucur/$maxRows_filtroelimiSucur)-1;

mysql_free_result($filtroelimiSucur);
?>

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
      <td><a href="javascript:;" onclick="aviso('eliminarSucur.php?root=<?php echo $row_filtroelimiSucur['IDSUCURSAL']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtroelimiSucur['IDSUCURSAL']; ?></td>
      <td><?php echo $row_filtroelimiSucur['NOMBRESUCURSAL']; ?></td>
      <td><?php echo $row_filtroelimiSucur['DIRECCIONSUCURSAL']; ?></td>
      <td><?php echo $row_filtroelimiSucur['TELEFONOSUCURSAL']; ?></td>
    </tr>
    <?php } while ($row_filtroelimiSucur = mysql_fetch_assoc($filtroelimiSucur)); ?>
</table>
