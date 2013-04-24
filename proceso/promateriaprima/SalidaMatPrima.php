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

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboidpedido = "SELECT ID_ENCAPEDIDO FROM TRNENCABEZADOPEDMATPRI";
$comboidpedido = mysql_query($query_comboidpedido, $basepangloria) or die(mysql_error());
$row_comboidpedido = mysql_fetch_assoc($comboidpedido);
$totalRows_comboidpedido = mysql_num_rows($comboidpedido);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comoboidempleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$comoboidempleado = mysql_query($query_comoboidempleado, $basepangloria) or die(mysql_error());
$row_comoboidempleado = mysql_fetch_assoc($comoboidempleado);
$totalRows_comoboidempleado = mysql_num_rows($comoboidempleado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Empleados</title>
<link href="../../style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.7.2.custom.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
	<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<script type="text/javascript">
jQuery(function($){
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});    

        $(document).ready(function() {
           $("#datepicker").datepicker();
        });
    </script>

<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="ordcompra" name="ordcompra" method="post" action="">
      <table width="820px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="5" align="center" bgcolor="#999999"><h1>Salida de Materia Prima</h1></td>
        </tr>
        <tr>
          <td width="186">Id de Salida de Materia Prima</td>
          <td width="188"><label for="IDEMPLEADO"></label>
            <span id="idsalidamatprima">
            <input name="IDENCABEZADOSALMATPRI" type="text" id="IDENCABEZADOSALMATPRI" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
          <td width="43">&nbsp;</td>
          <td width="231">Fecha y Hora</td>
          <td width="172"><label> Seleccionar Fecha:</label>
            <input type="text" name="FECHAYHORASALIDAMATPRIMA" id="FECHAYHORASALIDAMATPRIMA" size="12" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Id Pedido de Materia Prima</td>
          <td><select name="ID_PED_MAT_PRIMA" id="ID_PED_MAT_PRIMA">
            <?php
do {  
?>
            <option value="<?php echo $row_comboidpedido['ID_ENCAPEDIDO']?>"><?php echo $row_comboidpedido['ID_ENCAPEDIDO']?></option>
            <?php
} while ($row_comboidpedido = mysql_fetch_assoc($comboidpedido));
  $rows = mysql_num_rows($comboidpedido);
  if($rows > 0) {
      mysql_data_seek($comboidpedido, 0);
	  $row_comboidpedido = mysql_fetch_assoc($comboidpedido);
  }
?>
          </select></td>
          <td>&nbsp;</td>
          <td>Encabezado de Orden de Produccion</td>
          <td><select name="IDMEDIDA" id="IDMEDIDA">
</select></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Empleado que Ingresa</td>
          <td><select name="IDEMPLEADO" id="IDEMPLEADO">
            <?php
do {  
?>
            <option value="<?php echo $row_comoboidempleado['IDEMPLEADO']?>"><?php echo $row_comoboidempleado['NOMBREEMPLEADO']?></option>
            <?php
} while ($row_comoboidempleado = mysql_fetch_assoc($comoboidempleado));
  $rows = mysql_num_rows($comoboidempleado);
  if($rows > 0) {
      mysql_data_seek($comoboidempleado, 0);
	  $row_comoboidempleado = mysql_fetch_assoc($comoboidempleado);
  }
?>
          </select></td>
          <td>&nbsp;</td>
          <td>Id detalle Pedido Materia Prima</td>
          <td><input name="IDPRODUCTO4" type="text" disabled="disabled" id="IDPRODUCTO4" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="center" bgcolor="#999999">DETALLE</td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0" id="detalleprod">
            <tr>
              <td width="16%" align="center" bgcolor="#C8C8C8">Numero de Pedido</td>
              <td width="13%" align="center" bgcolor="#C8C8C8">Cantidad</td>
              <td width="14%" align="center" bgcolor="#C8C8C8">Unidad</td>
              <td width="57%" align="center" bgcolor="#C8C8C8">Materia Prima</td>
            </tr>
            <tr>
              <td><select name="OrdProdIDMedida2" id="OrdProdIDMedida2">
</select></td>
              <td>&nbsp;</td>
              <td><select name="OrdProdIDMedida" id="OrdProdIDMedida">
</select></td>
              <td><select name="OrdProdIDPRODUCTO5" id="OrdProdIDPRODUCTO5">
</select></td>
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
          </table>
            <label for="IDMEDIDA"></label></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="SEND" id="SEND" value="Enviar" /></td>
          <td><input type="reset" name="add2" id="add2" value="Limpiar" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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
          <td>&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("idsalidamatprima", "integer", {minChars:1, maxChars:2, validateOn:["change"], minValue:0, maxValue:99999, hint:"0001"});
</script>
</body>
</html>
<?php
mysql_free_result($comboidpedido);

mysql_free_result($comoboidempleado);
?>
