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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE TRNSALIDA_MAT_PRIM SET CANTMAT_PRIMA=%s, ID_MATPRIMA=%s, IDENCABEZADOSALMATPRI=%s, IDUNIDAD=%s, IDDEPTO=%s, FECHAYHORAUSUA=%s, EMPLEADOSACA=%s WHERE ID_SALIDA=%s",
                       GetSQLValueString($_POST['CANTMAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_MATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADOSALMATPRI'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"),
                       GetSQLValueString($_POST['FECHAYHORAUSUA'], "date"),
                       GetSQLValueString($_POST['EMPLEADOSACA'], "int"),
                       GetSQLValueString($_POST['ID_SALIDA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$maxRows_justi = 10;
$pageNum_justi = 0;
if (isset($_GET['pageNum_justi'])) {
  $pageNum_justi = $_GET['pageNum_justi'];
}
$startRow_justi = $pageNum_justi * $maxRows_justi;

mysql_select_db($database_basepangloria, $basepangloria);
$query_justi = "SELECT * FROM TRNSALIDA_MAT_PRIM ORDER BY ID_SALIDA DESC";
$query_limit_justi = sprintf("%s LIMIT %d, %d", $query_justi, $startRow_justi, $maxRows_justi);
$justi = mysql_query($query_limit_justi, $basepangloria) or die(mysql_error());
$row_justi = mysql_fetch_assoc($justi);

if (isset($_GET['totalRows_justi'])) {
  $totalRows_justi = $_GET['totalRows_justi'];
} else {
  $all_justi = mysql_query($query_justi);
  $totalRows_justi = mysql_num_rows($all_justi);
}
$totalPages_justi = ceil($totalRows_justi/$maxRows_justi)-1;
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
    <td><iframe src="" width="820" height="0" scrolling="auto"></iframe></td>
  </tr>
  <tr>
    <td align="center"><h1>Elimar Salida de Materia Prima</h1></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table border="1">
        <tr>
          <td>Modificar</td>
          <td>ID_SALIDA </td>
          <td>CANTMAT_PRIMA</td>
          <td>ID_MATPRIMA</td>
          <td>IDENCABEZADOSALMATPRI</td>
          <td>IDUNIDAD</td>
          <td>IDDEPTO</td>
          <td>FECHAYHORAUSUA</td>
          <td>EMPLEADOSACA</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><a href="javascript:;" onclick="aviso('eliminarProducto.php?root=<?php echo $row_consultaproducto['IDPRODUCTO'];?>'); return false;">Eliminar</a></td>
            <td><?php echo $row_justi['ID_SALIDA']; ?></td>
            <td><?php echo $row_justi['CANTMAT_PRIMA']; ?></td>
            <td><?php echo $row_justi['ID_MATPRIMA']; ?></td>
            <td><?php echo $row_justi['IDENCABEZADOSALMATPRI']; ?></td>
            <td><?php echo $row_justi['IDUNIDAD']; ?></td>
            <td><?php echo $row_justi['IDDEPTO']; ?></td>
            <td><?php echo $row_justi['FECHAYHORAUSUA']; ?></td>
            <td><?php echo $row_justi['EMPLEADOSACA']; ?></td>
          </tr>
          <?php } while ($row_justi = mysql_fetch_assoc($justi)); ?>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="ID_SALIDA" value="<?php echo $row_justi['ID_SALIDA']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($justi);
?>
