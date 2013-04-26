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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_consultaSalidaMP = 10;
$pageNum_consultaSalidaMP = 0;
if (isset($_GET['pageNum_consultaSalidaMP'])) {
  $pageNum_consultaSalidaMP = $_GET['pageNum_consultaSalidaMP'];
}
$startRow_consultaSalidaMP = $pageNum_consultaSalidaMP * $maxRows_consultaSalidaMP;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaSalidaMP = "SELECT * FROM TRNSALIDA_MAT_PRIM ORDER BY ID_SALIDA DESC";
$query_limit_consultaSalidaMP = sprintf("%s LIMIT %d, %d", $query_consultaSalidaMP, $startRow_consultaSalidaMP, $maxRows_consultaSalidaMP);
$consultaSalidaMP = mysql_query($query_limit_consultaSalidaMP, $basepangloria) or die(mysql_error());
$row_consultaSalidaMP = mysql_fetch_assoc($consultaSalidaMP);

if (isset($_GET['totalRows_consultaSalidaMP'])) {
  $totalRows_consultaSalidaMP = $_GET['totalRows_consultaSalidaMP'];
} else {
  $all_consultaSalidaMP = mysql_query($query_consultaSalidaMP);
  $totalRows_consultaSalidaMP = mysql_num_rows($all_consultaSalidaMP);
}
$totalPages_consultaSalidaMP = ceil($totalRows_consultaSalidaMP/$maxRows_consultaSalidaMP)-1;

$queryString_consultaSalidaMP = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaSalidaMP") == false && 
        stristr($param, "totalRows_consultaSalidaMP") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaSalidaMP = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaSalidaMP = sprintf("&totalRows_consultaSalidaMP=%d%s", $totalRows_consultaSalidaMP, $queryString_consultaSalidaMP);
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
    <td align="center" bgcolor="#999999"><h1>Modificación de Salida de Materia Prima </h1></td>
  </tr>
  <tr>
    <td><iframe src="ingresoSalidaMateriaPrima.php" width="820" height="0" scrolling="auto"><iframe src="ingresoSalidaMateriaPrima.php" width="820" height="0" scrolling="auto"><iframe src="" width="820" height="0" scrolling="auto"></iframe></iframe></iframe>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <input type="submit" name="enviar" id="enviar" value="Filtrar" />
      <label for="root"></label>
      <input type="text" name="root" id="root" />
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_consultaSalidaMP=%d%s", $currentPage, 0, $queryString_consultaSalidaMP); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaSalidaMP=%d%s", $currentPage, max(0, $pageNum_consultaSalidaMP - 1), $queryString_consultaSalidaMP); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaSalidaMP=%d%s", $currentPage, min($totalPages_consultaSalidaMP, $pageNum_consultaSalidaMP + 1), $queryString_consultaSalidaMP); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaSalidaMP=%d%s", $currentPage, $totalPages_consultaSalidaMP, $queryString_consultaSalidaMP); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Modificacion</td>
          <td>ID SALIDA</td>
          <td>CANTIDAD DE MATERIA PRIMA</td>
          <td>ID MATERIA PRIMA.</td>
          <td>ID ENCABEZADO DE SALIDA DE MATERIA PRI</td>
          <td>ID UNIDAD</td>
          <td>ID DEPTO</td>
          <td>FECHA Y HORA USUA</td>
          <td>EMPLEADOS</td>
        </tr>
        <?php do { ?>
          <tr>
            <td>Modificar </td>
            <td><?php echo $row_consultaSalidaMP['ID_SALIDA']; ?></td>
            <td><?php echo $row_consultaSalidaMP['CANTMAT_PRIMA']; ?></td>
            <td><?php echo $row_consultaSalidaMP['ID_MATPRIMA']; ?></td>
            <td><?php echo $row_consultaSalidaMP['IDENCABEZADOSALMATPRI']; ?></td>
            <td><?php echo $row_consultaSalidaMP['IDUNIDAD']; ?></td>
            <td><?php echo $row_consultaSalidaMP['IDDEPTO']; ?></td>
            <td><?php echo $row_consultaSalidaMP['FECHAYHORAUSUA']; ?></td>
            <td><?php echo $row_consultaSalidaMP['EMPLEADOSACA']; ?></td>
          </tr>
          <?php } while ($row_consultaSalidaMP = mysql_fetch_assoc($consultaSalidaMP)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultaSalidaMP);
?>
