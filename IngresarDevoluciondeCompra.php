<?php require_once('Connections/basepangloria.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO TRNDEVOLUCIONCOMPRA (IDDEVOLUCION, IDEMPLEADO, ID_DETENCCOM, DOCADEVOLVER, FECHADEVOLUCION, IMPORTE, GASTOGENERADO, OBSERVACION) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDEVOLUCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['DOCADEVOLVER'], "text"),
                       GetSQLValueString($_POST['FECHADEVOLUCION'], "date"),
                       GetSQLValueString($_POST['IMPORTE'], "double"),
                       GetSQLValueString($_POST['GASTOGENERADO'], "double"),
                       GetSQLValueString($_POST['OBSERVACION'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_devolu = "SELECT IDDEVOLUCION FROM TRNDEVOLUCIONCOMPRA";
$devolu = mysql_query($query_devolu, $basepangloria) or die(mysql_error());
$row_devolu = mysql_fetch_assoc($devolu);
$totalRows_devolu = mysql_num_rows($devolu);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_dect = "SELECT ID_DETENCCOM FROM TRNDEVOLUCIONCOMPRA";
$dect = mysql_query($query_dect, $basepangloria) or die(mysql_error());
$row_dect = mysql_fetch_assoc($dect);
$totalRows_dect = mysql_num_rows($dect);
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
    <td align="center"><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td align="center" bgcolor="#999999"><h1>Ingresar Devoluciones de Compra</h1></td>
        </tr>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <p>&nbsp;</p>
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID DEVOLUCION:</td>
            <td><select name="IDDEVOLUCION">
              <?php
do {  
?>
              <option value="<?php echo $row_devolu['IDDEVOLUCION']?>"><?php echo $row_devolu['IDDEVOLUCION']?></option>
              <?php
} while ($row_devolu = mysql_fetch_assoc($devolu));
  $rows = mysql_num_rows($devolu);
  if($rows > 0) {
      mysql_data_seek($devolu, 0);
	  $row_devolu = mysql_fetch_assoc($devolu);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID EMPLEADO:</td>
            <td><select name="IDEMPLEADO">
              <?php
do {  
?>
              <option value="<?php echo $row_empleado['IDEMPLEADO']?>"><?php echo $row_empleado['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_empleado = mysql_fetch_assoc($empleado));
  $rows = mysql_num_rows($empleado);
  if($rows > 0) {
      mysql_data_seek($empleado, 0);
	  $row_empleado = mysql_fetch_assoc($empleado);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID_DETENCCOM:</td>
            <td><select name="ID_DETENCCOM">
              <?php
do {  
?>
              <option value="<?php echo $row_dect['ID_DETENCCOM']?>"><?php echo $row_dect['ID_DETENCCOM']?></option>
              <?php
} while ($row_dect = mysql_fetch_assoc($dect));
  $rows = mysql_num_rows($dect);
  if($rows > 0) {
      mysql_data_seek($dect, 0);
	  $row_dect = mysql_fetch_assoc($dect);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">DOCADEVOLVER:</td>
            <td><input type="text" name="DOCADEVOLVER" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">FECHA DEVOLUCION:</td>
            <td><input type="text" name="FECHADEVOLUCION" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IMPORTE:</td>
            <td><input type="text" name="IMPORTE" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">GASTO GENERADO:</td>
            <td><input type="text" name="GASTOGENERADO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">OBSERVACION:</td>
            <td><input type="text" name="OBSERVACION" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form3" />
      </form>
      <p>&nbsp;</p>
<form method="post" name="form2" id="form2">
  <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($devolu);

mysql_free_result($empleado);

mysql_free_result($dect);
?>
