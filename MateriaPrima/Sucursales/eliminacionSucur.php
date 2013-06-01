<head>
<script language="JavaScript">
function aviso(url){
if (!confirm("ALERTA!! va a proceder a eliminar este registro, si desea eliminarlo de click en ACEPTAR\n de lo contrario de click en CANCELAR.")) {
return false;
}
else {
document.location = url;
return true;
}
}
</script>
</head>
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

$maxRows_elimisucur = 10;
$pageNum_elimisucur = 0;
if (isset($_GET['pageNum_elimisucur'])) {
  $pageNum_elimisucur = $_GET['pageNum_elimisucur'];
}
$startRow_elimisucur = $pageNum_elimisucur * $maxRows_elimisucur;

mysql_select_db($database_basepangloria, $basepangloria);
$query_elimisucur = "SELECT * FROM CATSUCURSAL ORDER BY IDSUCURSAL ASC";
$query_limit_elimisucur = sprintf("%s LIMIT %d, %d", $query_elimisucur, $startRow_elimisucur, $maxRows_elimisucur);
$elimisucur = mysql_query($query_limit_elimisucur, $basepangloria) or die(mysql_error());
$row_elimisucur = mysql_fetch_assoc($elimisucur);

if (isset($_GET['totalRows_elimisucur'])) {
  $totalRows_elimisucur = $_GET['totalRows_elimisucur'];
} else {
  $all_elimisucur = mysql_query($query_elimisucur);
  $totalRows_elimisucur = mysql_num_rows($all_elimisucur);
}
$totalPages_elimisucur = ceil($totalRows_elimisucur/$maxRows_elimisucur)-1;
?>
<table width="820" border="0">
  <tr>
    <td><iframe src="filtroelimiSucur.php" name="conten" width="820" height="400" scrolling="auto" id="conten"></iframe>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></td>
  </tr>
  <tr>
    <td><form action="filtroelimiSucur.php" method="post" name="form1" target="conten" id="form1">
      <label for="filtrosucu"></label>
      <input type="text" name="filtrosucu" id="filtrosucu" />
      <input type="submit" name="button" id="button" value="Enviar" />
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;
      <table border="1">
        <tr>
          <td>Eliminarcion</td>
          <td>IDSUCURSAL</td>
          <td>NOMBRESUCURSAL</td>
          <td>DIRECCIONSUCURSAL</td>
          <td>TELEFONOSUCURSAL</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="javascript:;" onclick="aviso('eliminarSucur.php?root=<?php echo $row_elimisucur['IDSUCURSAL']; ?>'); return false;">Eliminar</a></td>
            <td><?php echo $row_elimisucur['IDSUCURSAL']; ?></td>
            <td><?php echo $row_elimisucur['NOMBRESUCURSAL']; ?></td>
            <td><?php echo $row_elimisucur['DIRECCIONSUCURSAL']; ?></td>
            <td><?php echo $row_elimisucur['TELEFONOSUCURSAL']; ?></td>
          </tr>
          <?php } while ($row_elimisucur = mysql_fetch_assoc($elimisucur)); ?>
    </table></td>
  </tr>
</table>
<?php
mysql_free_result($elimisucur);
?>
