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

$maxRows_consultaprodhorno = 10;
$pageNum_consultaprodhorno = 0;
if (isset($_GET['pageNum_consultaprodhorno'])) {
  $pageNum_consultaprodhorno = $_GET['pageNum_consultaprodhorno'];
}
$startRow_consultaprodhorno = $pageNum_consultaprodhorno * $maxRows_consultaprodhorno;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaprodhorno = "SELECT * FROM TRNDETACONTROL_PRODUCTO_HORNO ORDER BY ID_CONTROLPRODHORNO DESC";
$query_limit_consultaprodhorno = sprintf("%s LIMIT %d, %d", $query_consultaprodhorno, $startRow_consultaprodhorno, $maxRows_consultaprodhorno);
$consultaprodhorno = mysql_query($query_limit_consultaprodhorno, $basepangloria) or die(mysql_error());
$row_consultaprodhorno = mysql_fetch_assoc($consultaprodhorno);

if (isset($_GET['totalRows_consultaprodhorno'])) {
  $totalRows_consultaprodhorno = $_GET['totalRows_consultaprodhorno'];
} else {
  $all_consultaprodhorno = mysql_query($query_consultaprodhorno);
  $totalRows_consultaprodhorno = mysql_num_rows($all_consultaprodhorno);
}
$totalPages_consultaprodhorno = ceil($totalRows_consultaprodhorno/$maxRows_consultaprodhorno)-1;

$queryString_consultaprodhorno = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaprodhorno") == false && 
        stristr($param, "totalRows_consultaprodhorno") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaprodhorno = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaprodhorno = sprintf("&totalRows_consultaprodhorno=%d%s", $totalRows_consultaprodhorno, $queryString_consultaprodhorno);
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
    <td align="center" bgcolor="#999999"><h1>Modificacion  de Control ede horno</h1></td>
  </tr>
  <tr>
    <td><iframe src="formodificarproductohorno.php" width="820" height="400" scrolling="auto" name="conti"></iframe>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <label for="root"></label>
      <input type="text" name="root" id="root" />
      <input type="submit" name="enviar" id="enviar" value="filtrar" />
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_consultaprodhorno=%d%s", $currentPage, 0, $queryString_consultaprodhorno); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaprodhorno=%d%s", $currentPage, max(0, $pageNum_consultaprodhorno - 1), $queryString_consultaprodhorno); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaprodhorno=%d%s", $currentPage, min($totalPages_consultaprodhorno, $pageNum_consultaprodhorno + 1), $queryString_consultaprodhorno); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaprodhorno=%d%s", $currentPage, $totalPages_consultaprodhorno, $queryString_consultaprodhorno); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Modificion</td>
          <td>ID_CONTROLPRODHORNO</td>
          <td>IDPRODUCTO</td>
          <td>IDENCABEZADO</td>
          <td>ID_MEDIDA</td>
          <td>CANTIDAD_INGRESO</td>
          <td>CANTIDADEGRESO</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="formodificarproductohorno.php?root=<?php echo $row_consultaprodhorno['ID_CONTROLPRODHORNO']; ?>" target="conti">Modificar</a></td>
            <td><?php echo $row_consultaprodhorno['ID_CONTROLPRODHORNO']; ?></td>
            <td><?php echo $row_consultaprodhorno['IDPRODUCTO']; ?></td>
            <td><?php echo $row_consultaprodhorno['IDENCABEZADO']; ?></td>
            <td><?php echo $row_consultaprodhorno['ID_MEDIDA']; ?></td>
            <td><?php echo $row_consultaprodhorno['CANTIDAD_INGRESO']; ?></td>
            <td><?php echo $row_consultaprodhorno['CANTIDADEGRESO']; ?></td>
          </tr>
          <?php } while ($row_consultaprodhorno = mysql_fetch_assoc($consultaprodhorno)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultaprodhorno);
?>
