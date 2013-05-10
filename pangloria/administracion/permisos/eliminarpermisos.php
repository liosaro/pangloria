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

$maxRows_consultapermi = 10;
$pageNum_consultapermi = 0;
if (isset($_GET['pageNum_consultapermi'])) {
  $pageNum_consultapermi = $_GET['pageNum_consultapermi'];
}
$startRow_consultapermi = $pageNum_consultapermi * $maxRows_consultapermi;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultapermi = "SELECT * FROM CATPERMISOS";
$query_limit_consultapermi = sprintf("%s LIMIT %d, %d", $query_consultapermi, $startRow_consultapermi, $maxRows_consultapermi);
$consultapermi = mysql_query($query_limit_consultapermi, $basepangloria) or die(mysql_error());
$row_consultapermi = mysql_fetch_assoc($consultapermi);

if (isset($_GET['totalRows_consultapermi'])) {
  $totalRows_consultapermi = $_GET['totalRows_consultapermi'];
} else {
  $all_consultapermi = mysql_query($query_consultapermi);
  $totalRows_consultapermi = mysql_num_rows($all_consultapermi);
}
$totalPages_consultapermi = ceil($totalRows_consultapermi/$maxRows_consultapermi)-1;

$queryString_consultapermi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultapermi") == false && 
        stristr($param, "totalRows_consultapermi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultapermi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultapermi = sprintf("&totalRows_consultapermi=%d%s", $totalRows_consultapermi, $queryString_consultapermi);

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
        <form action="filtroeliminapermiso.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <iframe src="filtroeliminapermiso.php" name="modiprodu" width="830" height="200" align="middle" scrolling="Auto" frameborder="0" id="modiprodu"></iframe>
                <p><a href="<?php printf("%s?pageNum_consultapermi=%d%s", $currentPage, 0, $queryString_consultapermi); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultapermi=%d%s", $currentPage, max(0, $pageNum_consultapermi - 1), $queryString_consultapermi); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultapermi=%d%s", $currentPage, min($totalPages_consultapermi, $pageNum_consultapermi + 1), $queryString_consultapermi); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultapermi=%d%s", $currentPage, $totalPages_consultapermi, $queryString_consultapermi); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a> </p>
                <p>
                  <input type="text" name="filtroprod" id="filtroprod" />
                  <input type="submit" name="filtrar" id="filtrar" value="Filtrar" />
                </p>
                <table border="1" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center">Modificar</td>
                    <td align="center">Codigo de Permiso</td>
                    <td align="center">Permiso</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="javascript:;" onclick="aviso('eliminaPermiso.php?root=<?php echo $row_consultapermi['IDPERMISO'];?>'); return false;">Eliminar</a></td>
                      <td><?php echo $row_consultapermi['IDPERMISO']; ?></td>
                      <td><?php echo $row_consultapermi['DESCRIPCION']; ?></td>
                    </tr>
                    <?php } while ($row_consultapermi = mysql_fetch_assoc($consultapermi)); ?>
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
mysql_free_result($consultapermi);

mysql_free_result($consultaProducto);
?>
