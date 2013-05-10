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

$maxRows_ConsultProveedor = 10;
$pageNum_ConsultProveedor = 0;
if (isset($_GET['pageNum_ConsultProveedor'])) {
  $pageNum_ConsultProveedor = $_GET['pageNum_ConsultProveedor'];
}
$startRow_ConsultProveedor = $pageNum_ConsultProveedor * $maxRows_ConsultProveedor;

mysql_select_db($database_basepangloria, $basepangloria);
$query_ConsultProveedor = "SELECT * FROM CATPROVEEDOR ORDER BY IDPROVEEDOR ASC";
$query_limit_ConsultProveedor = sprintf("%s LIMIT %d, %d", $query_ConsultProveedor, $startRow_ConsultProveedor, $maxRows_ConsultProveedor);
$ConsultProveedor = mysql_query($query_limit_ConsultProveedor, $basepangloria) or die(mysql_error());
$row_ConsultProveedor = mysql_fetch_assoc($ConsultProveedor);

if (isset($_GET['totalRows_ConsultProveedor'])) {
  $totalRows_ConsultProveedor = $_GET['totalRows_ConsultProveedor'];
} else {
  $all_ConsultProveedor = mysql_query($query_ConsultProveedor);
  $totalRows_ConsultProveedor = mysql_num_rows($all_ConsultProveedor);
}
$totalPages_ConsultProveedor = ceil($totalRows_ConsultProveedor/$maxRows_ConsultProveedor)-1;

$queryString_ConsultProveedor = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ConsultProveedor") == false && 
        stristr($param, "totalRows_ConsultProveedor") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ConsultProveedor = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ConsultProveedor = sprintf("&totalRows_ConsultProveedor=%d%s", $totalRows_ConsultProveedor, $queryString_ConsultProveedor);
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
   <td align="center" bgcolor="#999999"><h1>Consultar Proveedores</h1></td>
  </tr>
 <tr>
    <td><iframe src="../../index.php" width="820" scrolling="no"></iframe></td>
 </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
     <label for="root"></label>
     <input type="text" name="root" id="root" />
     <input type="submit" name="enviar" id="enviar" value="filtrar" />
   </form></td>
  </tr>
 <tr>
   <td><form id="form2" name="form2" method="post" action="">
     <a href="<?php printf("%s?pageNum_ConsultProveedor=%d%s", $currentPage, 0, $queryString_ConsultProveedor); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_ConsultProveedor=%d%s", $currentPage, max(0, $pageNum_ConsultProveedor - 1), $queryString_ConsultProveedor); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_ConsultProveedor=%d%s", $currentPage, min($totalPages_ConsultProveedor, $pageNum_ConsultProveedor + 1), $queryString_ConsultProveedor); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_ConsultProveedor=%d%s", $currentPage, $totalPages_ConsultProveedor, $queryString_ConsultProveedor); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
       <tr>
          <td align="center">Eliminacion</td>
          <td align="center">Modificacion</td>
          <td align="center">Id Proveedor</td>
          <td align="center">Pais</td>
          <td align="center">Nombre del Proveedor</td>
          <td align="center">Direccion del Proveedor</td>
          <td align="center">Telefono del Proveedor</td>
          <td align="center">Correo del Proveedor</td>
          <td align="center">Fecha de Ingreso del Proveedor</td>
          <td align="center">Giro</td>
          <td align="center">Numero de Registro</td>
          <td align="center">Web</td>
          <td align="center">Departamento del Pais del Proveedor</td>
       </tr>
       <?php do { ?>
          <tr>
            <td><a href="eliminar_proveedor.php?IDPROVEEDOR=&lt;php?">Eliminar</a></td>
           <td><a href="modificar_proveedor.php?IDPROVEEDOR=<?php echo $row_ConsultProveedor['IDPROVEEDOR'];?>">Modificar</a></td>
            <td><?php echo $row_ConsultProveedor['IDPROVEEDOR']; ?></td>
            <td><?php echo $row_ConsultProveedor['IDPAIS']; ?></td>
            <td><?php echo $row_ConsultProveedor['NOMBREPROVEEDOR']; ?></td>
            <td><?php echo $row_ConsultProveedor['DIRECCIONPROVEEDOR']; ?></td>
            <td><?php echo $row_ConsultProveedor['TELEFONOPROVEEDOR']; ?></td>
           <td><?php echo $row_ConsultProveedor['CORREOPROVEEDOR']; ?></td>
            <td><?php echo $row_ConsultProveedor['FECHAINGRESOPROVE']; ?></td>
            <td><?php echo $row_ConsultProveedor['GIRO']; ?></td>
            <td><?php echo $row_ConsultProveedor['NUMEROREGISTRO']; ?></td>
          <td><?php echo $row_ConsultProveedor['WEB']; ?></td>
           <td><?php echo $row_ConsultProveedor['DEPTOPAISPROVEEDOR']; ?></td>
       </tr>
        <?php } while ($row_ConsultProveedor = mysql_fetch_assoc($ConsultProveedor)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($ConsultProveedor);
?>
