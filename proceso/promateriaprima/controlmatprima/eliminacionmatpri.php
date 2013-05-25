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

$maxRows_consultamatpri = 5;
$pageNum_consultamatpri = 0;
if (isset($_GET['pageNum_consultamatpri'])) {
  $pageNum_consultamatpri = $_GET['pageNum_consultamatpri'];
}
$startRow_consultamatpri = $pageNum_consultamatpri * $maxRows_consultamatpri;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultamatpri = "SELECT * FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT ASC";
$query_limit_consultamatpri = sprintf("%s LIMIT %d, %d", $query_consultamatpri, $startRow_consultamatpri, $maxRows_consultamatpri);
$consultamatpri = mysql_query($query_limit_consultamatpri, $basepangloria) or die(mysql_error());
$row_consultamatpri = mysql_fetch_assoc($consultamatpri);

if (isset($_GET['totalRows_consultamatpri'])) {
  $totalRows_consultamatpri = $_GET['totalRows_consultamatpri'];
} else {
  $all_consultamatpri = mysql_query($query_consultamatpri);
  $totalRows_consultamatpri = mysql_num_rows($all_consultamatpri);
}
$totalPages_consultamatpri = ceil($totalRows_consultamatpri/$maxRows_consultamatpri)-1;$maxRows_consultamatpri = 5;
$pageNum_consultamatpri = 0;
if (isset($_GET['pageNum_consultamatpri'])) {
  $pageNum_consultamatpri = $_GET['pageNum_consultamatpri'];
}
$startRow_consultamatpri = $pageNum_consultamatpri * $maxRows_consultamatpri;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultamatpri = "SELECT * FROM TRNCONTROL_MAT_PRIMA";
$query_limit_consultamatpri = sprintf("%s LIMIT %d, %d", $query_consultamatpri, $startRow_consultamatpri, $maxRows_consultamatpri);
$consultamatpri = mysql_query($query_limit_consultamatpri, $basepangloria) or die(mysql_error());
$row_consultamatpri = mysql_fetch_assoc($consultamatpri);

if (isset($_GET['totalRows_consultamatpri'])) {
  $totalRows_consultamatpri = $_GET['totalRows_consultamatpri'];
} else {
  $all_consultamatpri = mysql_query($query_consultamatpri);
  $totalRows_consultamatpri = mysql_num_rows($all_consultamatpri);
}
$totalPages_consultamatpri = ceil($totalRows_consultamatpri/$maxRows_consultamatpri)-1;

$queryString_consultamatpri = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultamatpri") == false && 
        stristr($param, "totalRows_consultamatpri") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultamatpri = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultamatpri = sprintf("&totalRows_consultamatpri=%d%s", $totalRows_consultamatpri, $queryString_consultamatpri);

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
        <form action="filtroeliminamatpri.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left" bgcolor="#CCCCCC">&nbsp;
                <iframe src="filtroeliminamatpri.php" name="modiprodu" width="830" height="90" align="middle" scrolling="no" frameborder="0" id="modiprodu"></iframe>
<p><a href="<?php printf("%s?pageNum_consultamatpri=%d%s", $currentPage, 0, $queryString_consultamatpri); ?>"><img src="../../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultamatpri=%d%s", $currentPage, max(0, $pageNum_consultamatpri - 1), $queryString_consultamatpri); ?>"><img src="../../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultamatpri=%d%s", $currentPage, min($totalPages_consultamatpri, $pageNum_consultamatpri + 1), $queryString_consultamatpri); ?>"><img src="../../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultamatpri=%d%s", $currentPage, $totalPages_consultamatpri, $queryString_consultamatpri); ?>"><img src="../../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></p>
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
                    <td>Control Materia Prima</td>
                    <td>Materia Prima</td>
                    <td>Salida</td>
                    <td>Unidad</td>
                    <td>Cantidad Entregada</td>
                    <td>Cantidad Devuelta</td>
                    <td>Cantidad Utiliada</td>
                    <td>Fecha</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="javascript:;" onclick="aviso('eliminarMatpri.php?root=<?php echo $row_consultamatpri['ID_CONTROLMAT'];?>'); return false;">Eliminar</a></td>
                      <td><?php echo $row_consultamatpri['ID_CONTROLMAT']; ?></td>
                      <td><?php echo $row_consultamatpri['IDMATPRIMA']; ?></td>
                      <td><?php echo $row_consultamatpri['ID_SALIDA']; ?></td>
                      <td><?php echo $row_consultamatpri['IDUNIDAD']; ?></td>
                      <td><?php echo $row_consultamatpri['CANT_ENTREGA']; ?></td>
                      <td><?php echo $row_consultamatpri['CANT_DEVUELTA']; ?></td>
                      <td><?php echo $row_consultamatpri['CANT_UTILIZADA']; ?></td>
                      <td><?php echo $row_consultamatpri['FECHA_CONTROL']; ?></td>
                      </tr>
                    <?php } while ($row_consultamatpri = mysql_fetch_assoc($consultamatpri)); ?>
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
mysql_free_result($consultamatpri);

mysql_free_result($consultaProducto);
?>
