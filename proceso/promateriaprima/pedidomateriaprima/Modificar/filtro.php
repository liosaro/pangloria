<?php require_once('../../../../Connections/basepangloria.php'); ?>
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
$query_disponibl = "SELECT * FROM TRNENCABEZADOPEDMATPRI where ELIMINA=0 and EDITA =0 ORDER BY ID_ENCAPEDIDO DESC";
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

mysql_select_db($database_basepangloria, $basepangloria);
$query_COMBO = "SELECT ID_ENCAPEDIDO FROM TRNENCABEZADOPEDMATPRI WHERE ELIMINA = 0 AND EDITA = 0";
$COMBO = mysql_query($query_COMBO, $basepangloria) or die(mysql_error());
$row_COMBO = mysql_fetch_assoc($COMBO);
$totalRows_COMBO = mysql_num_rows($COMBO);



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
<link href="../../../../css/forms.css" rel="stylesheet" type="text/css" />
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
    <option value="<?php echo $row_COMBO['ID_ENCAPEDIDO']?>"><?php echo $row_COMBO['ID_ENCAPEDIDO']?></option>
    <?php
} while ($row_COMBO = mysql_fetch_assoc($COMBO));
  $rows = mysql_num_rows($COMBO);
  if($rows > 0) {
      mysql_data_seek($COMBO, 0);
	  $row_COMBO = mysql_fetch_assoc($COMBO);
  }
?>
  </select>
</p>
<table width="820" border="0">
  <tr>
    <td align="left"><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, 0, $queryString_disponibl); ?>"><img src="../../../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, max(0, $pageNum_disponibl - 1), $queryString_disponibl); ?>"><img src="../../../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, min($totalPages_disponibl, $pageNum_disponibl + 1), $queryString_disponibl); ?>"><img src="../../../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_disponibl=%d%s", $currentPage, $totalPages_disponibl, $queryString_disponibl); ?>"><img src="../../../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></td>
    <td align="left">&nbsp;
Registros <?php echo ($startRow_disponibl + 1) ?> a <?php echo min($startRow_disponibl + $maxRows_disponibl, $totalRows_disponibl) ?> de <?php echo $totalRows_disponibl ?></td>
  </tr>
  <tr>
    <td colspan="2"><table border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#000000" class="retabla"><span class="retabla">Pedido de Materia Prima No.</span></td>
        <td bgcolor="#000000" class="retabla"><span class="retabla">Codigo de Empleado que pidio</span></td>
        <td bgcolor="#000000" class="retabla"><span class="retabla">Orden de Produccion</span></td>
        <td bgcolor="#000000" class="retabla"><span class="retabla">Fecha</span></td>
        <td>Modificar</td>
      </tr>
      <?php do { ?>
      <?php mysql_select_db($database_basepangloria, $basepangloria);
	  $suc = $row_disponibl['IDEMPLEADO'];
$query_sucur = "SELECT NOMBREEMPLEADO FROM CATEMPLEADO WHERE  IDEMPLEADO = '$suc'";
$sucur = mysql_query($query_sucur, $basepangloria) or die(mysql_error());
$row_sucur = mysql_fetch_assoc($sucur);
$totalRows_sucur = mysql_num_rows($sucur);?>
      <tr >
        <td bgcolor="#CCCCCC" ><?php echo $row_disponibl['ID_ENCAPEDIDO']; ?></td>
        <td bgcolor="#999999"><?php echo $row_sucur['NOMBREEMPLEADO']; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row_disponibl['IDORDENPRODUCCION']; ?></td>
        <td bgcolor="#999999"><?php echo $row_disponibl['FECHA']; ?></td>
        <td align="right"><a href="modi.php?enca=<?php echo $row_disponibl['ID_ENCAPEDIDO']; ?>" target="_self"><img src="../../../../imagenes/icono/modi.png" width="32" height="32" /></a></td>
      </tr>
      <?php } while ($row_disponibl = mysql_fetch_assoc($disponibl)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($disponibl);

mysql_free_result($COMBO);

mysql_free_result($sucur);
?>
