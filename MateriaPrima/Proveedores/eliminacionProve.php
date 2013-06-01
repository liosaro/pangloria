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

$maxRows_elimiProve = 10;
$pageNum_elimiProve = 0;
if (isset($_GET['pageNum_elimiProve'])) {
  $pageNum_elimiProve = $_GET['pageNum_elimiProve'];
}
$startRow_elimiProve = $pageNum_elimiProve * $maxRows_elimiProve;

mysql_select_db($database_basepangloria, $basepangloria);
$query_elimiProve = "SELECT * FROM CATPROVEEDOR ORDER BY IDPROVEEDOR ASC";
$query_limit_elimiProve = sprintf("%s LIMIT %d, %d", $query_elimiProve, $startRow_elimiProve, $maxRows_elimiProve);
$elimiProve = mysql_query($query_limit_elimiProve, $basepangloria) or die(mysql_error());
$row_elimiProve = mysql_fetch_assoc($elimiProve);

if (isset($_GET['totalRows_elimiProve'])) {
  $totalRows_elimiProve = $_GET['totalRows_elimiProve'];
} else {
  $all_elimiProve = mysql_query($query_elimiProve);
  $totalRows_elimiProve = mysql_num_rows($all_elimiProve);
}
$totalPages_elimiProve = ceil($totalRows_elimiProve/$maxRows_elimiProve)-1;

$queryString_elimiProve = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_elimiProve") == false && 
        stristr($param, "totalRows_elimiProve") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_elimiProve = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_elimiProve = sprintf("&totalRows_elimiProve=%d%s", $totalRows_elimiProve, $queryString_elimiProve);
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
  <tr></tr>
<tr>
  <td><iframe src="filtroeliminacionProve.php" name="conten" width="820" height="400" scrolling="auto" id="conten"></iframe>&nbsp;</td>
</tr>
<tr>
  <td><a href="<?php printf("%s?pageNum_elimiProve=%d%s", $currentPage, 0, $queryString_elimiProve); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_elimiProve=%d%s", $currentPage, max(0, $pageNum_elimiProve - 1), $queryString_elimiProve); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_elimiProve=%d%s", $currentPage, min($totalPages_elimiProve, $pageNum_elimiProve + 1), $queryString_elimiProve); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_elimiProve=%d%s", $currentPage, $totalPages_elimiProve, $queryString_elimiProve); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
</tr>
<tr>
  <td><form id="form1" name="form1" method="post" action="filtroeliminacionProve.php">
    <label for="filtroProve"></label>
    <input type="text" name="filtroProve" id="filtroProve" />
    <input type="submit" name="button" id="button" value="Enviar" />
  </form></td>
</tr>
<tr>
  <td><table border="1">
    <tr>
      <td>Eliminar</td>
      <td>IDPROVEEDOR</td>
      <td>IDPAIS</td>
      <td>NOMBREPROVEEDOR</td>
      <td>DIRECCIONPROVEEDOR</td>
      <td>TELEFONOPROVEEDOR</td>
      <td>CORREOPROVEEDOR</td>
      <td>FECHAINGRESOPROVE</td>
      <td>GIRO</td>
      <td>NUMEROREGISTRO</td>
      <td>WEB</td>
      <td>DEPTOPAISPROVEEDOR</td>
      <td>ELIMIN</td>
      <td>EDITA</td>
      </tr>
    <?php do { ?>
      <tr>
        <td><a href="javascript:;" onclick="aviso('eliminarpro.php?root=<?php echo $row_elimiProve['IDPROVEEDOR']; ?>'); return false;">Eliminar</a></td>
        <td><?php echo $row_elimiProve['IDPROVEEDOR']; ?></td>
        <td><?php echo $row_elimiProve['IDPAIS']; ?></td>
        <td><?php echo $row_elimiProve['NOMBREPROVEEDOR']; ?></td>
        <td><?php echo $row_elimiProve['DIRECCIONPROVEEDOR']; ?></td>
        <td><?php echo $row_elimiProve['TELEFONOPROVEEDOR']; ?></td>
        <td><?php echo $row_elimiProve['CORREOPROVEEDOR']; ?></td>
        <td><?php echo $row_elimiProve['FECHAINGRESOPROVE']; ?></td>
        <td><?php echo $row_elimiProve['GIRO']; ?></td>
        <td><?php echo $row_elimiProve['NUMEROREGISTRO']; ?></td>
        <td><?php echo $row_elimiProve['WEB']; ?></td>
        <td><?php echo $row_elimiProve['DEPTOPAISPROVEEDOR']; ?></td>
        <td><?php echo $row_elimiProve['ELIMIN']; ?></td>
        <td><?php echo $row_elimiProve['EDITA']; ?></td>
        </tr>
      <?php } while ($row_elimiProve = mysql_fetch_assoc($elimiProve)); ?>
    </table></td>
</tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($elimiProve);
?>
