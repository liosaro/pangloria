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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE CATPROVEEDOR SET IDPAIS=%s, NOMBREPROVEEDOR=%s, DIRECCIONPROVEEDOR=%s, TELEFONOPROVEEDOR=%s, CORREOPROVEEDOR=%s, FECHAINGRESOPROVE=%s, GIRO=%s, NUMEROREGISTRO=%s, WEB=%s, DEPTOPAISPROVEEDOR=%s WHERE IDPROVEEDOR=%s",
                       GetSQLValueString($_POST['IDPAIS'], "int"),
                       GetSQLValueString($_POST['NOMBREPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['DIRECCIONPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['TELEFONOPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['CORREOPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['FECHAINGRESOPROVE'], "date"),
                       GetSQLValueString($_POST['GIRO'], "text"),
                       GetSQLValueString($_POST['NUMEROREGISTRO'], "text"),
                       GetSQLValueString($_POST['WEB'], "text"),
                       GetSQLValueString($_POST['DEPTOPAISPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modiProvee = "-1";
if (isset($_GET['root'])) {
  $colname_modiProvee = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiProvee = sprintf("SELECT * FROM CATPROVEEDOR WHERE IDPROVEEDOR = %s", GetSQLValueString($colname_modiProvee, "int"));
$modiProvee = mysql_query($query_modiProvee, $basepangloria) or die(mysql_error());
$row_modiProvee = mysql_fetch_assoc($modiProvee);
$totalRows_modiProvee = mysql_num_rows($modiProvee);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combpais = "SELECT * FROM CATPAIS";
$combpais = mysql_query($query_combpais, $basepangloria) or die(mysql_error());
$row_combpais = mysql_fetch_assoc($combpais);
$totalRows_combpais = mysql_num_rows($combpais);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combdepPais = "SELECT * FROM CATDEPTOPAIS";
$combdepPais = mysql_query($query_combdepPais, $basepangloria) or die(mysql_error());
$row_combdepPais = mysql_fetch_assoc($combdepPais);
$totalRows_combdepPais = mysql_num_rows($combdepPais);
?>

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?php
mysql_free_result($modiProvee);

mysql_free_result($combpais);

mysql_free_result($combdepPais);
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Modificar Proveedor</h1></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Id Proveedor:</td>
      <td><?php echo $row_modiProvee['IDPROVEEDOR']; ?></td>
      <td>Direccion del Proveedor:</td>
      <td><input type="text" name="DIRECCIONPROVEEDOR" value="<?php echo htmlentities($row_modiProvee['DIRECCIONPROVEEDOR'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Id Pais:</td>
      <td><select name="IDPAIS">
        <?php
do {  
?>
        <option value="<?php echo $row_combpais['IDPAIS']?>"<?php if (!(strcmp($row_combpais['IDPAIS'], htmlentities($row_modiProvee['IDPAIS'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_combpais['NOMBREDEPAIS']?></option>
        <?php
} while ($row_combpais = mysql_fetch_assoc($combpais));
  $rows = mysql_num_rows($combpais);
  if($rows > 0) {
      mysql_data_seek($combpais, 0);
	  $row_combpais = mysql_fetch_assoc($combpais);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Nombre del Proveedor:</td>
      <td><input type="text" name="NOMBREPROVEEDOR" value="<?php echo htmlentities($row_modiProvee['NOMBREPROVEEDOR'], ENT_COMPAT, ''); ?>" size="32"></td>
      <td>Departamento Pais Proveedor:</td>
      <td><select name="DEPTOPAISPROVEEDOR">
        <?php
do {  
?>
        <option value="<?php echo $row_combdepPais['IDDP']?>"<?php if (!(strcmp($row_combdepPais['IDDP'], htmlentities($row_modiProvee['DEPTOPAISPROVEEDOR'], ENT_COMPAT, '')))) {echo "selected=\"selected\"";} ?>><?php echo $row_combdepPais['NOMBREDEPTOPAIS']?></option>
        <?php
} while ($row_combdepPais = mysql_fetch_assoc($combdepPais));
  $rows = mysql_num_rows($combdepPais);
  if($rows > 0) {
      mysql_data_seek($combdepPais, 0);
	  $row_combdepPais = mysql_fetch_assoc($combdepPais);
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
      <td>Telefono del Proveedor:</td>
      <td><input type="text" name="TELEFONOPROVEEDOR" value="<?php echo htmlentities($row_modiProvee['TELEFONOPROVEEDOR'], ENT_COMPAT, ''); ?>" size="32"></td>
      <td>Correo del Proveedor:</td>
      <td><input type="text" name="CORREOPROVEEDOR" value="<?php echo htmlentities($row_modiProvee['CORREOPROVEEDOR'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="baseline" nowrap>Fecha de Ingreso Proveedor:</td>
      <td><input type="text" name="FECHAINGRESOPROVE" value="<?php echo htmlentities($row_modiProvee['FECHAINGRESOPROVE'], ENT_COMPAT, ''); ?>" size="32"></td>
      <td>Giro:</td>
      <td><input type="text" name="GIRO" value="<?php echo htmlentities($row_modiProvee['GIRO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Numero de Registro:</td>
      <td><input type="text" name="NUMEROREGISTRO" value="<?php echo htmlentities($row_modiProvee['NUMEROREGISTRO'], ENT_COMPAT, ''); ?>" size="32"></td>
      <td>Web:</td>
      <td><input type="text" name="WEB" value="<?php echo htmlentities($row_modiProvee['WEB'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" value="Actualizar registro"></td>
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
  <p>
    <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="IDPROVEEDOR" value="<?php echo $row_modiProvee['IDPROVEEDOR']; ?>">
</p>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
