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
  $updateSQL = sprintf("UPDATE TRNSALIDA_MAT_PRIM SET CANTMAT_PRIMA=%s, ID_MATPRIMA=%s, IDENCABEZADOSALMATPRI=%s, IDUNIDAD=%s, IDDEPTO=%s, ELIMIN=%s, EDITA=%s WHERE ID_SALIDA=%s",
                       GetSQLValueString($_POST['CANTMAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_MATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADOSALMATPRI'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"),
                       GetSQLValueString($_POST['ELIMIN'], "int"),
                       GetSQLValueString($_POST['EDITA'], "int"),
                       GetSQLValueString($_POST['ID_SALIDA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modisalida = "-1";
if (isset($_GET['root'])) {
  $colname_modisalida = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modisalida = sprintf("SELECT * FROM TRNSALIDA_MAT_PRIM WHERE ID_SALIDA = %s", GetSQLValueString($colname_modisalida, "int"));
$modisalida = mysql_query($query_modisalida, $basepangloria) or die(mysql_error());
$row_modisalida = mysql_fetch_assoc($modisalida);
$totalRows_modisalida = mysql_num_rows($modisalida);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap" bgcolor="#999999"><h1>Modificacion de Salida de Materia Prima</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_SALIDA:</td>
      <td><?php echo $row_modisalida['ID_SALIDA']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANTMAT_PRIMA:</td>
      <td><input type="text" name="CANTMAT_PRIMA" value="<?php echo htmlentities($row_modisalida['CANTMAT_PRIMA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_MATPRIMA:</td>
      <td><input type="text" name="ID_MATPRIMA" value="<?php echo htmlentities($row_modisalida['ID_MATPRIMA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDENCABEZADOSALMATPRI:</td>
      <td><input type="text" name="IDENCABEZADOSALMATPRI" value="<?php echo htmlentities($row_modisalida['IDENCABEZADOSALMATPRI'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDUNIDAD:</td>
      <td><input type="text" name="IDUNIDAD" value="<?php echo htmlentities($row_modisalida['IDUNIDAD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDDEPTO:</td>
      <td><input type="text" name="IDDEPTO" value="<?php echo htmlentities($row_modisalida['IDDEPTO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_SALIDA" value="<?php echo $row_modisalida['ID_SALIDA']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modisalida);
?>
