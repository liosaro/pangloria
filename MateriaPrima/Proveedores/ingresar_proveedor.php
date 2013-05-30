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

mysql_select_db($database_basepangloria, $basepangloria);
$query_pais = "SELECT * FROM CATPAIS ORDER BY NOMBREDEPAIS ASC";
$pais = mysql_query($query_pais, $basepangloria) or die(mysql_error());
$row_pais = mysql_fetch_assoc($pais);
$totalRows_pais = mysql_num_rows($pais);

mysql_select_db($database_basepangloria, $basepangloria);
$query_depPais = "SELECT IDDP, NOMBREDEPTOPAIS FROM CATDEPTOPAIS";
$depPais = mysql_query($query_depPais, $basepangloria) or die(mysql_error());
$row_depPais = mysql_fetch_assoc($depPais);
$totalRows_depPais = mysql_num_rows($depPais);

$maxRows_ingeProvee = 10;
$pageNum_ingeProvee = 0;
if (isset($_GET['pageNum_ingeProvee'])) {
  $pageNum_ingeProvee = $_GET['pageNum_ingeProvee'];
}
$startRow_ingeProvee = $pageNum_ingeProvee * $maxRows_ingeProvee;

mysql_select_db($database_basepangloria, $basepangloria);
$query_ingeProvee = "SELECT * FROM CATPROVEEDOR ORDER BY IDPROVEEDOR DESC";
$query_limit_ingeProvee = sprintf("%s LIMIT %d, %d", $query_ingeProvee, $startRow_ingeProvee, $maxRows_ingeProvee);
$ingeProvee = mysql_query($query_limit_ingeProvee, $basepangloria) or die(mysql_error());
$row_ingeProvee = mysql_fetch_assoc($ingeProvee);

if (isset($_GET['totalRows_ingeProvee'])) {
  $totalRows_ingeProvee = $_GET['totalRows_ingeProvee'];
} else {
  $all_ingeProvee = mysql_query($query_ingeProvee);
  $totalRows_ingeProvee = mysql_num_rows($all_ingeProvee);
}
$totalPages_ingeProvee = ceil($totalRows_ingeProvee/$maxRows_ingeProvee)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_provee = "SELECT IDPROVEEDOR FROM CATPROVEEDOR ORDER BY IDPROVEEDOR DESC";
$provee = mysql_query($query_provee, $basepangloria) or die(mysql_error());
$row_provee = mysql_fetch_assoc($provee);
$totalRows_provee = mysql_num_rows($provee);
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
	font-size: 16px;
}
</style>
<link href="../../css/forms.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

<script>
function Confirm(form){

alert("Se ha agregado un nuevo registro!"); 

form.submit();

}

</script>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="left"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="left">
        <tr valign="baseline">
          <td colspan="4" align="center" nowrap="nowrap" class="ENCABEZADO"><span class="encaforms">Ingreso de Proveedores</span></td>
          </tr>
        <tr valign="baseline">
          <td >Id Proveedor:</td>
          <td ><input name="IDPROVEEDOR" type="text" value="<?php echo $row_provee['IDPROVEEDOR']+1; ?>" size="32" readonly="readonly" /></td>
          <td >Direccion del Porveedor:</td>
          <td><input type="text" name="DIRECCIONPROVEEDOR" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">Pais:</td>
          <td><select name="IDPAIS">
            <?php
do {  
?>
            <option value="<?php echo $row_pais['IDPAIS']?>"><?php echo $row_pais['NOMBREDEPAIS']?></option>
            <?php
} while ($row_pais = mysql_fetch_assoc($pais));
  $rows = mysql_num_rows($pais);
  if($rows > 0) {
      mysql_data_seek($pais, 0);
	  $row_pais = mysql_fetch_assoc($pais);
  }
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td >Nombre del Porveedor:</td>
          <td ><input type="text" name="NOMBREPROVEEDOR" value="" size="32" /></td>
          <td>Departamento</td>
          <td><select name="DEPTOPAISPROVEEDOR">
            <?php
do {  
?>
            <option value="<?php echo $row_depPais['IDDP']?>"><?php echo $row_depPais['NOMBREDEPTOPAIS']?></option>
            <?php
} while ($row_depPais = mysql_fetch_assoc($depPais));
  $rows = mysql_num_rows($depPais);
  if($rows > 0) {
      mysql_data_seek($depPais, 0);
	  $row_depPais = mysql_fetch_assoc($depPais);
  }
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td >Telefono del Proveedor:</td>
          <td nowrap="nowrap" align="right"><span id="sprytextfield1">
          <input type="text" name="TELEFONOPROVEEDOR" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          <td nowrap="nowrap" align="right">Correo del Proveedor:</td>
          <td><span id="sprytextfield2">
          <input type="text" name="CORREOPROVEEDOR" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td >Fecha Ingreso del Proveedor:</td>
          <td><script type="text/javascript"
src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
</script>
<script type="text/javascript"
src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
</script>
<script type="text/javascript"
src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript"
src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
</script> <div id="datetimepicker4" class="input-append">


<input name="FECHAINGRESOPROVE" type="text" id="FECHAINGRESOPROVE" data-format="yyyy-MM-dd"></input>
<span class="add-on"><script type="text/javascript"
src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
</script>
<script type="text/javascript"
src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
</script>
<script type="text/javascript"
src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript"
src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
</script> <div id="datetimepicker4" class="input-append">

<i data-time-icon="icon-time" data-date-icon="icon-calendar">
</i>
</div>
<script type="text/javascript">
$(function() {
$('#datetimepicker4').datetimepicker({
pickTime: false
});
});
</script>

</td>
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
          <td >Numero de Registro:</td>
          <td ><span id="sprytextfield4">
          <input type="text" name="NUMEROREGISTRO" value="" size="32" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          <td nowrap="nowrap" align="right">WEB:</td>
          <td> <input type="text" name="textfield" id="textfield" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><input type="submit" name="SEND" id="SEND"  value="Insertar registro" onClick="Confirm(this.form)" /></td>
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
<table border="1">
  <tr>
    <td>IDPROVEEDOR</td>
    <td>NOMBREPROVEEDOR</td>
    <td>DIRECCIONPROVEEDOR</td>
    <td>TELEFONOPROVEEDOR</td>
    <td>GIRO</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ingeProvee['IDPROVEEDOR']; ?></td>
      <td><?php echo $row_ingeProvee['NOMBREPROVEEDOR']; ?></td>
      <td><?php echo $row_ingeProvee['DIRECCIONPROVEEDOR']; ?></td>
      <td><?php echo $row_ingeProvee['TELEFONOPROVEEDOR']; ?></td>
      <td><?php echo $row_ingeProvee['GIRO']; ?></td>
    </tr>
    <?php } while ($row_ingeProvee = mysql_fetch_assoc($ingeProvee)); ?>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0000-0000", useCharacterMasking:true, validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {hint:"ejemplo@dominio.com", useCharacterMasking:true, validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "custom", {pattern:"000-000000-000-0", useCharacterMasking:true, validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($pais);

mysql_free_result($depPais);

mysql_free_result($ingeProvee);

mysql_free_result($provee);
?>
