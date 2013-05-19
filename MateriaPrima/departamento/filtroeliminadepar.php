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

$maxRows_filtrodepar = 10;
$pageNum_filtrodepar = 0;
if (isset($_GET['pageNum_filtrodepar'])) {
  $pageNum_filtrodepar = $_GET['pageNum_filtrodepar'];
}
$startRow_filtrodepar = $pageNum_filtrodepar * $maxRows_filtrodepar;

$colname_filtrodepar = "-1";
if (isset($_POST['filtrodepa'])) {
  $colname_filtrodepar = $_POST['filtrodepa'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrodepar = sprintf("SELECT * FROM CATDEPARTAMENEMPRESA WHERE DEPARTAMENTO LIKE %s ORDER BY DEPARTAMENTO ASC", GetSQLValueString("%" . $colname_filtrodepar . "%", "text"));
$query_limit_filtrodepar = sprintf("%s LIMIT %d, %d", $query_filtrodepar, $startRow_filtrodepar, $maxRows_filtrodepar);
$filtrodepar = mysql_query($query_limit_filtrodepar, $basepangloria) or die(mysql_error());
$row_filtrodepar = mysql_fetch_assoc($filtrodepar);

if (isset($_GET['totalRows_filtrodepar'])) {
  $totalRows_filtrodepar = $_GET['totalRows_filtrodepar'];
} else {
  $all_filtrodepar = mysql_query($query_filtrodepar);
  $totalRows_filtrodepar = mysql_num_rows($all_filtrodepar);
}
$totalPages_filtrodepar = ceil($totalRows_filtrodepar/$maxRows_filtrodepar)-1;
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
    <td colspan="4" align="center" bgcolor="#999999"><h1>Eliminar Departamento de Empresa</h1></td>
  </tr>
  <tr>
    <td>Modificacion</td>
    <td>IDDEPTO</td>
    <td>DEPARTAMENTO</td>
    <td>NUMEROTELEFONO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarDepartamento.php?root=<?php echo $row_filtrodepar['IDDEPTO'];?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_filtrodepar['IDDEPTO']; ?></td>
      <td><?php echo $row_filtrodepar['DEPARTAMENTO']; ?></td>
      <td><?php echo $row_filtrodepar['NUMEROTELEFONO']; ?></td>
    </tr>
    <?php } while ($row_filtrodepar = mysql_fetch_assoc($filtrodepar)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtrodepar);
?>
