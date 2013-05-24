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

$maxRows_modificar = 10;
$pageNum_modificar = 0;
if (isset($_GET['pageNum_modificar'])) {
  $pageNum_modificar = $_GET['pageNum_modificar'];
}
$startRow_modificar = $pageNum_modificar * $maxRows_modificar;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificar = "SELECT * FROM TRNSALIDA_MAT_PRIM ORDER BY ID_SALIDA ASC";
$query_limit_modificar = sprintf("%s LIMIT %d, %d", $query_modificar, $startRow_modificar, $maxRows_modificar);
$modificar = mysql_query($query_limit_modificar, $basepangloria) or die(mysql_error());
$row_modificar = mysql_fetch_assoc($modificar);

if (isset($_GET['totalRows_modificar'])) {
  $totalRows_modificar = $_GET['totalRows_modificar'];
} else {
  $all_modificar = mysql_query($query_modificar);
  $totalRows_modificar = mysql_num_rows($all_modificar);
}
$totalPages_modificar = ceil($totalRows_modificar/$maxRows_modificar)-1;

$queryString_modificar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificar") == false && 
        stristr($param, "totalRows_modificar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificar = sprintf("&totalRows_modificar=%d%s", $totalRows_modificar, $queryString_modificar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<iframe src="cmodi.php" name="modificar" width="820" height="400" scrolling="NO" id="modificar">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></iframe>
<form action="filtrosalida.php" method="post" name="form1" target="modificar" id="form1">
Ingrese el Nombre del Departamento:
  <label for="filtrosalida"></label>
  <input type="text" name="filtrosalida" id="filtrosalida" />
  <input type="submit" name="button" id="button" value="Enviar" />
</form>
<table border="1">
  <tr>
    <td colspan="7"><a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, 0, $queryString_modificar); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, max(0, $pageNum_modificar - 1), $queryString_modificar); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, min($totalPages_modificar, $pageNum_modificar + 1), $queryString_modificar); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, $totalPages_modificar, $queryString_modificar); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Modificacion</td>
    <td>ID_SALIDA</td>
    <td>CANTMAT_PRIMA</td>
    <td>ID_MATPRIMA</td>
    <td>IDENCABEZADOSALMATPRI</td>
    <td>IDUNIDAD</td>
    <td>IDDEPTO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="cmodi.php?root=<?php echo $row_modificar['ID_SALIDA']; ?>" target="modificar">Modificar</a></td>
      <td><?php echo $row_modificar['ID_SALIDA']; ?></td>
      <td><?php echo $row_modificar['CANTMAT_PRIMA']; ?></td>
      <td><?php echo $row_modificar['ID_MATPRIMA']; ?></td>
      <td><?php echo $row_modificar['IDENCABEZADOSALMATPRI']; ?></td>
      <td><?php echo $row_modificar['IDUNIDAD']; ?></td>
      <td><?php echo $row_modificar['IDDEPTO']; ?></td>
    </tr>
    <?php } while ($row_modificar = mysql_fetch_assoc($modificar)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($modificar);
?>
