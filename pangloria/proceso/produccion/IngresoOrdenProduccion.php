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
  $insertSQL = sprintf("INSERT INTO TRNDETORDENPRODUCCION (IDORDENPRODUCCION, IDENCABEORDPROD, CANTIDADORPROD, ID_MEDIDA, PRODUCTOORDPRODUC, FECHAHORAUSUA, USUARIO) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['IDENCABEORDPROD'], "int"),
                       GetSQLValueString($_POST['CANTIDADORPROD'], "double"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['PRODUCTOORDPRODUC'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"),
                       GetSQLValueString($_POST['USUARIO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboproducto = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$comboproducto = mysql_query($query_comboproducto, $basepangloria) or die(mysql_error());
$row_comboproducto = mysql_fetch_assoc($comboproducto);
$totalRows_comboproducto = mysql_num_rows($comboproducto);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combomedida = "SELECT * FROM CATMEDIDAS";
$combomedida = mysql_query($query_combomedida, $basepangloria) or die(mysql_error());
$row_combomedida = mysql_fetch_assoc($combomedida);
$totalRows_combomedida = mysql_num_rows($combomedida);
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
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form3" name="form3" method="post" action="">
  <span id="sprytextfield1">
  <input type="text" name="text1" id="text1" />
  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
</form>
<table width="977" border="0">
  <tr>
    <td width="971"><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#CCCCCC"><h1>Ingresar Orden de Producción</h1></td>
          </tr>
          <tr>
            <td width="20%">Id Orden de Producción</td>
            <td width="21%"><input type="text" name="IDORDENPRODUCCION" value="" size="32" /></td>
            <td width="22%">Encabezado Orden de Produccion</td>
            <td width="37%"><input type="text" name="IDENCABEORDPROD" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cantiad Orden de Producción</td>
            <td><input type="text" name="CANTIDADORPROD" value="" size="32" /></td>
            <td>Medida a usar:</td>
            <td><select name="ID_MEDIDA">
              <?php
do {  
?>
              <option value="<?php echo $row_combomedida['ID_MEDIDA']?>"><?php echo $row_combomedida['MEDIDA']?></option>
              <?php
} while ($row_combomedida = mysql_fetch_assoc($combomedida));
  $rows = mysql_num_rows($combomedida);
  if($rows > 0) {
      mysql_data_seek($combomedida, 0);
	  $row_combomedida = mysql_fetch_assoc($combomedida);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td height="23">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Producto:</td>
            <td><select name="PRODUCTOORDPRODUC" size="1">
              <?php
do {  
?>
              <option value="<?php echo $row_comboproducto['IDPRODUCTO']?>"><?php echo $row_comboproducto['DESCRIPCIONPRODUC']?></option>
              <?php
} while ($row_comboproducto = mysql_fetch_assoc($comboproducto));
  $rows = mysql_num_rows($comboproducto);
  if($rows > 0) {
      mysql_data_seek($comboproducto, 0);
	  $row_comboproducto = mysql_fetch_assoc($comboproducto);
  }
?>
            </select></td>
            <td>Fecha</td>
            <td><span id="spryfecha">
            <input type="text" name="FECHAHORAUSUA" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Usuario:</td>
            <td><input type="text" name="USUARIO" value="" size="32" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="Insertar" type="submit" id="Insertar" value="Insertar registro" /></td>
            <td><input type="reset" name="button" id="button" value="Cancelar" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("spryfecha", "date", {format:"yyyy/mm/dd", validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($comboproducto);

mysql_free_result($combomedida);
?>
