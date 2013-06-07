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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNDEVOLUCIONCOMPRA (IDDEVOLUCION, IDEMPLEADO, ID_DETENCCOM, DOCADEVOLVER, FECHADEVOLUCION, IMPORTE, GASTOGENERADO, OBSERVACION, ELIMIN, EDITA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDEVOLUCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['DOCADEVOLVER'], "text"),
                       GetSQLValueString($_POST['FECHADEVOLUCION'], "date"),
                       GetSQLValueString($_POST['IMPORTE'], "double"),
                       GetSQLValueString($_POST['GASTOGENERADO'], "double"),
                       GetSQLValueString($_POST['OBSERVACION'], "text"),
                       GetSQLValueString($_POST['ELIMIN'], "int"),
                       GetSQLValueString($_POST['EDITA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_GET['ID_DETENCCOM'])) && ($_GET['ID_DETENCCOM'] != "")) {
  $deleteSQL = sprintf("DELETE FROM TRNENCABEZADOCOMPRA WHERE ID_DETENCCOM=%s",
                       GetSQLValueString($_GET['ID_DETENCCOM'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($deleteSQL, $basepangloria) or die(mysql_error());
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT * FROM TRNDETALLECOMPRA";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset2 = "SELECT * FROM TRNDEVOLUCIONCOMPRA";
$Recordset2 = mysql_query($query_Recordset2, $basepangloria) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td colspan="5" align="center" bgcolor="#999999"><h1>Ingreso Devolución de Compra</h1></td>
          </tr>
        <tr>
          <td width="12%">Id Devolución</td>
          <td width="29%"><input type="text" name="IDDEVOLUCION" value="<?php echo $row_Recordset2['IDDEVOLUCION']; +1?>" size="32" /></td>
          <td width="9%">Fecha:</td>
          <td width="25%"><input name="FECHADEVOLUCION" type="text" value="<?php echo $row_Recordset1['']; $hoy = date('d/M/y');?>" size="32" );/></td>
          <td width="25%">&nbsp;</td>
        </tr>
        <tr>
          <td>Id Compra</td>
          <td><input type="text" name="ID_DETENCCOM" value="<?php echo $row_Recordset1['IDCOMPRA']; ?>" size="32" /></td>
          <td>Empleado</td>
          <td><input type="text" name="IDEMPLEADO" value="" size="32" /></td>
          <td><input type="submit" value="Insertar registro" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table border="1">
        <tr>
          <td>IDCOMPRA</td>
          <td>IDUNIDAD</td>
          <td>ID_DETENCCOM</td>
          <td>CANTIDADMATPRIMA</td>
          <td>MATERIAPRIMA</td>
          <td>PRECIOUNIDAD</td>
          <td>ELIMINA</td>
          <td>EDITA</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_Recordset1['IDCOMPRA']; ?></td>
            <td><?php echo $row_Recordset1['IDUNIDAD']; ?></td>
            <td><?php echo $row_Recordset1['ID_DETENCCOM']; ?></td>
            <td><?php echo $row_Recordset1['CANTIDADMATPRIMA']; ?></td>
            <td><?php echo $row_Recordset1['MATERIAPRIMA']; ?></td>
            <td><?php echo $row_Recordset1['PRECIOUNIDAD']; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
