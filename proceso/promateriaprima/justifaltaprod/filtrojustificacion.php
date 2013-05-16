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

mysql_select_db($database_basepangloria, $basepangloria);
$query_justificacion = "SELECT ID_JUSTIFICACION, FECHAINGRESOJUSFAPROD FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$justificacion = mysql_query($query_justificacion, $basepangloria) or die(mysql_error());
$row_justificacion = mysql_fetch_assoc($justificacion);
$totalRows_justificacion = mysql_num_rows($justificacion);

$maxRows_detalle = 10;
$pageNum_detalle = 0;
if (isset($_GET['pageNum_detalle'])) {
  $pageNum_detalle = $_GET['pageNum_detalle'];
}
$startRow_detalle = $pageNum_detalle * $maxRows_detalle;

mysql_select_db($database_basepangloria, $basepangloria);
$query_detalle = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_detalle = sprintf("%s LIMIT %d, %d", $query_detalle, $startRow_detalle, $maxRows_detalle);
$detalle = mysql_query($query_limit_detalle, $basepangloria) or die(mysql_error());
$row_detalle = mysql_fetch_assoc($detalle);

if (isset($_GET['totalRows_detalle'])) {
  $totalRows_detalle = $_GET['totalRows_detalle'];
} else {
  $all_detalle = mysql_query($query_detalle);
  $totalRows_detalle = mysql_num_rows($all_detalle);
}
$totalPages_detalle = ceil($totalRows_detalle/$maxRows_detalle)-1;
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
    <td><form action="frmmodificar.php" method="post" name="form1" target="conjusprod" id="form1">
Ingrese o Seleccione el codigo de Justificacion de Falta de Producto
      <label for="select"></label>
      <select name="select" id="select">
        <?php
do {  
?>
        <option value="<?php echo $row_justificacion['ID_JUSTIFICACION']?>"><?php echo $row_justificacion['ID_JUSTIFICACION']?>____<?php echo $row_justificacion['FECHAINGRESOJUSFAPROD']?></option>
        <?php
} while ($row_justificacion = mysql_fetch_assoc($justificacion));
  $rows = mysql_num_rows($justificacion);
  if($rows > 0) {
      mysql_data_seek($justificacion, 0);
	  $row_justificacion = mysql_fetch_assoc($justificacion);
  }
?>
      </select>
      <input type="submit" name="Enviar" id="Enviar" value="Enviar" />
    </form></td>
  </tr>
  <tr>
    <td><iframe src="frmmodificar.php" name="conjusprod" width="820" height="400" scrolling="No" frameborder="0"></iframe>&nbsp;</td>
  </tr>
</table>
<table width="820" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($justificacion);

mysql_free_result($detalle);
?>
