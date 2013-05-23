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
$query_todos = "SELECT * FROM TRNSALIDA_MAT_PRIM ORDER BY ID_SALIDA ASC";
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

mysql_select_db($database_basepangloria, $basepangloria);
$query_mat = "SELECT DESCRIPCION FROM CATMATERIAPRIMA";
$mat = mysql_query($query_mat, $basepangloria) or die(mysql_error());
$row_mat = mysql_fetch_assoc($mat);
$totalRows_mat = mysql_num_rows($mat);

mysql_select_db($database_basepangloria, $basepangloria);
$query_uni = "SELECT TIPOUNIDAD FROM CATUNIDADES";
$uni = mysql_query($query_uni, $basepangloria) or die(mysql_error());
$row_uni = mysql_fetch_assoc($uni);
$totalRows_uni = mysql_num_rows($uni);

mysql_select_db($database_basepangloria, $basepangloria);
$query_depto = "SELECT DEPARTAMENTO FROM CATDEPARTAMENEMPRESA";
$depto = mysql_query($query_depto, $basepangloria) or die(mysql_error());
$row_depto = mysql_fetch_assoc($depto);
$totalRows_depto = mysql_num_rows($depto);

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
    <td colspan="6" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
  </tr>
  <tr>
    <td colspan="6"><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, 0, $queryString_todos); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, max(0, $pageNum_todos - 1), $queryString_todos); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, min($totalPages_todos, $pageNum_todos + 1), $queryString_todos); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_todos=%d%s", $currentPage, $totalPages_todos, $queryString_todos); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>ID_SALIDA</td>
    <td>Cantidad de Materia Prima</td>
    <td>Materia Prima </td>
    <td>ENCABEZADO de Salida de Materia</td>
    <td>Unidad</td>
    <td>Departamento</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_todos['ID_SALIDA']; ?></td>
      <td><?php echo $row_todos['CANTMAT_PRIMA']; ?></td>
      <td><?php echo $row_mat['DESCRIPCION']; ?></td>
      <td><?php echo $row_todos['IDENCABEZADOSALMATPRI']; ?></td>
      <td><?php echo $row_uni['TIPOUNIDAD']; ?></td>
      <td><?php echo $row_depto['DEPARTAMENTO']; ?></td>
    </tr>
    <?php } while ($row_todos = mysql_fetch_assoc($todos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($todos);

mysql_free_result($mat);

mysql_free_result($uni);

mysql_free_result($depto);
?>
