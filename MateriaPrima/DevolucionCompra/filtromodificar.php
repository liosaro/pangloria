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

$maxRows_filtrodevolu = 10;
$pageNum_filtrodevolu = 0;
if (isset($_GET['pageNum_filtrodevolu'])) {
  $pageNum_filtrodevolu = $_GET['pageNum_filtrodevolu'];
}
$startRow_filtrodevolu = $pageNum_filtrodevolu * $maxRows_filtrodevolu;

$colname_filtrodevolu = "-1";
if (isset($_POST['filtro'])) {
  $colname_filtrodevolu = $_POST['filtro'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtrodevolu = sprintf("SELECT * FROM TRNDEVOLUCIONCOMPRA WHERE FECHADEVOLUCION LIKE %s ORDER BY FECHADEVOLUCION ASC", GetSQLValueString("%" . $colname_filtrodevolu . "%", "date"));
$query_limit_filtrodevolu = sprintf("%s LIMIT %d, %d", $query_filtrodevolu, $startRow_filtrodevolu, $maxRows_filtrodevolu);
$filtrodevolu = mysql_query($query_limit_filtrodevolu, $basepangloria) or die(mysql_error());
$row_filtrodevolu = mysql_fetch_assoc($filtrodevolu);

if (isset($_GET['totalRows_filtrodevolu'])) {
  $totalRows_filtrodevolu = $_GET['totalRows_filtrodevolu'];
} else {
  $all_filtrodevolu = mysql_query($query_filtrodevolu);
  $totalRows_filtrodevolu = mysql_num_rows($all_filtrodevolu);
}
$totalPages_filtrodevolu = ceil($totalRows_filtrodevolu/$maxRows_filtrodevolu)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body><iframe src="modificarDevo.php" name="modificar2" width="850" height="400" scrolling="auto"></iframe>
<table border="1">
  <tr>
    <td>Eliminar</td>
    <td>IDDEVOLUCION</td>
    <td>IDEMPLEADO</td>
    <td>DOCADEVOLVER</td>
    <td>FECHADEVOLUCION</td>
    <td>IMPORTE</td>
    <td>GASTOGENERADO</td>
    <td>OBSERVACION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="modificarDevo.php?root=<?php echo $row_filtrodevolu['IDDEVOLUCION']; ?> "target="modificar">Modificar</a></td>
      <td><?php echo $row_filtrodevolu['IDDEVOLUCION']; ?></td>
      <td><?php echo $row_filtrodevolu['IDEMPLEADO']; ?></td>
      <td><?php echo $row_filtrodevolu['DOCADEVOLVER']; ?></td>
      <td><?php echo $row_filtrodevolu['FECHADEVOLUCION']; ?></td>
      <td><?php echo $row_filtrodevolu['IMPORTE']; ?></td>
      <td><?php echo $row_filtrodevolu['GASTOGENERADO']; ?></td>
      <td><?php echo $row_filtrodevolu['OBSERVACION']; ?></td>
    </tr>
    <?php } while ($row_filtrodevolu = mysql_fetch_assoc($filtrodevolu)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtrodevolu);
?>
