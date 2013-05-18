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

$maxRows_elimiSucur = 10;
$pageNum_elimiSucur = 0;
if (isset($_GET['pageNum_elimiSucur'])) {
  $pageNum_elimiSucur = $_GET['pageNum_elimiSucur'];
}
$startRow_elimiSucur = $pageNum_elimiSucur * $maxRows_elimiSucur;

mysql_select_db($database_basepangloria, $basepangloria);
$query_elimiSucur = "SELECT * FROM CATSUCURSAL ORDER BY IDSUCURSAL ASC";
$query_limit_elimiSucur = sprintf("%s LIMIT %d, %d", $query_elimiSucur, $startRow_elimiSucur, $maxRows_elimiSucur);
$elimiSucur = mysql_query($query_limit_elimiSucur, $basepangloria) or die(mysql_error());
$row_elimiSucur = mysql_fetch_assoc($elimiSucur);

if (isset($_GET['totalRows_elimiSucur'])) {
  $totalRows_elimiSucur = $_GET['totalRows_elimiSucur'];
} else {
  $all_elimiSucur = mysql_query($query_elimiSucur);
  $totalRows_elimiSucur = mysql_num_rows($all_elimiSucur);
}
$totalPages_elimiSucur = ceil($totalRows_elimiSucur/$maxRows_elimiSucur)-1;
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
  <tr></tr>
<tr>
  <td colspan="5" align="center" bgcolor="#999999"><h1>Eliminar Sucursal</h1></td>
</tr>
<tr>
  <td colspan="5"><p>
    <iframe src="filtroelimiSucur.php" name="eliminar" width="820" height="400" scrolling="Auto" frameborder="0" id="eliminar"></iframe>
  </p>
    <p><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></p></td>
</tr>
<tr>
  <td colspan="5"><form action="filtroelimiSucur.php" method="post" name="enviosucur" target="eliminar" id="enviosucur">
    <label for="elimisucur"></label>
    <input type="text" name="elimisucur" id="elimisucur" />
    <input type="submit" name="button" id="button" value="Enviar" />
  </form></td>
</tr>
<tr>
  <td>Eliminacion</td>
  <td>IDSUCURSAL</td>
  <td>NOMBRESUCURSAL</td>
  <td>DIRECCIONSUCURSAL</td>
  <td>TELEFONOSUCURSAL</td>
</tr>
<?php do { ?>
<tr>
  <td><a href="javascript:;" onclick="aviso('eliminarSucur.php?root=<?php echo $row_elimiSucur['IDSUCURSAL']; ?>'); return false;">Eliminar</a></td>
  <td><?php echo $row_elimiSucur['IDSUCURSAL']; ?></td>
  <td><?php echo $row_elimiSucur['NOMBRESUCURSAL']; ?></td>
  <td><?php echo $row_elimiSucur['DIRECCIONSUCURSAL']; ?></td>
  <td><?php echo $row_elimiSucur['TELEFONOSUCURSAL']; ?></td>
</tr>
<?php } while ($row_elimiSucur = mysql_fetch_assoc($elimiSucur)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($elimiSucur);
?>
