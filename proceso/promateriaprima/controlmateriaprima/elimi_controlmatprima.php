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

$maxRows_tablaeliminar = 10;
$pageNum_tablaeliminar = 0;
if (isset($_GET['pageNum_tablaeliminar'])) {
  $pageNum_tablaeliminar = $_GET['pageNum_tablaeliminar'];
}
$startRow_tablaeliminar = $pageNum_tablaeliminar * $maxRows_tablaeliminar;

mysql_select_db($database_basepangloria, $basepangloria);
$query_tablaeliminar = "SELECT CANT_ENTREGA, CANT_DEVUELTA, CANT_UTILIZADA FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT DESC";
$query_limit_tablaeliminar = sprintf("%s LIMIT %d, %d", $query_tablaeliminar, $startRow_tablaeliminar, $maxRows_tablaeliminar);
$tablaeliminar = mysql_query($query_limit_tablaeliminar, $basepangloria) or die(mysql_error());
$row_tablaeliminar = mysql_fetch_assoc($tablaeliminar);

if (isset($_GET['totalRows_tablaeliminar'])) {
  $totalRows_tablaeliminar = $_GET['totalRows_tablaeliminar'];
} else {
  $all_tablaeliminar = mysql_query($query_tablaeliminar);
  $totalRows_tablaeliminar = mysql_num_rows($all_tablaeliminar);
}
$totalPages_tablaeliminar = ceil($totalRows_tablaeliminar/$maxRows_tablaeliminar)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_botonmatprima = "SELECT IDMATPRIMA FROM TRNCONTROL_MAT_PRIMA";
$botonmatprima = mysql_query($query_botonmatprima, $basepangloria) or die(mysql_error());
$row_botonmatprima = mysql_fetch_assoc($botonmatprima);
$totalRows_botonmatprima = mysql_num_rows($botonmatprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_botonsalida = "SELECT ID_SALIDA FROM TRNCONTROL_MAT_PRIMA";
$botonsalida = mysql_query($query_botonsalida, $basepangloria) or die(mysql_error());
$row_botonsalida = mysql_fetch_assoc($botonsalida);
$totalRows_botonsalida = mysql_num_rows($botonsalida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT IDUNIDAD FROM TRNCONTROL_MAT_PRIMA";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_menumatprima = "SELECT IDMATPRIMA FROM TRNCONTROL_MAT_PRIMA";
$menumatprima = mysql_query($query_menumatprima, $basepangloria) or die(mysql_error());
$row_menumatprima = mysql_fetch_assoc($menumatprima);
$totalRows_menumatprima = mysql_num_rows($menumatprima);

$colname_compmatprima = "-1";
if (isset($_GET['ID_CONTROLMAT'])) {
  $colname_compmatprima = $_GET['ID_CONTROLMAT'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_compmatprima = sprintf("SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA WHERE ID_CONTROLMAT = %s ORDER BY ID_CONTROLMAT DESC", GetSQLValueString($colname_compmatprima, "int"));
$compmatprima = mysql_query($query_compmatprima, $basepangloria) or die(mysql_error());
$row_compmatprima = mysql_fetch_assoc($compmatprima);
$totalRows_compmatprima = mysql_num_rows($compmatprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_COMBOUNIDAD = "SELECT IDUNIDAD, TIPOUNIDAD FROM CATUNIDADES";
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
            <td colspan="4" align="center" bgcolor="#999999"><h1>Eliminar Control Materia Prima</h1></td>
          </tr>
          <tr>
            <td width="21%">Id Control Materia Prima</td>
            <td width="17%"><input name="ID_CONTROLMAT" type="text" disabled="disabled" value="<?php echo $row_compmatprima['ID_CONTROLMAT']+1; ?>" size="20" readonly="readonly" /></td>
            <td width="14%">Id Salida </td>
            <td width="48%"><select name="ID_SALIDA">
              <?php
do {  
?>
              <option value="<?php echo $row_botonsalida['ID_SALIDA']?>"><?php echo $row_botonsalida['ID_SALIDA']?></option>
              <?php
} while ($row_botonsalida = mysql_fetch_assoc($botonsalida));
  $rows = mysql_num_rows($botonsalida);
  if($rows > 0) {
      mysql_data_seek($botonsalida, 0);
	  $row_botonsalida = mysql_fetch_assoc($botonsalida);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>Id Materia Prima:</td>
            <td><select name="IDMATPRIMA">
              <?php
do {  
?>
              <option value="<?php echo $row_botonmatprima['IDMATPRIMA']?>"><?php echo $row_botonmatprima['IDMATPRIMA']?></option>
              <?php
} while ($row_botonmatprima = mysql_fetch_assoc($botonmatprima));
  $rows = mysql_num_rows($botonmatprima);
  if($rows > 0) {
      mysql_data_seek($botonmatprima, 0);
	  $row_botonmatprima = mysql_fetch_assoc($botonmatprima);
  }
?>
            </select>
            <label for="matprima"></label></td>
            <td>Id Unidad</td>
            <td><span class="textfieldInvalidFormatMsg">
              <select name="IDUNIDAD">
                <?php
do {  
?>
                <option value="<?php echo $row_COMBOUNIDAD['IDUNIDAD']?>"><?php echo $row_COMBOUNIDAD['TIPOUNIDAD']?></option>
                <?php
} while ($row_COMBOUNIDAD = mysql_fetch_assoc($COMBOUNIDAD));
  $rows = mysql_num_rows($COMBOUNIDAD);
  if($rows > 0) {
      mysql_data_seek($COMBOUNIDAD, 0);
	  $row_COMBOUNIDAD = mysql_fetch_assoc($COMBOUNIDAD);
  }
?>
              </select>
            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cantidad entregada</td>
            <td><input type="text" name="CANT_ENTREGA" value="" size="20" /></td>
            <td> <strong>Fecha</strong></td>
            <td><span class="textfieldInvalidFormatMsg">
              <input name="datepicker" type="text" id="datepicker" size="12" readonly="readonly" />
            </span></td>
          </tr>
          <tr>
            <td>Cantidad Devuelta</td>
            <td><input type="text" name="CANT_DEVUELTA" value="" size="20" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cantidad Utilizada</td>
            <td><input type="text" name="CANT_UTILIZADA" value="" size="20" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;
              <table border="1">
                <tr>
                  <td>CANT_ENTREGA</td>
                  <td>CANT_DEVUELTA</td>
                  <td>CANT_UTILIZADA</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td><?php echo $row_tablaeliminar['CANT_ENTREGA']; ?></td>
                    <td><?php echo $row_tablaeliminar['CANT_DEVUELTA']; ?></td>
                    <td><?php echo $row_tablaeliminar['CANT_UTILIZADA']; ?></td>
                  </tr>
                  <?php } while ($row_tablaeliminar = mysql_fetch_assoc($tablaeliminar)); ?>
              </table></td>
          </tr>
          <tr>
            <td height="26">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="Eliminar" type="submit" id="Eliminar" value="Eliminar" /></td>
            <td><input type="reset" name="Cancelar" id="Cancelar" value="Cancelar" /></td>
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
mysql_free_result($tablaeliminar);

mysql_free_result($botonmatprima);

mysql_free_result($botonsalida);

mysql_free_result($Recordset1);

mysql_free_result($menumatprima);

mysql_free_result($compmatprima);

mysql_free_result($COMBOUNIDAD);
?>
