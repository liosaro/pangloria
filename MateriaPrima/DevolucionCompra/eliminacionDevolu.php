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

$maxRows_devo = 10;
$pageNum_devo = 0;
if (isset($_GET['pageNum_devo'])) {
  $pageNum_devo = $_GET['pageNum_devo'];
}
$startRow_devo = $pageNum_devo * $maxRows_devo;

mysql_select_db($database_basepangloria, $basepangloria);
$query_devo = "SELECT * FROM TRNDEVOLUCIONCOMPRA ORDER BY IDDEVOLUCION ASC";
$query_limit_devo = sprintf("%s LIMIT %d, %d", $query_devo, $startRow_devo, $maxRows_devo);
$devo = mysql_query($query_limit_devo, $basepangloria) or die(mysql_error());
$row_devo = mysql_fetch_assoc($devo);

if (isset($_GET['totalRows_devo'])) {
  $totalRows_devo = $_GET['totalRows_devo'];
} else {
  $all_devo = mysql_query($query_devo);
  $totalRows_devo = mysql_num_rows($all_devo);
}
$totalPages_devo = ceil($totalRows_devo/$maxRows_devo)-1;

$queryString_devo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_devo") == false && 
        stristr($param, "totalRows_devo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_devo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_devo = sprintf("&totalRows_devo=%d%s", $totalRows_devo, $queryString_devo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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
    <td><form action="filtroeliminar.php" method="post" name="eliminadevo" target="eliminar" id="eliminadevo"><iframe src="filtroeliminar.php" name="eliminar" width="820" height="300" scrolling="Auto" id="eliminar"></iframe>
      <p>&nbsp;</p>
      <table border="1">
        <tr>
          <td colspan="8"><a href="<?php printf("%s?pageNum_devo=%d%s", $currentPage, 0, $queryString_devo); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_devo=%d%s", $currentPage, max(0, $pageNum_devo - 1), $queryString_devo); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_devo=%d%s", $currentPage, min($totalPages_devo, $pageNum_devo + 1), $queryString_devo); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_devo=%d%s", $currentPage, $totalPages_devo, $queryString_devo); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
        </tr>
        <tr>
          <td colspan="8"><label for="textfield"></label>
            <input type="text" name="filtrodevolu" id="filtrodevolu" />
            <input type="submit" name="button" id="button" value="Enviar" /></td>
          </tr>
        <tr>
          <td>Eliminar </td>
          <td>IDDEVOLUCION</td>
          <td>IDEMPLEADO</td>
          <td>DOCADEVOLVER</td>
          <td>FECHADEVOLUCION</td>
          <td>IMPORTE</td>
          <td>GASTOGENERADO</td>
          <td>OBSERVACION</td>
          </tr>
        <?php do { ?>
          <tr>
            <td><a href="javascript:;" onclick="aviso('eliminar.php?root=<?php echo $row_devo['IDDEVOLUCION']; ?>'); return false;">Eliminar</a></td>
            <td><?php echo $row_devo['IDDEVOLUCION']; ?></td>
            <td><?php echo $row_devo['IDEMPLEADO']; ?></td>
            <td><?php echo $row_devo['DOCADEVOLVER']; ?></td>
            <td><?php echo $row_devo['FECHADEVOLUCION']; ?></td>
            <td><?php echo $row_devo['IMPORTE']; ?></td>
            <td><?php echo $row_devo['GASTOGENERADO']; ?></td>
            <td><?php echo $row_devo['OBSERVACION']; ?></td>
            </tr>
          <?php } while ($row_devo = mysql_fetch_assoc($devo)); ?>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($devo);
?>
