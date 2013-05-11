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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE TRNCONTROL_MAT_PRIMA SET IDMATPRIMA=%s, ID_SALIDA=%s, IDUNIDAD=%s, CANT_ENTREGA=%s, CANT_DEVUELTA=%s, CANT_UTILIZADA=%s, FECHA_CONTROL=%s WHERE ID_CONTROLMAT=%s",
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['ID_SALIDA'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANT_ENTREGA'], "double"),
                       GetSQLValueString($_POST['CANT_DEVUELTA'], "double"),
                       GetSQLValueString($_POST['CANT_UTILIZADA'], "double"),
                       GetSQLValueString($_POST['FECHA_CONTROL'], "date"),
                       GetSQLValueString($_POST['ID_CONTROLMAT'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_consultafiltrada = "-1";
if (isset($_GET['root'])) {
  $colname_consultafiltrada = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consultafiltrada = sprintf("SELECT * FROM TRNCONTROL_MAT_PRIMA WHERE ID_CONTROLMAT = %s ORDER BY ID_CONTROLMAT DESC", GetSQLValueString($colname_consultafiltrada, "int"));
$consultafiltrada = mysql_query($query_consultafiltrada, $basepangloria) or die(mysql_error());
$row_consultafiltrada = mysql_fetch_assoc($consultafiltrada);
$totalRows_consultafiltrada = mysql_num_rows($consultafiltrada);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_CONTROLMAT:</td>
      <td><?php echo $row_consultafiltrada['ID_CONTROLMAT']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDMATPRIMA:</td>
      <td><input type="text" name="IDMATPRIMA" value="<?php echo htmlentities($row_consultafiltrada['IDMATPRIMA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_SALIDA:</td>
      <td><input type="text" name="ID_SALIDA" value="<?php echo htmlentities($row_consultafiltrada['ID_SALIDA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDUNIDAD:</td>
      <td><input type="text" name="IDUNIDAD" value="<?php echo htmlentities($row_consultafiltrada['IDUNIDAD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANT_ENTREGA:</td>
      <td><input type="text" name="CANT_ENTREGA" value="<?php echo htmlentities($row_consultafiltrada['CANT_ENTREGA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANT_DEVUELTA:</td>
      <td><input type="text" name="CANT_DEVUELTA" value="<?php echo htmlentities($row_consultafiltrada['CANT_DEVUELTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANT_UTILIZADA:</td>
      <td><input type="text" name="CANT_UTILIZADA" value="<?php echo htmlentities($row_consultafiltrada['CANT_UTILIZADA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FECHA_CONTROL:</td>
      <td><input type="text" name="FECHA_CONTROL" value="<?php echo htmlentities($row_consultafiltrada['FECHA_CONTROL'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_CONTROLMAT" value="<?php echo $row_consultafiltrada['ID_CONTROLMAT']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultafiltrada);
?>
