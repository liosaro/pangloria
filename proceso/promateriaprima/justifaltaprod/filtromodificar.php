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

$maxRows_filtrojus = 10;
$pageNum_filtrojus = 0;
if (isset($_GET['pageNum_filtrojus'])) {
  $pageNum_filtrojus = $_GET['pageNum_filtrojus'];
}
$startRow_filtrojus = $pageNum_filtrojus * $maxRows_filtrojus;

$colname_filtrojus = "-1";
if (isset($_POST['filtrojusti'])) {
  $colname_filtrojus = $_POST['filtrojusti'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrojus = sprintf("SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO WHERE ID_JUSTIFICACION LIKE %s ORDER BY ID_JUSTIFICACION ASC", GetSQLValueString("%" . $colname_filtrojus . "%", "text"));
$query_limit_filtrojus = sprintf("%s LIMIT %d, %d", $query_filtrojus, $startRow_filtrojus, $maxRows_filtrojus);
$filtrojus = mysql_query($query_limit_filtrojus, $basepangloria) or die(mysql_error());
$row_filtrojus = mysql_fetch_assoc($filtrojus);

if (isset($_GET['totalRows_filtrojus'])) {
  $totalRows_filtrojus = $_GET['totalRows_filtrojus'];
} else {
  $all_filtrojus = mysql_query($query_filtrojus);
  $totalRows_filtrojus = mysql_num_rows($all_filtrojus);
}
$totalPages_filtrojus = ceil($totalRows_filtrojus/$maxRows_filtrojus)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body><iframe src="" width="820" height="400" scrolling="auto"></iframe>
<p>&nbsp;</p>
<table border="0">
  <tr>
    <td>Modificacion</td>
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
      <td>Modificar</td>
      <td><?php echo $row_filtrojus['ID_JUSTIFICACION']; ?></td>
      <td><?php echo $row_filtrojus['IDCONTROLPRODUCCION']; ?></td>
      <td><?php echo $row_filtrojus['CANTIDA_FALTANTE']; ?></td>
      <td><?php echo $row_filtrojus['IDPRODUCTOFALTA']; ?></td>
      <td><?php echo $row_filtrojus['ID_MEDIDA']; ?></td>
      <td><?php echo $row_filtrojus['FECHAINGRESOJUSFAPROD']; ?></td>
      <td><?php echo $row_filtrojus['JUSTIFICACIONFALTAPROD']; ?></td>
    </tr>
    <?php } while ($row_filtrojus = mysql_fetch_assoc($filtrojus)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtrojus);
?>
