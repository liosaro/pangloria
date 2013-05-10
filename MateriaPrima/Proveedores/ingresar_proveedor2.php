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
  $insertSQL = sprintf("INSERT INTO CATPROVEEDOR (IDPROVEEDOR, IDPAIS, NOMBREPROVEEDOR, DIRECCIONPROVEEDOR, TELEFONOPROVEEDOR, CORREOPROVEEDOR, FECHAINGRESOPROVE, GIRO, NUMEROREGISTRO, WEB, DEPTOPAISPROVEEDOR) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDPAIS'], "int"),
                       GetSQLValueString($_POST['NOMBREPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['DIRECCIONPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['TELEFONOPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['CORREOPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['FECHAINGRESOPROVE'], "date"),
                       GetSQLValueString($_POST['GIRO'], "text"),
                       GetSQLValueString($_POST['NUMEROREGISTRO'], "text"),
                       GetSQLValueString($_POST['WEB'], "text"),
                       GetSQLValueString($_POST['DEPTOPAISPROVEEDOR'], "int"));

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
      <table align="left">
        <tr valign="baseline">
          <td colspan="4" align="center" nowrap="nowrap">Ingreso de Proveedores</td>
          </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Id Proveedor:</td>
          <td nowrap="nowrap" align="right"><input name="IDPROVEEDOR" type="text" value="" size="32" readonly="readonly" /></td>
          <td nowrap="nowrap" align="right">Direccion del Porveedor:</td>
          <td><input type="text" name="DIRECCIONPROVEEDOR" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">Pais:</td>
          <td><select name="IDPAIS">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nombre del Porveedor:</td>
          <td nowrap="nowrap" align="right"><input type="text" name="NOMBREPROVEEDOR" value="" size="32" /></td>
          <td nowrap="nowrap" align="right">Departamento</td>
          <td><select name="DEPTOPAISPROVEEDOR">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Telefono del Proveedor:</td>
          <td nowrap="nowrap" align="right"><input type="text" name="TELEFONOPROVEEDOR" value="" size="32" /></td>
          <td nowrap="nowrap" align="right">Correo del Proveedor:</td>
          <td><input type="text" name="CORREOPROVEEDOR" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Fecha Ingreso del Proveedor:</td>
          <td nowrap="nowrap" align="right"><input type="text" name="FECHAINGRESOPROVE" value="" size="32" /></td>
          <td nowrap="nowrap" align="right">Giro:</td>
          <td><input type="text" name="GIRO" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Numero de Registro:</td>
          <td nowrap="nowrap" align="right"><input type="text" name="NUMEROREGISTRO" value="" size="32" /></td>
          <td nowrap="nowrap" align="right">WEB:</td>
          <td><input type="text" name="WEB" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><input type="submit" value="Insertar registro" /></td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form></td>
  </tr>
</table>
</body>
</html>