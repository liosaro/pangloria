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

$maxRows_filtradoproducto = 10;
$pageNum_filtradoproducto = 0;
if (isset($_GET['pageNum_filtradoproducto'])) {
  $pageNum_filtradoproducto = $_GET['pageNum_filtradoproducto'];
}
$startRow_filtradoproducto = $pageNum_filtradoproducto * $maxRows_filtradoproducto;

$colname_filtradoproducto = "-1";
if (isset($_POST['filtroprod'])) {
  $colname_filtradoproducto = $_POST['filtroprod'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradoproducto = sprintf("SELECT * FROM CATPERMISOS WHERE DESCRIPCION LIKE %s", GetSQLValueString("%" . $colname_filtradoproducto . "%", "text"));
$query_limit_filtradoproducto = sprintf("%s LIMIT %d, %d", $query_filtradoproducto, $startRow_filtradoproducto, $maxRows_filtradoproducto);
$filtradoproducto = mysql_query($query_limit_filtradoproducto, $basepangloria) or die(mysql_error());
$row_filtradoproducto = mysql_fetch_assoc($filtradoproducto);

if (isset($_GET['totalRows_filtradoproducto'])) {
  $totalRows_filtradoproducto = $_GET['totalRows_filtradoproducto'];
} else {
  $all_filtradoproducto = mysql_query($query_filtradoproducto);
  $totalRows_filtradoproducto = mysql_num_rows($all_filtradoproducto);
}
$totalPages_filtradoproducto = ceil($totalRows_filtradoproducto/$maxRows_filtradoproducto)-1;
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
<iframe src="modificadorPermiso.php" name="modiprodu" width="780" height="250" align="middle" scrolling="No" frameborder="0" id="modiproducs"></iframe>
<p>&nbsp;</p>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#999999"><strong>Modificacion</strong></td>
    <td align="center" bgcolor="#999999"><strong>Codigo de Permiso</strong></td>
    <td align="center" bgcolor="#999999"><strong>Permiso</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modificadorPermiso.php?root=<?php echo $row_filtradoproducto['IDPERMISO']; ?>" target="modiprodu">Modificar</a></td>
      <td><?php echo $row_filtradoproducto['IDPERMISO']; ?></td>
      <td><?php echo $row_filtradoproducto['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_filtradoproducto = mysql_fetch_assoc($filtradoproducto)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradoproducto);
?>
