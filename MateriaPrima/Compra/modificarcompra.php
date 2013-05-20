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

$maxRows_Consultaingresocompra = 10;
$pageNum_Consultaingresocompra = 0;
if (isset($_GET['pageNum_Consultaingresocompra'])) {
  $pageNum_Consultaingresocompra = $_GET['pageNum_Consultaingresocompra'];
}
$startRow_Consultaingresocompra = $pageNum_Consultaingresocompra * $maxRows_Consultaingresocompra;

mysql_select_db($database_basepangloria, $basepangloria);
$query_Consultaingresocompra = "SELECT IDCOMPRA, IDUNIDAD, ID_DETENCCOM, CANTIDADMATPRIMA, MATERIAPRIMA, PRECIOUNIDAD, PRECIOTOTAL, DESCUENTO, SUBTOTAL, IVA, TOTAL FROM TRNDETALLECOMPRA ORDER BY IDCOMPRA DESC";
$query_limit_Consultaingresocompra = sprintf("%s LIMIT %d, %d", $query_Consultaingresocompra, $startRow_Consultaingresocompra, $maxRows_Consultaingresocompra);
$Consultaingresocompra = mysql_query($query_limit_Consultaingresocompra, $basepangloria) or die(mysql_error());
$row_Consultaingresocompra = mysql_fetch_assoc($Consultaingresocompra);

if (isset($_GET['totalRows_Consultaingresocompra'])) {
  $totalRows_Consultaingresocompra = $_GET['totalRows_Consultaingresocompra'];
} else {
  $all_Consultaingresocompra = mysql_query($query_Consultaingresocompra);
  $totalRows_Consultaingresocompra = mysql_num_rows($all_Consultaingresocompra);
}
$totalPages_Consultaingresocompra = ceil($totalRows_Consultaingresocompra/$maxRows_Consultaingresocompra)-1;

$queryString_Consultaingresocompra = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Consultaingresocompra") == false && 
        stristr($param, "totalRows_Consultaingresocompra") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Consultaingresocompra = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Consultaingresocompra = sprintf("&totalRows_Consultaingresocompra=%d%s", $totalRows_Consultaingresocompra, $queryString_Consultaingresocompra);
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
    <td align="center" bgcolor="#999999"><h1>Formulario de Modificacion de Compra</h1>
    <label for="root"></label></td>
  </tr>
  <tr>
    <td><iframe src="../../index.php" width="820" scrolling="auto"></iframe></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
        <input type="text" name="root" id="root" />
        <input type="submit" name="enviar" id="enviar" value="filtrar" />
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_Consultaingresocompra=%d%s", $currentPage, 0, $queryString_Consultaingresocompra); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_Consultaingresocompra=%d%s", $currentPage, max(0, $pageNum_Consultaingresocompra - 1), $queryString_Consultaingresocompra); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_Consultaingresocompra=%d%s", $currentPage, min($totalPages_Consultaingresocompra, $pageNum_Consultaingresocompra + 1), $queryString_Consultaingresocompra); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_Consultaingresocompra=%d%s", $currentPage, $totalPages_Consultaingresocompra, $queryString_Consultaingresocompra); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Modificacion</td>
          <td>Codigo de Compra</td>
          <td>Codig de la Unidad</td>
          <td>ID_DETENCCOM</td>
          <td>Cantidad de Materia Prima</td>
          <td>Nombre de la Materia Prima</td>
          <td>Precio Unidad</td>
          <td>Total</td>
          <td>Descuento</td>
          <td>Subtotal</td>
          <td>IVA</td>
          <td>Total</td>
        </tr>
        <?php do { ?>
          <tr>
            <td>Modificar</td>
            <td><?php echo $row_Consultaingresocompra['IDCOMPRA']; ?></td>
            <td><?php echo $row_Consultaingresocompra['IDUNIDAD']; ?></td>
            <td><?php echo $row_Consultaingresocompra['ID_DETENCCOM']; ?></td>
            <td><?php echo $row_Consultaingresocompra['CANTIDADMATPRIMA']; ?></td>
            <td><?php echo $row_Consultaingresocompra['MATERIAPRIMA']; ?></td>
            <td><?php echo $row_Consultaingresocompra['PRECIOUNIDAD']; ?></td>
            <td><?php echo $row_Consultaingresocompra['PRECIOTOTAL']; ?></td>
            <td><?php echo $row_Consultaingresocompra['DESCUENTO']; ?></td>
            <td><?php echo $row_Consultaingresocompra['SUBTOTAL']; ?></td>
            <td><?php echo $row_Consultaingresocompra['IVA']; ?></td>
            <td><?php echo $row_Consultaingresocompra['TOTAL']; ?></td>
          </tr>
          <?php } while ($row_Consultaingresocompra = mysql_fetch_assoc($Consultaingresocompra)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Consultaingresocompra);
?>
