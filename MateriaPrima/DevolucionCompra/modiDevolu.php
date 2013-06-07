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

$maxRows_modi = 10;
$pageNum_modi = 0;
if (isset($_GET['pageNum_modi'])) {
  $pageNum_modi = $_GET['pageNum_modi'];
}
$startRow_modi = $pageNum_modi * $maxRows_modi;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modi = "SELECT * FROM TRNDEVOLUCIONCOMPRA ORDER BY IDDEVOLUCION DESC";
$query_limit_modi = sprintf("%s LIMIT %d, %d", $query_modi, $startRow_modi, $maxRows_modi);
$modi = mysql_query($query_limit_modi, $basepangloria) or die(mysql_error());
$row_modi = mysql_fetch_assoc($modi);

if (isset($_GET['totalRows_modi'])) {
  $totalRows_modi = $_GET['totalRows_modi'];
} else {
  $all_modi = mysql_query($query_modi);
  $totalRows_modi = mysql_num_rows($all_modi);
}
$totalPages_modi = ceil($totalRows_modi/$maxRows_modi)-1;

$queryString_modi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modi") == false && 
        stristr($param, "totalRows_modi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modi = sprintf("&totalRows_modi=%d%s", $totalRows_modi, $queryString_modi);
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
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><iframe src="modificarDevo.php" name="modificar" width="850" height="400" align="middle" scrolling="NO" frameborder="0" id="modificar "></iframe>&nbsp;
      <form action="filtromodificar.php" method="post" name="form2" target="modificar" id="form2">
Ingrese el Nombre
      a Modificar:
  <input type="text" name="filtro" id="filtro" />
  <input type="submit" name="btnfiltrar" id="btnfiltrar" value="Filtro" />
      </form>
      <table border="1">
        <tr>
          <td colspan="8"><a href="<?php printf("%s?pageNum_modi=%d%s", $currentPage, 0, $queryString_modi); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modi=%d%s", $currentPage, max(0, $pageNum_modi - 1), $queryString_modi); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modi=%d%s", $currentPage, min($totalPages_modi, $pageNum_modi + 1), $queryString_modi); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modi=%d%s", $currentPage, $totalPages_modi, $queryString_modi); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
        </tr>
        <tr>
          <td>Modificar</td>
          <td>IDDEVOLUCION</td>
          <td>IDEMPLEADO</td>
          <td>DOCADEVOLVER</td>
          <td>FECHADEVOLUCION</td>
          <td>IMPORTE</td>
          <td>GASTOGENERADO</td>
          <td>OBSERVACION</td>
        </tr>
        <?php do { ?>
        <tr>
          <td><a href="modificarDevo.php?root=<?php echo $row_modi['IDDEVOLUCION']; ?> "target="modificar">Modificar</a></td>
          <td><?php echo $row_modi['IDDEVOLUCION']; ?></td>
          <td><?php echo $row_modi['IDEMPLEADO']; ?></td>
          <td><?php echo $row_modi['DOCADEVOLVER']; ?></td>
          <td><?php echo $row_modi['FECHADEVOLUCION']; ?></td>
          <td><?php echo $row_modi['IMPORTE']; ?></td>
          <td><?php echo $row_modi['GASTOGENERADO']; ?></td>
          <td><?php echo $row_modi['OBSERVACION']; ?></td>
        </tr>
        <?php } while ($row_modi = mysql_fetch_assoc($modi)); ?>
      </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($modi);
?>
