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

$maxRows_rol = 10;
$pageNum_rol = 0;
if (isset($_GET['pageNum_rol'])) {
  $pageNum_rol = $_GET['pageNum_rol'];
}
$startRow_rol = $pageNum_rol * $maxRows_rol;

mysql_select_db($database_basepangloria, $basepangloria);
$query_rol = "SELECT * FROM CATROL";
$query_limit_rol = sprintf("%s LIMIT %d, %d", $query_rol, $startRow_rol, $maxRows_rol);
$rol = mysql_query($query_limit_rol, $basepangloria) or die(mysql_error());
$row_rol = mysql_fetch_assoc($rol);

if (isset($_GET['totalRows_rol'])) {
  $totalRows_rol = $_GET['totalRows_rol'];
} else {
  $all_rol = mysql_query($query_rol);
  $totalRows_rol = mysql_num_rows($all_rol);
}
$totalPages_rol = ceil($totalRows_rol/$maxRows_rol)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Consultar Rol</h1></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <label for="txtfiltrar"></label>
      <input type="text" name="txtfiltrar" id="txtfiltrar" />
      <input type="submit" name="btnFiltrar" id="btnFiltrar" value="Filtro" />
    </form></td>
  </tr>
  <tr>
    <td><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Modificar</td>
          <td>Eliminar</td>
          <td>IDROL</td>
          <td>DESCRIPCION</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="modificarRol.php?IDROL=<?php echo $row_rol['IDROL']; ?>">Modificar</a></td>
            <td>Eliminar</td>
            <td><?php echo $row_rol['IDROL']; ?></td>
            <td><?php echo $row_rol['DESCRIPCION']; ?></td>
          </tr>
          <?php } while ($row_rol = mysql_fetch_assoc($rol)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rol);
?>