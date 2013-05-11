<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$maxRows_modificacioningresoMateriaPrima = 5;
$pageNum_modificacioningresoMateriaPrima = 0;
if (isset($_GET['pageNum_modificacioningresoMateriaPrima'])) {
  $pageNum_modificacioningresoMateriaPrima = $_GET['pageNum_modificacioningresoMateriaPrima'];
}
$startRow_modificacioningresoMateriaPrima = $pageNum_modificacioningresoMateriaPrima * $maxRows_modificacioningresoMateriaPrima;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificacioningresoMateriaPrima = "SELECT * FROM TRNPEDIDO_MAT_PRIMA ORDER BY ID_PED_MAT_PRIMA DESC";
$query_limit_modificacioningresoMateriaPrima = sprintf("%s LIMIT %d, %d", $query_modificacioningresoMateriaPrima, $startRow_modificacioningresoMateriaPrima, $maxRows_modificacioningresoMateriaPrima);
$modificacioningresoMateriaPrima = mysql_query($query_limit_modificacioningresoMateriaPrima, $basepangloria) or die(mysql_error());
$row_modificacioningresoMateriaPrima = mysql_fetch_assoc($modificacioningresoMateriaPrima);

if (isset($_GET['totalRows_modificacioningresoMateriaPrima'])) {
  $totalRows_modificacioningresoMateriaPrima = $_GET['totalRows_modificacioningresoMateriaPrima'];
} else {
  $all_modificacioningresoMateriaPrima = mysql_query($query_modificacioningresoMateriaPrima);
  $totalRows_modificacioningresoMateriaPrima = mysql_num_rows($all_modificacioningresoMateriaPrima);
}
$totalPages_modificacioningresoMateriaPrima = ceil($totalRows_modificacioningresoMateriaPrima/$maxRows_modificacioningresoMateriaPrima)-1;

$queryString_modificacioningresoMateriaPrima = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificacioningresoMateriaPrima") == false && 
        stristr($param, "totalRows_modificacioningresoMateriaPrima") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificacioningresoMateriaPrima = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificacioningresoMateriaPrima = sprintf("&totalRows_modificacioningresoMateriaPrima=%d%s", $totalRows_modificacioningresoMateriaPrima, $queryString_modificacioningresoMateriaPrima);
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
    <td align="center" bgcolor="#999999"><h1>Formulario de Modificación de Ingreso de Materia Prima</h1></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><iframe src="formulariomodificaringresopedidomatprima.php" width="820" height="200" scrolling="auto"></iframe></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <label for="root"></label>
      <input type="text" name="root" id="root" />
      <input type="submit" name="enviar" id="enviar" value="filtrar" />
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_modificacioningresoMateriaPrima=%d%s", $currentPage, 0, $queryString_modificacioningresoMateriaPrima); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificacioningresoMateriaPrima=%d%s", $currentPage, max(0, $pageNum_modificacioningresoMateriaPrima - 1), $queryString_modificacioningresoMateriaPrima); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificacioningresoMateriaPrima=%d%s", $currentPage, min($totalPages_modificacioningresoMateriaPrima, $pageNum_modificacioningresoMateriaPrima + 1), $queryString_modificacioningresoMateriaPrima); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificacioningresoMateriaPrima=%d%s", $currentPage, $totalPages_modificacioningresoMateriaPrima, $queryString_modificacioningresoMateriaPrima); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Modificación</td>
          <td>Codigo del Ingreso de Materia Prima</td>
          <td>Codigo del Encabezado de Pedido</td>
          <td>Codigo de la Unidad</td>
          <td>IDMATPRIMA</td>
          <td>CANTIDADPEDMATPRI</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="ModificarIngresoPedidodeMateriaPrima.php">Modificar</a></td>
            <td><?php echo $row_modificacioningresoMateriaPrima['ID_PED_MAT_PRIMA']; ?></td>
            <td><?php echo $row_modificacioningresoMateriaPrima['ID_ENCAPEDIDO']; ?></td>
            <td><?php echo $row_modificacioningresoMateriaPrima['IDUNIDAD']; ?></td>
            <td><?php echo $row_modificacioningresoMateriaPrima['IDMATPRIMA']; ?></td>
            <td><?php echo $row_modificacioningresoMateriaPrima['CANTIDADPEDMATPRI']; ?></td>
          </tr>
          <?php } while ($row_modificacioningresoMateriaPrima = mysql_fetch_assoc($modificacioningresoMateriaPrima)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($modificacioningresoMateriaPrima);

mysql_free_result($modificacioningresoMateriaPrima);
?>
