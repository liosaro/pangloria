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

$maxRows_modi = 10;
$pageNum_modi = 0;
if (isset($_GET['pageNum_modi'])) {
  $pageNum_modi = $_GET['pageNum_modi'];
}
$startRow_modi = $pageNum_modi * $maxRows_modi;

mysql_select_db($database_basepangloria, $basepangloria);
$query_modi = "SELECT * FROM CatTipoMatPri ORDER BY IDTIPO ASC";
$query_limit_modi = sprintf("%s LIMIT %d, %d", $query_modi, $startRow_modi, $maxRows_modi);
$modi = mysql_query($query_limit_modi, $basepangloria) or die(mysql_error());
$row_modi = mysql_fetch_assoc($modi);

if (isset($_GET['totalRows_modi'])) {
  $totalRows_modi = $_GET['totalRows_modi'];
} else {
  $all_modi = mysql_query($query_modi);
  $totalRows_modi = mysql_num_rows($all_modi);
}
$totalPages_modi = ceil($totalRows_modi/$maxRows_modi)-1;
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
    <td><iframe src="modificarTipoMat.php" name="conten" width="820" height="400" scrolling="auto" id="conten"></iframe>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
  </tr>
  <tr>
    <td><form action="filtroModiTipoMat.php" method="post" name="form1" target="conten" id="form1">
      <label for="filtrTipo"></label>
      <input type="text" name="filtrTipo" id="filtrTipo" />
      <input type="submit" name="button" id="button" value="Enviar" />
    </form></td>
  </tr>
  <tr>
    <td><table border="1">
        <tr>
          <td>Modificacion</td>
          <td>IDTIPO</td>
          <td>DESCRIPCIONPRODUCTO</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="modificarTipoMat.php?root=<?php echo $row_modi['IDTIPO']; ?>" target="conten">Modificar</a></td>
            <td><?php echo $row_modi['IDTIPO']; ?></td>
            <td><?php echo $row_modi['DESCRIPCIONPRODUCTO']; ?></td>
          </tr>
          <?php } while ($row_modi = mysql_fetch_assoc($modi)); ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($modi);
?>
