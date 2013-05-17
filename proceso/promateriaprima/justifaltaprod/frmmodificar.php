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
  $updateSQL = sprintf("UPDATE TRNJUSTIFICACIONFALTAPRODUCTO SET IDCONTROLPRODUCCION=%s, CANTIDA_FALTANTE=%s, IDPRODUCTOFALTA=%s, ID_MEDIDA=%s, FECHAINGRESOJUSFAPROD=%s, JUSTIFICACIONFALTAPROD=%s WHERE ID_JUSTIFICACION=%s",
                       GetSQLValueString($_POST['IDCONTROLPRODUCCION'], "int"),
                       GetSQLValueString($_POST['CANTIDA_FALTANTE'], "double"),
                       GetSQLValueString($_POST['IDPRODUCTOFALTA'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSFAPROD'], "date"),
                       GetSQLValueString($_POST['JUSTIFICACIONFALTAPROD'], "text"),
                       GetSQLValueString($_POST['ID_JUSTIFICACION'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modificacion = "-1";
if (isset($_POST['select'])) {
  $colname_modificacion = $_POST['select'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modificacion = sprintf("SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO WHERE ID_JUSTIFICACION = %s", GetSQLValueString($colname_modificacion, "int"));
$modificacion = mysql_query($query_modificacion, $basepangloria) or die(mysql_error());
$row_modificacion = mysql_fetch_assoc($modificacion);
$totalRows_modificacion = mysql_num_rows($modificacion);

mysql_select_db($database_basepangloria, $basepangloria);
$query_controlprod = "SELECT ID_CONTROLPRODUCCION FROM TRNCONTROL_DEPRODUCCION ORDER BY ID_CONTROLPRODUCCION DESC";
$controlprod = mysql_query($query_controlprod, $basepangloria) or die(mysql_error());
$row_controlprod = mysql_fetch_assoc($controlprod);
$totalRows_controlprod = mysql_num_rows($controlprod);

mysql_select_db($database_basepangloria, $basepangloria);
$query_product = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO ORDER BY IDPRODUCTO DESC";
$product = mysql_query($query_product, $basepangloria) or die(mysql_error());
$row_product = mysql_fetch_assoc($product);
$totalRows_product = mysql_num_rows($product);

mysql_select_db($database_basepangloria, $basepangloria);
$query_conmedi = "SELECT * FROM CATMEDIDAS";
$conmedi = mysql_query($query_conmedi, $basepangloria) or die(mysql_error());
$row_conmedi = mysql_fetch_assoc($conmedi);
$totalRows_conmedi = mysql_num_rows($conmedi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <p>&nbsp;</p>
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#999999"><h1>Modificar Justificacion Falta de Producto </h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_JUSTIFICACION:</td>
      <td><?php echo $row_modificacion['ID_JUSTIFICACION']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDCONTROLPRODUCCION:</td>
      <td><select name="IDCONTROLPRODUCCION">
        <?php 
do {  
?>
        <option value="<?php echo $row_controlprod['ID_CONTROLPRODUCCION']?>" <?php if (!(strcmp($row_controlprod['ID_CONTROLPRODUCCION'], htmlentities($row_modificacion['IDCONTROLPRODUCCION'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_controlprod['ID_CONTROLPRODUCCION']?></option>
        <?php
} while ($row_controlprod = mysql_fetch_assoc($controlprod));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANTIDA_FALTANTE:</td>
      <td><input type="text" name="CANTIDA_FALTANTE" value="<?php echo htmlentities($row_modificacion['CANTIDA_FALTANTE'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDPRODUCTOFALTA:</td>
      <td><select name="IDPRODUCTOFALTA">
        <?php 
do {  
?>
        <option value="<?php echo $row_product['IDPRODUCTO']?>" <?php if (!(strcmp($row_product['IDPRODUCTO'], htmlentities($row_modificacion['IDPRODUCTOFALTA'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_product['DESCRIPCIONPRODUC']?></option>
        <?php
} while ($row_product = mysql_fetch_assoc($product));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_MEDIDA:</td>
      <td><select name="ID_MEDIDA">
        <?php 
do {  
?>
        <option value="<?php echo $row_conmedi['ID_MEDIDA']?>" <?php if (!(strcmp($row_conmedi['ID_MEDIDA'], htmlentities($row_modificacion['ID_MEDIDA'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_conmedi['MEDIDA']?></option>
        <?php
} while ($row_conmedi = mysql_fetch_assoc($conmedi));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FECHAINGRESOJUSFAPROD:</td>
      <td><input type="text" name="FECHAINGRESOJUSFAPROD" value="<?php echo htmlentities($row_modificacion['FECHAINGRESOJUSFAPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">JUSTIFICACIONFALTAPROD:</td>
      <td><input type="text" name="JUSTIFICACIONFALTAPROD" value="<?php echo htmlentities($row_modificacion['JUSTIFICACIONFALTAPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_JUSTIFICACION" value="<?php echo $row_modificacion['ID_JUSTIFICACION']; ?>" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modificacion);

mysql_free_result($controlprod);

mysql_free_result($product);

mysql_free_result($conmedi);
?>
