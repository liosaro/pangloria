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

$maxRows_modificarDEPTO = 10;
$pageNum_modificarDEPTO = 0;
if (isset($_GET['pageNum_modificarDEPTO'])) {
  $pageNum_modificarDEPTO = $_GET['pageNum_modificarDEPTO'];
}
$startRow_modificarDEPTO = $pageNum_modificarDEPTO * $maxRows_modificarDEPTO;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificarDEPTO = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO ASC";
$query_limit_modificarDEPTO = sprintf("%s LIMIT %d, %d", $query_modificarDEPTO, $startRow_modificarDEPTO, $maxRows_modificarDEPTO);
$modificarDEPTO = mysql_query($query_limit_modificarDEPTO, $basepangloria) or die(mysql_error());
$row_modificarDEPTO = mysql_fetch_assoc($modificarDEPTO);

if (isset($_GET['totalRows_modificarDEPTO'])) {
  $totalRows_modificarDEPTO = $_GET['totalRows_modificarDEPTO'];
} else {
  $all_modificarDEPTO = mysql_query($query_modificarDEPTO);
  $totalRows_modificarDEPTO = mysql_num_rows($all_modificarDEPTO);
}
$totalPages_modificarDEPTO = ceil($totalRows_modificarDEPTO/$maxRows_modificarDEPTO)-1;

$queryString_modificarDEPTO = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificarDEPTO") == false && 
        stristr($param, "totalRows_modificarDEPTO") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificarDEPTO = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificarDEPTO = sprintf("&totalRows_modificarDEPTO=%d%s", $totalRows_modificarDEPTO, $queryString_modificarDEPTO);
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
    <td colspan="4"><iframe src="modidepart.php" name="modificar" width="820" height="400" scrolling="NO" id="modificar"></iframe></td>
  </tr>
  <tr>
    <td colspan="4"><form action="filtromodiDepto.php" method="post" name="form1" target="modificar" id="form1">
      Ingrese el Nombre del Departamento: 
      <label for="filtdepto"></label>
      <input type="text" name="filtdepto" id="filtdepto" />
      <input type="submit" name="btnfiltrar" id="btnfiltrar" value="Filtrar" />
    </form></td>
  </tr>
  <tr>
    <td colspan="4"><a href="<?php printf("%s?pageNum_modificarDEPTO=%d%s", $currentPage, 0, $queryString_modificarDEPTO); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificarDEPTO=%d%s", $currentPage, max(0, $pageNum_modificarDEPTO - 1), $queryString_modificarDEPTO); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificarDEPTO=%d%s", $currentPage, min($totalPages_modificarDEPTO, $pageNum_modificarDEPTO + 1), $queryString_modificarDEPTO); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_modificarDEPTO=%d%s", $currentPage, $totalPages_modificarDEPTO, $queryString_modificarDEPTO); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
  </tr>
  <tr>
    <td>Modificacion</td>
    <td>IDDEPTO</td>
    <td>DEPARTAMENTO</td>
    <td>NUMEROTELEFONO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modidepart.php?root=<?php echo $row_modificarDEPTO['IDDEPTO']; ?>" target="modificar">Modificar</a></td>
      <td><?php echo $row_modificarDEPTO['IDDEPTO']; ?></td>
      <td><?php echo $row_modificarDEPTO['DEPARTAMENTO']; ?></td>
      <td><?php echo $row_modificarDEPTO['NUMEROTELEFONO']; ?></td>
    </tr>
    <?php } while ($row_modificarDEPTO = mysql_fetch_assoc($modificarDEPTO)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($modificarDEPTO);
?>
