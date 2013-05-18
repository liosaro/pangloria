<?php require_once('../../Connections/basepangloria.php'); ?>
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

$maxRows_departamento = 10;
$pageNum_departamento = 0;
if (isset($_GET['pageNum_departamento'])) {
  $pageNum_departamento = $_GET['pageNum_departamento'];
}
$startRow_departamento = $pageNum_departamento * $maxRows_departamento;

mysql_select_db($database_basepangloria, $basepangloria);
$query_departamento = "SELECT * FROM CATDEPARTAMENEMPRESA";
$query_limit_departamento = sprintf("%s LIMIT %d, %d", $query_departamento, $startRow_departamento, $maxRows_departamento);
$departamento = mysql_query($query_limit_departamento, $basepangloria) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);

if (isset($_GET['totalRows_departamento'])) {
  $totalRows_departamento = $_GET['totalRows_departamento'];
} else {
  $all_departamento = mysql_query($query_departamento);
  $totalRows_departamento = mysql_num_rows($all_departamento);
}
$totalPages_departamento = ceil($totalRows_departamento/$maxRows_departamento)-1;$maxRows_departamento = 10;
$pageNum_departamento = 0;
if (isset($_GET['pageNum_departamento'])) {
  $pageNum_departamento = $_GET['pageNum_departamento'];
}
$startRow_departamento = $pageNum_departamento * $maxRows_departamento;

mysql_select_db($database_basepangloria, $basepangloria);
$query_departamento = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO DESC";
$query_limit_departamento = sprintf("%s LIMIT %d, %d", $query_departamento, $startRow_departamento, $maxRows_departamento);
$departamento = mysql_query($query_limit_departamento, $basepangloria) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);

if (isset($_GET['totalRows_departamento'])) {
  $totalRows_departamento = $_GET['totalRows_departamento'];
} else {
  $all_departamento = mysql_query($query_departamento);
  $totalRows_departamento = mysql_num_rows($all_departamento);
}
$totalPages_departamento = ceil($totalRows_departamento/$maxRows_departamento)-1;

$queryString_departamento = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_departamento") == false && 
        stristr($param, "totalRows_departamento") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_departamento = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_departamento = sprintf("&totalRows_departamento=%d%s", $totalRows_departamento, $queryString_departamento);
$query_departamento = "SELECT * FROM CATDEPARTAMENEMPRESA ORDER BY IDDEPTO DESC";
$departamento = mysql_query($query_departamento, $basepangloria) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
$totalRows_departamento = mysql_num_rows($departamento);
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
    <td><form action="filtroeliminadepar.php" method="post" name="enviomodifica" target="modidepart" id="enviomodifica"><u>
    <iframe src="filtroeliminadepar.php" name="modidepart" width="830" height="200" align="middle" scrolling="NO" frameborder="0" id="modidepart">
    <p id="modidepart">&nbsp;</p>
    </iframe></u>
      <p>&nbsp;</p>
      <p><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, 0, $queryString_departamento); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, max(0, $pageNum_departamento - 1), $queryString_departamento); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, min($totalPages_departamento, $pageNum_departamento + 1), $queryString_departamento); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_departamento=%d%s", $currentPage, $totalPages_departamento, $queryString_departamento); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
      <table border="1">
        <tr>
          <td colspan="4"><label for="textfield"></label>
            <input type="text" name="filtrodepa" id="filtrodepa" />
            <input type="submit" name="filtrar" id="filtrar" value="Filtrar" /></td>
          </tr>
        <tr>
          <td>Modificando </td>
          <td>IDDEPTO</td>
          <td>DEPARTAMENTO</td>
          <td>NUMEROTELEFONO</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="javascript:;" onclick="aviso('eliminarDepartamento.php?root=<?php echo $row_departamento['IDDEPTO'];?>'); return false;">Eliminar</a></td>
            <td><?php echo $row_departamento['IDDEPTO']; ?></td>
            <td><?php echo $row_departamento['DEPARTAMENTO']; ?></td>
            <td><?php echo $row_departamento['NUMEROTELEFONO']; ?></td>
          </tr>
          <?php } while ($row_departamento = mysql_fetch_assoc($departamento)); ?>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($departamento);

mysql_free_result($departamento);
?>
