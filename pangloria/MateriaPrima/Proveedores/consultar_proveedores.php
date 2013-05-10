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

$maxRows_consultar_proveedores = 5;
$pageNum_consultar_proveedores= 0;
if (isset($_GET['pageNum_consultar_proveedores'])) {
  $pageNum_consultar_proveedores = $_GET['pageNum_consultar_proveedores'];
}
$startRow_consultar_proveedores = $pageNum_consultar_proveedores * $maxRows_consultar_proveedores;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultar_proveedores = "SELECT * FROM CATPROVEEDOR ORDER BY IDPROVEEDOR DESC";
$query_limit_consultar_proveedores = sprintf("%s LIMIT %d, %d", $query_consultar_proveedores, $startRow_consultar_proveedores, $maxRows_consultar_proveedores);
$consultar_proveedores = mysql_query($query_limit_consultar_proveedores, $basepangloria) or die(mysql_error());
$row_consultar_proveedores = mysql_fetch_assoc($consultar_proveedores);

if (isset($_GET['totalRows_consultar_proveedores'])) {
  $totalRows_consultar_proveedores = $_GET['totalRows_consultar_proveedores'];
} else {
  $all_consultar_proveedores = mysql_query($query_consultar_proveedores);
  $totalRows_consultar_proveedores = mysql_num_rows($all_consultar_proveedores);
}
$totalPages_consultar_proveedores = ceil($totalRows_consultar_proveedores/$maxRows_consultar_proveedores)-1;

$colname_modificar_proveedor = "-1";
if (isset($_GET['IDPROVEEDOR'])) {
  $colname_modificar_proveedor = $_GET['IDPROVEEDOR'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modificar_proveedor = sprintf("SELECT * FROM CATPROVEEDOR WHERE IDPROVEEDOR = %s", GetSQLValueString($colname_modificar_proveedor, "int"));
$modificar_proveedor = mysql_query($query_modificar_proveedor, $basepangloria) or die(mysql_error());
$row_modificar_proveedor = mysql_fetch_assoc($modificar_proveedor);
$totalRows_modificar_proveedor = mysql_num_rows($modificar_proveedor);

$queryString_consultar_proveedores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultar_proveedores") == false && 
        stristr($param, "totalRows_consultar_proveedores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultar_proveedores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultar_proveedores = sprintf("&totalRows_consultar_proveedores=%d%s", $totalRows_consultar_proveedores, $queryString_consultar_proveedores);

$queryString_consultar_proveedores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultar_proveedores") == false && 
        stristr($param, "totalRows_consultar_proveedores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultar_proveedores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultar_proveedores = sprintf("&totalRows_consultar_proveedores=%d%s", $totalRows_consultar_proveedores, $queryString_consultar_proveedores);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Proveedores</title>
<link href="../../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content" id="contenidoadminphp2">
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="844" align="center"><div class="cont">
        <form action="filtromodificaproveedores.php" method="post" name="envioproveedoresmodifica" target="modiprovee" id="envioproveedoresmodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <p><a href="<?php printf("%s?pageNum_consultar_proveedores=%d%s", $currentPage, 0, $queryString_consultar_proveedores); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultar_proveedores=%d%s", $currentPage, max(0, $pageNum_consultar_proveedores - 1), $queryString_consultar_proveedores); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultar_proveedores=%d%s", $currentPage, min($totalPages_consultar_proveedores, $pageNum_consultar_proveedores + 1), $queryString_consultar_proveedores); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultar_proveedores=%d%s", $currentPage, $totalPages_consultar_proveedores, $queryString_consultar_proveedores); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a>
                  <iframe src="../cmodproveedores.php" name="modiprovee" width="830" height="400" align="middle" scrolling="auto" frameborder="0" id="modiprovee"></iframe>
                </p>
                <table width="830" border="1">
                  <tr>
                    <td colspan="2"><input type="text" name="filtroprovee" id="filtroprovee" />
                      <input type="submit" name="filtrar" id="filtrar" value="Filtrar" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center">Modificar</td>
                    <td align="center">Id del proveedor</td>
                    <td align="center">pais</td>
                    <td align="center">Nombre del proveedor</td>
                    <td align="center">Direccion del proveedor</td>
                    <td align="center">telefono del proveedor</td>
                    <td align="center">correo del proveedor</td>
                    <td align="center">Fecha de Ingreso del proveedor     </td>
                    <td align="center">Giro</td>
                    <td align="center">Numero de Registro</td>
                    <td align="center">Web</td>
                    <td align="center">Departamento Pais del proveedor</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="consultar_proveedores.php?IDPROVEEDOR=<?php echo $row_consultar_proveedores['IDPROVEEDOR']; ?>" target="modiprovee">Modificar</a></td>
                      <td><?php echo $row_modificar_proveedor['IDPROVEEDOR']; ?></td>
                      <td><?php echo $row_modificar_proveedor['IDPAIS']; ?></td>
                      <td><?php echo $row_modificar_proveedor['NOMBREPROVEEDOR']; ?></td>
                      <td><?php echo $row_modificar_proveedor['DIRECCIONPROVEEDOR']; ?></td>
                      <td><?php echo $row_modificar_proveedor['TELEFONOPROVEEDOR']; ?></td>
                      <td><?php echo $row_modificar_proveedor['CORREOPROVEEDOR']; ?></td>
                      <td><?php echo $row_modificar_proveedor['FECHAINGRESOPROVE']; ?></td>
                      <td><?php echo $row_modificar_proveedor['GIRO']; ?></td>
                      <td><?php echo $row_modificar_proveedor['NUMEROREGISTRO']; ?></td>
                      <td><?php echo $row_modificar_proveedor['WEB']; ?></td>
                      <td><?php echo $row_modificar_proveedor['DEPTOPAISPROVEEDOR']; ?></td>
                      </tr>
                    <?php } while ($row_consultar_proveedores = mysql_fetch_assoc($consultar_proveedores)); ?>
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
mysql_free_result($consultar_proveedores);

mysql_free_result($modificar_proveedor);

mysql_free_result($consultar_proveedores);
?>
