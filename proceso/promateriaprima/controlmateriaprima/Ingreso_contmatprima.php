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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
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
$query_SUMARID = "SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT DESC";
$SUMARID = mysql_query($query_SUMARID, $basepangloria) or die(mysql_error());
$row_SUMARID = mysql_fetch_assoc($SUMARID);
$totalRows_SUMARID = mysql_num_rows($SUMARID);

mysql_select_db($database_basepangloria, $basepangloria);
$query_COMBOMATPRI = "SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA";
$COMBOMATPRI = mysql_query($query_COMBOMATPRI, $basepangloria) or die(mysql_error());
$row_COMBOMATPRI = mysql_fetch_assoc($COMBOMATPRI);
$totalRows_COMBOMATPRI = mysql_num_rows($COMBOMATPRI);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT ID_SALIDA FROM TRNCONTROL_MAT_PRIMA";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_COMBOUNIDAD = "SELECT IDUNIDAD FROM TRNCONTROL_MAT_PRIMA";
$COMBOUNIDAD = mysql_query($query_COMBOUNIDAD, $basepangloria) or die(mysql_error());
$row_COMBOUNIDAD = mysql_fetch_assoc($COMBOUNIDAD);
$totalRows_COMBOUNIDAD = mysql_num_rows($COMBOUNIDAD);
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
            <td width="16%"><input name="ID_CONTROLMAT" type="text" value="<?php echo $row_SUMARID['ID_CONTROLMAT']+1;?>" size="20" readonly="readonly" /></td>
            <td width="9%">Id Salida:</td>
            <td width="54%"><select name="ID_SALIDA">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['ID_SALIDA']?>"><?php echo $row_Recordset1['ID_SALIDA']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
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
              <option value="<?php echo $row_COMBOMATPRI['ID_CONTROLMAT']?>"><?php echo $row_COMBOMATPRI['ID_CONTROLMAT']?></option>
              <?php
} while ($row_COMBOMATPRI = mysql_fetch_assoc($COMBOMATPRI));
  $rows = mysql_num_rows($COMBOMATPRI);
  if($rows > 0) {
      mysql_data_seek($COMBOMATPRI, 0);
	  $row_COMBOMATPRI = mysql_fetch_assoc($COMBOMATPRI);
  }
?>
            </select></td>
            <td>Id Unidad</td>
            <td><select name="IDUNIDAD">
              <?php
do {  
?>
              <option value="<?php echo $row_COMBOUNIDAD['IDUNIDAD']?>"><?php echo $row_COMBOUNIDAD['IDUNIDAD']?></option>
              <?php
} while ($row_COMBOUNIDAD = mysql_fetch_assoc($COMBOUNIDAD));
  $rows = mysql_num_rows($COMBOUNIDAD);
  if($rows > 0) {
      mysql_data_seek($COMBOUNIDAD, 0);
	  $row_COMBOUNIDAD = mysql_fetch_assoc($COMBOUNIDAD);
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
            <td><input name="Enviar" type="submit" id="Enviar" value="Enviar" enable /></td>
            <td><input type="reset" name="Cancelar" id="Cancelar" value="Cancelar" /></td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
      </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($SUMARID);

mysql_free_result($COMBOMATPRI);

mysql_free_result($Recordset1);

mysql_free_result($COMBOUNIDAD);
?>
