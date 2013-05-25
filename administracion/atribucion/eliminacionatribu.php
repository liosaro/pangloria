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

$maxRows_consultaatribucion = 5;
$pageNum_consultaatribucion = 0;
if (isset($_GET['pageNum_consultaatribucion'])) {
  $pageNum_consultaatribucion = $_GET['pageNum_consultaatribucion'];
}
$startRow_consultaatribucion = $pageNum_consultaatribucion * $maxRows_consultaatribucion;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaatribucion = "SELECT * FROM CATATRIBUCIONES";
$query_limit_consultaatribucion = sprintf("%s LIMIT %d, %d", $query_consultaatribucion, $startRow_consultaatribucion, $maxRows_consultaatribucion);
$consultaatribucion = mysql_query($query_limit_consultaatribucion, $basepangloria) or die(mysql_error());
$row_consultaatribucion = mysql_fetch_assoc($consultaatribucion);

if (isset($_GET['totalRows_consultaatribucion'])) {
  $totalRows_consultaatribucion = $_GET['totalRows_consultaatribucion'];
} else {
  $all_consultaatribucion = mysql_query($query_consultaatribucion);
  $totalRows_consultaatribucion = mysql_num_rows($all_consultaatribucion);
}
$totalPages_consultaatribucion = ceil($totalRows_consultaatribucion/$maxRows_consultaatribucion)-1;

$queryString_consultaatribucion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaatribucion") == false && 
        stristr($param, "totalRows_consultaatribucion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaatribucion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaatribucion = sprintf("&totalRows_consultaatribucion=%d%s", $totalRows_consultaatribucion, $queryString_consultaatribucion);

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
<script language="JavaScript">
function aviso(url){
if (!confirm("ALERTA!! va a proceder a eliminar este registro, si desea eliminarlo de click en ACEPTAR\n de lo contrario de click en CANCELAR.")) {
return false;
}
else {
document.location = url;
return true;
}
}
</script>
</head>

<body>
<div class="content" id="contenidoadminphp2">
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="844" align="center"><div class="cont">
        <form action="filtroeliminaatribu.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left" bgcolor="#CCCCCC">&nbsp;
                <iframe src="filtroeliminaatribu.php" name="modiprodu" width="830" height="90" align="middle" scrolling="no" frameborder="0" id="modiprodu"></iframe>
<p><a href="<?php printf("%s?pageNum_consultaatribucion=%d%s", $currentPage, 0, $queryString_consultaatribucion); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaatribucion=%d%s", $currentPage, max(0, $pageNum_consultaatribucion - 1), $queryString_consultaatribucion); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaatribucion=%d%s", $currentPage, min($totalPages_consultaatribucion, $pageNum_consultaatribucion + 1), $queryString_consultaatribucion); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaatribucion=%d%s", $currentPage, $totalPages_consultaatribucion, $queryString_consultaatribucion); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></p>
                <table width="820" border="1">
                  <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Eliminarr</td>
                    <td>Id Atribución</td>
                    <td>Id Usuario</td>
                    <td>Id Rol</td>
                    <td>Id Permiso</td>
                    <td>C</td>
                    <td>R</td>
                    <td>U</td>
                    <td>D</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="javascript:;" onclick="aviso('eliminarAtribu.php?root=<?php echo $row_consultaatribucion['ID_ATRIB'];?>'); return false;">Eliminar</a></td>
                      <td><?php echo $row_consultaatribucion['ID_ATRIB']; ?></td>
                      <td><?php echo $row_consultaatribucion['IDUSUARIO']; ?></td>
                      <td><?php echo $row_consultaatribucion['IDROL']; ?></td>
                      <td><?php echo $row_consultaatribucion['IDPERMISO']; ?></td>
                      <td><?php echo $row_consultaatribucion['C']; ?><?php echo $row_consultaatribucion['R']; ?></td>
                      <td>&nbsp;</td>
                      <td><?php echo $row_consultaatribucion['U']; ?></td>
                      <td><?php echo $row_consultaatribucion['D']; ?></td>
                      </tr>
                    <?php } while ($row_consultaatribucion = mysql_fetch_assoc($consultaatribucion)); ?>
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
mysql_free_result($consultaatribucion);

mysql_free_result($consultaProducto);
?>
