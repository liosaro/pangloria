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

$maxRows_consultaatribu = 6;
$pageNum_consultaatribu = 0;
if (isset($_GET['pageNum_consultaatribu'])) {
  $pageNum_consultaatribu = $_GET['pageNum_consultaatribu'];
}
$startRow_consultaatribu = $pageNum_consultaatribu * $maxRows_consultaatribu;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaatribu = "SELECT * FROM CATATRIBUCIONES";
$query_limit_consultaatribu = sprintf("%s LIMIT %d, %d", $query_consultaatribu, $startRow_consultaatribu, $maxRows_consultaatribu);
$consultaatribu = mysql_query($query_limit_consultaatribu, $basepangloria) or die(mysql_error());
$row_consultaatribu = mysql_fetch_assoc($consultaatribu);

if (isset($_GET['totalRows_consultaatribu'])) {
  $totalRows_consultaatribu = $_GET['totalRows_consultaatribu'];
} else {
  $all_consultaatribu = mysql_query($query_consultaatribu);
  $totalRows_consultaatribu = mysql_num_rows($all_consultaatribu);
}
$totalPages_consultaatribu = ceil($totalRows_consultaatribu/$maxRows_consultaatribu)-1;

$queryString_consultaatribu = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaatribu") == false && 
        stristr($param, "totalRows_consultaatribu") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaatribu = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaatribu = sprintf("&totalRows_consultaatribu=%d%s", $totalRows_consultaatribu, $queryString_consultaatribu);

$queryString_consultaProducto = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaProducto") == false && 
        stristr($param, "totalRows_consultaProducto") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaProducto = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaProducto = sprintf("&totalRows_consultaProducto=%d%s", $totalRows_consultaProducto, $queryString_consultaProducto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Empleados</title>
<link href="../../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content" id="contenidoadminphp2">
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="844" align="center"><div class="cont">
        <form action="filtromodificaatribucion.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <iframe src="modificadoratribu.php" name="modiprodu" width="830" height="300" align="middle" scrolling="no" frameborder="0" id="modiprodu"></iframe>
                
                ><p><a href="<?php printf("%s?pageNum_consultaatribu=%d%s", $currentPage, 0, $queryString_consultaatribu); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaatribu=%d%s", $currentPage, max(0, $pageNum_consultaatribu - 1), $queryString_consultaatribu); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaatribu=%d%s", $currentPage, min($totalPages_consultaatribu, $pageNum_consultaatribu + 1), $queryString_consultaatribu); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaatribu=%d%s", $currentPage, $totalPages_consultaatribu, $queryString_consultaatribu); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a> </p>
                <p>&nbsp;</p>
                <table width="820" border="1">
                  <tr>
                    <td>Modificar</td>
                    <td>ID_ATRIB</td>
                    <td>IDUSUARIO</td>
                    <td>IDROL</td>
                    <td>IDPERMISO</td>
                    <td>C</td>
                    <td>R</td>
                    <td>U</td>
                    <td>D</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="modificadoratribu.php?root=<?php echo $row_consultaatribu['ID_ATRIB']; ?>" target="modiprodu">Modificar</a></td>
                      <td><?php echo $row_consultaatribu['ID_ATRIB']; ?></td>
                      <td><?php echo $row_consultaatribu['IDUSUARIO']; ?></td>
                      <td><?php echo $row_consultaatribu['IDUSUARIO']; ?></td>
                      <td><?php echo $row_consultaatribu['IDROL']; ?></td>
                      <td><?php echo $row_consultaatribu['IDPERMISO']; ?></td>
                      <td><?php echo $row_consultaatribu['C']; ?></td>
                      <td><?php echo $row_consultaatribu['R']; ?></td>
                      <td><?php echo $row_consultaatribu['U']; ?></td>
                      <td><?php echo $row_consultaatribu['D']; ?></td>
                      </tr>
                    <?php } while ($row_consultaatribu = mysql_fetch_assoc($consultaatribu)); ?>
                </table></td>
            </tr>
            </table>
        </form>
      </div></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultaatribu);

mysql_free_result($consultaProducto);
?>
