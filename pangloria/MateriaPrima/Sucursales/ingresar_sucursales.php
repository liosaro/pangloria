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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO CATSUCURSAL (IDSUCURSAL, NOMBRESUCURSAL, DIRECCIONSUCURSAL, TELEFONOSUCURSAL) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDSUCURSAL'], "int"),
                       GetSQLValueString($_POST['NOMBRESUCURSAL'], "text"),
                       GetSQLValueString($_POST['DIRECCIONSUCURSAL'], "text"),
                       GetSQLValueString($_POST['TELEFONOSUCURSAL'], "text"));

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
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="ingre_sucursales" id="ingre_sucursales">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center"><h1>Ingreso de Sucursales</h1></td>
          </tr>
          <tr>
            <td>Id sucursal:</td>
            <td><input name="IDSUCURSAL" type="text" disabled="disabled" value="" size="32" /></td>
            <td>Direccion de la Sucursal:</td>
            <td><input type="text" name="DIRECCIONSUCURSAL" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right" valign="baseline" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nombre de la Sucursal:</td>
            <td><input type="text" name="NOMBRESUCURSAL" value="" size="32" /></td>
            <td>Telefono de la Sucursal:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="TELEFONOSUCURSAL" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_insert" value="form2" />
      </p>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0000-0000", useCharacterMasking:true, validateOn:["blur"]});
</script>
</body>
</html>