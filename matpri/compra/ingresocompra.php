<?php require_once('../../Connections/basepangloria.php'); ?>
<?php require_once('../../Connections/basepangloria.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO TRNDETALLECOMPRA (IDCOMPRA, IDUNIDAD, ID_DETENCCOM, CANTIDADMATPRIMA, MATERIAPRIMA, PRECIOUNIDAD, PRECIOTOTAL, DESCUENTO, SUBTOTAL, IVA, TOTAL) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDCOMPRA'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['CANTIDADMATPRIMA'], "int"),
                       GetSQLValueString($_POST['MATERIAPRIMA'], "int"),
                       GetSQLValueString($_POST['PRECIOUNIDAD'], "double"),
                       GetSQLValueString($_POST['PRECIOTOTAL'], "double"),
                       GetSQLValueString($_POST['DESCUENTO'], "double"),
                       GetSQLValueString($_POST['SUBTOTAL'], "double"),
                       GetSQLValueString($_POST['IVA'], "double"),
                       GetSQLValueString($_POST['TOTAL'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$colname_ComboTipoFactura = "-1";
if (isset($_GET['IDESTAFACTURA'])) {
  $colname_ComboTipoFactura = $_GET['IDESTAFACTURA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_ComboTipoFactura = sprintf("SELECT IDESTAFACTURA, ESTADO FROM CATESTADOFACTURA WHERE IDESTAFACTURA = %s ORDER BY ESTADO ASC", GetSQLValueString($colname_ComboTipoFactura, "int"));
$ComboTipoFactura = mysql_query($query_ComboTipoFactura, $basepangloria) or die(mysql_error());
$row_ComboTipoFactura = mysql_fetch_assoc($ComboTipoFactura);
$totalRows_ComboTipoFactura = mysql_num_rows($ComboTipoFactura);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combotipofactura2 = "SELECT ESTADO FROM CATESTADOFACTURA";
$combotipofactura2 = mysql_query($query_combotipofactura2, $basepangloria) or die(mysql_error());
$row_combotipofactura2 = mysql_fetch_assoc($combotipofactura2);
$totalRows_combotipofactura2 = mysql_num_rows($combotipofactura2);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ComboOrdendeCompra = "SELECT IDORDEN FROM TRNENCAORDCOMPRA";
$ComboOrdendeCompra = mysql_query($query_ComboOrdendeCompra, $basepangloria) or die(mysql_error());
$row_ComboOrdendeCompra = mysql_fetch_assoc($ComboOrdendeCompra);
$totalRows_ComboOrdendeCompra = mysql_num_rows($ComboOrdendeCompra);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ComboProveedor = "SELECT IDPROVEEDOR, NOMBREPROVEEDOR FROM CATPROVEEDOR";
$ComboProveedor = mysql_query($query_ComboProveedor, $basepangloria) or die(mysql_error());
$row_ComboProveedor = mysql_fetch_assoc($ComboProveedor);
$totalRows_ComboProveedor = mysql_num_rows($ComboProveedor);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ComboEmpleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$ComboEmpleado = mysql_query($query_ComboEmpleado, $basepangloria) or die(mysql_error());
$row_ComboEmpleado = mysql_fetch_assoc($ComboEmpleado);
$totalRows_ComboEmpleado = mysql_num_rows($ComboEmpleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboEstadodeFactura = "SELECT IDESTAFACTURA, ESTADO FROM CATESTADOFACTURA";
$comboEstadodeFactura = mysql_query($query_comboEstadodeFactura, $basepangloria) or die(mysql_error());
$row_comboEstadodeFactura = mysql_fetch_assoc($comboEstadodeFactura);
$totalRows_comboEstadodeFactura = mysql_num_rows($comboEstadodeFactura);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboordendecompra2 = "SELECT IDCOMPRA FROM TRNDETALLECOMPRA";
$comboordendecompra2 = mysql_query($query_comboordendecompra2, $basepangloria) or die(mysql_error());
$row_comboordendecompra2 = mysql_fetch_assoc($comboordendecompra2);
$totalRows_comboordendecompra2 = mysql_num_rows($comboordendecompra2);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT IDUNIDAD FROM TRNDETALLECOMPRA";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="1">
  <tr>
    <td align="center" valign="baseline">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="baseline"><table width="99%" border="1">
        <tr>
          <td colspan="4" align="center" valign="middle"><h1>Formulario Ingreso de Compra</h1></td>
        </tr>
        <tr>
          <td width="29%">Codigo de la Compra :</td>
          <td width="29%"><input name="ID_DETENCCOM" type="text" disabled="disabled" value="" size="32" /></td>
          <td width="36%">Codigo del Proveedor </td>
          <td width="6%"><select name="IDPROVEEDOR">
            <?php
do {  
?>
            <option value="<?php echo $row_ComboProveedor['IDPROVEEDOR']?>"><?php echo $row_ComboProveedor['NOMBREPROVEEDOR']?></option>
            <?php
} while ($row_ComboProveedor = mysql_fetch_assoc($ComboProveedor));
  $rows = mysql_num_rows($ComboProveedor);
  if($rows > 0) {
      mysql_data_seek($ComboProveedor, 0);
	  $row_ComboProveedor = mysql_fetch_assoc($ComboProveedor);
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
          <td>Codigo de Orden de Compra</td>
          <td><form id="form2" name="form2" method="post" action="">
            <span id="spryselect2">
              <select name="select2" id="select2">
                <?php
do {  
?>
                <option value="<?php echo $row_ComboOrdendeCompra['IDORDEN']?>"><?php echo $row_ComboOrdendeCompra['IDORDEN']?></option>
                <?php
} while ($row_ComboOrdendeCompra = mysql_fetch_assoc($ComboOrdendeCompra));
  $rows = mysql_num_rows($ComboOrdendeCompra);
  if($rows > 0) {
      mysql_data_seek($ComboOrdendeCompra, 0);
	  $row_ComboOrdendeCompra = mysql_fetch_assoc($ComboOrdendeCompra);
  }
?>
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
          </form></td>
          <td>Codigo del Empleado</td>
          <td><select name="IDEMPLEADO">
            <?php
do {  
?>
            <option value="<?php echo $row_ComboEmpleado['IDEMPLEADO']?>"><?php echo $row_ComboEmpleado['NOMBREEMPLEADO']?></option>
            <?php
} while ($row_ComboEmpleado = mysql_fetch_assoc($ComboEmpleado));
  $rows = mysql_num_rows($ComboEmpleado);
  if($rows > 0) {
      mysql_data_seek($ComboEmpleado, 0);
	  $row_ComboEmpleado = mysql_fetch_assoc($ComboEmpleado);
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
          <td>Tipo de Factura</td>
          <td><span id="spryselect1">
            <select name="select1" id="select1">
              <?php
do {  
?>
              <option value="<?php echo $row_combotipofactura2['ESTADO']?>"><?php echo $row_combotipofactura2['ESTADO']?></option>
              <?php
} while ($row_combotipofactura2 = mysql_fetch_assoc($combotipofactura2));
  $rows = mysql_num_rows($combotipofactura2);
  if($rows > 0) {
      mysql_data_seek($combotipofactura2, 0);
	  $row_combotipofactura2 = mysql_fetch_assoc($combotipofactura2);
  }
?>
            </select>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
          <td>Estado de la Factura :</td>
          <td><select name="IDESTAFACTURA">
            <?php
do {  
?>
            <option value="<?php echo $row_comboEstadodeFactura['IDESTAFACTURA']?>"><?php echo $row_comboEstadodeFactura['ESTADO']?></option>
            <?php
} while ($row_comboEstadodeFactura = mysql_fetch_assoc($comboEstadodeFactura));
  $rows = mysql_num_rows($comboEstadodeFactura);
  if($rows > 0) {
      mysql_data_seek($comboEstadodeFactura, 0);
	  $row_comboEstadodeFactura = mysql_fetch_assoc($comboEstadodeFactura);
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
          <td>No de Factura </td>
          <td><input type="text" name="NOFACTURA" value="" size="32" /></td>
          <td>Fecha de Compra</td>
          <td><input type="text" name="FECHACOMPRA" value="" size="32" /></td>
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
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="99%" border="1">
          <tr>
            <td>IDCOMPRA</td>
            <td><select name="IDCOMPRA">
              <?php
do {  
?>
              <option value="<?php echo $row_comboordendecompra2['IDCOMPRA']?>"><?php echo $row_comboordendecompra2['IDCOMPRA']?></option>
              <?php
} while ($row_comboordendecompra2 = mysql_fetch_assoc($comboordendecompra2));
  $rows = mysql_num_rows($comboordendecompra2);
  if($rows > 0) {
      mysql_data_seek($comboordendecompra2, 0);
	  $row_comboordendecompra2 = mysql_fetch_assoc($comboordendecompra2);
  }
?>
            </select></td>
            <td>IDUNIDAD</td>
            <td><input type="text" name="IDUNIDAD" value="" size="32" /></td>
            <td>ID_DETENCCOM</td>
            <td><select name="ID_DETENCCOM2">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
            <td>CANTIDADMATPRIMA</td>
            <td>PRECIOUNIDAD</td>
            <td><input type="text" name="PRECIOUNIDAD" value="" size="32" /></td>
            <td>PRECIOTOTAL</td>
            <td><input type="text" name="PRECIOTOTAL" value="" size="32" /></td>
            <td><input type="text" name="CANTIDADMATPRIMA" value="" size="32" /></td>
            <td>MATERIAPRIMA</td>
            <td><input type="text" name="MATERIAPRIMA" value="" size="32" /></td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form3" />
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
</html>
<?php
mysql_free_result($ComboTipoFactura);

mysql_free_result($combotipofactura2);

mysql_free_result($ComboOrdendeCompra);

mysql_free_result($ComboProveedor);

mysql_free_result($ComboEmpleado);

mysql_free_result($comboEstadodeFactura);

mysql_free_result($comboordendecompra2);

mysql_free_result($Recordset1);
?>
