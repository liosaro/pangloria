<head>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</Head>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "orden_produccion")) {
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOORDENPROD (IDENCABEORDPROD, IDEMPLEADO, IDSUCURSAL, FECHA) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEORDPROD'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDSUCURSAL'], "int"),
                       GetSQLValueString($_POST['FECHA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboEmpleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$comboEmpleado = mysql_query($query_comboEmpleado, $basepangloria) or die(mysql_error());
$row_comboEmpleado = mysql_fetch_assoc($comboEmpleado);
$totalRows_comboEmpleado = mysql_num_rows($comboEmpleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboSucursal = "SELECT IDSUCURSAL, NOMBRESUCURSAL FROM CATSUCURSAL";
$comboSucursal = mysql_query($query_comboSucursal, $basepangloria) or die(mysql_error());
$row_comboSucursal = mysql_fetch_assoc($comboSucursal);
$totalRows_comboSucursal = mysql_num_rows($comboSucursal);
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
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="orden_produccion" id="orden_produccion">
        <table width="100%" border="0">
          <tr>
            <td colspan="2" align="center"><h1>Ingresar Orden de Producción</h1></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center">Id orden de produccion:</td>
            <td><input name="IDENCABEORDPROD" type="text" disabled="disabled" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center">Id Empleado:</td>
            <td><select name="IDEMPLEADO">
              <?php
do {  
?>
              <option value="<?php echo $row_comboEmpleado['IDEMPLEADO']?>"><?php echo $row_comboEmpleado['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_comboEmpleado = mysql_fetch_assoc($comboEmpleado));
  $rows = mysql_num_rows($comboEmpleado);
  if($rows > 0) {
      mysql_data_seek($comboEmpleado, 0);
	  $row_comboEmpleado = mysql_fetch_assoc($comboEmpleado);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center">Id Sucursal:</td>
            <td><select name="IDSUCURSAL">
              <?php
do {  
?>
              <option value="<?php echo $row_comboSucursal['IDSUCURSAL']?>"><?php echo $row_comboSucursal['NOMBRESUCURSAL']?></option>
              <?php
} while ($row_comboSucursal = mysql_fetch_assoc($comboSucursal));
  $rows = mysql_num_rows($comboSucursal);
  if($rows > 0) {
      mysql_data_seek($comboSucursal, 0);
	  $row_comboSucursal = mysql_fetch_assoc($comboSucursal);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center">Fecha:</td>
            
            <td> <script type="text/javascript"
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
</script> <div id="datetimepicker4" class="input-append"><span id="sprytextfield1">
<input name="FECHAENTREGA" type="text" id="FECHAENTREGA" data-format="yyyy-MM-dd" />
<span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
  </input>
<span class="add-on">
<i data-time-icon="icon-time" data-date-icon="icon-calendar">
</i>
</span>
</div>
<script type="text/javascript">
$(function() {
$('#datetimepicker4').datetimepicker({
pickTime: false
});
});
</script></td>
         

          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_insert" value="orden_produccion" />
      </p>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($comboEmpleado);

mysql_free_result($comboSucursal);
?>
