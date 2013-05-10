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

$colname_encabezado = "-1";
if (isset($_POST['filtrador'])) {
  $colname_encabezado = $_POST['filtrador'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_encabezado = sprintf("SELECT * FROM TRNENCABEZADOJUSTPERMATPRIM WHERE IDENCABEZADO = %s", GetSQLValueString($colname_encabezado, "int"));
$encabezado = mysql_query($query_encabezado, $basepangloria) or die(mysql_error());
$row_encabezado = mysql_fetch_assoc($encabezado);
$totalRows_encabezado = mysql_num_rows($encabezado);

$maxRows_cuerpo = 10;
$pageNum_cuerpo = 0;
if (isset($_GET['pageNum_cuerpo'])) {
  $pageNum_cuerpo = $_GET['pageNum_cuerpo'];
}
$startRow_cuerpo = $pageNum_cuerpo * $maxRows_cuerpo;

$colname_cuerpo = "-1";
if (isset($_POST['filtrador'])) {
  $colname_cuerpo = $_POST['filtrador'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_cuerpo = sprintf("SELECT * FROM TRNJUSTIFICAIONPERMATPRI WHERE IDENCABEZADO = %s", GetSQLValueString($colname_cuerpo, "int"));
$query_limit_cuerpo = sprintf("%s LIMIT %d, %d", $query_cuerpo, $startRow_cuerpo, $maxRows_cuerpo);
$cuerpo = mysql_query($query_limit_cuerpo, $basepangloria) or die(mysql_error());
$row_cuerpo = mysql_fetch_assoc($cuerpo);

if (isset($_GET['totalRows_cuerpo'])) {
  $totalRows_cuerpo = $_GET['totalRows_cuerpo'];
} else {
  $all_cuerpo = mysql_query($query_cuerpo);
  $totalRows_cuerpo = mysql_num_rows($all_cuerpo);
}
$totalPages_cuerpo = ceil($totalRows_cuerpo/$maxRows_cuerpo)-1;

$colname_materiajustifi = "-1";
if (isset($_POST['IDMATPRIMA'])) {
  $colname_materiajustifi = $_POST['IDMATPRIMA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$sdr = $row_cuerpo['MAT_PRIMA'];
$query_materiajustifi = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$sdr'", GetSQLValueString($colname_materiajustifi, "int"));
$materiajustifi = mysql_query($query_materiajustifi, $basepangloria) or die(mysql_error());
$row_materiajustifi = mysql_fetch_assoc($materiajustifi);
$totalRows_materiajustifi = mysql_num_rows($materiajustifi);

$colname_medida = "-1";
if (isset($_POST['ID_MEDIDA'])) {
  $colname_medida = $_POST['ID_MEDIDA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$elijustmedida= $row_cuerpo['IDUNIDAD'];
$query_medida = sprintf("SELECT MEDIDA FROM CATMEDIDAS WHERE ID_MEDIDA = '$elijustmedida'", GetSQLValueString($colname_medida, "int"));
$medida = mysql_query($query_medida, $basepangloria) or die(mysql_error());
$row_medida = mysql_fetch_assoc($medida);
$totalRows_medida = mysql_num_rows($medida);

$colname_nomempleado = "-1";
if (isset($_POST['IDEMPLEADO'])) {
  $colname_nomempleado = $_POST['IDEMPLEADO'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$buscar= $row_encabezado['IDENCABEZADO']; 
$query_nomempleado = sprintf("SELECT NOMBREEMPLEADO FROM CATEMPLEADO WHERE IDEMPLEADO = '$buscar'", GetSQLValueString($colname_nomempleado, "int"));
$nomempleado = mysql_query($query_nomempleado, $basepangloria) or die(mysql_error());
$row_nomempleado = mysql_fetch_assoc($nomempleado);
$totalRows_nomempleado = mysql_num_rows($nomempleado);
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
<table width="820" border="0">
  <tr>
    <td align="center" bgcolor="#999999">Encabezado de la Justificacion</td>
  </tr>
  <tr>
    <td><a href="javascript:;" onclick="aviso('EliminarHead.php?root=<?php echo $row_encabezado['IDENCABEZADO'];?>'); return false;">Eliminar</a>
      <table width="815" border="0">
      <tr>
        <td width="153">Codigo de justificacion:</td>
        <td width="296"><?php echo $row_encabezado['IDENCABEZADO']; ?></td>
        <td width="13">Empleado</td>
        <td width="335"><?php echo $row_nomempleado['NOMBREEMPLEADO']; ?></td>
      </tr>
      <tr>
        <td>Orden de Produccion</td>
        <td><?php echo $row_encabezado['IDORDENPRODUCCION']; ?></td>
        <td>Fecha de Ingreso</td>
        <td><?php echo $row_encabezado['FECHAINGRESOJUSTIFICA']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#999999">Detalle</td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td>Codigo de detalle</td>
          <td>Codigo de Justificacion</td>
          <td>Medida</td>
          <td>Cantidad Perdida</td>
          <td>Materia Prima</td>
          <td>Justificacion</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_cuerpo['ID_PERDIDA']; ?></td>
            <td><?php echo $row_cuerpo['IDENCABEZADO']; ?></td>
            <td><?php echo $row_medida['MEDIDA']; ?></p></td>
            <td><?php echo $row_cuerpo['CANT_PERDIDA']; ?></td>
            <td><?php echo $row_materiajustifi['DESCRIPCION']; ?></td>
            <td><?php echo $row_cuerpo['JUSTIFICACION']; ?></td>
          </tr>
          <?php } while ($row_cuerpo = mysql_fetch_assoc($cuerpo)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($encabezado);

mysql_free_result($cuerpo);

mysql_free_result($materiajustifi);

mysql_free_result($medida);

mysql_free_result($nomempleado);
?>
