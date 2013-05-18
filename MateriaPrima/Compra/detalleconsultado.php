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

mysql_select_db($database_basepangloria, $basepangloria);
$query_selecclaOrd = "SELECT IDORDEN, FECHAENTREGA FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$selecclaOrd = mysql_query($query_selecclaOrd, $basepangloria) or die(mysql_error());
$row_selecclaOrd = mysql_fetch_assoc($selecclaOrd);
$totalRows_selecclaOrd = mysql_num_rows($selecclaOrd);

$maxRows_consuldetaorprod = 10;
$pageNum_consuldetaorprod = 0;
if (isset($_GET['pageNum_consuldetaorprod'])) {
  $pageNum_consuldetaorprod = $_GET['pageNum_consuldetaorprod'];
}
$startRow_consuldetaorprod = $pageNum_consuldetaorprod * $maxRows_consuldetaorprod;

$colname_consuldetaorprod = "-1";
if (isset($_GET['IDORDEN'])) {
  $colname_consuldetaorprod = $_GET['IDORDEN'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consuldetaorprod = sprintf("SELECT IDMATPRIMA, IDORDEN IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO FROM TRNDETALLEORDENCOMPRA WHERE IDORDEN = %s", GetSQLValueString($colname_consuldetaorprod, "int"));
$query_limit_consuldetaorprod = sprintf("%s LIMIT %d, %d", $query_consuldetaorprod, $startRow_consuldetaorprod, $maxRows_consuldetaorprod);
$consuldetaorprod = mysql_query($query_limit_consuldetaorprod, $basepangloria) or die(mysql_error());
$row_consuldetaorprod = mysql_fetch_assoc($consuldetaorprod);

if (isset($_GET['totalRows_consuldetaorprod'])) {
  $totalRows_consuldetaorprod = $_GET['totalRows_consuldetaorprod'];
} else {
  $all_consuldetaorprod = mysql_query($query_consuldetaorprod);
  $totalRows_consuldetaorprod = mysql_num_rows($all_consuldetaorprod);
}
$totalPages_consuldetaorprod = ceil($totalRows_consuldetaorprod/$maxRows_consuldetaorprod)-1;



$colname_consulmatpri = "-1";
if (isset($_GET['IDMATPRIMA'])) {
  $colname_consulmatpri = $_GET['IDMATPRIMA'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820">
  <tr>
    <td>Selecciones Orden de Compra : 
      <label for="conordenC"></label>
      <select name="conordenC" id="conordenC"  onchange="window.location.href='detalleconsultado.php?IDORDEN='+document.getElementById(this.id).value ;">
        <?php
do {  
?>
        <option value="<?php echo $row_selecclaOrd['IDORDEN']?>"><?php echo $row_selecclaOrd['IDORDEN']?>---<?php echo $row_selecclaOrd['FECHAENTREGA']?></option>
        <?php
} while ($row_selecclaOrd = mysql_fetch_assoc($selecclaOrd));
  $rows = mysql_num_rows($selecclaOrd);
  if($rows > 0) {
      mysql_data_seek($selecclaOrd, 0);
	  $row_selecclaOrd = mysql_fetch_assoc($selecclaOrd);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td><form action="" method="post">
      <table border="1">
        <tr>
          <td>Agregar</td>
          <td>Unidad de Peso</td>
          <td>Materia Prima</td>
          <td>Cantidad de Producto</td>
          <td>Precio Unitario</td>
          <td>Descuento</td>
          <td>Costo</td>
        </tr>
        <?php do { ?>
        <?php
		mysql_select_db($database_basepangloria, $basepangloria);
		$consumat = $row_consuldetaorprod['IDMATPRIMA'];
$query_consulmatpri = sprintf("SELECT  DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$consumat'");
$consulmatpri = mysql_query($query_consulmatpri, $basepangloria) or die(mysql_error());
$row_consulmatpri = mysql_fetch_assoc($consulmatpri);
$totalRows_consulmatpri = mysql_num_rows($consulmatpri);
$conunidad = $row_consuldetaorprod['IDUNIDAD'];
$query_consulunipeso = "SELECT * FROM CATUNIDADES where IDUNIDAD='$conunidad' ";
$consulunipeso = mysql_query($query_consulunipeso, $basepangloria) or die(mysql_error());
$row_consulunipeso = mysql_fetch_assoc($consulunipeso);
$totalRows_consulunipeso = mysql_num_rows($consulunipeso);
 
		?>
        <tr>
          <td><input type="checkbox" name="very[]2" id="very[]2" value="<?php echo $row_consuldetaorprod['IDORDEN']; ?>" checked="checked" />
            <label for="very[]2"></label></td>
          <td><?php echo $row_consulunipeso['TIPOUNIDAD']; ?></td>
          <td><?php echo $row_consulmatpri['DESCRIPCION']; ?></td>
          <td><?php echo $row_consuldetaorprod['CANTPRODUCTO']; ?></td>
          <td><?php echo $row_consuldetaorprod['PRECIOUNITARIO']; ?></td>
          <td><label for="desc[]"></label>
            <input type="text" name="desc[]2" id="desc[]" /></td>
          <td><?php echo $row_consuldetaorprod['PRECIOUNITARIO'] *  $row_consuldetaorprod['CANTPRODUCTO']; ?></td>
        </tr>
        <?php } while ($row_consuldetaorprod = mysql_fetch_assoc($consuldetaorprod)); ?>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="right">
</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($selecclaOrd);

mysql_free_result($consuldetaorprod);

mysql_free_result($consulunipeso);

mysql_free_result($consulmatpri);
?>
