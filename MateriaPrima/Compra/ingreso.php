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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
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

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT IDORDEN FROM TRNENCAORDCOMPRA";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="820" border="0">
    <tr>
      <td><table width="99%" border="1">
        <tr>
          <td colspan="8" align="center" bgcolor="#999999"><h1>&nbsp;</h1>
            <h1>Formulario para el Ingreso de Compra</h1></td>
          </tr>
        <tr>
          <td align="center">ID_DETENCCOM</td>
          <td align="center"><select name="ID_DETENCCOM">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td align="center">IDPROVEEDOR:</td>
          <td align="center"><select name="IDPROVEEDOR">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td align="center">No.FACTURA:</td>
          <td align="center"><input type="text" name="NOFACTURA" value="" size="32" /></td>
          <td align="center">FECHACOMPRA:</td>
          <td align="center"><input type="text" name="FECHACOMPRA" value="" size="32" /></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">IDORDEN:</td>
          <td align="center"><select name="IDORDEN">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td align="center">IDEMPLEADO</td>
          <td align="center"><select name="IDEMPLEADO">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">IDESTAFACTURA: </td>
          <td align="center"><select name="IDESTAFACTURA">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td align="center">ID_TIPO_FACTURA:</td>
          <td align="center"><select name="ID_TIPO_FACTURA">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
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
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" value="Insertar registro" /></td>
        </tr>
        <tr>
          <td colspan="8" align="center" bgcolor="#999999"><h1>Dellate de la Compra</h1></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
  <table width="99%" border="1">
    <tr>
      <td width="8%">IDCOMPRA:</td>
      <td width="18%"><input type="text" name="IDCOMPRA" value="" size="32" /></td>
      <td width="8%">IDUNIDAD:</td>
      <td width="10%"><select name="IDUNIDAD">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
      <td width="12%">ID_DETENCCOM</td>
      <td width="10%"><select name="ID_DETENCCOM2">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
      <td width="16%">MATERIAPRIMA</td>
      <td width="18%"><select name="MATERIAPRIMA">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
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
      <td>CANTIDADMATPRIMA:</td>
      <td><input type="text" name="CANTIDADMATPRIMA" value="" size="32" /></td>
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
    </tr>
    <tr>
      <td>PRECIOUNIDAD</td>
      <td><input type="text" name="PRECIOUNIDAD" value="" size="32" /></td>
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
    </tr>
    <tr>
      <td>PRECIOTOTAL</td>
      <td><input type="text" name="PRECIOTOTAL" value="" size="32" /></td>
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
    </tr>
    <tr>
      <td>DESCUENTO</td>
      <td><input type="text" name="DESCUENTO" value="" size="32" /></td>
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
    </tr>
    <tr>
      <td>SUBTOTAL</td>
      <td><input type="text" name="SUBTOTAL" value="" size="32" /></td>
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
    </tr>
    <tr>
      <td>IVA:</td>
      <td><input type="text" name="IVA" value="" size="32" /></td>
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
    </tr>
    <tr>
      <td>TOTAL</td>
      <td><input type="text" name="TOTAL" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form3" />
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form4" id="form4">
  <input type="hidden" name="MM_insert" value="form4" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
