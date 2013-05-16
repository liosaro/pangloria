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

$maxRows_consultaempresa = 5;
$pageNum_consultaempresa = 0;
if (isset($_GET['pageNum_consultaempresa'])) {
  $pageNum_consultaempresa = $_GET['pageNum_consultaempresa'];
}
$startRow_consultaempresa = $pageNum_consultaempresa * $maxRows_consultaempresa;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaempresa = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO DESC";
$query_limit_consultaempresa = sprintf("%s LIMIT %d, %d", $query_consultaempresa, $startRow_consultaempresa, $maxRows_consultaempresa);
$consultaempresa = mysql_query($query_limit_consultaempresa, $basepangloria) or die(mysql_error());
$row_consultaempresa = mysql_fetch_assoc($consultaempresa);

if (isset($_GET['totalRows_consultaempresa'])) {
  $totalRows_consultaempresa = $_GET['totalRows_consultaempresa'];
} else {
  $all_consultaempresa = mysql_query($query_consultaempresa);
  $totalRows_consultaempresa = mysql_num_rows($all_consultaempresa);
}
$totalPages_consultaempresa = ceil($totalRows_consultaempresa/$maxRows_consultaempresa ) -1;
$pageNum_consultaempresa = 0;
if (isset($_GET['pageNum_consultaempresa'])) {
  $pageNum_consultaempresa = $_GET['pageNum_consultaempresa'];
}
$startRow_consultaempresa = $pageNum_consultaempresa * $maxRows_consultaempresa;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaempresa = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO DESC";
$query_limit_consultaempresa = sprintf("%s LIMIT %d, %d", $query_consultaempresa, $startRow_consultaempresa, $maxRows_consultaempresa);
$consultaempresa = mysql_query($query_limit_consultaempresa, $basepangloria) or die(mysql_error());
$row_consultaempresa = mysql_fetch_assoc($consultaempresa);

if (isset($_GET['totalRows_consultaempresa'])) {
  $totalRows_consultaempresa = $_GET['totalRows_consultaempresa'];
} else {
  $all_consultaempresa = mysql_query($query_consultaempresa);
  $totalRows_consultaempresa = mysql_num_rows($all_consultaempresa);
}
$totalPages_consultaempresa = ceil($totalRows_consultaempresa/$maxRows_consultaempresa)-1;$maxRows_consultaempresa = -1;
$pageNum_consultaempresa = 0;
if (isset($_GET['pageNum_consultaempresa'])) {
  $pageNum_consultaempresa = $_GET['pageNum_consultaempresa'];
}
$startRow_consultaempresa = $pageNum_consultaempresa * $maxRows_consultaempresa;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaempresa = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO DESC";
$query_limit_consultaempresa = sprintf("%s LIMIT %d, %d", $query_consultaempresa, $startRow_consultaempresa, $maxRows_consultaempresa);
$consultaempresa = mysql_query($query_limit_consultaempresa, $basepangloria) or die(mysql_error());
$row_consultaempresa = mysql_fetch_assoc($consultaempresa);

if (isset($_GET['totalRows_consultaempresa'])) {
  $totalRows_consultaempresa = $_GET['totalRows_consultaempresa'];
} else {
  $all_consultaempresa = mysql_query($query_consultaempresa);
  $totalRows_consultaempresa = mysql_num_rows($all_consultaempresa);
}
$totalPages_consultaempresa = ceil($totalRows_consultaempresa/$maxRows_consultaempresa)-1;

$queryString_consultaempresa = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaempresa") == false && 
        stristr($param, "totalRows_consultaempresa") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaempresa = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaempresa = sprintf("&totalRows_consultaempresa=%d%s", $totalRows_consultaempresa, $queryString_consultaempresa);

$queryString_consultaempresa = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaempresa") == false && 
        stristr($param, "totalRows_consultaempresa") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaempresa = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaempresa = sprintf("&totalRows_consultaempresa=%d%s", $totalRows_consultaempresa, $queryString_consultaempresa);
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
        <form action="filtroeliminarDepar.php" method="post" name="enviodepa" target="modidepa" id="enviodepa">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <iframe src="filtroeliminaproducto.php" name="modiprodu" width="830" height="200" align="middle" scrolling="Auto" frameborder="0" id="modiprodu"></iframe>
<p><a href="<?php printf("%s?pageNum_consultaempresa=%d%s", $currentPage, 0, $queryString_consultaempresa); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaempresa=%d%s", $currentPage, max(0, $pageNum_consultaempresa - 1), $queryString_consultaempresa); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaempresa=%d%s", $currentPage, min($totalPages_consultaempresa, $pageNum_consultaempresa + 1), $queryString_consultaempresa); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaempresa=%d%s", $currentPage, $totalPages_consultaempresa, $queryString_consultaempresa); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></p>
                <table width="830" border="1">
                  <tr>
                    <td colspan="2"><input type="text" name="root" id="root" />
                      <input type="submit" name="filtrar" id="filtrar" value="Filtrar" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>Modificar</td>
                    <td>Id del Departamento</td>
                    <td>Nombre del Departamento</td>
                    <td>Numero de Telefono</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="javascript:;" onclick="aviso('eliminarDepartamento.php?root=<?php echo $row_filtradodepartamento['IDDEPTO']; ?>; return false;">Eliminar</a></td>
                      <td><?php echo $row_consultaempresa['IDDEPTO']; ?></td>
                      <td><?php echo $row_consultaempresa['DEPARTAMENTO']; ?></td>
                      <td><?php echo $row_consultaempresa['NUMEROTELEFONO']; ?></td>
                      </tr>
                    <?php } while ($row_consultaempresa = mysql_fetch_assoc($consultaempresa)); ?>
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
mysql_free_result($consultaempresa);

mysql_free_result($consultaProducto);
?>
