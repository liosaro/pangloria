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
  $insertSQL = sprintf("INSERT INTO TRNSALIDA_MAT_PRIM (ID_SALIDA, CANTMAT_PRIMA, ID_MATPRIMA, IDENCABEZADOSALMATPRI, IDUNIDAD, IDDEPTO, FECHAYHORAUSUA, EMPLEADOSACA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_SALIDA'], "int"),
                       GetSQLValueString($_POST['CANTMAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_MATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADOSALMATPRI'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"),
                       GetSQLValueString($_POST['FECHAYHORAUSUA'], "date"),
                       GetSQLValueString($_POST['EMPLEADOSACA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboencabe = "SELECT IDENCABEZADOSALMATPRI, IDEMPLEADO FROM TRNENCABEZADOSALIDMATPRIMA";
$comboencabe = mysql_query($query_comboencabe, $basepangloria) or die(mysql_error());
$row_comboencabe = mysql_fetch_assoc($comboencabe);
$totalRows_comboencabe = mysql_num_rows($comboencabe);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT IDMATPRIMA FROM CATMATERIAPRIMA";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset2 = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$Recordset2 = mysql_query($query_Recordset2, $basepangloria) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset3 = "SELECT IDDEPTO, DEPARTAMENTO FROM CATDEPARTAMENEMPRESA";
$Recordset3 = mysql_query($query_Recordset3, $basepangloria) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset4 = "SELECT IDUNIDAD, TIPOUNIDAD FROM CATUNIDADES";
$Recordset4 = mysql_query($query_Recordset4, $basepangloria) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combocantidadMp = "SELECT CANTMAT_PRIMA FROM TRNSALIDA_MAT_PRIM";
$combocantidadMp = mysql_query($query_combocantidadMp, $basepangloria) or die(mysql_error());
$row_combocantidadMp = mysql_fetch_assoc($combocantidadMp);
$totalRows_combocantidadMp = mysql_num_rows($combocantidadMp);
$query_comboencabe = "SELECT IDENCABEZADOSALMATPRI FROM TRNENCABEZADOSALIDMATPRIMA";
$comboencabe = mysql_query($query_comboencabe, $basepangloria) or die(mysql_error());
$row_comboencabe = mysql_fetch_assoc($comboencabe);
$totalRows_comboencabe = mysql_num_rows($comboencabe);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1> Salida de Materia Prima</h1></td>
          </tr>
          <tr>
            <td>ID_SALIDA:</td>
            <td><span id="sprytextfield2">
            <input name="IDENCABEZADOSALMATPRI" type="text" disabled="disabled" id="IDENCABEZADOSALMATPRI" readonly="readonly" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
            <td>CANTMAT_PRIMA</td>
            <td><select name="IdCantida" id="IdCantida">
              <?php
do {  
?>
              <option value="<?php echo $row_combocantidadMp['CANTMAT_PRIMA']?>"><?php echo $row_combocantidadMp['CANTMAT_PRIMA']?></option>
              <?php
} while ($row_combocantidadMp = mysql_fetch_assoc($combocantidadMp));
  $rows = mysql_num_rows($combocantidadMp);
  if($rows > 0) {
      mysql_data_seek($combocantidadMp, 0);
	  $row_combocantidadMp = mysql_fetch_assoc($combocantidadMp);
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
            <td>ID_MATPRIMA</td>
            <td><select name="ID_PED_MAT_PRIMA" id="ID_PED_MAT_PRIMA">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['IDMATPRIMA']?>"><?php echo $row_Recordset1['IDMATPRIMA']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select></td>
            <td>IDENCABEZADOSALMATPRI</td>
            <td><select name="ID_PED_MAT_PRIMA3" id="ID_PED_MAT_PRIMA3">
              <?php
do {  
?>
              <option value="<?php echo $row_comboencabe['IDENCABEZADOSALMATPRI']?>"><?php echo $row_comboencabe['IDENCABEZADOSALMATPRI']?></option>
              <?php
} while ($row_comboencabe = mysql_fetch_assoc($comboencabe));
  $rows = mysql_num_rows($comboencabe);
  if($rows > 0) {
      mysql_data_seek($comboencabe, 0);
	  $row_comboencabe = mysql_fetch_assoc($comboencabe);
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
            <td>IDUNIDAD</td>
            <td><select name="ID_PED_MAT_PRIMA2" id="ID_PED_MAT_PRIMA2">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset4['TIPOUNIDAD']?>"><?php echo $row_Recordset4['IDUNIDAD']?></option>
              <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
            </select></td>
            <td>IDDEPTO</td>
            <td><select name="ID_PED_MAT_PRIMA4" id="ID_PED_MAT_PRIMA4">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset3['DEPARTAMENTO']?>"><?php echo $row_Recordset3['IDDEPTO']?></option>
              <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
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
            <td>FECHAYHORAUSUA</td>
            <td><span id="fecha">
            <input type="text" name="FECHAYHORAUSUA" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td>EMPLEADOSACA:</td>
            <td><select name="IDEMPLEADO" id="IDEMPLEADO">
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
            <td><input type="submit" value="Insertar registro" /></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("fecha", "date", {hint:"2013-12-20", validateOn:["blur"], format:"yyyy-mm-dd"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {hint:"0001", minChars:1, maxChars:2, minValue:0, maxValue:9999, validateOn:["change"]});
</script>
</body>
</html>
<?php
mysql_free_result($comboencabe);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($combocantidadMp);
?>
