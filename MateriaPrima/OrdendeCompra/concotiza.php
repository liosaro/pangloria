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
<table width="820" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="166" bgcolor="#999999">Agregar</td>
  	<td width="166" bgcolor="#999999">Numero Referencial</td>
    <td width="166" bgcolor="#999999">Materia Prima</td>
    <td width="144" bgcolor="#999999">Unidad de Medida</td>
    <td width="195" bgcolor="#999999">Cantida de Producto</td>
    <td width="208" bgcolor="#999999">Precio Unitario</td>
    <td width="208" bgcolor="#999999"> Costo</td>
  </tr>
   <?php do { ?>
   <?php $conuniconcoti = $row_concoti['IDUNIDAD'];
$query_Recordset1 = sprintf("SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$conuniconcoti'", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$conmatconcoti = $row_concoti['IDMATPRIMA']; 
$query_nommateria = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$conmatconcoti'", GetSQLValueString($colname_nommateria, "int"));
$nommateria = mysql_query($query_nommateria, $basepangloria) or die(mysql_error());
$row_nommateria = mysql_fetch_assoc($nommateria);
$totalRows_nommateria = mysql_num_rows($nommateria);

?>
    <tr>
      <td><input name="very[]" type="checkbox" id="very[]" value="<?php echo $row_concoti['IDDETALLE']; ?>" checked="CHECKED" /></td>
    <td><?php echo $row_concoti['IDDETALLE']; ?></td>
      <td><?php echo $row_nommateria['DESCRIPCION']; ?></td>
      <td><?php echo $row_Recordset1['TIPOUNIDAD']; ?></td>
      <td><?php echo $row_concoti['CANTPRODUCTO']; ?></td>
      <td><?php echo $row_concoti['PRECIOUNITARIO']; ?></td>
      <td><?php echo $row_concoti['PRECIOUNITARIO']*$row_concoti['CANTPRODUCTO'] ; ?></td>
    </tr>
    <?php } while ($row_concoti = mysql_fetch_assoc($concoti)); ?> 
</table>
<table width="820" border="0">
  <tr>
    <td align="right" bgcolor="#CCCCCC">Total de la Compra</td>
    <td bgcolor="#CCCCCC"><?php 
	$col = $_request['coti'];
	$result = mysql_query("Select sum(CANTPRODUCTO * PRECIOUNITARIO ) as total from TRNDETALLECOTIZACION where IDENCABEZADO =" . $_GET['coti']);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	echo $row['total'];
	 ?></td>
  </tr>
</table>
    <input type="submit" name="enviar" id="enviar" value="Enviar"  />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($concoti);
?>
