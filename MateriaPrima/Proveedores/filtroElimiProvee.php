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

$maxRows_filtroElimiProve = 10;
$pageNum_filtroElimiProve = 0;
if (isset($_GET['pageNum_filtroElimiProve'])) {
  $pageNum_filtroElimiProve = $_GET['pageNum_filtroElimiProve'];
}
$startRow_filtroElimiProve = $pageNum_filtroElimiProve * $maxRows_filtroElimiProve;

$colname_filtroElimiProve = "-1";
if (isset($_POST['filtroProvee'])) {
  $colname_filtroElimiProve = $_POST['filtroProvee'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtroElimiProve = sprintf("SELECT * FROM CATPROVEEDOR WHERE NOMBREPROVEEDOR LIKE %s ORDER BY IDPROVEEDOR ASC", GetSQLValueString("%" . $colname_filtroElimiProve . "%", "text"));
$query_limit_filtroElimiProve = sprintf("%s LIMIT %d, %d", $query_filtroElimiProve, $startRow_filtroElimiProve, $maxRows_filtroElimiProve);
$filtroElimiProve = mysql_query($query_limit_filtroElimiProve, $basepangloria) or die(mysql_error());
$row_filtroElimiProve = mysql_fetch_assoc($filtroElimiProve);

if (isset($_GET['totalRows_filtroElimiProve'])) {
  $totalRows_filtroElimiProve = $_GET['totalRows_filtroElimiProve'];
} else {
  $all_filtroElimiProve = mysql_query($query_filtroElimiProve);
  $totalRows_filtroElimiProve = mysql_num_rows($all_filtroElimiProve);
}
$totalPages_filtroElimiProve = ceil($totalRows_filtroElimiProve/$maxRows_filtroElimiProve)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

<body>
<table border="1">
  <tr>
    <td>Eliminacion</td>
    <td>IDPROVEEDOR</td>
    <td>IDPAIS</td>
    <td>NOMBREPROVEEDOR</td>
    <td>DIRECCIONPROVEEDOR</td>
    <td>TELEFONOPROVEEDOR</td>
    <td>CORREOPROVEEDOR</td>
    <td>FECHAINGRESOPROVE</td>
    <td>GIRO</td>
    <td>NUMEROREGISTRO</td>
    <td>WEB</td>
    <td>DEPTOPAISPROVEEDOR</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminar_proveedor.php'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtroElimiProve['IDPROVEEDOR']; ?></td>
      <td><?php echo $row_filtroElimiProve['IDPAIS']; ?></td>
      <td><?php echo $row_filtroElimiProve['NOMBREPROVEEDOR']; ?></td>
      <td><?php echo $row_filtroElimiProve['DIRECCIONPROVEEDOR']; ?></td>
      <td><?php echo $row_filtroElimiProve['TELEFONOPROVEEDOR']; ?></td>
      <td><?php echo $row_filtroElimiProve['CORREOPROVEEDOR']; ?></td>
      <td><?php echo $row_filtroElimiProve['FECHAINGRESOPROVE']; ?></td>
      <td><?php echo $row_filtroElimiProve['GIRO']; ?></td>
      <td><?php echo $row_filtroElimiProve['NUMEROREGISTRO']; ?></td>
      <td><?php echo $row_filtroElimiProve['WEB']; ?></td>
      <td><?php echo $row_filtroElimiProve['DEPTOPAISPROVEEDOR']; ?></td>
    </tr>
    <?php } while ($row_filtroElimiProve = mysql_fetch_assoc($filtroElimiProve)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtroElimiProve);
?>
