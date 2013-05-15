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

$maxRows_modificarRol = 10;
$pageNum_modificarRol = 0;
if (isset($_GET['pageNum_modificarRol'])) {
  $pageNum_modificarRol = $_GET['pageNum_modificarRol'];
}
$startRow_modificarRol = $pageNum_modificarRol * $maxRows_modificarRol;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificarRol = "SELECT * FROM CATROL ORDER BY IDROL DESC";
$query_limit_modificarRol = sprintf("%s LIMIT %d, %d", $query_modificarRol, $startRow_modificarRol, $maxRows_modificarRol);
$modificarRol = mysql_query($query_limit_modificarRol, $basepangloria) or die(mysql_error());
$row_modificarRol = mysql_fetch_assoc($modificarRol);

if (isset($_GET['totalRows_modificarRol'])) {
  $totalRows_modificarRol = $_GET['totalRows_modificarRol'];
} else {
  $all_modificarRol = mysql_query($query_modificarRol);
  $totalRows_modificarRol = mysql_num_rows($all_modificarRol);
}
$totalPages_modificarRol = ceil($totalRows_modificarRol/$maxRows_modificarRol)-1;

$queryString_modificaRol = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificaRol") == false && 
        stristr($param, "totalRows_modificaRol") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificaRol = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificaRol = sprintf("&totalRows_modificaRol=%d%s", $totalRows_modificaRol, $queryString_modificaRol);
$query_modificaRol = "SELECT * FROM CATROL ORDER BY IDROL ASC";
$modificaRol = mysql_query($query_modificaRol, $basepangloria) or die(mysql_error());
$row_modificaRol = mysql_fetch_assoc($modificaRol);
$totalRows_modificaRol = mysql_num_rows($modificaRol);
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
<iframe src="modificarRol.php" name="modiRol" width="830" height="300" scrolling="No" align="left"  frameborder="0" id="modiRol"></iframe>
<div class="content" id="contenidoadminphp2">
  <p>&nbsp;</p>
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="844" align="center"><div class="cont">
        <form action="filtroModiRol.php" method="post" name="MODIFICAR" target="modiRol" id="MODIFICAR">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left"><table width="820" border="0">
                <tr>
    <td><a href="<?php printf("%s?pageNum_modificaRol=%d%s", $currentPage, 0, $queryString_modificaRol); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificaRol=%d%s", $currentPage, max(0, $pageNum_modificaRol - 1), $queryString_modificaRol); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificaRol=%d%s", $currentPage, min($totalPages_modificaRol, $pageNum_modificaRol + 1), $queryString_modificaRol); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificaRol=%d%s", $currentPage, $totalPages_modificaRol, $queryString_modificaRol); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td><form action="modificarRol.php" method="post" name="form1" target="modiRol" id="form1">
      Nombre  del Proveedor a Modificar:
      <input type="text" name="filmodro" id="filmodro" />
      <input type="submit" name="btnfiltrar" id="btnfiltrar" value="Filtrar" />
    </form></td>
  </tr>
  <tr>
    <td><table border="1">
      <tr>
        <td>Modificacion</td>
        <td>IDROL</td>
        <td>DESCRIPCION</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><a href="modificarRol.php?root=<?php echo $row_modificarRol['IDROL']; ?>" target="modiRol">Modificar</a></td>
        <td><?php echo $row_modificarRol['IDROL']; ?></td>
        <td><?php echo $row_modificarRol['DESCRIPCION']; ?></td>
      </tr>
      <?php } while ($row_modificarRol = mysql_fetch_assoc($modificarRol)); ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>

</html>
<?php
mysql_free_result($modificarRol);
?>
