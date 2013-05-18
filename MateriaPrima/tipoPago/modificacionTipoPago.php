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

$maxRows_modifitipopago = 10;
$pageNum_modifitipopago = 0;
if (isset($_GET['pageNum_modifitipopago'])) {
  $pageNum_modifitipopago = $_GET['pageNum_modifitipopago'];
}
$startRow_modifitipopago = $pageNum_modifitipopago * $maxRows_modifitipopago;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modifitipopago = "SELECT * FROM CATCONDICIONPAGO ORDER BY IDCONDICION ASC";
$query_limit_modifitipopago = sprintf("%s LIMIT %d, %d", $query_modifitipopago, $startRow_modifitipopago, $maxRows_modifitipopago);
$modifitipopago = mysql_query($query_limit_modifitipopago, $basepangloria) or die(mysql_error());
$row_modifitipopago = mysql_fetch_assoc($modifitipopago);

if (isset($_GET['totalRows_modifitipopago'])) {
  $totalRows_modifitipopago = $_GET['totalRows_modifitipopago'];
} else {
  $all_modifitipopago = mysql_query($query_modifitipopago);
  $totalRows_modifitipopago = mysql_num_rows($all_modifitipopago);
}
$totalPages_modifitipopago = ceil($totalRows_modifitipopago/$maxRows_modifitipopago)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td colspan="3"><iframe src="mdiTipoPago.php" name="modipago" width="820" height="400" scrolling="NO" id="modipago"></iframe></td>
  </tr>
  <tr>
    <td colspan="3"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
  </tr>
  <tr>
    <td colspan="3"><form action="filtroModiTipoPago.php" method="post" name="enviarpago" target="modipago" id="enviarpago">
      Ingrese el Nombre del Producto a Modificar:
      <label for="filtropago"></label>
      <input type="text" name="filtropago" id="filtropago" />
      <input type="submit" name="button" id="button" value="Enviar" />
    </form></td>
  </tr>
  <tr>
    <td width="79">Modificacion</td>
    <td width="300">IDCONDICION</td>
    <td width="300">TIPO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="mdiTipoPago.php?root=<?php echo $row_modifitipopago['IDCONDICION']; ?>" target="modipago">Modificar</a></td>
      <td><?php echo $row_modifitipopago['IDCONDICION']; ?></td>
      <td><?php echo $row_modifitipopago['TIPO']; ?></td>
    </tr>
    <?php } while ($row_modifitipopago = mysql_fetch_assoc($modifitipopago)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($modifitipopago);
?>
