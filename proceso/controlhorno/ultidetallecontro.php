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

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultienca = "SELECT IDENCABEZADO FROM TRNENCACONTROLPRODHORNO ORDER BY IDENCABEZADO DESC";
$ultienca = mysql_query($query_ultienca, $basepangloria) or die(mysql_error());
$row_ultienca = mysql_fetch_assoc($ultienca);
$totalRows_ultienca = mysql_num_rows($ultienca);

$maxRows_ultidetalle = 10;
$pageNum_ultidetalle = 0;
if (isset($_GET['pageNum_ultidetalle'])) {
  $pageNum_ultidetalle = $_GET['pageNum_ultidetalle'];
}
$startRow_ultidetalle = $pageNum_ultidetalle * $maxRows_ultidetalle;

$colname_ultidetalle = "-1";
if (isset($_GET['IDENCABEZADO'])) {
  $colname_ultidetalle = $_GET['IDENCABEZADO'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$ulti = $row_ultienca['IDENCABEZADO'];
$query_ultidetalle = sprintf("SELECT ID_CONTROLPRODHORNO, IDPRODUCTO, ID_MEDIDA, CANTIDAD_INGRESO, CANTIDADEGRESO FROM TRNDETACONTROL_PRODUCTO_HORNO WHERE IDENCABEZADO = '$ulti' ORDER BY ID_CONTROLPRODHORNO DESC");
$query_limit_ultidetalle = sprintf("%s LIMIT %d, %d", $query_ultidetalle, $startRow_ultidetalle, $maxRows_ultidetalle);
$ultidetalle = mysql_query($query_limit_ultidetalle, $basepangloria) or die(mysql_error());
$row_ultidetalle = mysql_fetch_assoc($ultidetalle);

if (isset($_GET['totalRows_ultidetalle'])) {
  $totalRows_ultidetalle = $_GET['totalRows_ultidetalle'];
} else {
  $all_ultidetalle = mysql_query($query_ultidetalle);
  $totalRows_ultidetalle = mysql_num_rows($all_ultidetalle);
}
$totalPages_ultidetalle = ceil($totalRows_ultidetalle/$maxRows_ultidetalle)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>ID_CONTROLPRODHORNO</td>
          <td>IDPRODUCTO</td>
          <td>ID_MEDIDA</td>
          <td>CANTIDAD_INGRESO</td>
          <td>CANTIDADEGRESO</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_ultidetalle['ID_CONTROLPRODHORNO']; ?></td>
            <td><?php echo $row_ultidetalle['IDPRODUCTO']; ?></td>
            <td><?php echo $row_ultidetalle['ID_MEDIDA']; ?></td>
            <td><?php echo $row_ultidetalle['CANTIDAD_INGRESO']; ?></td>
            <td><?php echo $row_ultidetalle['CANTIDADEGRESO']; ?></td>
          </tr>
          <?php } while ($row_ultidetalle = mysql_fetch_assoc($ultidetalle)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($ultienca);

mysql_free_result($ultidetalle);
?>
