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
$query_comboordenproduccion = "SELECT IDORDENPRODUCCION FROM TRNDETORDENPRODUCCION";
$comboordenproduccion = mysql_query($query_comboordenproduccion, $basepangloria) or die(mysql_error());
$row_comboordenproduccion = mysql_fetch_assoc($comboordenproduccion);
$totalRows_comboordenproduccion = mysql_num_rows($comboordenproduccion);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboencabezado = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD";
$comboencabezado = mysql_query($query_comboencabezado, $basepangloria) or die(mysql_error());
$row_comboencabezado = mysql_fetch_assoc($comboencabezado);
$totalRows_comboencabezado = mysql_num_rows($comboencabezado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
</style>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="1">
  <tr>
    <td bgcolor="#CCCCCC"><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#CCCCCC"><h1>Modificar Orden de Producción</h1></td>
          </tr>
          <tr>
            <td width="20%" height="28" align="center">Id Orden de Produccion</td>
            <td width="24%"><select name="IDORDENPRODUCCION">
              <?php
do {  
?>
              <option value="<?php echo $row_comboordenproduccion['IDORDENPRODUCCION']?>"><?php echo $row_comboordenproduccion['IDORDENPRODUCCION']?></option>
              <?php
} while ($row_comboordenproduccion = mysql_fetch_assoc($comboordenproduccion));
  $rows = mysql_num_rows($comboordenproduccion);
  if($rows > 0) {
      mysql_data_seek($comboordenproduccion, 0);
	  $row_comboordenproduccion = mysql_fetch_assoc($comboordenproduccion);
  }
?>
            </select></td>
            <td width="43%">Encabezado Orden Produccion            <strong>
              <select name="IDENCABEORDPROD">
                <option value="value">label</option>
                <?php
do {  
?>
                <option value="<?php echo $row_comboencabezado['IDENCABEORDPROD']?>"><?php echo $row_comboencabezado['IDENCABEORDPROD']?></option>
                <?php
} while ($row_comboencabezado = mysql_fetch_assoc($comboencabezado));
  $rows = mysql_num_rows($comboencabezado);
  if($rows > 0) {
      mysql_data_seek($comboencabezado, 0);
	  $row_comboencabezado = mysql_fetch_assoc($comboencabezado);
  }
?>
              </select>
            </strong></td>
            <td width="13%">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">Fecha</td>
            <td><span id="spryfecha">
            <input type="text" name="FECHAHORAUSUA" value="" size="25" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td>:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC"><p>&nbsp;</p></td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC"><strong>Cantidad:</strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong>Medida:</strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong>  Producto:
              
            </strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="CANTIDADORPROD" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="ID_MEDIDA" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="PRODUCTOORDPRODUC" type="text" value="" size="40" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="CANTIDADORPROD2" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="ID_MEDIDA2" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="PRODUCTOORDPRODUC2" type="text" value="" size="40" readonly="readonly" /></td>
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
            <td align="center"><input name="Restablecer" type="reset" value="Modificar Registro" /></td>
            <td align="center"><input name="SEND" type="submit" id="SEND" value="Aceptar" /></td>
            <td><input name="Restablecer3" type="reset" value="Cancelar" /></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryfecha", "date", {format:"yyyy-mm-dd", validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($comboordenproduccion);

mysql_free_result($comboencabezado);
?>
