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

$maxRows_disponibl = 10;
$pageNum_disponibl = 0;
if (isset($_GET['pageNum_disponibl'])) {
  $pageNum_disponibl = $_GET['pageNum_disponibl'];
}
$startRow_disponibl = $pageNum_disponibl * $maxRows_disponibl;

mysql_select_db($database_basepangloria, $basepangloria);
$query_disponibl = "SELECT IDENCABEZADO  FROM TRNENCACONTROLPRODHORNO WHERE ELIMIN=0 ORDER BY IDENCABEZADO  DESC";
$query_limit_disponibl = sprintf("%s LIMIT %d, %d", $query_disponibl, $startRow_disponibl, $maxRows_disponibl);
$disponibl = mysql_query($query_limit_disponibl, $basepangloria) or die(mysql_error());
$row_disponibl = mysql_fetch_assoc($disponibl);

if (isset($_GET['totalRows_disponibl'])) {
  $totalRows_disponibl = $_GET['totalRows_disponibl'];
} else {
  $all_disponibl = mysql_query($query_disponibl);
  $totalRows_disponibl = mysql_num_rows($all_disponibl);
}
$totalPages_disponibl = ceil($totalRows_disponibl/$maxRows_disponibl)-1;

$maxRows_constabla = 10;
$pageNum_constabla = 0;
if (isset($_GET['pageNum_constabla'])) {
  $pageNum_constabla = $_GET['pageNum_constabla'];
}
$startRow_constabla = $pageNum_constabla * $maxRows_constabla;

mysql_select_db($database_basepangloria, $basepangloria);
$query_constabla = "SELECT * FROM TRNENCACONTROLPRODHORNO  WHERE ELIMIN=0 ORDER BY IDENCABEZADO DESC";
$query_limit_constabla = sprintf("%s LIMIT %d, %d", $query_constabla, $startRow_constabla, $maxRows_constabla);
$constabla = mysql_query($query_limit_constabla, $basepangloria) or die(mysql_error());
$row_constabla = mysql_fetch_assoc($constabla);

if (isset($_GET['totalRows_constabla'])) {
  $totalRows_constabla = $_GET['totalRows_constabla'];
} else {
  $all_constabla = mysql_query($query_constabla);
  $totalRows_constabla = mysql_num_rows($all_constabla);
}
$totalPages_constabla = ceil($totalRows_constabla/$maxRows_constabla)-1;



$queryString_disponibl = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_disponibl") == false && 
        stristr($param, "totalRows_disponibl") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_disponibl = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_disponibl = sprintf("&totalRows_disponibl=%d%s", $totalRows_disponibl, $queryString_disponibl);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../css/forms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.retabla {
	text-align: center;
}
</style></head>

<body>
<p>Elija La Orden de Produccion que desea Modificar: 
  <label for="select"></label>
  <select name="select" id="select"   onchange="window.location.href='modi.php?enca='+document.getElementById(this.id).value ;">
    <?php
do {  
?>
    <option value="<?php echo $row_disponibl['IDENCABEZADO']?>"><?php echo $row_disponibl['IDENCABEZADO']?></option>
    <?php
} while ($row_disponibl = mysql_fetch_assoc($disponibl));
  $rows = mysql_num_rows($disponibl);
  if($rows > 0) {
      mysql_data_seek($disponibl, 0);
	  $row_disponibl = mysql_fetch_assoc($disponibl);
  }
?>
  </select>
</p>
<p>Si el Numero de la Orden de produccion que Busca No se Encuentra, fue liminada o ya no puede editarse.</p>
<table width="820" border="0">
  <tr>
    <td align="left"><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, 0, $queryString_disponibl); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, max(0, $pageNum_disponibl - 1), $queryString_disponibl); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, min($totalPages_disponibl, $pageNum_disponibl + 1), $queryString_disponibl); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, $totalPages_disponibl, $queryString_disponibl); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /> Registros <?php echo ($startRow_constabla + 1) ?> a <?php echo min($startRow_constabla + $maxRows_constabla, $totalRows_constabla) ?> de <?php echo $totalRows_constabla ?> </a></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1" cellpadding="0" cellspacing="0">
        <tr class="retabla">
          <td bgcolor="#000000">Control de Producto No.</td>
          <td bgcolor="#000000">Orden de Produccion</td>
          <td bgcolor="#000000">Fecha y Hora</td>
          <td bgcolor="#000000">Codigo de Empleado</td>
          <td bgcolor="#000000">Modificar</td>
        </tr>
        <?php do { ?>
          <tr>
            <td bgcolor="#CCCCCC"><?php echo $row_constabla['IDENCABEZADO']; ?></td>
            <td bgcolor="#999999"><?php echo $row_constabla['IDORDENPRODUCCION']; ?></td>
            <td bgcolor="#CCCCCC"><?php echo $row_constabla['FECHAYHORADEINGRESO']; ?></td>
            <td bgcolor="#999999"><?php echo $row_constabla['EMPLEADEREVISA']; ?></td>
            <td align="center"><a href="../produccion/controlhorno/Modificacion/modi.php?enca=<?php echo $row_constabla['IDENCABEZADO']; ?>" target="_self"><img src="../../imagenes/icono/modi.png" width="32" height="32" /></a></td>
          </tr>
          <?php } while ($row_constabla = mysql_fetch_assoc($constabla)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($disponibl);

mysql_free_result($constabla);

mysql_free_result($sucur);
?>
