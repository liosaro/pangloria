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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNENCAORDCOMPRA (IDORDEN, NUMEROCOTIZACIO, IDEMPLEADO, FECHAEMISIONORDCOM, FECHAENTREGA, AUTORIZADOPOR, ESTADODEORDEN) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDORDEN'], "int"),
                       GetSQLValueString($_POST['NUMEROCOTIZACIO'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['FECHAEMISIONORDCOM'], "date"),
                       GetSQLValueString($_POST['FECHAENTREGA'], "date"),
                       GetSQLValueString($_POST['AUTORIZADOPOR'], "int"),
                       GetSQLValueString($_POST['ESTADODEORDEN'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}
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
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="left"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td colspan="4" align="center" nowrap="nowrap">Ingreso de Orden de Produccion</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">IDORDEN:</td>
          <td nowrap="nowrap" align="left"><input type="text" name="IDORDEN" value="" size="32" /></td>
          <td nowrap="nowrap" align="left">NUMEROCOTIZACIO:</td>
          <td align="left"><select name="NUMEROCOTIZACIO"  onchange="location.href = 'tupagina.php?coti=' + this.value"></select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">IDEMPLEADO:</td>
          <td nowrap="nowrap" align="left"><input type="text" name="IDEMPLEADO" value="" size="32" /></td>
          <td nowrap="nowrap" align="left">AUTORIZADOPOR:</td>
          <td align="left"><select name="AUTORIZADOPOR" onchange=""></select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">FECHAEMISIONORDCOM</td>
          <td nowrap="nowrap" align="left"><input type="text" name="FECHAEMISIONORDCOM" value="" size="32" /></td>
          <td nowrap="nowrap" align="left">ESTADODEORDEN</td>
          <td align="left"><select name="ESTADODEORDEN">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">FECHAENTREGA::</td>
          <td nowrap="nowrap" align="left"><input type="text" name="FECHAENTREGA" value="" size="32" /></td>
          <td nowrap="nowrap" align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><input type="submit" value="Insertar registro" /></td>
          <td nowrap="nowrap" align="left">&nbsp;</td>
          <td nowrap="nowrap" align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>