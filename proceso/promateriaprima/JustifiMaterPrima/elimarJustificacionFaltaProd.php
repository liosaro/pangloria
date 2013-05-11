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

$maxRows_eliminarju = 10;
$pageNum_eliminarju = 0;
if (isset($_GET['pageNum_eliminarju'])) {
  $pageNum_eliminarju = $_GET['pageNum_eliminarju'];
}
$startRow_eliminarju = $pageNum_eliminarju * $maxRows_eliminarju;

mysql_select_db($database_basepangloria, $basepangloria);
$query_eliminarju = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_eliminarju = sprintf("%s LIMIT %d, %d", $query_eliminarju, $startRow_eliminarju, $maxRows_eliminarju);
$eliminarju = mysql_query($query_limit_eliminarju, $basepangloria) or die(mysql_error());
$row_eliminarju = mysql_fetch_assoc($eliminarju);

if (isset($_GET['totalRows_eliminarju'])) {
  $totalRows_eliminarju = $_GET['totalRows_eliminarju'];
} else {
  $all_eliminarju = mysql_query($query_eliminarju);
  $totalRows_eliminarju = mysql_num_rows($all_eliminarju);
}
$totalPages_eliminarju = ceil($totalRows_eliminarju/$maxRows_eliminarju)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Eliminar Justificacion de Falta de Producto</h1></td>
  </tr>
</table>
<table border="1">
  <tr>
    <td>modificacion</td>
    <td>ID_JUSTIFICACION</td>
    <td>IDCONTROLPRODUCCION</td>
    <td>CANTIDA_FALTANTE</td>
    <td>IDPRODUCTOFALTA</td>
    <td>ID_MEDIDA</td>
    <td>FECHAINGRESOJUSFAPROD</td>
    <td>JUSTIFICACIONFALTAPROD</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminaPermiso.php?root=<?php echo $row_consultapermi['IDPERMISO'];?>'); return false;">Eliminar</a></td>
      <td><?php echo $row_eliminarju['ID_JUSTIFICACION']; ?></td>
      <td><?php echo $row_eliminarju['IDCONTROLPRODUCCION']; ?></td>
      <td><?php echo $row_eliminarju['CANTIDA_FALTANTE']; ?></td>
      <td><?php echo $row_eliminarju['IDPRODUCTOFALTA']; ?></td>
      <td><?php echo $row_eliminarju['ID_MEDIDA']; ?></td>
      <td><?php echo $row_eliminarju['FECHAINGRESOJUSFAPROD']; ?></td>
      <td><?php echo $row_eliminarju['JUSTIFICACIONFALTAPROD']; ?></td>
    </tr>
    <?php } while ($row_eliminarju = mysql_fetch_assoc($eliminarju)); ?>
</table>
<table width="820" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($eliminarju);
?>
