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
  $insertSQL = sprintf("INSERT INTO CATEMPLEADO (IDEMPLEADO, IDDEPTO, IDCARGO, IDSUCURSAL, NOMBREEMPLEADO, EDADEMPLEADO, DIRECCION, NIT, NUP, NSEGURO, DUI, CUENTABANCARIA, CORREOEMPLEADO, MOVILEMPLEADO, FIJO, IDUSUARIO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"),
                       GetSQLValueString($_POST['IDCARGO'], "int"),
                       GetSQLValueString($_POST['IDSUCURSAL'], "int"),
                       GetSQLValueString($_POST['NOMBREEMPLEADO'], "text"),
                       GetSQLValueString($_POST['EDADEMPLEADO'], "date"),
                       GetSQLValueString($_POST['DIRECCION'], "text"),
                       GetSQLValueString($_POST['NIT'], "text"),
                       GetSQLValueString($_POST['NUP'], "text"),
                       GetSQLValueString($_POST['NSEGURO'], "text"),
                       GetSQLValueString($_POST['DUI'], "text"),
                       GetSQLValueString($_POST['CUENTABANCARIA'], "text"),
                       GetSQLValueString($_POST['CORREOEMPLEADO'], "text"),
                       GetSQLValueString($_POST['MOVILEMPLEADO'], "text"),
                       GetSQLValueString($_POST['FIJO'], "text"),
                       GetSQLValueString($_POST['IDUSUARIO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_idemple = "SELECT IDEMPLEADO FROM CATEMPLEADO ORDER BY IDEMPLEADO DESC";
$idemple = mysql_query($query_idemple, $basepangloria) or die(mysql_error());
$row_idemple = mysql_fetch_assoc($idemple);
$totalRows_idemple = mysql_num_rows($idemple);

mysql_select_db($database_basepangloria, $basepangloria);
$query_cargo = "SELECT IDCARGO, CARGO FROM CATCARGO";
$cargo = mysql_query($query_cargo, $basepangloria) or die(mysql_error());
$row_cargo = mysql_fetch_assoc($cargo);
$totalRows_cargo = mysql_num_rows($cargo);

mysql_select_db($database_basepangloria, $basepangloria);
$query_departa = "SELECT IDDEPTO, DEPARTAMENTO FROM CATDEPARTAMENEMPRESA";
$departa = mysql_query($query_departa, $basepangloria) or die(mysql_error());
$row_departa = mysql_fetch_assoc($departa);
$totalRows_departa = mysql_num_rows($departa);

mysql_select_db($database_basepangloria, $basepangloria);
$query_sucursal = "SELECT IDSUCURSAL, NOMBRESUCURSAL FROM CATSUCURSAL";
$sucursal = mysql_query($query_sucursal, $basepangloria) or die(mysql_error());
$row_sucursal = mysql_fetch_assoc($sucursal);
$totalRows_sucursal = mysql_num_rows($sucursal);

$colname_usuarioentra = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarioentra = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_usuarioentra = sprintf("SELECT IDUSUARIO, NOMBREUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s ORDER BY NOMBREUSUARIO ASC", GetSQLValueString($colname_usuarioentra, "text"));
$usuarioentra = mysql_query($query_usuarioentra, $basepangloria) or die(mysql_error());
$row_usuarioentra = mysql_fetch_assoc($usuarioentra);
$totalRows_usuarioentra = mysql_num_rows($usuarioentra);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Ingresar Empleado</h1></td>
    </tr>
    <tr>
      <td>Id Empleado:</td>
      <td><input name="IDEMPLEADO" type="text" disabled="disabled" value="<?php echo $row_idemple['IDEMPLEADO']; ?>" size="32" /></td>
      <td>Departamento:</td>
      <td><select name="IDDEPTO">
        <?php
do {  
?>
        <option value="<?php echo $row_departa['IDDEPTO']?>"><?php echo $row_departa['DEPARTAMENTO']?></option>
        <?php
} while ($row_departa = mysql_fetch_assoc($departa));
  $rows = mysql_num_rows($departa);
  if($rows > 0) {
      mysql_data_seek($departa, 0);
	  $row_departa = mysql_fetch_assoc($departa);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cargo:</td>
      <td><select name="IDCARGO">
        <?php
do {  
?>
        <option value="<?php echo $row_cargo['IDCARGO']?>"><?php echo $row_cargo['CARGO']?></option>
        <?php
} while ($row_cargo = mysql_fetch_assoc($cargo));
  $rows = mysql_num_rows($cargo);
  if($rows > 0) {
      mysql_data_seek($cargo, 0);
	  $row_cargo = mysql_fetch_assoc($cargo);
  }
?>
      </select></td>
      <td>Sucursal:</td>
      <td><select name="IDSUCURSAL">
        <?php
do {  
?>
        <option value="<?php echo $row_sucursal['IDSUCURSAL']?>"><?php echo $row_sucursal['NOMBRESUCURSAL']?></option>
        <?php
} while ($row_sucursal = mysql_fetch_assoc($sucursal));
  $rows = mysql_num_rows($sucursal);
  if($rows > 0) {
      mysql_data_seek($sucursal, 0);
	  $row_sucursal = mysql_fetch_assoc($sucursal);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Nombre del Empleado:</td>
      <td><input type="text" name="NOMBREEMPLEADO" value="" size="32" /></td>
      <td>Edad del Empleado:</td>
      <td><span id="sprytextfield4">
      <input type="text" name="EDADEMPLEADO" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Direccion:</td>
      <td><input type="text" name="DIRECCION" value="" size="32" /></td>
      <td>NIT:</td>
      <td><span id="sprytextfield5">
      <input type="text" name="NIT" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>NUP</td>
      <td><span id="sprytextfield1">
      <input type="text" name="NUP" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
      <td>Numero de Seguro:</td>
      <td><span id="sprytextfield6">
      <input type="text" name="NSEGURO" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>DUI:</td>
      <td><span id="sprytextfield2">
      <input type="text" name="DUI" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
      <td>Cuenta Bancaria:</td>
      <td><span id="sprytextfield7">
      <input type="text" name="CUENTABANCARIA" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Correo del Empleado:</td>
      <td><span id="sprytextfield3">
      <input type="text" name="CORREOEMPLEADO" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
      <td>Movil del Empleado:</td>
      <td><span id="sprytextfield8">
      <input type="text" name="MOVILEMPLEADO" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Fijo: </td>
      <td><span id="sprytextfield9">
      <input type="text" name="FIJO" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
      <td>Usuario:</td>
      <td><label for="usuario"></label>
        <select name="usuario" id="usuario">
          <?php
do {  
?>
          <option value="<?php echo $row_usuarioentra['IDUSUARIO']?>"><?php echo $row_usuarioentra['NOMBREUSUARIO']?></option>
          <?php
} while ($row_usuarioentra = mysql_fetch_assoc($usuarioentra));
  $rows = mysql_num_rows($usuarioentra);
  if($rows > 0) {
      mysql_data_seek($usuarioentra, 0);
	  $row_usuarioentra = mysql_fetch_assoc($usuarioentra);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td><input type="submit" value="Insertar registro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "social_security_number", {format:"ssn_custom", validateOn:["blur"], useCharacterMasking:true, pattern:"000000000000"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "social_security_number", {validateOn:["blur"], useCharacterMasking:true, format:"ssn_custom", pattern:"00000000-0"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur"], useCharacterMasking:true, hint:"ejemple@dominio.com"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "custom", {validateOn:["blur"], useCharacterMasking:true});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "custom", {validateOn:["blur"], useCharacterMasking:true, pattern:"0000-000000-00-0"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "social_security_number", {validateOn:["blur"], useCharacterMasking:true, format:"ssn_custom", pattern:"000000000"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "custom", {validateOn:["blur"], useCharacterMasking:true, pattern:"000000000"});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "phone_number", {format:"phone_custom", validateOn:["blur"], useCharacterMasking:true, pattern:"000000-00"});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "phone_number", {format:"phone_custom", validateOn:["blur"], useCharacterMasking:true, pattern:"000000-00"});
</script>
</body>
</html>
<?php
mysql_free_result($idemple);

mysql_free_result($cargo);

mysql_free_result($departa);

mysql_free_result($sucursal);

mysql_free_result($usuarioentra);
?>
