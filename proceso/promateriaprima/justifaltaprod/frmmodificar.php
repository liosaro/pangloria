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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE TRNJUSTIFICACIONFALTAPRODUCTO SET IDCONTROLPRODUCCION=%s, CANTIDA_FALTANTE=%s, IDPRODUCTOFALTA=%s, ID_MEDIDA=%s, FECHAINGRESOJUSFAPROD=%s, JUSTIFICACIONFALTAPROD=%s WHERE ID_JUSTIFICACION=%s",
                       GetSQLValueString($_POST['IDCONTROLPRODUCCION'], "int"),
                       GetSQLValueString($_POST['CANTIDA_FALTANTE'], "double"),
                       GetSQLValueString($_POST['IDPRODUCTOFALTA'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSFAPROD'], "date"),
                       GetSQLValueString($_POST['JUSTIFICACIONFALTAPROD'], "text"),
                       GetSQLValueString($_POST['ID_JUSTIFICACION'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_modificacion = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$modificacion = mysql_query($query_modificacion, $basepangloria) or die(mysql_error());
$row_modificacion = mysql_fetch_assoc($modificacion);
$totalRows_modificacion = mysql_num_rows($modificacion);$colname_modificacion = "-1";
if (isset($_GET['root'])) {
  $colname_modificacion = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modificacion = sprintf("SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO WHERE ID_JUSTIFICACION = %s", GetSQLValueString($colname_modificacion, "int"));
$modificacion = mysql_query($query_modificacion, $basepangloria) or die(mysql_error());
$row_modificacion = mysql_fetch_assoc($modificacion);
$totalRows_modificacion = mysql_num_rows($modificacion);

mysql_select_db($database_basepangloria, $basepangloria);
$query_medi = "SELECT * FROM CATMEDIDAS";
$medi = mysql_query($query_medi, $basepangloria) or die(mysql_error());
$row_medi = mysql_fetch_assoc($medi);
$totalRows_medi = mysql_num_rows($medi);

mysql_select_db($database_basepangloria, $basepangloria);
$query_producto = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$producto = mysql_query($query_producto, $basepangloria) or die(mysql_error());
$row_producto = mysql_fetch_assoc($producto);
$totalRows_producto = mysql_num_rows($producto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Modificar Justificacion Falta de Producto</h1></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" border="0">
    <tr>
      <td>ID_JUSTIFICACION:</td>
      <td><?php echo $row_modificacion['ID_JUSTIFICACION']; ?></td>
      <td>ID CONTROL PRODUCCION</td>
      <td><input type="text" name="IDCONTROLPRODUCCION" value="<?php echo htmlentities($row_modificacion['IDCONTROLPRODUCCION'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="baseline" nowrap="nowrap">CANTIDAD FALTA DEL PRODCUTO:</td>
      <td><input type="text" name="CANTIDA_FALTANTE" value="<?php echo htmlentities($row_modificacion['CANTIDA_FALTANTE'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>PRODUCTO FALTANTE:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="IDPRODUCTOFALTA" value="<?php echo $row_producto['DESCRIPCIONPRODUC']; ?>" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>MEDIDA</td>
      <td><input type="text" name="ID_MEDIDA" value="<?php echo $row_medi['MEDIDA']; ?>" size="32" /></td>
      <td>FECHA INGRESO </td>
      <td><input type="text" name="FECHAINGRESOJUSFAPROD" value="<?php echo htmlentities($row_modificacion['FECHAINGRESOJUSFAPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>JUSTIFICACION FALTA PRODUCTO</td>
      <td><textarea name="JUSTIFICACIONFALTAPROD" cols="32"><?php echo htmlentities($row_modificacion['JUSTIFICACIONFALTAPROD'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_JUSTIFICACION" value="<?php echo $row_modificacion['ID_JUSTIFICACION']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($modificacion);

mysql_free_result($medi);

mysql_free_result($producto);
?>
