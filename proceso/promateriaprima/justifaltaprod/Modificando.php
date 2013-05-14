<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$maxRows_modificacion = 10;
$pageNum_modificacion = 0;
if (isset($_GET['pageNum_modificacion'])) {
  $pageNum_modificacion = $_GET['pageNum_modificacion'];
}
$startRow_modificacion = $pageNum_modificacion * $maxRows_modificacion;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificacion = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_modificacion = sprintf("%s LIMIT %d, %d", $query_modificacion, $startRow_modificacion, $maxRows_modificacion);
$modificacion = mysql_query($query_limit_modificacion, $basepangloria) or die(mysql_error());
$row_modificacion = mysql_fetch_assoc($modificacion);

if (isset($_GET['totalRows_modificacion'])) {
  $totalRows_modificacion = $_GET['totalRows_modificacion'];
} else {
  $all_modificacion = mysql_query($query_modificacion);
  $totalRows_modificacion = mysql_num_rows($all_modificacion);
}
$totalPages_modificacion = ceil($totalRows_modificacion/$maxRows_modificacion)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_falta = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$falta = mysql_query($query_falta, $basepangloria) or die(mysql_error());
$row_falta = mysql_fetch_assoc($falta);
$totalRows_falta = mysql_num_rows($falta);
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
<table width="100%" border="0">
  <tr>
    <td><iframe src="frmmodificar.php" width="820" height="420" scrolling="auto" id="idjustificacion"></iframe> 
      &nbsp;
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table border="1">
        <tr>
          <td><input type="text" name="textfield" id="textfield" /></td>
          <td colspan="3"><input type="submit" name="Filtro" id="Filtro" value="Filtro" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Modificacion </td>
          <td>ID_JUSTIFICACION</td>
          <td>CONTROL DE PRODUCCION</td>
          <td>CANTIDA_FALTANTE</td>
          <td>PRODUCTO FALTA</td>
          <td>MEDIDA</td>
          <td>FECHAINGRESOJUSFAPROD</td>
          <td>JUSTIFICACIONFALTAPROD</td>
        </tr>
        <?php do { ?>
        <tr>
          <td><a href="frmmodificar.php?root=<?php echo $row_modificacion['ID_JUSTIFICACION']; ?>" target="idjustificacion">Modificar</a></td>
          <td><?php echo $row_modificacion['ID_JUSTIFICACION']; ?></td>
          <td><?php echo $row_modificacion['IDCONTROLPRODUCCION']; ?></td>
          <td><?php echo $row_modificacion['CANTIDA_FALTANTE']; ?></td>
          <td><?php echo $row_falta['DESCRIPCIONPRODUC']; ?></td>
          <td><?php echo $row_modificacion['MEDIDA']; ?></td>
          <td><?php echo $row_modificacion['FECHAINGRESOJUSFAPROD']; ?></td>
          <td><?php echo $row_modificacion['JUSTIFICACIONFALTAPROD']; ?></td>
        </tr>
        <?php } while ($row_modificacion = mysql_fetch_assoc($modificacion)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($modificacion);

mysql_free_result($falta);
?>
