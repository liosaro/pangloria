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
  $insertSQL = sprintf("INSERT INTO TRNCABEZACOTIZACION (IDENCABEZADO, IDVENDEDOR, IDPROVEEDOR, IDEMPLEADO, IDCONDICION, FECHACOTIZACION, VALIDEZOFERTA, PLAZOENTREGA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDVENDEDOR'], "int"),
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDCONDICION'], "int"),
                       GetSQLValueString($_POST['FECHACOTIZACION'], "date"),
                       GetSQLValueString($_POST['VALIDEZOFERTA'], "int"),
                       GetSQLValueString($_POST['PLAZOENTREGA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE CATVENDEDOR_PROV SET IDPROVEEDOR=%s, NOM=%s, EDAD=%s, CORREO=%s, MOVIL=%s, TELEFONO=%s WHERE IDVENDEDOR=%s",
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['NOM'], "text"),
                       GetSQLValueString($_POST['EDAD'], "date"),
                       GetSQLValueString($_POST['CORREO'], "text"),
                       GetSQLValueString($_POST['MOVIL'], "text"),
                       GetSQLValueString($_POST['TELEFONO'], "text"),
                       GetSQLValueString($_POST['IDVENDEDOR'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_COMBOVENDEDOR = "-1";
if (isset($_GET['IDVENDEDOR'])) {
  $colname_COMBOVENDEDOR = $_GET['IDVENDEDOR'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_COMBOVENDEDOR = sprintf("SELECT IDVENDEDOR FROM CATVENDEDOR_PROV WHERE IDVENDEDOR = %s", GetSQLValueString($colname_COMBOVENDEDOR, "int"));
$COMBOVENDEDOR = mysql_query($query_COMBOVENDEDOR, $basepangloria) or die(mysql_error());
$row_COMBOVENDEDOR = mysql_fetch_assoc($COMBOVENDEDOR);
$totalRows_COMBOVENDEDOR = mysql_num_rows($COMBOVENDEDOR);
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
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Cotizacion</h1></td>
          </tr>
          <tr>
            <td width="15%">Id Encabeado</td>
            <td width="16%"><input type="text" name="IDENCABEZADO" value="" size="20" /></td>
            <td width="14%">Id Empleado:</td>
            <td width="55%"><select name="IDEMPLEADO">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr>
            <td>Id Vendedor:</td>
            <td><select name="IDVENDEDOR">
              <?php
do {  
?>
              <option value="<?php echo $row_COMBOVENDEDOR['IDVENDEDOR']?>"<?php if (!(strcmp($row_COMBOVENDEDOR['IDVENDEDOR'], $row_COMBOVENDEDOR['']))) {echo "selected=\"selected\"";} ?>><?php echo $row_COMBOVENDEDOR['IDVENDEDOR']?></option>
              <?php
} while ($row_COMBOVENDEDOR = mysql_fetch_assoc($COMBOVENDEDOR));
  $rows = mysql_num_rows($COMBOVENDEDOR);
  if($rows > 0) {
      mysql_data_seek($COMBOVENDEDOR, 0);
	  $row_COMBOVENDEDOR = mysql_fetch_assoc($COMBOVENDEDOR);
  }
?>
            </select></td>
            <td>Id Condición:</td>
            <td><select name="IDCONDICION">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr>
            <td>Id Proveedor:</td>
            <td><select name="IDPROVEEDOR">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
            <td>Fecha</td>
            <td><input type="text" name="FECHACOTIZACION" value="" size="20" /></td>
          </tr>
          <tr>
            <td>Validez de Oferta:</td>
            <td><input type="text" name="VALIDEZOFERTA" value="" size="20" /></td>
            <td>Plazo de Entrega:</td>
            <td><input type="text" name="PLAZOENTREGA" value="" size="20" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="submit" value="Insertar registro" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDVENDEDOR:</td>
            <td><?php echo $row_COMBOVENDEDOR['IDVENDEDOR']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDPROVEEDOR:</td>
            <td><input type="text" name="IDPROVEEDOR" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NOM:</td>
            <td><input type="text" name="NOM" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">EDAD:</td>
            <td><input type="text" name="EDAD" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CORREO:</td>
            <td><input type="text" name="CORREO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">MOVIL:</td>
            <td><input type="text" name="MOVIL" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">TELEFONO:</td>
            <td><input type="text" name="TELEFONO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Actualizar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form3" />
        <input type="hidden" name="IDVENDEDOR" value="<?php echo $row_COMBOVENDEDOR['IDVENDEDOR']; ?>" />
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($COMBOVENDEDOR);
?>
