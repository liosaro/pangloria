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
  $insertSQL = sprintf("INSERT INTO TRNJUSTIFICACIONFALTAPRODUCTO (ID_JUSTIFICACION, IDCONTROLPRODUCCION, CANTIDA_FALTANTE, IDPRODUCTOFALTA, ID_MEDIDA, FECHAINGRESOJUSFAPROD, JUSTIFICACIONFALTAPROD) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_JUSTIFICACION'], "int"),
                       GetSQLValueString($_POST['IDCONTROLPRODUCCION'], "int"),
                       GetSQLValueString($_POST['CANTIDA_FALTANTE'], "double"),
                       GetSQLValueString($_POST['IDPRODUCTOFALTA'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSFAPROD'], "date"),
                       GetSQLValueString($_POST['JUSTIFICACIONFALTAPROD'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_idcontrol = "SELECT ID_CONTROLPRODUCCION FROM TRNCONTROL_DEPRODUCCION";
$idcontrol = mysql_query($query_idcontrol, $basepangloria) or die(mysql_error());
$row_idcontrol = mysql_fetch_assoc($idcontrol);
$totalRows_idcontrol = mysql_num_rows($idcontrol);

mysql_select_db($database_basepangloria, $basepangloria);
$query_medidas = "SELECT ID_MEDIDA, MEDIDA FROM CATMEDIDAS";
$medidas = mysql_query($query_medidas, $basepangloria) or die(mysql_error());
$row_medidas = mysql_fetch_assoc($medidas);
$totalRows_medidas = mysql_num_rows($medidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Justificacion de falta de Producto</h1></td>
  </tr>
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <p>&nbsp;</p>
        <table width="820" border="0">
          <tr>
            <td>ID_JUSTIFICACION</td>
            <td><input name="ID_JUSTIFICACION" type="text" disabled="disabled" value="0001" size="32" readonly="readonly" /></td>
            <td>IDCONTROLPRODUCCION</td>
            <td><select name="IDCONTROLPRODUCCION">
              <?php
do {  
?>
              <option value="<?php echo $row_idcontrol['ID_CONTROLPRODUCCION']?>"><?php echo $row_idcontrol['ID_CONTROLPRODUCCION']?></option>
              <?php
} while ($row_idcontrol = mysql_fetch_assoc($idcontrol));
  $rows = mysql_num_rows($idcontrol);
  if($rows > 0) {
      mysql_data_seek($idcontrol, 0);
	  $row_idcontrol = mysql_fetch_assoc($idcontrol);
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
            <td>CANTIDA_FALTANTE</td>
            <td><input type="text" name="CANTIDA_FALTANTE2" size="32" /></td>
            <td>IDPRODUCTOFALTA:</td>
            <td><input name="CANTIDA_FALTANTE" type="text" disabled="disabled" value="001" size="32" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>ID_MEDIDA:</td>
            <td><select name="ID_MEDIDA">
              <?php
do {  
?>
              <option value="<?php echo $row_medidas['ID_MEDIDA']?>"><?php echo $row_medidas['MEDIDA']?></option>
              <?php
} while ($row_medidas = mysql_fetch_assoc($medidas));
  $rows = mysql_num_rows($medidas);
  if($rows > 0) {
      mysql_data_seek($medidas, 0);
	  $row_medidas = mysql_fetch_assoc($medidas);
  }
?>
            </select></td>
            <td>FECHAINGRESOJUSFAPROD</td>
            <td><input type="text" name="FECHAINGRESOJUSFAPROD" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUSTIFICACIONFALTAPROD</td>
            <td><textarea name="JUSTIFICACIONFALTAPROD" cols="32"></textarea></td>
            <td>&nbsp;</td>
            <td><input type="submit" value="Enviar" /></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($idcontrol);

mysql_free_result($medidas);
?>
