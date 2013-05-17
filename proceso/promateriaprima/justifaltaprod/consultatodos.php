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

$maxRows_todos = 10;
$pageNum_todos = 0;
if (isset($_GET['pageNum_todos'])) {
  $pageNum_todos = $_GET['pageNum_todos'];
}
$startRow_todos = $pageNum_todos * $maxRows_todos;

mysql_select_db($database_basepangloria, $basepangloria);
$query_todos = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_todos = sprintf("%s LIMIT %d, %d", $query_todos, $startRow_todos, $maxRows_todos);
$todos = mysql_query($query_limit_todos, $basepangloria) or die(mysql_error());
$row_todos = mysql_fetch_assoc($todos);

if (isset($_GET['totalRows_todos'])) {
  $totalRows_todos = $_GET['totalRows_todos'];
} else {
  $all_todos = mysql_query($query_todos);
  $totalRows_todos = mysql_num_rows($all_todos);
}
$totalPages_todos = ceil($totalRows_todos/$maxRows_todos)-1;

$queryString_todos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_todos") == false && 
        stristr($param, "totalRows_todos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_todos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_todos = sprintf("&totalRows_todos=%d%s", $totalRows_todos, $queryString_todos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <tr>
    <td colspan="7" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td colspan="7"><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, 0, $queryString_todos); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, max(0, $pageNum_todos - 1), $queryString_todos); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, min($totalPages_todos, $pageNum_todos + 1), $queryString_todos); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, $totalPages_todos, $queryString_todos); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
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
      <td><?php echo $row_todos['ID_JUSTIFICACION']; ?></td>
      <td><?php echo $row_todos['IDCONTROLPRODUCCION']; ?></td>
      <td><?php echo $row_todos['CANTIDA_FALTANTE']; ?></td>
      <td><?php echo $row_todos['IDPRODUCTOFALTA']; ?></td>
      <td><?php echo $row_todos['ID_MEDIDA']; ?></td>
      <td><?php echo $row_todos['FECHAINGRESOJUSFAPROD']; ?></td>
      <td><?php echo $row_todos['JUSTIFICACIONFALTAPROD']; ?></td>
    </tr>
    <?php } while ($row_todos = mysql_fetch_assoc($todos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($todos);
?>
