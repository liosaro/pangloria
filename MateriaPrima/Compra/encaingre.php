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
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOCOMPRA (ID_DETENCCOM, IDPROVEEDOR, IDORDEN, IDEMPLEADO, ID_TIPO_FACTURA, IDESTAFACTURA, NOFACTURA, FECHACOMPRA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDORDEN'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_TIPO_FACTURA'], "int"),
                       GetSQLValueString($_POST['IDESTAFACTURA'], "int"),
                       GetSQLValueString($_POST['NOFACTURA'], "text"),
                       GetSQLValueString($_POST['FECHACOMPRA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulemple = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO ORDER BY IDEMPLEADO ASC";
$consulemple = mysql_query($query_consulemple, $basepangloria) or die(mysql_error());
$row_consulemple = mysql_fetch_assoc($consulemple);
$totalRows_consulemple = mysql_num_rows($consulemple);

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulestadoF = "SELECT * FROM CATESTADOFACTURA ORDER BY ESTADO ASC";
$consulestadoF = mysql_query($query_consulestadoF, $basepangloria) or die(mysql_error());
$row_consulestadoF = mysql_fetch_assoc($consulestadoF);
$totalRows_consulestadoF = mysql_num_rows($consulestadoF);

mysql_select_db($database_basepangloria, $basepangloria);
$query_consutipF = "SELECT * FROM CATTIPOFACTURA ORDER BY TIPOFACTURA ASC";
$consutipF = mysql_query($query_consutipF, $basepangloria) or die(mysql_error());
$row_consutipF = mysql_fetch_assoc($consutipF);
$totalRows_consutipF = mysql_num_rows($consutipF);

mysql_select_db($database_basepangloria, $basepangloria);
$query_consulprovee = "SELECT * FROM CATPROVEEDOR ORDER BY NOMBREPROVEEDOR ASC";
$consulprovee = mysql_query($query_consulprovee, $basepangloria) or die(mysql_error());
$row_consulprovee = mysql_fetch_assoc($consulprovee);
$totalRows_consulprovee = mysql_num_rows($consulprovee);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ConsulOrd = "SELECT IDORDEN FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$ConsulOrd = mysql_query($query_ConsulOrd, $basepangloria) or die(mysql_error());
$row_ConsulOrd = mysql_fetch_assoc($ConsulOrd);
$totalRows_ConsulOrd = mysql_num_rows($ConsulOrd);

mysql_select_db($database_basepangloria, $basepangloria);
$query_conuslencabcompra = "SELECT ID_DETENCCOM FROM TRNENCABEZADOCOMPRA ORDER BY ID_DETENCCOM DESC";
$conuslencabcompra = mysql_query($query_conuslencabcompra, $basepangloria) or die(mysql_error());
$row_conuslencabcompra = mysql_fetch_assoc($conuslencabcompra);
$totalRows_conuslencabcompra = mysql_num_rows($conuslencabcompra);
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
      <td colspan="4" align="left" nowrap="nowrap">Encabezado de Comras</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Codigo de Compra:</td>
      <td><input type="text" disabled="disabled" name="ID_DETENCCOM" value="<?php echo $row_conuslencabcompra['ID_DETENCCOM']; ?>" size="32" /></td>
      
      
      
      <td align="right">Proveedor</td>
      <td><select name="IDPROVEEDOR">
        <?php 
do {  
?>
        <option value="<?php echo $row_consulprovee['IDPROVEEDOR']?>" ><?php echo $row_consulprovee['NOMBREPROVEEDOR']?></option>
        <?php
} while ($row_consulprovee = mysql_fetch_assoc($consulprovee));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Factura de referencia</td>
      <td><input type="text" name="NOFACTURA" value="" size="32" /></td>
      <td align="right">Empleado</td>
      <td><select name="IDEMPLEADO">
        <?php 
do {  
?>
        <option value="<?php echo $row_consulemple['IDEMPLEADO']?>" ><?php echo $row_consulemple['NOMBREEMPLEADO']?></option>
        <?php
} while ($row_consulemple = mysql_fetch_assoc($consulemple));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Fecha de Compra:</td>
      <td><input type="text" name="FECHACOMPRA" value="" size="32" /></td>
      <td align="right">Orden de Produccion</td>
      <td><select name="IDORDEN">
        <?php 
do {  
?>
        <option value="<?php echo $row_ConsulOrd['IDORDEN']?>" ><?php echo $row_ConsulOrd['IDORDEN']?></option>
        <?php
} while ($row_ConsulOrd = mysql_fetch_assoc($ConsulOrd));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tipo de Factura</td>
      <td><select name="ID_TIPO_FACTURA">
        <?php 
do {  
?>
        <option value="<?php echo $row_consutipF['ID_TIPO_FACTURA']?>" ><?php echo $row_consutipF['TIPOFACTURA']?></option>
        <?php
} while ($row_consutipF = mysql_fetch_assoc($consutipF));
?>
      </select></td>
      <td align="right">Estado de Factura:</td>
      <td><select name="IDESTAFACTURA">
        <?php 
do {  
?>
        <option value="<?php echo $row_consulestadoF['IDESTAFACTURA']?>" ><?php echo $row_consulestadoF['ESTADO']?></option>
        <?php
} while ($row_consulestadoF = mysql_fetch_assoc($consulestadoF));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consulemple);

mysql_free_result($consulestadoF);

mysql_free_result($consutipF);

mysql_free_result($consulprovee);

mysql_free_result($ConsulOrd);

mysql_free_result($conuslencabcompra);
?>
