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

$maxRows_filtradocargo = 15;
$pageNum_filtradocargo = 0;
if (isset($_GET['pageNum_filtradocargo'])) {
  $pageNum_filtradocargo = $_GET['pageNum_filtradocargo'];
}
$startRow_filtradocargo = $pageNum_filtradocargo * $maxRows_filtradocargo;

mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradocargo = "SELECT * FROM CATCARGO ORDER BY IDCARGO DESC";
$query_limit_filtradocargo = sprintf("%s LIMIT %d, %d", $query_filtradocargo, $startRow_filtradocargo, $maxRows_filtradocargo);
$filtradocargo = mysql_query($query_limit_filtradocargo, $basepangloria) or die(mysql_error());
$row_filtradocargo = mysql_fetch_assoc($filtradocargo);

if (isset($_GET['totalRows_filtradocargo'])) {
  $totalRows_filtradocargo = $_GET['totalRows_filtradocargo'];
} else {
  $all_filtradocargo = mysql_query($query_filtradocargo);
  $totalRows_filtradocargo = mysql_num_rows($all_filtradocargo);
}
$totalPages_filtradocargo = ceil($totalRows_filtradocargo/$maxRows_filtradocargo)-1;
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
</head>

<body>
<iframe src="modificadorcargo.php" name="modiprodu" width="780" height="250" align="middle" scrolling="No" frameborder="0" id="modiproducs"></iframe>
<p>&nbsp;</p>
<table width="830" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>Modificacion</td>
    <td>ID de Cargo</td>
    <td>Nombre de Cargo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="<?php echo $row_filtradocargo['IDCARGO']; ?>?root=<?php echo $row_filtradocargo['IDCARGO'']; ?>" target="modiprodu">Modificar</a></td>
      <td><?php echo $row_filtradocargo['IDCARGO']; ?></td>
      <td><?php echo $row_filtradocargo['CARGO']; ?></td>
    </tr>
    <?php } while ($row_filtradocargo = mysql_fetch_assoc($filtradocargo)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradocargo);
?>
