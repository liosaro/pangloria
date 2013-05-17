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

$maxRows_filtradodepartamento = 10;
$pageNum_filtradodepartamento = 0;
if (isset($_GET['pageNum_filtradodepartamento'])) {
  $pageNum_filtradodepartamento = $_GET['pageNum_filtradodepartamento'];
}
$startRow_filtradodepartamento = $pageNum_filtradodepartamento * $maxRows_filtradodepartamento;

$colname_filtradodepartamento = "-1";
if (isset($_GET['root '])) {
  $colname_filtradodepartamento = $_GET['root '];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_filtradodepartamento = sprintf("SELECT * FROM CATDEPARTAMENEMPRESA WHERE DEPARTAMENTO LIKE %s ORDER BY DEPARTAMENTO ASC", GetSQLValueString("%" . $colname_filtradodepartamento . "%", "text"));
$query_limit_filtradodepartamento = sprintf("%s LIMIT %d, %d", $query_filtradodepartamento, $startRow_filtradodepartamento, $maxRows_filtradodepartamento);
$filtradodepartamento = mysql_query($query_limit_filtradodepartamento, $basepangloria) or die(mysql_error());
$row_filtradodepartamento = mysql_fetch_assoc($filtradodepartamento);

if (isset($_GET['totalRows_filtradodepartamento'])) {
  $totalRows_filtradodepartamento = $_GET['totalRows_filtradodepartamento'];
} else {
  $all_filtradodepartamento = mysql_query($query_filtradodepartamento);
  $totalRows_filtradodepartamento = mysql_num_rows($all_filtradodepartamento);
}
$totalPages_filtradodepartamento = ceil($totalRows_filtradodepartamento/$maxRows_filtradodepartamento)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

</head>

<body>
<table border="1">
  <tr>
    <td>Modificacion</td>
    <td>IDDEPTO</td>
    <td>DEPARTAMENTO</td>
    <td>NUMEROTELEFONO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="javascript:;" onclick="aviso('eliminarDepartamento.php?root=<?php echo $row_filtradodepartamento['IDDEPTO']; ?>; return false;">Eliminar</a></td>
      <td><?php echo $row_filtradodepartamento['IDDEPTO']; ?></td>
      <td><?php echo $row_filtradodepartamento['DEPARTAMENTO']; ?></td>
      <td><?php echo $row_filtradodepartamento['NUMEROTELEFONO']; ?></td>
    </tr>
    <?php } while ($row_filtradodepartamento = mysql_fetch_assoc($filtradodepartamento)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($filtradodepartamento);
?>
