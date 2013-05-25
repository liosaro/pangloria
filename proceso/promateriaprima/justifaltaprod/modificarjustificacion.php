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

$maxRows_justi = 10;
$pageNum_justi = 0;
if (isset($_GET['pageNum_justi'])) {
  $pageNum_justi = $_GET['pageNum_justi'];
}
$startRow_justi = $pageNum_justi * $maxRows_justi;

mysql_select_db($database_basepangloria, $basepangloria);
$query_justi = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO ORDER BY ID_JUSTIFICACION DESC";
$query_limit_justi = sprintf("%s LIMIT %d, %d", $query_justi, $startRow_justi, $maxRows_justi);
$justi = mysql_query($query_limit_justi, $basepangloria) or die(mysql_error());
$row_justi = mysql_fetch_assoc($justi);

if (isset($_GET['totalRows_justi'])) {
  $totalRows_justi = $_GET['totalRows_justi'];
} else {
  $all_justi = mysql_query($query_justi);
  $totalRows_justi = mysql_num_rows($all_justi);
}
$totalPages_justi = ceil($totalRows_justi/$maxRows_justi)-1;

$queryString_justi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_justi") == false && 
        stristr($param, "totalRows_justi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_justi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_justi = sprintf("&totalRows_justi=%d%s", $totalRows_justi, $queryString_justi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <p><iframe src="" width="820" height="400" scrolling="auto">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      </iframe>
      </p>
      <p><a href="<?php printf("%s?pageNum_justi=%d%s", $currentPage, 0, $queryString_justi); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_justi=%d%s", $currentPage, max(0, $pageNum_justi - 1), $queryString_justi); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_justi=%d%s", $currentPage, min($totalPages_justi, $pageNum_justi + 1), $queryString_justi); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_justi=%d%s", $currentPage, $totalPages_justi, $queryString_justi); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
      <table border="0">
        <tr>
          <td colspan="8">Ingrese el Nombre del Producto a Modificar:            
            <label for="textfield"></label>
            <input type="text" name="textfield" id="textfield" />
            <input type="submit" name="button" id="button" value="Enviar" /></td>
          </tr>
        <tr>
          <td>modificacion</td>
          <td>ID_JUSTIFICACION</td>
          <td>IDCONTROLPRODUCCION</td>
          <td>CANTIDA_FALTANTE</td>
          <td>IDPRODUCTOFALTA</td>
          <td>ID_MEDIDA</td>
          <td>FECHAINGRESOJUSFAPROD</td>
          <td>JUSTIFICACIONFALTAPROD</td>
          </tr>
        <?php do { ?>
          <tr>
            <td><a href="cmodproducto.php?root=<?php echo $row_justi['ID_JUSTIFICACION']; ?>" target="modiprodu">Modificar</a></td>
            <td><?php echo $row_justi['ID_JUSTIFICACION']; ?></td>
            <td><?php echo $row_justi['IDCONTROLPRODUCCION']; ?></td>
            <td><?php echo $row_justi['CANTIDA_FALTANTE']; ?></td>
            <td><?php echo $row_justi['IDPRODUCTOFALTA']; ?></td>
            <td><?php echo $row_justi['ID_MEDIDA']; ?></td>
            <td><?php echo $row_justi['FECHAINGRESOJUSFAPROD']; ?></td>
            <td><?php echo $row_justi['JUSTIFICACIONFALTAPROD']; ?></td>
            </tr>
          <?php } while ($row_justi = mysql_fetch_assoc($justi)); ?>
      </table>
<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($justi);
?>
