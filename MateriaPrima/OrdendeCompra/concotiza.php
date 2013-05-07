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

$maxRows_concoti = 10;
$pageNum_concoti = 0;
if (isset($_GET['pageNum_concoti'])) {
  $pageNum_concoti = $_GET['pageNum_concoti'];
}
$startRow_concoti = $pageNum_concoti * $maxRows_concoti;

$colname_concoti = "-1";
if (isset($_GET['coti'])) {
  $colname_concoti = $_GET['coti'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_concoti = sprintf("SELECT IDDETALLE, IDMATPRIMA, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO FROM TRNDETALLECOTIZACION WHERE IDENCABEZADO = %s", GetSQLValueString($colname_concoti, "int"));
$query_limit_concoti = sprintf("%s LIMIT %d, %d", $query_concoti, $startRow_concoti, $maxRows_concoti);
$concoti = mysql_query($query_limit_concoti, $basepangloria) or die(mysql_error());
$row_concoti = mysql_fetch_assoc($concoti);

if (isset($_GET['totalRows_concoti'])) {
  $totalRows_concoti = $_GET['totalRows_concoti'];
} else {
  $all_concoti = mysql_query($query_concoti);
  $totalRows_concoti = mysql_num_rows($all_concoti);
}
$totalPages_concoti = ceil($totalRows_concoti/$maxRows_concoti)-1;
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

<body><form id="form1" name="form1" method="post" action="script.php">
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
  	<td width="166">Numero Referencial</td>
    <td width="166">IDMATPRIMA</td>
    <td width="144">IDUNIDAD</td>
    <td width="195">CANTPRODUCTO</td>
    <td width="208">&nbsp;</td>
    <td width="208">PRECIOUNITARIO</td>
  </tr>
   <?php do { ?>
    <tr>
    <td><?php echo $row_concoti['IDDETALLE']; ?></td>
      <td><?php echo $row_concoti['IDMATPRIMA']; ?></td>
      <td><?php echo $row_concoti['IDUNIDAD']; ?></td>
      <td><?php echo $row_concoti['CANTPRODUCTO']; ?></td>
      <td><input name="very[]" id="very[]" type="checkbox" value="<?php echo $row_concoti['IDDETALLE']; ?>" /></td>
      <td><?php echo $row_concoti['PRECIOUNITARIO']; ?></td>
    </tr>
    <?php } while ($row_concoti = mysql_fetch_assoc($concoti)); ?>
</table>

  <input type="submit" name="enviar" id="enviar" value="Enviar"  />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($concoti);
?>
