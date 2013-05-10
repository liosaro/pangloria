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
  $insertSQL = sprintf("INSERT INTO TRNCONTROL_MAT_PRIMA (ID_CONTROLMAT, IDMATPRIMA, ID_SALIDA, IDUNIDAD, CANT_ENTREGA, CANT_DEVUELTA, CANT_UTILIZADA, FECHA_CONTROL) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_CONTROLMAT'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['ID_SALIDA'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANT_ENTREGA'], "double"),
                       GetSQLValueString($_POST['CANT_DEVUELTA'], "double"),
                       GetSQLValueString($_POST['CANT_UTILIZADA'], "double"),
                       GetSQLValueString($_POST['FECHA_CONTROL'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_TEXMATPRIMA = "SELECT IDMATPRIMA FROM TRNCONTROL_MAT_PRIMA";
$TEXMATPRIMA = mysql_query($query_TEXMATPRIMA, $basepangloria) or die(mysql_error());
$row_TEXMATPRIMA = mysql_fetch_assoc($TEXMATPRIMA);
$totalRows_TEXMATPRIMA = mysql_num_rows($TEXMATPRIMA);

mysql_select_db($database_basepangloria, $basepangloria);
$query_TEXSALIDA = "SELECT ID_SALIDA FROM TRNCONTROL_MAT_PRIMA";
$TEXSALIDA = mysql_query($query_TEXSALIDA, $basepangloria) or die(mysql_error());
$row_TEXSALIDA = mysql_fetch_assoc($TEXSALIDA);
$totalRows_TEXSALIDA = mysql_num_rows($TEXSALIDA);

mysql_select_db($database_basepangloria, $basepangloria);
$query_TEXUNIDAD = "SELECT IDUNIDAD FROM TRNCONTROL_MAT_PRIMA";
$TEXUNIDAD = mysql_query($query_TEXUNIDAD, $basepangloria) or die(mysql_error());
$row_TEXUNIDAD = mysql_fetch_assoc($TEXUNIDAD);
$totalRows_TEXUNIDAD = mysql_num_rows($TEXUNIDAD);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ULTIMOID = "SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT DESC";
$ULTIMOID = mysql_query($query_ULTIMOID, $basepangloria) or die(mysql_error());
$row_ULTIMOID = mysql_fetch_assoc($ULTIMOID);
$totalRows_ULTIMOID = mysql_num_rows($ULTIMOID);
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../style.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.7.2.custom.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
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
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingresar </h1>
<h1>Control de Materia Prima</h1></td>
          </tr>
          <tr>
            <td width="21%">Id Control Materia Prima</td>
            <td width="16%"><input type="text" name="ID_CONTROLMAT" value="<?php echo $row_ULTIMOID['ID_CONTROLMAT']+1; ?>" size="20" /></td>
            <td width="9%">Id Salida:</td>
            <td width="54%"><select name="ID_SALIDA">
              <?php
do {  
?>
              <option value="<?php echo $row_TEXSALIDA['ID_SALIDA']?>"><?php echo $row_TEXSALIDA['ID_SALIDA']?></option>
              <?php
} while ($row_TEXSALIDA = mysql_fetch_assoc($TEXSALIDA));
  $rows = mysql_num_rows($TEXSALIDA);
  if($rows > 0) {
      mysql_data_seek($TEXSALIDA, 0);
	  $row_TEXSALIDA = mysql_fetch_assoc($TEXSALIDA);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>Id Materia Prima</td>
            <td><select name="IDMATPRIMA">
              <?php
do {  
?>
              <option value="<?php echo $row_TEXMATPRIMA['IDMATPRIMA']?>"><?php echo $row_TEXMATPRIMA['IDMATPRIMA']?></option>
              <?php
} while ($row_TEXMATPRIMA = mysql_fetch_assoc($TEXMATPRIMA));
  $rows = mysql_num_rows($TEXMATPRIMA);
  if($rows > 0) {
      mysql_data_seek($TEXMATPRIMA, 0);
	  $row_TEXMATPRIMA = mysql_fetch_assoc($TEXMATPRIMA);
  }
?>
            </select></td>
            <td>Id Unidad</td>
            <td><select name="IDUNIDAD">
              <?php
do {  
?>
              <option value="<?php echo $row_TEXUNIDAD['IDUNIDAD']?>"><?php echo $row_TEXUNIDAD['IDUNIDAD']?></option>
              <?php
} while ($row_TEXUNIDAD = mysql_fetch_assoc($TEXUNIDAD));
  $rows = mysql_num_rows($TEXUNIDAD);
  if($rows > 0) {
      mysql_data_seek($TEXUNIDAD, 0);
	  $row_TEXUNIDAD = mysql_fetch_assoc($TEXUNIDAD);
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
            <td height="34">Cantidad Entregada::</td>
            <td><input type="text" name="CANT_ENTREGA" value="" size="20" /></td>
            <td>&nbsp;</td>
            <td>Fecha:            
              <span id="sprytextfield1"><span class="textfieldInvalidFormatMsg">.
              <input name="datepicker" type="text" id="datepicker" size="12" readonly="readonly" />
              </span></span></td>
          </tr>
          <tr>
            <td height="35">Cantidad Devuelta</td>
            <td><input type="text" name="CANT_DEVUELTA" value="" size="20" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cantidad Utilizada</td>
            <td><input type="text" name="CANT_UTILIZADA" value="" size="20" /></td>
            <td>&nbsp;</td>
            <td><label for="Cancelar"></label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="Enviar" type="submit" id="Enviar" value="Enviar" /></td>
            <td><input type="reset" name="Cancelar" id="Cancelar" value="Cancelar" /></td>
            <td>&nbsp;</td>
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
</body>
</html>
<?php
mysql_free_result($TEXMATPRIMA);

mysql_free_result($TEXSALIDA);

mysql_free_result($TEXUNIDAD);

mysql_free_result($ULTIMOID);
?>
