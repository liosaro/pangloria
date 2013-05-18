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

$maxRows_filtropago = 10;
$pageNum_filtropago = 0;
if (isset($_GET['pageNum_filtropago'])) {
  $pageNum_filtropago = $_GET['pageNum_filtropago'];
}
$startRow_filtropago = $pageNum_filtropago * $maxRows_filtropago;

$colname_filtropago = "-1";
if (isset($_POST['filtrotipago'])) {
  $colname_filtropago = $_POST['filtrotipago'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtropago = sprintf("SELECT * FROM CATCONDICIONPAGO WHERE TIPO LIKE %s ORDER BY IDCONDICION ASC", GetSQLValueString("%" . $colname_filtropago . "%", "text"));
$query_limit_filtropago = sprintf("%s LIMIT %d, %d", $query_filtropago, $startRow_filtropago, $maxRows_filtropago);
$filtropago = mysql_query($query_limit_filtropago, $basepangloria) or die(mysql_error());
$row_filtropago = mysql_fetch_assoc($filtropago);

if (isset($_GET['totalRows_filtropago'])) {
  $totalRows_filtropago = $_GET['totalRows_filtropago'];
} else {
  $all_filtropago = mysql_query($query_filtropago);
  $totalRows_filtropago = mysql_num_rows($all_filtropago);
}
$totalPages_filtropago = ceil($totalRows_filtropago/$maxRows_filtropago)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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
    <td>IDCONDICION</td>
    <td>TIPO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('elimiTipoPago.php?root=<?php echo $row_filtropago['IDCONDICION']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtropago['IDCONDICION']; ?></td>
      <td><?php echo $row_filtropago['TIPO']; ?></td>
    </tr>
    <?php } while ($row_filtropago = mysql_fetch_assoc($filtropago)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtropago);
?>
