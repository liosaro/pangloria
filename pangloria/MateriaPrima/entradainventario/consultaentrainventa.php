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

$colname_consuenca = "-1";
if (isset($_POST['filtrador'])) {
  $colname_consuenca = $_POST['filtrador'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consuenca = sprintf("SELECT * FROM TrnEncaEntrInventario WHERE IdEncabezadoEnInventario = %s", GetSQLValueString($colname_consuenca, "int"));
$consuenca = mysql_query($query_consuenca, $basepangloria) or die(mysql_error());
$row_consuenca = mysql_fetch_assoc($consuenca);
$totalRows_consuenca = mysql_num_rows($consuenca);

$maxRows_concuerp = 10;
$pageNum_concuerp = 0;
if (isset($_GET['pageNum_concuerp'])) {
  $pageNum_concuerp = $_GET['pageNum_concuerp'];
}
$startRow_concuerp = $pageNum_concuerp * $maxRows_concuerp;

$colname_concuerp = "-1";
if (isset($_POST['filtrador'])) {
  $colname_concuerp = $_POST['filtrador'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_concuerp = sprintf("SELECT * FROM TRNENTRADA_INVENTARIO WHERE IdEncabezadoEnInventario = %s", GetSQLValueString($colname_concuerp, "int"));
$query_limit_concuerp = sprintf("%s LIMIT %d, %d", $query_concuerp, $startRow_concuerp, $maxRows_concuerp);
$concuerp = mysql_query($query_limit_concuerp, $basepangloria) or die(mysql_error());
$row_concuerp = mysql_fetch_assoc($concuerp);

if (isset($_GET['totalRows_concuerp'])) {
  $totalRows_concuerp = $_GET['totalRows_concuerp'];
} else {
  $all_concuerp = mysql_query($query_concuerp);
  $totalRows_concuerp = mysql_num_rows($all_concuerp);
}
$totalPages_concuerp = ceil($totalRows_concuerp/$maxRows_concuerp)-1;

$colname_medida = "-1";
if (isset($_POST['IDUNIDAD'])) {
  $colname_medida = $_POST['IDUNIDAD'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$med = $row_concuerp['IDUNIDAD'];
$query_medida = sprintf("SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$med'", GetSQLValueString($colname_medida, "int"));
$medida = mysql_query($query_medida, $basepangloria) or die(mysql_error());
$row_medida = mysql_fetch_assoc($medida);
$totalRows_medida = mysql_num_rows($medida);

$colname_conmateripri = "-1";
if (isset($_POST['IDMATPRIMA'])) {
  $colname_conmateripri = $_POST['IDMATPRIMA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$mati = $row_concuerp['IDMATPRIMA'];
$query_conmateripri = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$mati'", GetSQLValueString($colname_conmateripri, "int"));
$conmateripri = mysql_query($query_conmateripri, $basepangloria) or die(mysql_error());
$row_conmateripri = mysql_fetch_assoc($conmateripri);
$totalRows_conmateripri = mysql_num_rows($conmateripri);

$colname_conempleado = "-1";
if (isset($_POST['IDEMPLEADO'])) {
  $colname_conempleado = $_POST['IDEMPLEADO'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$emple= $row_consuenca['idEmpleado'];
$query_conempleado = sprintf("SELECT NOMBREEMPLEADO FROM CATEMPLEADO WHERE IDEMPLEADO = '$emple'", GetSQLValueString($colname_conempleado, "int"));
$conempleado = mysql_query($query_conempleado, $basepangloria) or die(mysql_error());
$row_conempleado = mysql_fetch_assoc($conempleado);
$totalRows_conempleado = mysql_num_rows($conempleado);
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
<table width="820" border="0">
  <tr>
    <td>Codigo de Encabezado</td>
    <td><?php echo $row_consuenca['IdEncabezadoEnInventario']; ?></td>
    <td>Empleado que Ingreso</td>
    <td><?php echo $row_conempleado['NOMBREEMPLEADO']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Fecha de Ingreso</td>
    <td><?php echo $row_consuenca['fechaIngresoInventario']; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;
      <table border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td>Codigo de Entrada</td>
          <td>Codigo de Inventario</td>
          <td>Unidad de Medida</td>
          <td>Materia Prima</td>
          <td>CANTIDAD</td>
          <td>Fecha de Expiracion</td>
          <td>Precio en ultima Compra</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_concuerp['IDENTRADA']; ?></td>
            <td><?php echo $row_concuerp['IdEncabezadoEnInventario']; ?></td>
            <td><?php echo $row_medida['TIPOUNIDAD']; ?></td>
            <td><?php echo $row_conmateripri['DESCRIPCION']; ?></td>
            <td><?php echo $row_concuerp['CANTIDAD']; ?></td>
            <td><?php echo $row_concuerp['FECHAEXPIRACION']; ?></td>
            <td><?php echo $row_concuerp['PRECIOULTIMACOMPRA']; ?></td>
          </tr>
          <?php } while ($row_concuerp = mysql_fetch_assoc($concuerp)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consuenca);

mysql_free_result($concuerp);

mysql_free_result($medida);

mysql_free_result($conmateripri);

mysql_free_result($conempleado);
?>
