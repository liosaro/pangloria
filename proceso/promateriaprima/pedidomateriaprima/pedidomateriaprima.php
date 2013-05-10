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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOPEDMATPRI (ID_ENCAPEDIDO, IDEMPLEADO, IDORDENPRODUCCION, FECHA, USUARIO, FECHAHORAUSUA) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ENCAPEDIDO'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['FECHA'], "date"),
                       GetSQLValueString($_POST['USUARIO'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_combordenprod = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD";
$combordenprod = mysql_query($query_combordenprod, $basepangloria) or die(mysql_error());
$row_combordenprod = mysql_fetch_assoc($combordenprod);
$totalRows_combordenprod = mysql_num_rows($combordenprod);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comempleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$comempleado = mysql_query($query_comempleado, $basepangloria) or die(mysql_error());
$row_comempleado = mysql_fetch_assoc($comempleado);
$totalRows_comempleado = mysql_num_rows($comempleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultimoped = "SELECT ID_ENCAPEDIDO FROM TRNENCABEZADOPEDMATPRI ORDER BY ID_ENCAPEDIDO DESC";
$ultimoped = mysql_query($query_ultimoped, $basepangloria) or die(mysql_error());
$row_ultimoped = mysql_fetch_assoc($ultimoped);
$totalRows_ultimoped = mysql_num_rows($ultimoped);
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
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso Pedido de Materia Prima</h1></td>
          </tr>
          <tr>
            <td>Id Encabezado de Pedido:</td>
            <td><input name="ID_ENCAPEDIDO" type="text" disabled="disabled" value="<?php echo $row_ultimoped['ID_ENCAPEDIDO']+1; ?>" size="32" readonly="readonly" /></td>
            <td>Empleado Pide:</td>
            <td><select name="IDEMPLEADO">
              <?php
do {  
?>
              <option value="<?php echo $row_comempleado['IDEMPLEADO']?>"><?php echo $row_comempleado['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_comempleado = mysql_fetch_assoc($comempleado));
  $rows = mysql_num_rows($comempleado);
  if($rows > 0) {
      mysql_data_seek($comempleado, 0);
	  $row_comempleado = mysql_fetch_assoc($comempleado);
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
            <td>IDORDENPRODUCCION</td>
            <td><select name="IDORDENPRODUCCION">
              <?php
do {  
?>
              <option value="<?php echo $row_combordenprod['IDENCABEORDPROD']?>"><?php echo $row_combordenprod['IDENCABEORDPROD']?></option>
              <?php
} while ($row_combordenprod = mysql_fetch_assoc($combordenprod));
  $rows = mysql_num_rows($combordenprod);
  if($rows > 0) {
      mysql_data_seek($combordenprod, 0);
	  $row_combordenprod = mysql_fetch_assoc($combordenprod);
  }
?>
            </select></td>
            <td>FECHA</td>
            <td><span id="spryfecha">
            <input type="text" name="FECHA" value="" size="32" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td><input type="submit" name="enviarenca" id="enviarenca" value="Insertar Encabezado" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
          <input type="hidden" name="MM_insert" value="form1" />
      </form>  
      </tr>
</table>
    <p><iframe src="insertadordetalle.php" name="conteb" width="820" height="350" scrolling="auto" frameborder="0"></iframe>&nbsp;</p></td>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryfecha", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($combordenprod);

mysql_free_result($comempleado);

mysql_free_result($ultimoped);
?>
