<?php require_once('../Connections/basepangloria.php'); ?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="ingresaproducto.php";
  $loginUsername = $_POST['DESCRIPCIONPRODUC'];
  $LoginRS__query = sprintf("SELECT DESCRIPCIONPRODUC FROM CATPRODUCTO WHERE DESCRIPCIONPRODUC=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_basepangloria, $basepangloria);
  $LoginRS=mysql_query($LoginRS__query, $basepangloria) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
	if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "envioproducto")) {
  $insertSQL = sprintf("INSERT INTO CATPRODUCTO (DESCRIPCIONPRODUC, PRECIO_COSTO, PRECIO_VENTAMAYOREO, PRECIO_VENTAMENOR, DIAS_CADUCIDAD) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['DESCRIPCIONPRODUC'], "text"),
                       GetSQLValueString($_POST['PRECIO_COSTO'], "double"),
                       GetSQLValueString($_POST['PRECIO_VENTAMAYOR'], "double"),
                       GetSQLValueString($_POST['PRECIO_VENTAMENOR'], "double"),
                       GetSQLValueString($_POST['DIAS_CADUCIDAD'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Empleados</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="600" border="0">
  <tr>
    <td><form id="envioproducto" name="envioproducto" method="post" action="<?php echo $editFormAction; ?>">
      <table width="820px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="5" align="center" bgcolor="#999999"><h1>Ingresar Productos</h1></td>
        </tr>
        <tr>
          <td colspan="5" align="center">ID de compra
            <label for="IDPRODUCTO"></label>
            *
            <input name="IDPRODUCTO" type="text" id="IDPRODUCTO" value="Automaticamente" readonly="readonly" /></td>
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
            <input type="text" name="DESCRIPCIONPRODUC" id="DESCRIPCIONPRODUC" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">Mombre muy corto.</span></span></td>
          <td>&nbsp;</td>
          <td>Precio de venta al Menudeo</td>
          <td><span id="PRODVENTAMENOR">
            <input type="text" name="PRECIO_VENTAMENOR" id="PRECIO_VENTAMENOR" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
</tr>
        <tr>
          <td><p>&nbsp;</p></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Precio de Costo</td>
          <td><span id="PRODCOSTO">
            <input type="text" name="PRECIO_COSTO" id="date" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          <td>&nbsp;</td>
          <td>Precio de Venta Mayoreo</td>
          <td><span id="PRODVENTAMAYOR">
            <input type="text" name="PRECIO_VENTAMAYOR" id="PRECIO_VENTAMAYOR" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
</tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="center">Dias Caducidad *<span id="PRODCADUCIDAD">
            <input type="text" name="DIAS_CADUCIDAD" id="DIAS_CADUCIDAD" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
</tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="SEND" id="SEND" value="Enviar" /></td>
          <td><input type="reset" name="add2" id="add2" value="Limpiar" /></td>
          <td>&nbsp;</td>
          <td><input type="reset" name="prodbotNuevo" id="prodbotNuevo" value="Nuevo Registro" /></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="envioproducto" />
      <table width="820px" border="0" cellspacing="0" cellpadding="0">
        <tr> </tr>
        <tr> </tr>
        <tr> </tr>
      </table>
    </form></td>
  </tr>
</table>
</div>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("PRODCADUCIDAD", "integer", {minChars:1, maxChars:3, minValue:1, maxValue:365, validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("PRODVENTAMAYOR", "currency", {hint:"0.00", validateOn:["blur"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("PRODCOSTO", "currency", {validateOn:["blur"], hint:"0.00", isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("PRODVENTAMENOR", "currency", {hint:"0.00", isRequired:false, validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("verficardortiponombre", "none", {validateOn:["blur"], minChars:4});
</script>
</body>
</html>

 
            
            
            