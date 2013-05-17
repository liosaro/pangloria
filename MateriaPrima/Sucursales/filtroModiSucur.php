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

$maxRows_filtroSucur = 10;
$pageNum_filtroSucur = 0;
if (isset($_GET['pageNum_filtroSucur'])) {
  $pageNum_filtroSucur = $_GET['pageNum_filtroSucur'];
}
$startRow_filtroSucur = $pageNum_filtroSucur * $maxRows_filtroSucur;

$colname_filtroSucur = "-1";
if (isset($_POST['filtroSucu'])) {
  $colname_filtroSucur = $_POST['filtroSucu'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtroSucur = sprintf("SELECT * FROM CATSUCURSAL WHERE NOMBRESUCURSAL LIKE %s ORDER BY NOMBRESUCURSAL ASC", GetSQLValueString("%" . $colname_filtroSucur . "%", "text"));
$query_limit_filtroSucur = sprintf("%s LIMIT %d, %d", $query_filtroSucur, $startRow_filtroSucur, $maxRows_filtroSucur);
$filtroSucur = mysql_query($query_limit_filtroSucur, $basepangloria) or die(mysql_error());
$row_filtroSucur = mysql_fetch_assoc($filtroSucur);

if (isset($_GET['totalRows_filtroSucur'])) {
  $totalRows_filtroSucur = $_GET['totalRows_filtroSucur'];
} else {
  $all_filtroSucur = mysql_query($query_filtroSucur);
  $totalRows_filtroSucur = mysql_num_rows($all_filtroSucur);
}
$totalPages_filtroSucur = ceil($totalRows_filtroSucur/$maxRows_filtroSucur)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<p><iframe src="modiSucursal.php" name="modificar2" width="820" height="400" scrolling="no"></iframe>&nbsp;</p>
<table border="1">
  <tr>
    <td>Modificacion</td>
    <td>IDSUCURSAL</td>
    <td>NOMBRESUCURSAL</td>
    <td>DIRECCIONSUCURSAL</td>
    <td>TELEFONOSUCURSAL</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modiSucursal.php?root=<?php echo $row_filtroSucur['IDSUCURSAL']; ?>"target="modificar">Modificar</a></td>
      <td><?php echo $row_filtroSucur['IDSUCURSAL']; ?></td>
      <td><?php echo $row_filtroSucur['NOMBRESUCURSAL']; ?></td>
      <td><?php echo $row_filtroSucur['DIRECCIONSUCURSAL']; ?></td>
      <td><?php echo $row_filtroSucur['TELEFONOSUCURSAL']; ?></td>
    </tr>
    <?php } while ($row_filtroSucur = mysql_fetch_assoc($filtroSucur)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtroSucur);
?>
