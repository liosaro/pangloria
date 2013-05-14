<?php require_once('file:///C|/Users/Connections/basepangloria.php'); ?>
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
  $updateSQL = sprintf("UPDATE TRNPEDIDO_MAT_PRIMA SET ID_ENCAPEDIDO=%s, IDUNIDAD=%s, IDMATPRIMA=%s, CANTIDADPEDMATPRI=%s WHERE ID_PED_MAT_PRIMA=%s",
                       GetSQLValueString($_POST['ID_ENCAPEDIDO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['CANTIDADPEDMATPRI'], "double"),
                       GetSQLValueString($_POST['ID_PED_MAT_PRIMA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modetalle = "-1";
if (isset($_GET['idped'])) {
  $colname_modetalle = $_GET['idped'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modetalle = sprintf("SELECT * FROM TRNPEDIDO_MAT_PRIMA WHERE ID_PED_MAT_PRIMA = %s", GetSQLValueString($colname_modetalle, "int"));
$modetalle = mysql_query($query_modetalle, $basepangloria) or die(mysql_error());
$row_modetalle = mysql_fetch_assoc($modetalle);
$totalRows_modetalle = mysql_num_rows($modetalle);

mysql_select_db($database_basepangloria, $basepangloria);
$query_conunidad = "SELECT * FROM CATUNIDADES";
$conunidad = mysql_query($query_conunidad, $basepangloria) or die(mysql_error());
$row_conunidad = mysql_fetch_assoc($conunidad);
$totalRows_conunidad = mysql_num_rows($conunidad);

mysql_select_db($database_basepangloria, $basepangloria);
$query_conmati = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$conmati = mysql_query($query_conmati, $basepangloria) or die(mysql_error());
$row_conmati = mysql_fetch_assoc($conmati);
$totalRows_conmati = mysql_num_rows($conmati);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="810" border="0">
  <tr>
    <td align="left"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="left">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID_PED_MAT_PRIMA:</td>
            <td><?php echo $row_modetalle['ID_PED_MAT_PRIMA']; ?></td>
            <td>ID_ENCAPEDIDO:</td>
            <td><input type="text" name="ID_ENCAPEDIDO" value="<?php echo htmlentities($row_modetalle['ID_ENCAPEDIDO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDUNIDAD:</td>
            <td><select name="IDUNIDAD">
              <?php 
do {  
?>
              <option value="<?php echo $row_conunidad['IDUNIDAD']?>" <?php if (!(strcmp($row_conunidad['IDUNIDAD'], htmlentities($row_modetalle['IDUNIDAD'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_conunidad['TIPOUNIDAD']?></option>
              <?php
} while ($row_conunidad = mysql_fetch_assoc($conunidad));
?>
            </select></td>
            <td>IDMATPRIMA:</td>
            <td><select name="IDMATPRIMA">
              <?php 
do {  
?>
              <option value="<?php echo $row_conmati['IDMATPRIMA']?>" <?php if (!(strcmp($row_conmati['IDMATPRIMA'], htmlentities($row_modetalle['IDMATPRIMA'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_conmati['DESCRIPCION']?></option>
              <?php
} while ($row_conmati = mysql_fetch_assoc($conmati));
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CANTIDADPEDMATPRI:</td>
            <td><input type="text" name="CANTIDADPEDMATPRI" value="<?php echo htmlentities($row_modetalle['CANTIDADPEDMATPRI'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> </tr>
          <tr> </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Actualizar registro" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="ID_PED_MAT_PRIMA" value="<?php echo $row_modetalle['ID_PED_MAT_PRIMA']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($modetalle);

mysql_free_result($conunidad);

mysql_free_result($conmati);
?>
