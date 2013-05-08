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

$maxRows_uljusperdia = 10;
$pageNum_uljusperdia = 0;
if (isset($_GET['pageNum_uljusperdia'])) {
  $pageNum_uljusperdia = $_GET['pageNum_uljusperdia'];
}
$startRow_uljusperdia = $pageNum_uljusperdia * $maxRows_uljusperdia;

mysql_select_db($database_basepangloria, $basepangloria);
$query_uljusperdia = "SELECT IDUNIDAD, CANT_PERDIDA, MAT_PRIMA, JUSTIFICACION, USUARIOPERMATPRI FROM TRNJUSTIFICAIONPERMATPRI ORDER BY ID_PERDIDA DESC";
$query_limit_uljusperdia = sprintf("%s LIMIT %d, %d", $query_uljusperdia, $startRow_uljusperdia, $maxRows_uljusperdia);
$uljusperdia = mysql_query($query_limit_uljusperdia, $basepangloria) or die(mysql_error());
$row_uljusperdia = mysql_fetch_assoc($uljusperdia);

if (isset($_GET['totalRows_uljusperdia'])) {
  $totalRows_uljusperdia = $_GET['totalRows_uljusperdia'];
} else {
  $all_uljusperdia = mysql_query($query_uljusperdia);
  $totalRows_uljusperdia = mysql_num_rows($all_uljusperdia);
}
$totalPages_uljusperdia = ceil($totalRows_uljusperdia/$maxRows_uljusperdia)-1;$maxRows_uljusperdia = 10;
$pageNum_uljusperdia = 0;
if (isset($_GET['pageNum_uljusperdia'])) {
  $pageNum_uljusperdia = $_GET['pageNum_uljusperdia'];
}
$startRow_uljusperdia = $pageNum_uljusperdia * $maxRows_uljusperdia;

mysql_select_db($database_basepangloria, $basepangloria);
$query_uljusperdia = "SELECT ID_PERDIDA, IDUNIDAD, CANT_PERDIDA, MAT_PRIMA, JUSTIFICACION, USUARIOPERMATPRI FROM TRNJUSTIFICAIONPERMATPRI ORDER BY ID_PERDIDA DESC";
$query_limit_uljusperdia = sprintf("%s LIMIT %d, %d", $query_uljusperdia, $startRow_uljusperdia, $maxRows_uljusperdia);
$uljusperdia = mysql_query($query_limit_uljusperdia, $basepangloria) or die(mysql_error());
$row_uljusperdia = mysql_fetch_assoc($uljusperdia);

if (isset($_GET['totalRows_uljusperdia'])) {
  $totalRows_uljusperdia = $_GET['totalRows_uljusperdia'];
} else {
  $all_uljusperdia = mysql_query($query_uljusperdia);
  $totalRows_uljusperdia = mysql_num_rows($all_uljusperdia);
}
$totalPages_uljusperdia = ceil($totalRows_uljusperdia/$maxRows_uljusperdia)-1;
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
<link href="../../../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" align="center" bgcolor="#999999" class="ENCABEZADO">ULTIMOS REGISTROS AGREGADOS</td>
  </tr>
  <tr>
    <td bgcolor="#999999">Codigo de Ingreso</td>
    <td bgcolor="#999999">Cantidad</td>
    <td bgcolor="#999999">Medida de Peso</td>
    <td bgcolor="#999999">Materia Prima Perdida</td>
    <td bgcolor="#999999">JustificacionJustifica</td>
  </tr>
  <?php do { ?>
  	<?php mysql_select_db($database_basepangloria, $basepangloria);
$mati = $row_uljusperdia['MAT_PRIMA'];
$query_conmateripri = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$mati'", GetSQLValueString($colname_conmateripri, "int"));
$conmateripri = mysql_query($query_conmateripri, $basepangloria) or die(mysql_error());
$row_conmateripri = mysql_fetch_assoc($conmateripri);
$totalRows_conmateripri = mysql_num_rows($conmateripri); 
mysql_select_db($database_basepangloria, $basepangloria);
$med = $row_uljusperdia['IDUNIDAD'];
$query_medida = sprintf("SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$med'", GetSQLValueString($colname_medida, "int"));
$medida = mysql_query($query_medida, $basepangloria) or die(mysql_error());
$row_medida = mysql_fetch_assoc($medida);
$totalRows_medida = mysql_num_rows($medida);
?>
    <tr>
      <td><?php echo $row_uljusperdia['ID_PERDIDA']; ?></td>
      <td><?php echo $row_uljusperdia['CANT_PERDIDA']; ?></td>
      <td><?php echo $row_medida['TIPOUNIDAD']; ?></td>
      <td><?php echo $row_conmateripri['DESCRIPCION']; ?></td>
      <td><?php echo $row_uljusperdia['JUSTIFICACION']; ?></td>
    </tr>
    <?php } while ($row_uljusperdia = mysql_fetch_assoc($uljusperdia)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($uljusperdia);
?>
