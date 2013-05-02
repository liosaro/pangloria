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

$maxRows_consultaEmpre = 10;
$pageNum_consultaEmpre = 0;
if (isset($_GET['pageNum_consultaEmpre'])) {
  $pageNum_consultaEmpre = $_GET['pageNum_consultaEmpre'];
}
$startRow_consultaEmpre = $pageNum_consultaEmpre * $maxRows_consultaEmpre;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaEmpre = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO DESC";
$query_limit_consultaEmpre = sprintf("%s LIMIT %d, %d", $query_consultaEmpre, $startRow_consultaEmpre, $maxRows_consultaEmpre);
$consultaEmpre = mysql_query($query_limit_consultaEmpre, $basepangloria) or die(mysql_error());
$row_consultaEmpre = mysql_fetch_assoc($consultaEmpre);

if (isset($_GET['totalRows_consultaEmpre'])) {
  $totalRows_consultaEmpre = $_GET['totalRows_consultaEmpre'];
} else {
  $all_consultaEmpre = mysql_query($query_consultaEmpre);
  $totalRows_consultaEmpre = mysql_num_rows($all_consultaEmpre);
}
$totalPages_consultaEmpre = ceil($totalRows_consultaEmpre/$maxRows_consultaEmpre)-1;

$queryString_consultaEmpre = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaEmpre") == false && 
        stristr($param, "totalRows_consultaEmpre") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaEmpre = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaEmpre = sprintf("&totalRows_consultaEmpre=%d%s", $totalRows_consultaEmpre, $queryString_consultaEmpre);
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
      <table width="100%" border="0">
        <tr>
          <td align="center"><iframe src="consultarDepartamento.php" width="820" scrolling="auto"></iframe>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><h1>Consulta De Departamento de la Empresa</h1></td>
        </tr>
        <tr>
          <td><label for="text"></label>
            <input type="text" name="text" id="text" />
            <input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
        </tr>
        <tr>
          <td><a href="<?php printf("%s?pageNum_consultaEmpre=%d%s", $currentPage, 0, $queryString_consultaEmpre); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaEmpre=%d%s", $currentPage, max(0, $pageNum_consultaEmpre - 1), $queryString_consultaEmpre); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaEmpre=%d%s", $currentPage, min($totalPages_consultaEmpre, $pageNum_consultaEmpre + 1), $queryString_consultaEmpre); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaEmpre=%d%s", $currentPage, $totalPages_consultaEmpre, $queryString_consultaEmpre); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
            <table border="1">
              <tr>
                <td>Modificacion</td>
                <td>IDDEPTO</td>
                <td>DEPARTAMENTO</td>
                <td>NUMEROTELEFONO</td>
              </tr>
              <?php do { ?>
                <tr>
                  <td><a href="<?php printf("%s?pageNum_consultaEmpre=%d%s", $currentPage, $totalPages_consultaEmpre, $queryString_consultaEmpre); ?>">Modificar</a></td>
                  <td><?php echo $row_consultaEmpre['IDDEPTO']; ?></td>
                  <td><?php echo $row_consultaEmpre['DEPARTAMENTO']; ?></td>
                  <td><?php echo $row_consultaEmpre['NUMEROTELEFONO']; ?></td>
                </tr>
                <?php } while ($row_consultaEmpre = mysql_fetch_assoc($consultaEmpre)); ?>
            </table>
<p>&nbsp;</p>
            <p>&nbsp;</p></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($consultaEmpre);
?>
