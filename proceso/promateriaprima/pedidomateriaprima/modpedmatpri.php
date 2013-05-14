<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$maxRows_conmodpedmatpri = 10;
$pageNum_conmodpedmatpri = 0;
if (isset($_GET['pageNum_conmodpedmatpri'])) {
  $pageNum_conmodpedmatpri = $_GET['pageNum_conmodpedmatpri'];
}
$startRow_conmodpedmatpri = $pageNum_conmodpedmatpri * $maxRows_conmodpedmatpri;

$colname_conmodpedmatpri = "-1";
if (isset($_POST['filtrojust'])) {
  $colname_conmodpedmatpri = $_POST['filtrojust'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_conmodpedmatpri = sprintf("SELECT * FROM TRNPEDIDO_MAT_PRIMA WHERE ID_ENCAPEDIDO = %s", GetSQLValueString($colname_conmodpedmatpri, "int"));
$query_limit_conmodpedmatpri = sprintf("%s LIMIT %d, %d", $query_conmodpedmatpri, $startRow_conmodpedmatpri, $maxRows_conmodpedmatpri);
$conmodpedmatpri = mysql_query($query_limit_conmodpedmatpri, $basepangloria) or die(mysql_error());
$row_conmodpedmatpri = mysql_fetch_assoc($conmodpedmatpri);

if (isset($_GET['totalRows_conmodpedmatpri'])) {
  $totalRows_conmodpedmatpri = $_GET['totalRows_conmodpedmatpri'];
} else {
  $all_conmodpedmatpri = mysql_query($query_conmodpedmatpri);
  $totalRows_conmodpedmatpri = mysql_num_rows($all_conmodpedmatpri);
}
$totalPages_conmodpedmatpri = ceil($totalRows_conmodpedmatpri/$maxRows_conmodpedmatpri)-1;


$colname_conmatprima = "-1";
if (isset($_GET['IDMATPRIMA'])) {
  $colname_conmatprima = $_GET['IDMATPRIMA'];
}


$colname_encapedmatpri = "-1";
if (isset($_POST['filtrojust'])) {
  $colname_encapedmatpri = $_POST['filtrojust'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_encapedmatpri = sprintf("SELECT * FROM TRNENCABEZADOPEDMATPRI WHERE ID_ENCAPEDIDO = %s", GetSQLValueString($colname_encapedmatpri, "int"));
$encapedmatpri = mysql_query($query_encapedmatpri, $basepangloria) or die(mysql_error());
$row_encapedmatpri = mysql_fetch_assoc($encapedmatpri);
$totalRows_encapedmatpri = mysql_num_rows($encapedmatpri);
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
    <td><table width="100%" border="0">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Modificar Pedido de Materia Prima</h1></td>
            </tr>
          <tr>
            <td width="29%">Codigo de Pedido de Materia Prima:</td>
            <td width="30%" bgcolor="#D1D1D1"><?php echo $row_encapedmatpri['ID_ENCAPEDIDO']; ?></td>
            <td width="16%">Codigo de Empleado que pide la materia prima</td>
            <td width="25%" bgcolor="#D1D1D1"><?php echo $row_encapedmatpri['IDEMPLEADO']; ?></td>
          </tr>
          <tr>
            <td>Orden de Produccion que Genera el Pedido:</td>
            <td bgcolor="#CCCCCC"><?php echo $row_encapedmatpri['IDORDENPRODUCCION']; ?></td>
            <td>Fecha del Pedido:</td>
            <td bgcolor="#D1D1D1"><?php echo $row_encapedmatpri['FECHA']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center">Detalle del pedido de Materia PrimaS</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;
          <table border="1">
            <tr>
              <td>Eliminar</td>
              <td>Modificar</td>
              <td>ID_PED_MAT_PRIMA</td>
              <td>ID_ENCAPEDIDO</td>
              <td>IDUNIDAD</td>
              <td>IDMATPRIMA</td>
              <td>CANTIDADPEDMATPRI</td>
            </tr>
            <?php do { ?>
            <?php mysql_select_db($database_basepangloria, $basepangloria);
			$var1= $row_conmodpedmatpri['IDMATPRIMA'];
			$var2= $row_conmodpedmatpri['IDUNIDAD'];
$query_conmatprima = sprintf("SELECT  DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$var1'  ORDER BY DESCRIPCION ASC", GetSQLValueString($colname_conmatprima, "int"));
$conmatprima = mysql_query($query_conmatprima, $basepangloria) or die(mysql_error());
$row_conmatprima = mysql_fetch_assoc($conmatprima);
$totalRows_conmatprima = mysql_num_rows($conmatprima);
mysql_select_db($database_basepangloria, $basepangloria);
$query_conuni = "SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$var2' ORDER BY TIPOUNIDAD ASC";
$conuni = mysql_query($query_conuni, $basepangloria) or die(mysql_error());
$row_conuni = mysql_fetch_assoc($conuni);
$totalRows_conuni = mysql_num_rows($conuni);
?>
              <tr>
                <td>Eliminar</td>
                <td>Modificar</td>
                <td><?php echo $row_conmodpedmatpri['ID_PED_MAT_PRIMA']; ?></td>
                <td><?php echo $row_conmodpedmatpri['ID_ENCAPEDIDO']; ?></td>
                <td><?php echo $row_conuni['TIPOUNIDAD']; ?></td>
                <td><?php echo $row_conmatprima['DESCRIPCION']; ?></td>
                <td><?php echo $row_conmodpedmatpri['CANTIDADPEDMATPRI']; ?></td>
              </tr>
              <?php } while ($row_conmodpedmatpri = mysql_fetch_assoc($conmodpedmatpri)); ?>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($conmodpedmatpri);

mysql_free_result($conmodpedmatpri);

mysql_free_result($conuni);

mysql_free_result($conmatprima);

mysql_free_result($encapedmatpri);
?>
