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

$maxRows_filtradoRol = 10;
$pageNum_filtradoRol = 0;
if (isset($_GET['pageNum_filtradoRol'])) {
  $pageNum_filtradoRol = $_GET['pageNum_filtradoRol'];
}
$startRow_filtradoRol = $pageNum_filtradoRol * $maxRows_filtradoRol;

$colname_filtradoRol = "-1";
if (isset($_POST['IDROL'])) {
  $colname_filtradoRol = $_POST['IDROL'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradoRol = sprintf("SELECT * FROM CATROL WHERE DESCRIPCION LIKE %s ORDER BY DESCRIPCION ASC", GetSQLValueString("%" . $colname_filtradoRol . "%", "text"));
$query_limit_filtradoRol = sprintf("%s LIMIT %d, %d", $query_filtradoRol, $startRow_filtradoRol, $maxRows_filtradoRol);
$filtradoRol = mysql_query($query_limit_filtradoRol, $basepangloria) or die(mysql_error());
$row_filtradoRol = mysql_fetch_assoc($filtradoRol);

if (isset($_GET['totalRows_filtradoRol'])) {
  $totalRows_filtradoRol = $_GET['totalRows_filtradoRol'];
} else {
  $all_filtradoRol = mysql_query($query_filtradoRol);
  $totalRows_filtradoRol = mysql_num_rows($all_filtradoRol);
}
$totalPages_filtradoRol = ceil($totalRows_filtradoRol/$maxRows_filtradoRol)-1;
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
    <td>IDROL</td>
    <td>DESCRIPCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarRol.php?IDROL=<?php echo $row_filtradoRol['IDROL']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtradoRol['IDROL']; ?></td>
      <td><?php echo $row_filtradoRol['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_filtradoRol = mysql_fetch_assoc($filtradoRol)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradoRol);
?>
