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

$maxRows_conatribu = 10;
$pageNum_conatribu = 0;
if (isset($_GET['pageNum_conatribu'])) {
  $pageNum_conatribu = $_GET['pageNum_conatribu'];
}
$startRow_conatribu = $pageNum_conatribu * $maxRows_conatribu;

$colname_conatribu = "-1";
if (isset($_GET['q'])) {
  $colname_conatribu = $_GET['q'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_conatribu = sprintf("SELECT * FROM CATATRIBUCIONES WHERE ID_ATRIB = %s", GetSQLValueString($colname_conatribu, "int"));
$query_limit_conatribu = sprintf("%s LIMIT %d, %d", $query_conatribu, $startRow_conatribu, $maxRows_conatribu);
$conatribu = mysql_query($query_limit_conatribu, $basepangloria) or die(mysql_error());
$row_conatribu = mysql_fetch_assoc($conatribu);

if (isset($_GET['totalRows_conatribu'])) {
  $totalRows_conatribu = $_GET['totalRows_conatribu'];
} else {
  $all_conatribu = mysql_query($query_conatribu);
  $totalRows_conatribu = mysql_num_rows($all_conatribu);
}
$totalPages_conatribu = ceil($totalRows_conatribu/$maxRows_conatribu)-1;

$queryString_conatribu = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_conatribu") == false && 
        stristr($param, "totalRows_conatribu") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_conatribu = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_conatribu = sprintf("&totalRows_conatribu=%d%s", $totalRows_conatribu, $queryString_conatribu);
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
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8" bgcolor="#999999">Detalle de Consulta de Atribucion por Id</td>
  </tr>
  <tr>
    <td colspan="8"><a href="<?php printf("%s?pageNum_conatribu=%d%s", $currentPage, 0, $queryString_conatribu); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_conatribu=%d%s", $currentPage, max(0, $pageNum_conatribu - 1), $queryString_conatribu); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_conatribu=%d%s", $currentPage, min($totalPages_conatribu, $pageNum_conatribu + 1), $queryString_conatribu); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_conatribu=%d%s", $currentPage, $totalPages_conatribu, $queryString_conatribu); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Codigo de Atribucion</td>
    <td>Usuario</td>
    <td>Rol</td>
    <td>Permisos</td>
    <td>C</td>
    <td>R</td>
    <td>U</td>
    <td>D</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_conatribu['ID_ATRIB']; ?></td>
      <td><?php echo $row_conatribu['IDUSUARIO']; ?></td>
      <td><?php echo $row_conatribu['IDROL']; ?></td>
      <td><?php echo $row_conatribu['IDPERMISO']; ?></td>
      <td><?php echo $row_conatribu['C']; ?></td>
      <td><?php echo $row_conatribu['R']; ?></td>
      <td><?php echo $row_conatribu['U']; ?></td>
      <td><?php echo $row_conatribu['D']; ?></td>
    </tr>
    <?php } while ($row_conatribu = mysql_fetch_assoc($conatribu)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($conatribu);
?>
