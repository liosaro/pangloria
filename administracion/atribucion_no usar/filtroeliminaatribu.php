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

$maxRows_filtradoatribu = 15;
$pageNum_filtradoatribu = 0;
if (isset($_GET['pageNum_filtradoatribu'])) {
  $pageNum_filtradoatribu = $_GET['pageNum_filtradoatribu'];
}
$startRow_filtradoatribu = $pageNum_filtradoatribu * $maxRows_filtradoatribu;

mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradoatribu = "SELECT * FROM CATATRIBUCIONES";
$query_limit_filtradoatribu = sprintf("%s LIMIT %d, %d", $query_filtradoatribu, $startRow_filtradoatribu, $maxRows_filtradoatribu);
$filtradoatribu = mysql_query($query_limit_filtradoatribu, $basepangloria) or die(mysql_error());
$row_filtradoatribu = mysql_fetch_assoc($filtradoatribu);

if (isset($_GET['totalRows_filtradoatribu'])) {
  $totalRows_filtradoatribu = $_GET['totalRows_filtradoatribu'];
} else {
  $all_filtradoatribu = mysql_query($query_filtradoatribu);
  $totalRows_filtradoatribu = mysql_num_rows($all_filtradoatribu);
}
$totalPages_filtradoatribu = ceil($totalRows_filtradoatribu/$maxRows_filtradoatribu)-1;
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
<table width="821" border="1">
  <tr>
    <td colspan="10" align="center" bgcolor="#999999"><h1>Eliminar Atribuciones</h1></td>
  </tr>
  <tr>
    <td colspan="10"><table width="830" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Modificacion</td>
        <td>Id Atribucion</td>
        <td>Id Usuario</td>
        <td>Id Rol</td>
        <td>Id Permiso</td>
        <td>C</td>
        <td>R</td>
        <td>U</td>
        <td>D</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><a href="javascript:;" onclick="aviso('eliminarAtribu.php?root=<?php echo $row_filtradoatribu['ID_ATRIB'];?>'); return false;">Eliminar</a></td>
        <td><?php echo $row_filtradoatribu['ID_ATRIB']; ?></td>
        <td><?php echo $row_filtradoatribu['IDUSUARIO']; ?></td>
        <td><?php echo $row_filtradoatribu['IDROL']; ?></td>
        <td><?php echo $row_filtradoatribu['IDPERMISO']; ?></td>
        <td><?php echo $row_filtradoatribu['C']; ?></td>
        <td><?php echo $row_filtradoatribu['R']; ?></td>
        <td><?php echo $row_filtradoatribu['U']; ?></td>
        <td><?php echo $row_filtradoatribu['D']; ?></td>
      </tr>
      <?php } while ($row_filtradoatribu = mysql_fetch_assoc($filtradoatribu)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($filtradoatribu);
?>
