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

$maxRows_consultajsutificacion = 5;
$pageNum_consultajsutificacion = 0;
if (isset($_GET['pageNum_consultajsutificacion'])) {
  $pageNum_consultajsutificacion = $_GET['pageNum_consultajsutificacion'];
}
$startRow_consultajsutificacion = $pageNum_consultajsutificacion * $maxRows_consultajsutificacion;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultajsutificacion = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_consultajsutificacion = sprintf("%s LIMIT %d, %d", $query_consultajsutificacion, $startRow_consultajsutificacion, $maxRows_consultajsutificacion);
$consultajsutificacion = mysql_query($query_limit_consultajsutificacion, $basepangloria) or die(mysql_error());
$row_consultajsutificacion = mysql_fetch_assoc($consultajsutificacion);

if (isset($_GET['totalRows_consultajsutificacion'])) {
  $totalRows_consultajsutificacion = $_GET['totalRows_consultajsutificacion'];
} else {
  $all_consultajsutificacion = mysql_query($query_consultajsutificacion);
  $totalRows_consultajsutificacion = mysql_num_rows($all_consultajsutificacion);
}
$totalPages_consultajsutificacion = ceil($totalRows_consultajsutificacion/$maxRows_consultajsutificacion)-1;

$queryString_consultajsutificacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultajsutificacion") == false && 
        stristr($param, "totalRows_consultajsutificacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultajsutificacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultajsutificacion = sprintf("&totalRows_consultajsutificacion=%d%s", $totalRows_consultajsutificacion, $queryString_consultajsutificacion);

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
        <form action="filtroeliminaproducto.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <iframe src="filtroeliminaproducto.php" name="modiprodu" width="830" height="200" align="middle" scrolling="Auto" frameborder="0" id="modiprodu"></iframe>
<p><a href="<?php printf("%s?pageNum_consultajsutificacion=%d%s", $currentPage, 0, $queryString_consultajsutificacion); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultajsutificacion=%d%s", $currentPage, max(0, $pageNum_consultajsutificacion - 1), $queryString_consultajsutificacion); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultajsutificacion=%d%s", $currentPage, min($totalPages_consultajsutificacion, $pageNum_consultajsutificacion + 1), $queryString_consultajsutificacion); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultajsutificacion=%d%s", $currentPage, $totalPages_consultajsutificacion, $queryString_consultajsutificacion); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
                <table width="830" border="1">
                  <tr>
                    <td colspan="2"><input type="text" name="filtroprod" id="filtroprod" />
                      <input type="submit" name="filtrar" id="filtrar" value="Filtrar" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Modificar</td>
                    <td>Id del producto</td>
                    <td>Nombre del Producto</td>
                    <td>Precio Costo</td>
                    <td>Precio Mayoreo</td>
                    <td>Precio Menudeo</td>
                    <td>Dias Caducidad</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="javascript:;" onclick="aviso('eliminarProducto.php?root=<?php echo $row_consultajsutificacion['IDPRODUCTO'];?>'); return false;">Eliminar</a></td>
                      <td><?php echo $row_consultajsutificacion['IDPRODUCTO']; ?></td>
                      <td><?php echo $row_consultajsutificacion['DESCRIPCIONPRODUC']; ?></td>
                      <td><?php echo $row_consultajsutificacion['PRECIO_COSTO']; ?></td>
                      <td><?php echo $row_consultajsutificacion['PRECIO_VENTAMAYOREO']; ?></td>
                      <td><?php echo $row_consultajsutificacion['PRECIO_VENTAMENOR']; ?></td>
                      <td><?php echo $row_consultajsutificacion['DIAS_CADUCIDAD']; ?></td>
                      </tr>
                    <?php } while ($row_consultajsutificacion = mysql_fetch_assoc($consultajsutificacion)); ?>
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
mysql_free_result($consultajsutificacion);

mysql_free_result($consultaProducto);
?>
