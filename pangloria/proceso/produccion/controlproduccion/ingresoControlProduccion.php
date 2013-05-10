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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNCONTROL_DEPRODUCCION (ID_CONTROLPRODUCCION, IDORDENPRODUCCIONCONTROLA, CANTIDADSOLICITADA, CANTIDADRECIBIDA, ID_MEDIDA, IDPRODUCTOCONTROLA, FECHAINGRESOCONPROD) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_CONTROLPRODUCCION'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCIONCONTROLA'], "int"),
                       GetSQLValueString($_POST['CANTIDADSOLICITADA'], "double"),
                       GetSQLValueString($_POST['CANTIDADRECIBIDA'], "double"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['IDPRODUCTOCONTROLA'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOCONPROD'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_Combomedidas = "SELECT ID_MEDIDA, MEDIDA FROM CATMEDIDAS";
$Combomedidas = mysql_query($query_Combomedidas, $basepangloria) or die(mysql_error());
$row_Combomedidas = mysql_fetch_assoc($Combomedidas);
$totalRows_Combomedidas = mysql_num_rows($Combomedidas);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboprosolicitado = "SELECT IDORDENPRODUCCION, PRODUCTOORDPRODUC FROM TRNDETORDENPRODUCCION";
$comboprosolicitado = mysql_query($query_comboprosolicitado, $basepangloria) or die(mysql_error());
$row_comboprosolicitado = mysql_fetch_assoc($comboprosolicitado);
$totalRows_comboprosolicitado = mysql_num_rows($comboprosolicitado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboordendproduccion = "SELECT IDORDENPRODUCCION FROM TRNDETORDENPRODUCCION";
$comboordendproduccion = mysql_query($query_comboordendproduccion, $basepangloria) or die(mysql_error());
$row_comboordendproduccion = mysql_fetch_assoc($comboordendproduccion);
$totalRows_comboordendproduccion = mysql_num_rows($comboordendproduccion);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combocantidadsolicitada = "SELECT IDORDENPRODUCCION, CANTIDADORPROD FROM TRNDETORDENPRODUCCION";
$combocantidadsolicitada = mysql_query($query_combocantidadsolicitada, $basepangloria) or die(mysql_error());
$row_combocantidadsolicitada = mysql_fetch_assoc($combocantidadsolicitada);
$totalRows_combocantidadsolicitada = mysql_num_rows($combocantidadsolicitada);

mysql_select_db($database_basepangloria, $basepangloria);
$query_texCantidadsolicitada = "SELECT IDORDENPRODUCCION, CANTIDADORPROD FROM TRNDETORDENPRODUCCION";
$texCantidadsolicitada = mysql_query($query_texCantidadsolicitada, $basepangloria) or die(mysql_error());
$row_texCantidadsolicitada = mysql_fetch_assoc($texCantidadsolicitada);
$totalRows_texCantidadsolicitada = mysql_num_rows($texCantidadsolicitada);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="1">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso de Control de Producción</h1></td>
          </tr>
          <tr>
            <td width="19%">Codigo de Control de Producción :</td>
            <td width="21%"><input name="ID_CONTROLPRODUCCION" type="text" disabled="disabled" value="" size="32" /></td>
            <td width="28%">Codigo de la Orden de Producción :</td>
            <td width="32%"><select name="CANTIDADSOLICITADA3">
              <?php
do {  
?>
              <option value="<?php echo $row_comboordendproduccion['IDORDENPRODUCCION']?>"><?php echo $row_comboordendproduccion['IDORDENPRODUCCION']?></option>
              <?php
} while ($row_comboordendproduccion = mysql_fetch_assoc($comboordendproduccion));
  $rows = mysql_num_rows($comboordendproduccion);
  if($rows > 0) {
      mysql_data_seek($comboordendproduccion, 0);
	  $row_comboordendproduccion = mysql_fetch_assoc($comboordendproduccion);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>Cantidad Solicitada :</td>
            <td><input name="CANTIDADRECIBIDA2" type="text" size="35" maxlength="40" readonly="readonly" /></td>
            <td>Cantidad Recibida :</td>
            <td><input type="text" name="CANTIDADRECIBIDA" value="" size="32" /></td>
          </tr>
          <tr>
            <td>Medida </td>
            <td><select name="CANTIDADSOLICITADA2">
              <?php
do {  
?>
              <option value="<?php echo $row_Combomedidas['ID_MEDIDA']?>"><?php echo $row_Combomedidas['MEDIDA']?></option>
              <?php
} while ($row_Combomedidas = mysql_fetch_assoc($Combomedidas));
  $rows = mysql_num_rows($Combomedidas);
  if($rows > 0) {
      mysql_data_seek($Combomedidas, 0);
	  $row_Combomedidas = mysql_fetch_assoc($Combomedidas);
  }
?>
            </select></td>
            <td>Producto</td>
            <td><select name="IDPRODUCTOCONTROLA">
              <?php
do {  
?>
              <option value="<?php echo $row_comboprosolicitado['IDORDENPRODUCCION']?>"><?php echo $row_comboprosolicitado['PRODUCTOORDPRODUC']?></option>
              <?php
} while ($row_comboprosolicitado = mysql_fetch_assoc($comboprosolicitado));
  $rows = mysql_num_rows($comboprosolicitado);
  if($rows > 0) {
      mysql_data_seek($comboprosolicitado, 0);
	  $row_comboprosolicitado = mysql_fetch_assoc($comboprosolicitado);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>Fecha de Ingreso</td>
            <td><span id="sprymedida">
            <input type="text" name="FECHAINGRESOCONPROD" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
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
            <td><input name="guardar" type="submit" id="guardar" value="Guardar" /></td>
            <td><input type="reset" name="cancelar" id="cancelar" value="Cancelar" /></td>
            <td><input type="submit" name="salir" id="salir" value="Salir" /></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprymedida", "date", {format:"yyyy-mm-dd", validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($Combomedidas);

mysql_free_result($comboprosolicitado);

mysql_free_result($comboordendproduccion);

mysql_free_result($combocantidadsolicitada);

mysql_free_result($texCantidadsolicitada);
?>
