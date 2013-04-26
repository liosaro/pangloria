<?php require_once('../Connections/basepangloria.php'); ?>
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

$maxRows_consultaproducto = 10;
$pageNum_consultaproducto = 0;
if (isset($_GET['pageNum_consultaproducto'])) {
  $pageNum_consultaproducto = $_GET['pageNum_consultaproducto'];
}
$startRow_consultaproducto = $pageNum_consultaproducto * $maxRows_consultaproducto;

$colname_consultaproducto = "-1";
if (isset($_POST['filtrnomproduc'])) {
  $colname_consultaproducto = $_POST['filtrnomproduc'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consultaproducto = sprintf("SELECT * FROM CATPRODUCTO WHERE DESCRIPCIONPRODUC LIKE %s ORDER BY IDPRODUCTO DESC", GetSQLValueString("%" . $colname_consultaproducto . "%", "text"));
$query_limit_consultaproducto = sprintf("%s LIMIT %d, %d", $query_consultaproducto, $startRow_consultaproducto, $maxRows_consultaproducto);
$consultaproducto = mysql_query($query_limit_consultaproducto, $basepangloria) or die(mysql_error());
$row_consultaproducto = mysql_fetch_assoc($consultaproducto);

if (isset($_GET['totalRows_consultaproducto'])) {
  $totalRows_consultaproducto = $_GET['totalRows_consultaproducto'];
} else {
  $all_consultaproducto = mysql_query($query_consultaproducto);
  $totalRows_consultaproducto = mysql_num_rows($all_consultaproducto);
}
$totalPages_consultaproducto = ceil($totalRows_consultaproducto/$maxRows_consultaproducto)-1;

$queryString_consultaproducto = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaproducto") == false && 
        stristr($param, "totalRows_consultaproducto") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaproducto = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaproducto = sprintf("&totalRows_consultaproducto=%d%s", $totalRows_consultaproducto, $queryString_consultaproducto);

$queryString_consultaProducto = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultaProducto") == false && 
        stristr($param, "totalRows_consultaProducto") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultaProducto = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultaProducto = sprintf("&totalRows_consultaProducto=%d%s", $totalRows_consultaProducto, $queryString_consultaProducto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Empleados</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content" id="contenidoadminphp2">
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="844" align="center"><div class="cont">
        <form id="envioproductomodifica" name="envioproductomodifica" method="post">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="6">&nbsp;
                <iframe src="cmodproducto.php" name="modiprodu" width="780" height="250" align="middle" scrolling="No" frameborder="0" id="modiprodu"></iframe>
                <table width="100%" border="1">
                  <tr>
                    <td>Modificar</td>
                    <td>Id del producto</td>
                    <td>Nombre del Producto</td>
                    <td>Precio Costo</td>
                    <td>Precio Mayoreo</td>
                    <td>Precio Menudeo</td>
                    <td>Dias Caducidad</td>
                  </tr>
                  <?php do { ?>
                  <tr>
                    <td><a href="cmodproducto.php?root=<?php echo $row_consultaproducto['IDPRODUCTO']; ?>" target="modiprodu">Modificar</a></td>
                    <td><?php echo $row_consultaproducto['IDPRODUCTO']; ?></td>
                    <td><?php echo $row_consultaproducto['DESCRIPCIONPRODUC']; ?></td>
                    <td><?php echo $row_consultaproducto['PRECIO_COSTO']; ?></td>
                    <td><?php echo $row_consultaproducto['PRECIO_VENTAMAYOREO']; ?></td>
                    <td><?php echo $row_consultaproducto['PRECIO_VENTAMENOR']; ?></td>
                    <td><?php echo $row_consultaproducto['DIAS_CADUCIDAD']; ?></td>
                  </tr>
                  <?php } while ($row_consultaproducto = mysql_fetch_assoc($consultaproducto)); ?>
                </table></td>
            </tr>
            <tr>
              <td width="314"><a href="<?php printf("%s?pageNum_consultaproducto=%d%s", $currentPage, 0, $queryString_consultaproducto); ?>"><img src="../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaproducto=%d%s", $currentPage, max(0, $pageNum_consultaproducto - 1), $queryString_consultaproducto); ?>"><img src="../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaproducto=%d%s", $currentPage, min($totalPages_consultaproducto, $pageNum_consultaproducto + 1), $queryString_consultaproducto); ?>"><img src="../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultaproducto=%d%s", $currentPage, $totalPages_consultaproducto, $queryString_consultaproducto); ?>"><img src="../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
              <td width="189">Filtrar Nombre de Producto</td>
              <td width="507"><label for="filtrnomproduc"></label>
                <input name="filtrnomproduc" type="text" id="filtrnomproduc" value="Budin" />
                <input type="button" name="filtrar" id="filtrar" value="filtrar" /></td>
              <td width="42">&nbsp;</td>
              <td width="297"><input type="hidden" name="IDPRODUCTO" /></td>
              <td width="385">&nbsp;</td>
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
mysql_free_result($consultaproducto);

mysql_free_result($consultaProducto);
?>
