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

$maxRows_Id = 10;
$pageNum_Id = 0;
if (isset($_GET['pageNum_Id'])) {
  $pageNum_Id = $_GET['pageNum_Id'];
}
$startRow_Id = $pageNum_Id * $maxRows_Id;

$colname_Id = "-1";
if (isset($_GET['root'])) {
  $colname_Id = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_Id = sprintf("SELECT * FROM CATSUCURSAL WHERE IDSUCURSAL = %s ORDER BY IDSUCURSAL ASC", GetSQLValueString($colname_Id, "int"));
$query_limit_Id = sprintf("%s LIMIT %d, %d", $query_Id, $startRow_Id, $maxRows_Id);
$Id = mysql_query($query_limit_Id, $basepangloria) or die(mysql_error());
$row_Id = mysql_fetch_assoc($Id);

if (isset($_GET['totalRows_Id'])) {
  $totalRows_Id = $_GET['totalRows_Id'];
} else {
  $all_Id = mysql_query($query_Id);
  $totalRows_Id = mysql_num_rows($all_Id);
}
$totalPages_Id = ceil($totalRows_Id/$maxRows_Id)-1;
?>
<table border="1">
  <tr>
    <td colspan="4" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td>IDSUCURSAL</td>
    <td>NOMBRESUCURSAL</td>
    <td>DIRECCIONSUCURSAL</td>
    <td>TELEFONOSUCURSAL</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Id['IDSUCURSAL']; ?></td>
      <td><?php echo $row_Id['NOMBRESUCURSAL']; ?></td>
      <td><?php echo $row_Id['DIRECCIONSUCURSAL']; ?></td>
      <td><?php echo $row_Id['TELEFONOSUCURSAL']; ?></td>
    </tr>
    <?php } while ($row_Id = mysql_fetch_assoc($Id)); ?>
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
mysql_free_result($Id);
?>
