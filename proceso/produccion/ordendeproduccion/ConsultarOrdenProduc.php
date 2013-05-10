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

$maxRows_consultRol = 10;
$pageNum_consultRol = 0;
if (isset($_GET['pageNum_consultRol'])) {
  $pageNum_consultRol = $_GET['pageNum_consultRol'];
}
$startRow_consultRol = $pageNum_consultRol * $maxRows_consultRol;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultRol = "SELECT * FROM CATROL ORDER BY IDROL DESC";
$query_limit_consultRol = sprintf("%s LIMIT %d, %d", $query_consultRol, $startRow_consultRol, $maxRows_consultRol);
$consultRol = mysql_query($query_limit_consultRol, $basepangloria) or die(mysql_error());
$row_consultRol = mysql_fetch_assoc($consultRol);

if (isset($_GET['totalRows_consultRol'])) {
  $totalRows_consultRol = $_GET['totalRows_consultRol'];
} else {
  $all_consultRol = mysql_query($query_consultRol);
  $totalRows_consultRol = mysql_num_rows($all_consultRol);
}
$totalPages_consultRol = ceil($totalRows_consultRol/$maxRows_consultRol)-1;

$queryString_consultRol = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultRol") == false && 
        stristr($param, "totalRows_consultRol") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultRol = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultRol = sprintf("&totalRows_consultRol=%d%s", $totalRows_consultRol, $queryString_consultRol);
?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-weight: bold;
}
</style>
<table width="820" border="0">
  <tr>
    <td align="center"><h1>Consultar Rol</h1></td>
  </tr>
  <tr>
    <td><form name="form1" method="post" action="">
      <label for="txtfiltro"></label>
      <input type="text" name="txtfiltro" id="txtfiltro">
      <input type="submit" name="btnFiltro" id="btnFiltro" value="Filtrar">
    </form></td>
  </tr>
  <tr>
    <td><a href="<?php printf("%s?pageNum_consultRol=%d%s", $currentPage, 0, $queryString_consultRol); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32"></a><a href="<?php printf("%s?pageNum_consultRol=%d%s", $currentPage, max(0, $pageNum_consultRol - 1), $queryString_consultRol); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32"></a><a href="<?php printf("%s?pageNum_consultRol=%d%s", $currentPage, min($totalPages_consultRol, $pageNum_consultRol + 1), $queryString_consultRol); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32"></a><a href="<?php printf("%s?pageNum_consultRol=%d%s", $currentPage, $totalPages_consultRol, $queryString_consultRol); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32"></a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1" align="center">
        <tr>
          <td>IDROL</td>
          <td>DESCRIPCION</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_consultRol['IDROL']; ?></td>
            <td><?php echo $row_consultRol['DESCRIPCION']; ?></td>
          </tr>
          <?php } while ($row_consultRol = mysql_fetch_assoc($consultRol)); ?>
      </table></td>
  </tr>
</table>
<?php
mysql_free_result($consultRol);
?>
