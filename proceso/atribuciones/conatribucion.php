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

$maxRows_consultaatribuciones = 10;
$pageNum_consultaatribuciones = 0;
if (isset($_GET['pageNum_consultaatribuciones'])) {
  $pageNum_consultaatribuciones = $_GET['pageNum_consultaatribuciones'];
}
$startRow_consultaatribuciones = $pageNum_consultaatribuciones * $maxRows_consultaatribuciones;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaatribuciones = "SELECT * FROM CATATRIBUCIONES ORDER BY ID_ATRIB DESC";
$query_limit_consultaatribuciones = sprintf("%s LIMIT %d, %d", $query_consultaatribuciones, $startRow_consultaatribuciones, $maxRows_consultaatribuciones);
$consultaatribuciones = mysql_query($query_limit_consultaatribuciones, $basepangloria) or die(mysql_error());
$row_consultaatribuciones = mysql_fetch_assoc($consultaatribuciones);

if (isset($_GET['totalRows_consultaatribuciones'])) {
  $totalRows_consultaatribuciones = $_GET['totalRows_consultaatribuciones'];
} else {
  $all_consultaatribuciones = mysql_query($query_consultaatribuciones);
  $totalRows_consultaatribuciones = mysql_num_rows($all_consultaatribuciones);
}
$totalPages_consultaatribuciones = ceil($totalRows_consultaatribuciones/$maxRows_consultaatribuciones)-1;
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
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td bgcolor="#999999">Detalle de Consulta de Atribuciones</td>
          </tr>
        <tr>
          <td><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
          </tr>
        <tr>
          <td>&nbsp;
            <table border="1">
              <tr>
                <td><strong>Id Atribuciones</strong></td>
                <td><strong>Codigo Usuario</strong></td>
                <td><strong>Codigo Rol</strong></td>
                <td><strong>Codigo Permiso</strong></td>
                <td><strong>C</strong></td>
                <td><strong>R</strong></td>
                <td><strong>U</strong></td>
                <td><strong>D</strong></td>
                </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_consultaatribuciones['ID_ATRIB']; ?></td>
                  <td><?php echo $row_consultaatribuciones['IDUSUARIO']; ?></td>
                  <td><?php echo $row_consultaatribuciones['IDROL']; ?></td>
                  <td><?php echo $row_consultaatribuciones['IDPERMISO']; ?></td>
                  <td><?php echo $row_consultaatribuciones['C']; ?></td>
                  <td><?php echo $row_consultaatribuciones['R']; ?></td>
                  <td><?php echo $row_consultaatribuciones['U']; ?></td>
                  <td><?php echo $row_consultaatribuciones['D']; ?></td>
                  </tr>
                <?php } while ($row_consultaatribuciones = mysql_fetch_assoc($consultaatribuciones)); ?>
            </table></td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($consultaatribuciones);
?>
