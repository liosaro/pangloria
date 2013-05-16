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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO CATATRIBUCIONES (ID_ATRIB, IDUSUARIO, IDROL, IDPERMISO, C, R, U, D) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ATRIB'], "int"),
                       GetSQLValueString($_POST['IDUSUARIO'], "int"),
                       GetSQLValueString($_POST['IDROL'], "int"),
                       GetSQLValueString($_POST['IDPERMISO'], "int"),
                       GetSQLValueString($_POST['C'], "int"),
                       GetSQLValueString($_POST['R'], "int"),
                       GetSQLValueString($_POST['U'], "int"),
                       GetSQLValueString($_POST['D'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_ingresoatribu = "SELECT * FROM CATATRIBUCIONES";
$ingresoatribu = mysql_query($query_ingresoatribu, $basepangloria) or die(mysql_error());
$row_ingresoatribu = mysql_fetch_assoc($ingresoatribu);
$totalRows_ingresoatribu = mysql_num_rows($ingresoatribu);
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" align="center">
    <tr valign="baseline">
      <td colspan="4" align="center" nowrap="nowrap" bgcolor="#999999"><h1>Ingreso de Atribuciones</h1></td>
    </tr>
    <tr valign="baseline">
      <td width="168" align="right" nowrap="nowrap">Id Atribucion::</td>
      <td width="210"><input type="text" name="ID_ATRIB" value="" size="32" /></td>
      <td width="84">Rol:</td>
      <td width="338"><select name="IDROL">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Usuario:</td>
      <td><select name="IDUSUARIO">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
      <td>Permiso:</td>
      <td><select name="IDPERMISO">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">C:</td>
      <td><input type="text" name="C" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">R:</td>
      <td><input type="text" name="R" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">U:</td>
      <td><input type="text" name="U" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">D:</td>
      <td><input type="text" name="D" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ingresoatribu);
?>
