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

$maxRows_elimipago = 10;
$pageNum_elimipago = 0;
if (isset($_GET['pageNum_elimipago'])) {
  $pageNum_elimipago = $_GET['pageNum_elimipago'];
}
$startRow_elimipago = $pageNum_elimipago * $maxRows_elimipago;

mysql_select_db($database_basepangloria, $basepangloria);
$query_elimipago = "SELECT * FROM CATCONDICIONPAGO ORDER BY IDCONDICION ASC";
$query_limit_elimipago = sprintf("%s LIMIT %d, %d", $query_elimipago, $startRow_elimipago, $maxRows_elimipago);
$elimipago = mysql_query($query_limit_elimipago, $basepangloria) or die(mysql_error());
$row_elimipago = mysql_fetch_assoc($elimipago);

if (isset($_GET['totalRows_elimipago'])) {
  $totalRows_elimipago = $_GET['totalRows_elimipago'];
} else {
  $all_elimipago = mysql_query($query_elimipago);
  $totalRows_elimipago = mysql_num_rows($all_elimipago);
}
$totalPages_elimipago = ceil($totalRows_elimipago/$maxRows_elimipago)-1;
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
    <td height="31" colspan="3"><iframe src="filtroelimiTipoPago.php" name="eliminar" width="820" height="400" scrolling="Auto" id="eliminar"></iframe></td>
  </tr>
  <tr>
    <td colspan="3"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
  </tr>
  <tr>
    <td colspan="3"><form action="filtroelimiTipoPago.php" method="post" name="enviopago" target="eliminar" id="enviopago">
      <label for="filtrotipago"></label>
      Ingrese el Tipo de Pago
      <input type="text" name="filtrotipago" id="filtrotipago" />
      <input type="submit" name="button" id="button" value="Enviar" />
    </form></td>
  </tr>
  <tr>
    <td>Eliminacion</td>
    <td>IDCONDICION</td>
    <td>TIPO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('elimiTipoPago.php?root=<?php echo $row_elimipago['IDCONDICION']; ?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_elimipago['IDCONDICION']; ?></td>
      <td><?php echo $row_elimipago['TIPO']; ?></td>
    </tr>
    <?php } while ($row_elimipago = mysql_fetch_assoc($elimipago)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($elimipago);
?>
