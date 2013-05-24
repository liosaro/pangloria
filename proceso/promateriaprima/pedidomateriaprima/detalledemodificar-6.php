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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE TRNPEDIDO_MAT_PRIMA SET ID_ENCAPEDIDO=%s, IDUNIDAD=%s, IDMATPRIMA=%s, CANTIDADPEDMATPRI=%s, ELIMIN=%s, EDITA=%s WHERE ID_PED_MAT_PRIMA=%s",
                       GetSQLValueString($_POST['ID_ENCAPEDIDO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['CANTIDADPEDMATPRI'], "double"),
                       GetSQLValueString($_POST['ELIMIN'], "int"),
                       GetSQLValueString($_POST['EDITA'], "int"),
                       GetSQLValueString($_POST['ID_PED_MAT_PRIMA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());

  $updateGoTo = "paramodificar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_conuslmatpri = "-1";
if (isset($_GET['root'])) {
  $colname_conuslmatpri = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_conuslmatpri = sprintf("SELECT * FROM TRNPEDIDO_MAT_PRIMA WHERE ID_PED_MAT_PRIMA = %s ORDER BY IDMATPRIMA ASC", GetSQLValueString($colname_conuslmatpri, "int"));
$conuslmatpri = mysql_query($query_conuslmatpri, $basepangloria) or die(mysql_error());
$row_conuslmatpri = mysql_fetch_assoc($conuslmatpri);
$totalRows_conuslmatpri = mysql_num_rows($conuslmatpri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820">
  <tr>
    <td>&nbsp;
      <table width="99%">
        <tr>
          <td width="20%">ID_PED_MAT_PRIMA:</td>
          <td width="31%"><?php echo $row_conuslmatpri['ID_PED_MAT_PRIMA']; ?></td>
          <td width="17%">ID_ENCAPEDIDO:</td>
          <td width="25%"><input type="text" name="ID_ENCAPEDIDO" value="<?php echo htmlentities($row_conuslmatpri['ID_ENCAPEDIDO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          <td width="4%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
          <td>IDUNIDAD:</td>
          <td><select name="IDUNIDAD">
            <option value="menuitem1" <?php if (!(strcmp("menuitem1", <?php echo htmlentities($row_conuslmatpri['IDUNIDAD'], ENT_COMPAT, 'utf-8'); ?>))) {echo "selected";} ?>&gt;[ Etiqueta ]</option>
            <option value="menuitem2" <?php if (!(strcmp("menuitem2", <?php echo htmlentities($row_conuslmatpri['IDUNIDAD'], ENT_COMPAT, 'utf-8'); ?>))) {echo "selected";} ?>&gt;[ Etiqueta ]</option>
          </select></td>
          <td>CANTIDADPEDMATPRI:</td>
          <td><input type="text" name="CANTIDADPEDMATPRI" value="<?php echo htmlentities($row_conuslmatpri['CANTIDADPEDMATPRI'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>IDMATPRIMA:</td>
          <td><select name="IDMATPRIMA">
            <option value="menuitem1" <?php if (!(strcmp("menuitem1", <?php echo htmlentities($row_conuslmatpri['IDMATPRIMA'], ENT_COMPAT, 'utf-8'); ?>))) {echo "selected";} ?>&gt;[ Etiqueta ]</option>
            <option value="menuitem2" <?php if (!(strcmp("menuitem2", <?php echo htmlentities($row_conuslmatpri['IDMATPRIMA'], ENT_COMPAT, 'utf-8'); ?>))) {echo "selected";} ?>&gt;[ Etiqueta ]</option>
          </select></td>
          <td>ELIMIN:</td>
          <td><input type="text" name="ELIMIN" value="<?php echo htmlentities($row_conuslmatpri['ELIMIN'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>EDITA</td>
          <td><input type="text" name="EDITA" value="<?php echo htmlentities($row_conuslmatpri['EDITA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
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
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" value="Actualizar registro" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="ID_PED_MAT_PRIMA" value="<?php echo $row_conuslmatpri['ID_PED_MAT_PRIMA']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
</form>
</body>
</html>
<?php
mysql_free_result($conuslmatpri);
?>
