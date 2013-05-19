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

$maxRows_filtrodepto = 10;
$pageNum_filtrodepto = 0;
if (isset($_GET['pageNum_filtrodepto'])) {
  $pageNum_filtrodepto = $_GET['pageNum_filtrodepto'];
}
$startRow_filtrodepto = $pageNum_filtrodepto * $maxRows_filtrodepto;

$colname_filtrodepto = "-1";
if (isset($_POST['filtdepto'])) {
  $colname_filtrodepto = $_POST['filtdepto'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrodepto = sprintf("SELECT * FROM CATDEPARTAMENEMPRESA WHERE DEPARTAMENTO LIKE %s ORDER BY DEPARTAMENTO ASC", GetSQLValueString("%" . $colname_filtrodepto . "%", "text"));
$query_limit_filtrodepto = sprintf("%s LIMIT %d, %d", $query_filtrodepto, $startRow_filtrodepto, $maxRows_filtrodepto);
$filtrodepto = mysql_query($query_limit_filtrodepto, $basepangloria) or die(mysql_error());
$row_filtrodepto = mysql_fetch_assoc($filtrodepto);

if (isset($_GET['totalRows_filtrodepto'])) {
  $totalRows_filtrodepto = $_GET['totalRows_filtrodepto'];
} else {
  $all_filtrodepto = mysql_query($query_filtrodepto);
  $totalRows_filtrodepto = mysql_num_rows($all_filtrodepto);
}
$totalPages_filtrodepto = ceil($totalRows_filtrodepto/$maxRows_filtrodepto)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<p><iframe src="modidepart.php" name="modificar2" width="820" height="200" scrolling="NO" id="modificar"></iframe>&nbsp;</p>
<table border="1">
  <tr>
    <td>Modificacion</td>
    <td>IDDEPTO</td>
    <td>DEPARTAMENTO</td>
    <td>NUMEROTELEFONO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modidepart.php?root=<?php echo $row_filtrodepto['IDDEPTO']; ?>" target="modificar2">Modificar</a></td>
      <td><?php echo $row_filtrodepto['IDDEPTO']; ?></td>
      <td><?php echo $row_filtrodepto['DEPARTAMENTO']; ?></td>
      <td><?php echo $row_filtrodepto['NUMEROTELEFONO']; ?></td>
    </tr>
    <?php } while ($row_filtrodepto = mysql_fetch_assoc($filtrodepto)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtrodepto);
?>
