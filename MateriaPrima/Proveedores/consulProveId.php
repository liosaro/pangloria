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

$maxRows_id = 10;
$pageNum_id = 0;
if (isset($_GET['pageNum_id'])) {
  $pageNum_id = $_GET['pageNum_id'];
}
$startRow_id = $pageNum_id * $maxRows_id;

$colname_id = "-1";
if (isset($_GET['root'])) {
  $colname_id = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_id = sprintf("SELECT * FROM CATPROVEEDOR WHERE IDPROVEEDOR = %s AND ELIMIN = '0' ORDER BY IDPROVEEDOR ASC", GetSQLValueString($colname_id, "int"));
$query_limit_id = sprintf("%s LIMIT %d, %d", $query_id, $startRow_id, $maxRows_id);
$id = mysql_query($query_limit_id, $basepangloria) or die(mysql_error());
$row_id = mysql_fetch_assoc($id);

if (isset($_GET['totalRows_id'])) {
  $totalRows_id = $_GET['totalRows_id'];
} else {
  $all_id = mysql_query($query_id);
  $totalRows_id = mysql_num_rows($all_id);
}
$totalPages_id = ceil($totalRows_id/$maxRows_id)-1;
?>
<table border="1">
  <tr>
    <td colspan="11" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
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
      <td><?php echo $row_id['IDPROVEEDOR']; ?></td>
      <td><?php echo $row_id['IDPAIS']; ?></td>
      <td><?php echo $row_id['NOMBREPROVEEDOR']; ?></td>
      <td><?php echo $row_id['DIRECCIONPROVEEDOR']; ?></td>
      <td><?php echo $row_id['TELEFONOPROVEEDOR']; ?></td>
      <td><?php echo $row_id['CORREOPROVEEDOR']; ?></td>
      <td><?php echo $row_id['FECHAINGRESOPROVE']; ?></td>
      <td><?php echo $row_id['GIRO']; ?></td>
      <td><?php echo $row_id['NUMEROREGISTRO']; ?></td>
      <td><?php echo $row_id['WEB']; ?></td>
      <td><?php echo $row_id['DEPTOPAISPROVEEDOR']; ?></td>
    </tr>
    <?php } while ($row_id = mysql_fetch_assoc($id)); ?>
</table>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?php
mysql_free_result($id);
?>
