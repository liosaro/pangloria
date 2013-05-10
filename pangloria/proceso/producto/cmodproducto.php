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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE CATPRODUCTO SET DESCRIPCIONPRODUC=%s, PRECIO_COSTO=%s, PRECIO_VENTAMAYOREO=%s, PRECIO_VENTAMENOR=%s, DIAS_CADUCIDAD=%s WHERE IDPRODUCTO=%s",
                       GetSQLValueString($_POST['DESCRIPCIONPRODUC'], "text"),
                       GetSQLValueString($_POST['PRECIO_COSTO'], "double"),
                       GetSQLValueString($_POST['PRECIO_VENTAMAYOREO'], "double"),
                       GetSQLValueString($_POST['PRECIO_VENTAMENOR'], "double"),
                       GetSQLValueString($_POST['DIAS_CADUCIDAD'], "int"),
                       GetSQLValueString($_POST['IDPRODUCTO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_consufiltradaproducto = "-1";
if (isset($_GET['root'])) {
  $colname_consufiltradaproducto = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consufiltradaproducto = sprintf("SELECT * FROM CATPRODUCTO WHERE IDPRODUCTO = %s", GetSQLValueString($colname_consufiltradaproducto, "int"));
$consufiltradaproducto = mysql_query($query_consufiltradaproducto, $basepangloria) or die(mysql_error());
$row_consufiltradaproducto = mysql_fetch_assoc($consufiltradaproducto);
$totalRows_consufiltradaproducto = mysql_num_rows($consufiltradaproducto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
}
</style>
</head>

<body>
<form id="modiproducto" name="modiproducto" method="POST">
<table width="820px" border="0" cellspacing="0" cellpadding="0">
  <tr>    </tr>
  <tr>    </tr>
  <tr>    </tr>
</table>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820px" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="5" align="center" bgcolor="#999999"><h1>Modificar Productos</h1></td>
    </tr>
    <tr>
      <td colspan="5" align="center">ID de compra:
        <label for="IDPRODUCTO"><?php echo $row_consufiltradaproducto['IDPRODUCTO']; ?></label></td>
    </tr>
    <tr>
      <td width="186">&nbsp;</td>
      <td width="206">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="176">&nbsp;</td>
      <td width="227">&nbsp;</td>
    </tr>
    <tr>
      <td>Nombre del Producto</td>
      <td><span id="verficardortiponombre"> *
        <input name="DESCRIPCIONPRODUC" type="text" id="DESCRIPCIONPRODUC" value="<?php echo htmlentities($row_consufiltradaproducto['DESCRIPCIONPRODUC'], ENT_COMPAT, 'utf-8'); ?>" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">Mombre muy corto.</span></span></td>
      <td>&nbsp;</td>
      <td>Precio de venta al Menudeo</td>
      <td><span id="PRODVENTAMENOR">
        <input name="PRECIO_VENTAMENOR" type="text" id="PRECIO_VENTAMENOR" value="<?php echo htmlentities($row_consufiltradaproducto['PRECIO_VENTAMENOR'], ENT_COMPAT, 'utf-8'); ?>" />
        <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
</tr>
    <tr>
      <td>Precio de Costo</td>
      <td><span id="PRODCOSTO">
        <input name="PRECIO_COSTO" type="text" id="PRECIO_COSTO" value="<?php echo htmlentities($row_consufiltradaproducto['PRECIO_COSTO'], ENT_COMPAT, 'utf-8'); ?>" />
        <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
      <td>&nbsp;</td>
      <td>Precio de Venta Mayoreo</td>
      <td><span id="PRODVENTAMAYOR">
        <input name="PRECIO_VENTAMAYOREO" type="text" id="PRECIO_VENTAMAYOREO" value="<?php echo htmlentities($row_consufiltradaproducto['PRECIO_VENTAMAYOREO'], ENT_COMPAT, 'utf-8'); ?>" />
        <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
</tr>
    <tr>
      <td colspan="5" align="center">Dias Caducidad *<span id="PRODCADUCIDAD">
        <input name="DIAS_CADUCIDAD" type="text" id="DIAS_CADUCIDAD" value="<?php echo htmlentities($row_consufiltradaproducto['DIAS_CADUCIDAD'], ENT_COMPAT, 'utf-8'); ?>" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
</tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" value="Actualizar registro" /></td>
      <td><input type="reset" name="add2" id="add2" value="Limpiar" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> </tr>
    <tr> </tr>
    <tr> </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="IDPRODUCTO" value="<?php echo $row_consufiltradaproducto['IDPRODUCTO']; ?>" />
  </p>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("PRODCADUCIDAD", "integer", {minChars:1, maxChars:3, minValue:1, maxValue:365, validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("PRODVENTAMAYOR", "currency", {hint:"0.00", validateOn:["blur"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("PRODCOSTO", "currency", {validateOn:["blur"], hint:"0.00", isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("PRODVENTAMENOR", "currency", {hint:"0.00", isRequired:false, validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("verficardortiponombre", "none", {validateOn:["blur"], minChars:4});
</script>
</body>
</html>
<?php
mysql_free_result($consufiltradaproducto);
?>
