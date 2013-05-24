<?php require_once('../../../Connections/basepangloria.php'); ?>
<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$maxRows_consulta = 10;
$pageNum_consulta = 0;
if (isset($_GET['pageNum_consulta'])) {
  $pageNum_consulta = $_GET['pageNum_consulta'];
}
$startRow_consulta = $pageNum_consulta * $maxRows_consulta;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulta = "SELECT * FROM TRNSALIDA_MAT_PRIM ORDER BY ID_SALIDA DESC";
$query_limit_consulta = sprintf("%s LIMIT %d, %d", $query_consulta, $startRow_consulta, $maxRows_consulta);
$consulta = mysql_query($query_limit_consulta, $basepangloria) or die(mysql_error());
$row_consulta = mysql_fetch_assoc($consulta);

if (isset($_GET['totalRows_consulta'])) {
  $totalRows_consulta = $_GET['totalRows_consulta'];
} else {
  $all_consulta = mysql_query($query_consulta);
  $totalRows_consulta = mysql_num_rows($all_consulta);
}
$totalPages_consulta = ceil($totalRows_consulta/$maxRows_consulta)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_matPri = "SELECT DESCRIPCION FROM CATMATERIAPRIMA";
$matPri = mysql_query($query_matPri, $basepangloria) or die(mysql_error());
$row_matPri = mysql_fetch_assoc($matPri);
$totalRows_matPri = mysql_num_rows($matPri);

mysql_select_db($database_basepangloria, $basepangloria);
$query_unida = "SELECT TIPOUNIDAD FROM CATUNIDADES";
$unida = mysql_query($query_unida, $basepangloria) or die(mysql_error());
$row_unida = mysql_fetch_assoc($unida);
$totalRows_unida = mysql_num_rows($unida);

$queryString_consulta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consulta") == false && 
        stristr($param, "totalRows_consulta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consulta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consulta = sprintf("&totalRows_consulta=%d%s", $totalRows_consulta, $queryString_consulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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
<table width="820" border="0">
  <tr>
    <td><form action="filtroeliminar.php" method="post" name="envio" target="modisalida" id="envio"><iframe src="filtroeliminar.php" name="modisalida" width="830" height="200" align="middle" scrolling="Auto" frameborder="0" id="modisalida"></iframe>
      <p>&nbsp;</p>
      <p><a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, 0, $queryString_consulta); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, max(0, $pageNum_consulta - 1), $queryString_consulta); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, min($totalPages_consulta, $pageNum_consulta + 1), $queryString_consulta); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, $totalPages_consulta, $queryString_consulta); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
      <table border="1">
        <tr>
          <td colspan="6"><label for="filtro"></label>
            <input type="text" name="filtro" id="filtro" />
            <input type="submit" name="filtrar" id="filtrar" value="Filtrar" /></td>
          </tr>
        <tr>
          <td>Eliminancion</td>
          <td>ID_SALIDA</td>
          <td>Cantidad de Materia Prima</td>
          <td>Materia Prima</td>
          <td>id Encabezado Materia Prima </td>
          <td>Unidad </td>
          </tr>
        <?php do { ?>
          <tr>
            <td><a href="javascript:;" onclick="aviso('eliminacion.php?root=<?php echo $row_consulta['ID_SALIDA'];?>'); return false;">Eliminar</a></td>
            <td><?php echo $row_consulta['ID_SALIDA']; ?></td>
            <td><?php echo $row_consulta['CANTMAT_PRIMA']; ?></td>
            <td><?php echo $row_matPri['DESCRIPCION']; ?></td>
            <td><?php echo $row_consulta['IDENCABEZADOSALMATPRI']; ?></td>
            <td><?php echo $row_unida['TIPOUNIDAD']; ?></td>
            </tr>
          <?php } while ($row_consulta = mysql_fetch_assoc($consulta)); ?>
    </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($consulta);

mysql_free_result($matPri);

mysql_free_result($unida);

mysql_free_result($consulta);
?>
