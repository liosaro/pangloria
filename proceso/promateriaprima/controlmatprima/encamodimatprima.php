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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
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

  $updateGoTo = "file:///C|/Users/Glenda/Documents/GitHub/pangloria/proceso/promateriaprima/controlmatprima/modimatprima.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['ID_CONTROLMAT'])) {
  $colname_Recordset1 = $_GET['ID_CONTROLMAT'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = sprintf("SELECT * FROM TRNCONTROL_MAT_PRIMA WHERE ID_CONTROLMAT = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combomateprima = "SELECT IDMATPRIMA, IDTIPO FROM CATMATERIAPRIMA";
$combomateprima = mysql_query($query_combomateprima, $basepangloria) or die(mysql_error());
$row_combomateprima = mysql_fetch_assoc($combomateprima);
$totalRows_combomateprima = mysql_num_rows($combomateprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset2 = "SELECT IDUNIDAD, TIPOUNIDAD FROM CATUNIDADES";
$Recordset2 = mysql_query($query_Recordset2, $basepangloria) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
	margin-left: 1px;
	margin-top: 1px;
	margin-right: 1px;
	margin-bottom: 1px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td width="21%">Id Control Materia Prima:</td>
            <td width="30%"><?php echo $row_Recordset1['ID_CONTROLMAT']; ?></td>
            <td width="10%">Id Salida:</td>
            <td width="39%"><input type="text" name="ID_SALIDA" value="<?php echo htmlentities($row_Recordset1['ID_SALIDA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr>
            <td>Id Materia Prima:</td>
            <td><input type="text" name="IDMATPRIMA" value="<?php echo htmlentities($row_Recordset1['IDMATPRIMA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td>Unidad:</td>
            <td><input type="text" name="IDUNIDAD" value="<?php echo htmlentities($row_Recordset1['IDUNIDAD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr>
            <td>Cantidad Entregada:</td>
            <td><input type="text" name="CANT_ENTREGA" value="<?php echo htmlentities($row_Recordset1['CANT_ENTREGA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td>Cantidad Devuelta:</td>
            <td><input type="text" name="CANT_DEVUELTA" value="<?php echo htmlentities($row_Recordset1['CANT_DEVUELTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr>
            <td>Cantidad Utilizada:</td>
            <td><input type="text" disable="disable" name="CANT_UTILIZADA" value="<?php echo htmlentities ($row_Recordset1['CANT_UTILIZADA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
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
            <td><input type="submit" value="Actualizar registro" /></td>
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
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <input type="hidden" name="MM_update" value="form3" />
        <input type="hidden" name="ID_CONTROLMAT" value="<?php echo $row_Recordset1['ID_CONTROLMAT']; ?>" />
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($combomateprima);

mysql_free_result($Recordset2);
?>
