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

$maxRows_elimina = 10;
$pageNum_elimina = 0;
if (isset($_GET['pageNum_elimina'])) {
  $pageNum_elimina = $_GET['pageNum_elimina'];
}
$startRow_elimina = $pageNum_elimina * $maxRows_elimina;

mysql_select_db($database_basepangloria, $basepangloria);
$query_elimina = "SELECT * FROM CATUSUARIO ORDER BY IDUSUARIO DESC";
$query_limit_elimina = sprintf("%s LIMIT %d, %d", $query_elimina, $startRow_elimina, $maxRows_elimina);
$elimina = mysql_query($query_limit_elimina, $basepangloria) or die(mysql_error());
$row_elimina = mysql_fetch_assoc($elimina);

if (isset($_GET['totalRows_elimina'])) {
  $totalRows_elimina = $_GET['totalRows_elimina'];
} else {
  $all_elimina = mysql_query($query_elimina);
  $totalRows_elimina = mysql_num_rows($all_elimina);
}
$totalPages_elimina = ceil($totalRows_elimina/$maxRows_elimina)-1;

$queryString_elimina = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_elimina") == false && 
        stristr($param, "totalRows_elimina") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_elimina = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_elimina = sprintf("&totalRows_elimina=%d%s", $totalRows_elimina, $queryString_elimina);
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
    <td> <form action="filtrousuario.php" method="post" name="envio" target="modiusu" id="envio"><iframe src="filtrousuario.php" name="modiusu" width="830" height="200" align="middle" scrolling="Auto" frameborder="0" id="modiusu"></iframe>
      <p>&nbsp;</p>
      <table border="1">
        <tr>
          <td colspan="6"><a href="<?php printf("%s?pageNum_elimina=%d%s", $currentPage, 0, $queryString_elimina); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_elimina=%d%s", $currentPage, max(0, $pageNum_elimina - 1), $queryString_elimina); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_elimina=%d%s", $currentPage, min($totalPages_elimina, $pageNum_elimina + 1), $queryString_elimina); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_elimina=%d%s", $currentPage, $totalPages_elimina, $queryString_elimina); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
        </tr>
        <tr>
          <td colspan="6"><label for="textfield"></label>
            <input type="text" name="filtro" id="filtro" />
            <input type="submit" name="button" id="button" value="Enviar" /></td>
          </tr>
        <tr>
          <td>Modificar</td>
          <td>IDUSUARIO</td>
          <td>NOMBREUSUARIO</td>
          <td>CONTRASENA</td>
          <td>PRIMERINICIO</td>
          <td>ULTIMOINICIO</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="javascript:;" onclick="aviso('eliminarconsulta.php?root=<?php echo $row_elimina['IDUSUARIO'];?>');return false;">Eliminar</a></td>
            <td><?php echo $row_elimina['IDUSUARIO']; ?></td>
            <td><?php echo $row_elimina['NOMBREUSUARIO']; ?></td>
            <td><?php echo $row_elimina['CONTRASENA']; ?></td>
            <td><?php echo $row_elimina['PRIMERINICIO']; ?></td>
            <td><?php echo $row_elimina['ULTIMOINICIO']; ?></td>
          </tr>
          <?php } while ($row_elimina = mysql_fetch_assoc($elimina)); ?>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($elimina);
?>
