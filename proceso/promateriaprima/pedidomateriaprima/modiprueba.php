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

$maxRows_consulmodipedmatprima = 5;
$pageNum_consulmodipedmatprima = 0;
if (isset($_GET['pageNum_consulmodipedmatprima'])) {
  $pageNum_consulmodipedmatprima = $_GET['pageNum_consulmodipedmatprima'];
}
$startRow_consulmodipedmatprima = $pageNum_consulmodipedmatprima * $maxRows_consulmodipedmatprima;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulmodipedmatprima = "SELECT * FROM TRNPEDIDO_MAT_PRIMA";
$query_limit_consulmodipedmatprima = sprintf("%s LIMIT %d, %d", $query_consulmodipedmatprima, $startRow_consulmodipedmatprima, $maxRows_consulmodipedmatprima);
$consulmodipedmatprima = mysql_query($query_limit_consulmodipedmatprima, $basepangloria) or die(mysql_error());
$row_consulmodipedmatprima = mysql_fetch_assoc($consulmodipedmatprima);

if (isset($_GET['totalRows_consulmodipedmatprima'])) {
  $totalRows_consulmodipedmatprima = $_GET['totalRows_consulmodipedmatprima'];
} else {
  $all_consulmodipedmatprima = mysql_query($query_consulmodipedmatprima);
  $totalRows_consulmodipedmatprima = mysql_num_rows($all_consulmodipedmatprima);
}
$totalPages_consulmodipedmatprima = ceil($totalRows_consulmodipedmatprima/$maxRows_consulmodipedmatprima)-1;
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
    <td>ID_PED_MAT_PRIMA</td>
    <td>ID_ENCAPEDIDO</td>
    <td>IDUNIDAD</td>
    <td>IDMATPRIMA</td>
    <td>CANTIDADPEDMATPRI</td>
    <td>ELIMIN</td>
    <td>EDITA</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_consulmodipedmatprima['ID_PED_MAT_PRIMA']; ?></td>
      <td><?php echo $row_consulmodipedmatprima['ID_ENCAPEDIDO']; ?></td>
      <td><?php echo $row_consulmodipedmatprima['IDUNIDAD']; ?></td>
      <td><?php echo $row_consulmodipedmatprima['IDMATPRIMA']; ?></td>
      <td><?php echo $row_consulmodipedmatprima['CANTIDADPEDMATPRI']; ?></td>
      <td><?php echo $row_consulmodipedmatprima['ELIMIN']; ?></td>
      <td><?php echo $row_consulmodipedmatprima['EDITA']; ?></td>
    </tr>
    <?php } while ($row_consulmodipedmatprima = mysql_fetch_assoc($consulmodipedmatprima)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($consulmodipedmatprima);
?>
