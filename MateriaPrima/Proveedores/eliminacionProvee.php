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

$maxRows_eliminarPorvee = 10;
$pageNum_eliminarPorvee = 0;
if (isset($_GET['pageNum_eliminarPorvee'])) {
  $pageNum_eliminarPorvee = $_GET['pageNum_eliminarPorvee'];
}
$startRow_eliminarPorvee = $pageNum_eliminarPorvee * $maxRows_eliminarPorvee;

mysql_select_db($database_basepangloria, $basepangloria);
$query_eliminarPorvee = "SELECT * FROM CATPROVEEDOR ORDER BY IDPROVEEDOR ASC";
$query_limit_eliminarPorvee = sprintf("%s LIMIT %d, %d", $query_eliminarPorvee, $startRow_eliminarPorvee, $maxRows_eliminarPorvee);
$eliminarPorvee = mysql_query($query_limit_eliminarPorvee, $basepangloria) or die(mysql_error());
$row_eliminarPorvee = mysql_fetch_assoc($eliminarPorvee);

if (isset($_GET['totalRows_eliminarPorvee'])) {
  $totalRows_eliminarPorvee = $_GET['totalRows_eliminarPorvee'];
} else {
  $all_eliminarPorvee = mysql_query($query_eliminarPorvee);
  $totalRows_eliminarPorvee = mysql_num_rows($all_eliminarPorvee);
}
$totalPages_eliminarPorvee = ceil($totalRows_eliminarPorvee/$maxRows_eliminarPorvee)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table border="1">
    <tr></tr>
    <tr>
      <td colspan="11">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11"><label for="filtroProvee"></label>
      <input type="text" name="filtroProvee" id="filtroProvee" />
      <input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" /></td>
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
      <td><?php echo $row_eliminarPorvee['IDPROVEEDOR']; ?></td>
      <td><?php echo $row_eliminarPorvee['IDPAIS']; ?></td>
      <td><?php echo $row_eliminarPorvee['NOMBREPROVEEDOR']; ?></td>
      <td><?php echo $row_eliminarPorvee['DIRECCIONPROVEEDOR']; ?></td>
      <td><?php echo $row_eliminarPorvee['TELEFONOPROVEEDOR']; ?></td>
      <td><?php echo $row_eliminarPorvee['CORREOPROVEEDOR']; ?></td>
      <td><?php echo $row_eliminarPorvee['FECHAINGRESOPROVE']; ?></td>
      <td><?php echo $row_eliminarPorvee['GIRO']; ?></td>
      <td><?php echo $row_eliminarPorvee['NUMEROREGISTRO']; ?></td>
      <td><?php echo $row_eliminarPorvee['WEB']; ?></td>
      <td><?php echo $row_eliminarPorvee['DEPTOPAISPROVEEDOR']; ?></td>
    </tr>
    <?php } while ($row_eliminarPorvee = mysql_fetch_assoc($eliminarPorvee)); ?>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($eliminarPorvee);
?>
