<?php require_once('Connections/basepangloria.php'); ?>
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

$maxRows_departamento = 10;
$pageNum_departamento = 0;
if (isset($_GET['pageNum_departamento'])) {
  $pageNum_departamento = $_GET['pageNum_departamento'];
}
$startRow_departamento = $pageNum_departamento * $maxRows_departamento;

mysql_select_db($database_basepangloria, $basepangloria);
$query_departamento = "SELECT * FROM CATDEPARTAMENEMPRESA";
$query_limit_departamento = sprintf("%s LIMIT %d, %d", $query_departamento, $startRow_departamento, $maxRows_departamento);
$departamento = mysql_query($query_limit_departamento, $basepangloria) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);

if (isset($_GET['totalRows_departamento'])) {
  $totalRows_departamento = $_GET['totalRows_departamento'];
} else {
  $all_departamento = mysql_query($query_departamento);
  $totalRows_departamento = mysql_num_rows($all_departamento);
}
$totalPages_departamento = ceil($totalRows_departamento/$maxRows_departamento)-1;

$queryString_departamento = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_departamento") == false && 
        stristr($param, "totalRows_departamento") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_departamento = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_departamento = sprintf("&totalRows_departamento=%d%s", $totalRows_departamento, $queryString_departamento);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Consultar Departamento de Empresa</h1></td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1" method="post" action="">
      <p>
        <label for="textfield"></label>
        <input type="text" name="textfield" id="textfield" />
        <input type="submit" name="button" id="button" value="Filtrar" />
      </p>
      <p><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, 0, $queryString_departamento); ?>"><img src="imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, max(0, $pageNum_departamento - 1), $queryString_departamento); ?>"><img src="imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, min($totalPages_departamento, $pageNum_departamento + 1), $queryString_departamento); ?>"><img src="imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, $totalPages_departamento, $queryString_departamento); ?>"><img src="imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
    </form>
      <table border="1">
        <tr>
        <td>ID DEPARTAMENTO</td>
        <td>DEPARTAMENTO</td>
        <td>NUMERO DE TELEFONO</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row_departamento['IDDEPTO']; ?></td>
        <td><?php echo $row_departamento['DEPARTAMENTO']; ?></td>
        <td><?php echo $row_departamento['NUMEROTELEFONO']; ?></td>
        <td><a href="modificartodo.php?root=<?php echo $row_departamento['IDDEPTO']; ?>">Modificar</a></td>
        <td><a href="eliminar.php?root=<?php echo $row_departamento['IDDEPTO']; ?>">Eliminar</a></td>
      </tr>
      <?php } while ($row_departamento = mysql_fetch_assoc($departamento)); ?>
  </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($departamento);
?>
