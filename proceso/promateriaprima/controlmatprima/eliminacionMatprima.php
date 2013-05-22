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

$maxRows_consultacontrol = 5;
$pageNum_consultacontrol = 0;
if (isset($_GET['pageNum_consultacontrol'])) {
  $pageNum_consultacontrol = $_GET['pageNum_consultacontrol'];
}
$startRow_consultacontrol = $pageNum_consultacontrol * $maxRows_consultacontrol;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultacontrol = "SELECT * FROM CATPRODUCTO ORDER BY IDPRODUCTO DESC";
$query_limit_consultacontrol = sprintf("%s LIMIT %d, %d", $query_consultacontrol, $startRow_consultacontrol, $maxRows_consultacontrol);
$consultacontrol = mysql_query($query_limit_consultacontrol, $basepangloria) or die(mysql_error());
$row_consultacontrol = mysql_fetch_assoc($consultacontrol);

if (isset($_GET['totalRows_consultacontrol'])) {
  $totalRows_consultacontrol = $_GET['totalRows_consultacontrol'];
} else {
  $all_consultacontrol = mysql_query($query_consultacontrol);
  $totalRows_consultacontrol = mysql_num_rows($all_consultacontrol);
}
$totalPages_consultacontrol = ceil($totalRows_consultacontrol/$maxRows_consultacontrol-1; $maxRows_consultacontrol= 5;
$pageNum_consultacontrol = 0;
if (isset($_GET['pageNum_consultacontrol'])) {
  $pageNum_consultacontrol = $_GET['pageNum_consultacontrol'];
}
$startRow_consultacontrol = $pageNum_consultacontrol * $maxRows_consultacontrol;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultacontrol = "SELECT * FROM TRNCONTROL_MAT_PRIMA";
$query_limit_consultacontrol = sprintf("%s LIMIT %d, %d", $query_consultacontrol, $startRow_consultacontrol, $maxRows_consultacontrol);
$consultacontrol = mysql_query($query_limit_consultacontrol, $basepangloria) or die(mysql_error());
$row_consultacontrol = mysql_fetch_assoc($consultacontrol);

if (isset($_GET['totalRows_consultacontrol'])) {
  $totalRows_consultacontrol = $_GET['totalRows_consultacontrol'];
} else {
  $all_consultacontrol = mysql_query($query_consultacontrol);
  $totalRows_consultacontrol = mysql_num_rows($all_consultacontrol);
}
$totalPages_consultacontrol = ceil($totalRows_consultacontrol/$maxRows_consultacontrol)-1;

$queryString_consultacontrol = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultacontrol") == false && 
        stristr($param, "totalRows_consultacontrol") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultacontrol = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultacontrol = sprintf("&totalRows_consultacontrol=%d%s", $totalRows_consultacontrol, $queryString_consultacontrol);

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
        <form action="filtroeliminamatprima.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <iframe src="filtroeliminamatprima.php" name="modiprodu" width="830" height="200" align="middle" scrolling="Auto" frameborder="0" id="modiprodu"></iframe>
<p><a href="<?php printf("%s?pageNum_consultacontrol=%d%s", $currentPage, 0, $queryString_consultacontrol); ?>"><img src="../../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultacontrol=%d%s", $currentPage, max(0, $pageNum_consultacontrol - 1), $queryString_consultacontrol); ?>"><img src="../../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultacontrol=%d%s", $currentPage, min($totalPages_consultacontrol, $pageNum_consultacontrol + 1), $queryString_consultacontrol); ?>"><img src="../../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultacontrol=%d%s", $currentPage, $totalPages_consultacontrol, $queryString_consultacontrol); ?>"><img src="../../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></p>
                <table width="830" border="1">
                  <tr>
                    <td colspan="2"><input type="text" name="filtroprod" id="filtroprod" />
                      <input type="submit" name="filtrar" id="filtrar" value="Filtrar" /></td>
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
                    <td>Id Control</td>
                    <td>Materia Prima</td>
                    <td>Salida</td>
                    <td>Unidad</td>
                    <td>Cantid Entregda</td>
                    <td>Cantidad Devuelta</td>
                    <td>Cantidad Utilizada</td>
                    <td>Fecha</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="javascript:;" onclick=""aviso('eliminarMatprima.php?root=<?php echo $row_consultaproducto['ID_CONTROLMAT'];?>'); return false;">Eliminar</a></td>
                      <td><?php echo $row_consultacontrol['ID_CONTROLMAT']; ?></td>
                      <td><?php echo $row_consultacontrol['IDMATPRIMA']; ?></td>
                      <td><?php echo $row_consultacontrol['ID_SALIDA']; ?></td>
                      <td><?php echo $row_consultacontrol['IDUNIDAD']; ?></td>
                      <td><?php echo $row_consultacontrol['CANT_ENTREGA']; ?></td>
                      <td><?php echo $row_consultacontrol['CANT_DEVUELTA']; ?></td>
                      <td><?php echo $row_consultacontrol['CANT_UTILIZADA']; ?></td>
                      <td><?php echo $row_consultacontrol['FECHA_CONTROL']; ?></td>
                      </tr>
                    <?php } while ($row_consultacontrol = mysql_fetch_assoc($consultacontrol)); ?>
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
mysql_free_result($consultacontrol);

mysql_free_result($consultaProducto);
?>
