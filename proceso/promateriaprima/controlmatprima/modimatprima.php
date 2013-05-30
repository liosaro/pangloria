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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_modmatpri = 10;
$pageNum_modmatpri = 0;
if (isset($_GET['pageNum_modmatpri'])) {
  $pageNum_modmatpri = $_GET['pageNum_modmatpri'];
}
$startRow_modmatpri = $pageNum_modmatpri * $maxRows_modmatpri;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modmatpri = "SELECT * FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT ASC";
$query_limit_modmatpri = sprintf("%s LIMIT %d, %d", $query_modmatpri, $startRow_modmatpri, $maxRows_modmatpri);
$modmatpri = mysql_query($query_limit_modmatpri, $basepangloria) or die(mysql_error());
$row_modmatpri = mysql_fetch_assoc($modmatpri);

if (isset($_GET['totalRows_modmatpri'])) {
  $totalRows_modmatpri = $_GET['totalRows_modmatpri'];
} else {
  $all_modmatpri = mysql_query($query_modmatpri);
  $totalRows_modmatpri = mysql_num_rows($all_modmatpri);
}
$totalPages_modmatpri = ceil($totalRows_modmatpri/$maxRows_modmatpri)-1;$maxRows_modmatpri = 10;
$pageNum_modmatpri = 0;
if (isset($_GET['pageNum_modmatpri'])) {
  $pageNum_modmatpri = $_GET['pageNum_modmatpri'];
}
$startRow_modmatpri = $pageNum_modmatpri * $maxRows_modmatpri;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modmatpri = "SELECT * FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT ASC";
$query_limit_modmatpri = sprintf("%s LIMIT %d, %d", $query_modmatpri, $startRow_modmatpri, $maxRows_modmatpri);
$modmatpri = mysql_query($query_limit_modmatpri, $basepangloria) or die(mysql_error());
$row_modmatpri = mysql_fetch_assoc($modmatpri);

if (isset($_GET['totalRows_modmatpri'])) {
  $totalRows_modmatpri = $_GET['totalRows_modmatpri'];
} else {
  $all_modmatpri = mysql_query($query_modmatpri);
  $totalRows_modmatpri = mysql_num_rows($all_modmatpri);
}
$totalPages_modmatpri = ceil($totalRows_modmatpri/$maxRows_modmatpri)-1;

$queryString_modmatpri = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modmatpri") == false && 
        stristr($param, "totalRows_modmatpri") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modmatpri = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modmatpri = sprintf("&totalRows_modmatpri=%d%s", $totalRows_modmatpri, $queryString_modmatpri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 1px;
	margin-top: 1px;
	margin-right: 1px;
	margin-bottom: 1px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Modificar Control de Materia Prima</h1></td>
  </tr>
  <tr>
    <td><iframe src="encamodimatprima.php" width="820" name="contenedor" height="200" scrolling="no"></iframe>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <label>
        <input type="text" name="root" id="root" />
      </label>
      <input type="submit" name="enviar" id="enviar" value="Filtrar" />
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_modmatpri=%d%s", $currentPage, 0, $queryString_modmatpri); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modmatpri=%d%s", $currentPage, max(0, $pageNum_modmatpri - 1), $queryString_modmatpri); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modmatpri=%d%s", $currentPage, min($totalPages_modmatpri, $pageNum_modmatpri + 1), $queryString_modmatpri); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modmatpri=%d%s", $currentPage, $totalPages_modmatpri, $queryString_modmatpri); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Id Control de Matria</td>
          <td>Id Materia Prima</td>
          <td>Salida</td>
          <td>Unidad</td>
          <td>Cantidad Entregada</td>
          <td>Cantidad Devuelta</td>
          <td>Cantidad Utilizada</td>
          <td>Fecha</td>
          <td>Modificacion</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_modmatpri['ID_CONTROLMAT']; ?></td>
            <td><?php echo $row_modmatpri['IDMATPRIMA']; ?></td>
            <td><?php echo $row_modmatpri['ID_SALIDA']; ?></td>
            <td><?php echo $row_modmatpri['IDUNIDAD']; ?></td>
            <td><?php echo $row_modmatpri['CANT_ENTREGA']; ?></td>
            <td><?php echo $row_modmatpri['CANT_DEVUELTA']; ?></td>
            <td><?php echo $row_modmatpri['CANT_UTILIZADA']; ?></td>
            <td><?php echo $row_modmatpri['FECHA_CONTROL']; ?></td>
            <td><a href="encamodimatprima.php" target="contenedor">Modificar</a></td>
          </tr>
          <?php } while ($row_modmatpri = mysql_fetch_assoc($modmatpri)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modmatpri);
?>
