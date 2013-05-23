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

$maxRows_consulmatpri = 10;
$pageNum_consulmatpri = 0;
if (isset($_GET['pageNum_consulmatpri'])) {
  $pageNum_consulmatpri = $_GET['pageNum_consulmatpri'];
}
$startRow_consulmatpri = $pageNum_consulmatpri * $maxRows_consulmatpri;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulmatpri = "SELECT * FROM TRNPEDIDO_MAT_PRIMA";
$query_limit_consulmatpri = sprintf("%s LIMIT %d, %d", $query_consulmatpri, $startRow_consulmatpri, $maxRows_consulmatpri);
$consulmatpri = mysql_query($query_limit_consulmatpri, $basepangloria) or die(mysql_error());
$row_consulmatpri = mysql_fetch_assoc($consulmatpri);

if (isset($_GET['totalRows_consulmatpri'])) {
  $totalRows_consulmatpri = $_GET['totalRows_consulmatpri'];
} else {
  $all_consulmatpri = mysql_query($query_consulmatpri);
  $totalRows_consulmatpri = mysql_num_rows($all_consulmatpri);
}
$totalPages_consulmatpri = ceil($totalRows_consulmatpri/$maxRows_consulmatpri)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820">
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Modificar</td>
          <td>Eliminar</td>
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
            <td><a href="detallemodificar-6.php">modificar </td>
            <td>eliminar</td>
            <td><?php echo $row_consulmatpri['ID_PED_MAT_PRIMA']; ?></td>
            <td><?php echo $row_consulmatpri['ID_ENCAPEDIDO']; ?></td>
            <td><?php echo $row_consulmatpri['IDUNIDAD']; ?></td>
            <td><?php echo $row_consulmatpri['IDMATPRIMA']; ?></td>
            <td><?php echo $row_consulmatpri['CANTIDADPEDMATPRI']; ?></td>
            <td><?php echo $row_consulmatpri['ELIMIN']; ?></td>
            <td><?php echo $row_consulmatpri['EDITA']; ?></td>
          </tr>
          <?php } while ($row_consulmatpri = mysql_fetch_assoc($consulmatpri)); ?>
    </table></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
</form>
</body>
</html>
<?php
mysql_free_result($consulmatpri);
?>
