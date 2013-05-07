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

$editFormAction = $_SERVER['PHP_blank'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TrnEncaEntrInventario (IdEncabezadoEnInventario, idEmpleado, fechaIngresoInventario) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['IdEncabezadoEnInventario'], "int"),
                       GetSQLValueString($_POST['idEmpleado'], "int"),
                       GetSQLValueString($_POST['fechaIngresoInventario'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNENTRADA_INVENTARIO (IDENTRADA, IdEncabezadoEnInventario, IDUNIDAD, IDMATPRIMA, CANTIDAD, FECHAEXPIRACION, PRECIOULTIMACOMPRA) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENTRADA'], "int"),
                       GetSQLValueString($_POST['IdEncabezadoEnInventario2'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['CANTIDAD'], "double"),
                       GetSQLValueString($_POST['FECHAEXPIRACION'], "date"),
                       GetSQLValueString($_POST['PRECIOULTIMACOMPRA'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT IdEncabezadoEnInventario FROM TrnEncaEntrInventario ORDER BY IdEncabezadoEnInventario DESC";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset2 = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$Recordset2 = mysql_query($query_Recordset2, $basepangloria) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_basepangloria, $basepangloria);
$query_codicuer = "SELECT IDENTRADA FROM TRNENTRADA_INVENTARIO ORDER BY IDENTRADA DESC";
$codicuer = mysql_query($query_codicuer, $basepangloria) or die(mysql_error());
$row_codicuer = mysql_fetch_assoc($codicuer);
$totalRows_codicuer = mysql_num_rows($codicuer);

mysql_select_db($database_basepangloria, $basepangloria);
$query_unmedida = "SELECT * FROM CATUNIDADES";
$unmedida = mysql_query($query_unmedida, $basepangloria) or die(mysql_error());
$row_unmedida = mysql_fetch_assoc($unmedida);
$totalRows_unmedida = mysql_num_rows($unmedida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_encainvetario = "SELECT IdEncabezadoEnInventario FROM TrnEncaEntrInventario ORDER BY IdEncabezadoEnInventario DESC";
$encainvetario = mysql_query($query_encainvetario, $basepangloria) or die(mysql_error());
$row_encainvetario = mysql_fetch_assoc($encainvetario);
$totalRows_encainvetario = mysql_num_rows($encainvetario);

mysql_select_db($database_basepangloria, $basepangloria);
$query_materiapri = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$materiapri = mysql_query($query_materiapri, $basepangloria) or die(mysql_error());
$row_materiapri = mysql_fetch_assoc($materiapri);
$totalRows_materiapri = mysql_num_rows($materiapri);
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
	text-align: left;
}
.divcontenedor {
}
</style>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" >
      <table width="820" align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">IdEncabezadoEnInventario:</td>
          <td align="left"><input type="text" disabled="disabled" value="<?php echo $row_Recordset1['IdEncabezadoEnInventario']+1; ?>" size="32" readonly="readonly" /></td>
          <td align="left">IdEmpleado:</td>
          <td align="left"><span id="idempleado">
            <select name="idEmpleado">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset2['IDEMPLEADO']?>"><?php echo $row_Recordset2['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
            </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">FechaIngresoInventario</td>
          <td align="left"><input name="fechaIngresoInventario" type="text" value="<?php echo date("Y-m-d H:i:s");;?> " size="32" readonly="readonly" /></td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><input name="enca" type="submit" id="enca"  value="Insertar registro" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
      <form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
        <table width="820" align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Codigo de Entrada:</td>
            <td><input name="IDENTRADA" type="text" value="<?php echo $row_codicuer['IDENTRADA']+1; ?>" size="32" readonly="readonly" /></td>
            <td>Codigo de Encabezado:</td>
            <td><span id="sprytextfield3">
            <input name="IdEncabezadoEnInventario2" type="text" value="<?php echo $row_encainvetario['IdEncabezadoEnInventario']; ?>" size="32" readonly="readonly" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Unidad de Medida:</td>
            <td><span id="spryselect2">
              <select name="IDUNIDAD">
                <?php
do {  
?>
                <option value="<?php echo $row_unmedida['IDUNIDAD']?>"><?php echo $row_unmedida['TIPOUNIDAD']?></option>
                <?php
} while ($row_unmedida = mysql_fetch_assoc($unmedida));
  $rows = mysql_num_rows($unmedida);
  if($rows > 0) {
      mysql_data_seek($unmedida, 0);
	  $row_unmedida = mysql_fetch_assoc($unmedida);
  }
?>
              </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>Materia Prima:</td>
            <td><span id="spryselect3">
              <select name="IDMATPRIMA"  onfocus="document.form2.cuerpo.disabled=false;">
                <?php
do {  
?>
                <option value="<?php echo $row_materiapri['IDMATPRIMA']?>"><?php echo $row_materiapri['DESCRIPCION']?></option>
                <?php
} while ($row_materiapri = mysql_fetch_assoc($materiapri));
  $rows = mysql_num_rows($materiapri);
  if($rows > 0) {
      mysql_data_seek($materiapri, 0);
	  $row_materiapri = mysql_fetch_assoc($materiapri);
  }
?>
              </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Cantidad:</td>
            <td><span id="sprytextfield1">
            <input type="text" name="CANTIDAD" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span></td>
            <td>Fecha de Expiracion:</td>
            <td><span id="sprytextfield4"><script type="text/javascript"
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
    </script>  <div id="datetimepicker4" class="input-append"><input type="text" name="FECHAEXPIRACION" value="" size="32" data-format="yyyy-MM-dd"></input><span class="add-on">
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
</script> 
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Precio de Ultima Compra</td>
            <td><span id="sprytextfield2">
            <input type="text" name="PRECIOULTIMACOMPRA" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><input name="cuerpo" type="submit" id="cuerpo" value="Insertar registro" disabled /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form2" />
      </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("idempleado", {validateOn:["change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "real", {validateOn:["blur"], hint:"12.5", minValue:1});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency", {minValue:0, validateOn:["blur"], format:"dot_comma"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], minValue:1});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($codicuer);

mysql_free_result($unmedida);

mysql_free_result($encainvetario);

mysql_free_result($materiapri);
?>
