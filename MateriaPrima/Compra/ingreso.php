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

mysql_select_db($database_basepangloria, $basepangloria);
$query_COMestadofact = "SELECT ESTADO FROM CATESTADOFACTURA ORDER BY ESTADO ASC";
$COMestadofact = mysql_query($query_COMestadofact, $basepangloria) or die(mysql_error());
$row_COMestadofact = mysql_fetch_assoc($COMestadofact);
$totalRows_COMestadofact = mysql_num_rows($COMestadofact);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comproveedor = "SELECT NOMBREPROVEEDOR FROM CATPROVEEDOR ORDER BY IDPROVEEDOR ASC";
$comproveedor = mysql_query($query_comproveedor, $basepangloria) or die(mysql_error());
$row_comproveedor = mysql_fetch_assoc($comproveedor);
$totalRows_comproveedor = mysql_num_rows($comproveedor);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comEmple = "SELECT NOMBREEMPLEADO FROM CATEMPLEADO ORDER BY NOMBREEMPLEADO ASC";
$comEmple = mysql_query($query_comEmple, $basepangloria) or die(mysql_error());
$row_comEmple = mysql_fetch_assoc($comEmple);
$totalRows_comEmple = mysql_num_rows($comEmple);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Ctipfactura = "SELECT TIPOFACTURA FROM CATTIPOFACTURA ORDER BY TIPOFACTURA ASC";
$Ctipfactura = mysql_query($query_Ctipfactura, $basepangloria) or die(mysql_error());
$row_Ctipfactura = mysql_fetch_assoc($Ctipfactura);
$totalRows_Ctipfactura = mysql_num_rows($Ctipfactura);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comunid = "SELECT TIPOUNIDAD FROM CATUNIDADES ORDER BY TIPOUNIDAD ASC";
$comunid = mysql_query($query_comunid, $basepangloria) or die(mysql_error());
$row_comunid = mysql_fetch_assoc($comunid);
$totalRows_comunid = mysql_num_rows($comunid);

mysql_select_db($database_basepangloria, $basepangloria);
$query_commatprim = "SELECT DESCRIPCION FROM CATMATERIAPRIMA ORDER BY DESCRIPCION ASC";
$commatprim = mysql_query($query_commatprim, $basepangloria) or die(mysql_error());
$row_commatprim = mysql_fetch_assoc($commatprim);
$totalRows_commatprim = mysql_num_rows($commatprim);
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
          <td width="16%" align="center">ID_DETENCCOM</td>
          <td width="14%" align="center"><label for="IDCOMPRA"></label>
            <input name="IDCOMPRA2" type="text" disabled="disabled" id="IDCOMPRA" readonly="readonly" /></td>
          <td width="12%" align="left">Nombre de Proveedor:</td>
          <td width="4%" align="left"><select name="IDPROVEEDOR">
            <?php
do {  
?>
            <option value="<?php echo $row_comproveedor['NOMBREPROVEEDOR']?>"><?php echo $row_comproveedor['NOMBREPROVEEDOR']?></option>
            <?php
} while ($row_comproveedor = mysql_fetch_assoc($comproveedor));
  $rows = mysql_num_rows($comproveedor);
  if($rows > 0) {
      mysql_data_seek($comproveedor, 0);
	  $row_comproveedor = mysql_fetch_assoc($comproveedor);
  }
?>
          </select></td>
          <td width="7%" align="left">No.Factura:</td>
          <td width="18%" align="center"><input type="text" name="NOFACTURA" value="" size="32" /></td>
          <td width="11%" align="center">FECHACOMPRA:</td>
          <td width="18%" align="center"><input type="text" name="FECHACOMPRA" value="" size="32" /></td>
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
          <td align="left">Codigo de Orden de Compra:</td>
          <td align="left"><select name="IDORDEN">
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['IDORDEN']?>"><?php echo $row_Recordset1['IDORDEN']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select></td>
          <td align="left">Nombre de Empleado:</td>
          <td align="left"><select name="IDEMPLEADO">
            <?php
do {  
?>
            <option value="<?php echo $row_comEmple['NOMBREEMPLEADO']?>"><?php echo $row_comEmple['NOMBREEMPLEADO']?></option>
            <?php
} while ($row_comEmple = mysql_fetch_assoc($comEmple));
  $rows = mysql_num_rows($comEmple);
  if($rows > 0) {
      mysql_data_seek($comEmple, 0);
	  $row_comEmple = mysql_fetch_assoc($comEmple);
  }
?>
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
          <td align="left">Estado de la factura: </td>
          <td><select name="IDESTAFACTURA">
            <?php
do {  
?>
            <option value="<?php echo $row_COMestadofact['ESTADO']?>"><?php echo $row_COMestadofact['ESTADO']?></option>
            <?php
} while ($row_COMestadofact = mysql_fetch_assoc($COMestadofact));
  $rows = mysql_num_rows($COMestadofact);
  if($rows > 0) {
      mysql_data_seek($COMestadofact, 0);
	  $row_COMestadofact = mysql_fetch_assoc($COMestadofact);
  }
?>
          </select></td>
          <td align="left">Tipo de factura:</td>
          <td align="center"><select name="ID_TIPO_FACTURA">
            <?php
do {  
?>
            <option value="<?php echo $row_Ctipfactura['TIPOFACTURA']?>"><?php echo $row_Ctipfactura['TIPOFACTURA']?></option>
            <?php
} while ($row_Ctipfactura = mysql_fetch_assoc($Ctipfactura));
  $rows = mysql_num_rows($Ctipfactura);
  if($rows > 0) {
      mysql_data_seek($Ctipfactura, 0);
	  $row_Ctipfactura = mysql_fetch_assoc($Ctipfactura);
  }
?>
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
          <td align="right"><input name="enviar" type="submit" id="enviar" value="Insertar registro" /></td>
        </tr>
        <tr>
          <td colspan="8" align="center" bgcolor="#999999"><h1>Dellate de la Compra</h1>
            <p>&nbsp;</p></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
  <table width="99%" border="1" align="left">
    <tr>
      <td width="8%">Codigo de la Compra:</td>
      <td width="18%"><input type="text" name="IDCOMPRA" value="" size="32" /></td>
      <td width="8%">Unidad:</td>
      <td width="10%" align="left"><select name="IDUNIDAD">
        <?php
do {  
?>
        <option value="<?php echo $row_comunid['TIPOUNIDAD']?>"><?php echo $row_comunid['TIPOUNIDAD']?></option>
        <?php
} while ($row_comunid = mysql_fetch_assoc($comunid));
  $rows = mysql_num_rows($comunid);
  if($rows > 0) {
      mysql_data_seek($comunid, 0);
	  $row_comunid = mysql_fetch_assoc($comunid);
  }
?>
      </select></td>
      <td width="12%">ID_DETENCCOM</td>
      <td width="10%"><label for=""></label>
      <input name="iddetencompra" type="text" id="iddetencompra" readonly="readonly" /></td>
      <td width="16%">Nombre de Materia Prima</td>
      <td width="18%"><select name="MATERIAPRIMA">
        <?php
do {  
?>
        <option value="<?php echo $row_commatprim['DESCRIPCION']?>"><?php echo $row_commatprim['DESCRIPCION']?></option>
        <?php
} while ($row_commatprim = mysql_fetch_assoc($commatprim));
  $rows = mysql_num_rows($commatprim);
  if($rows > 0) {
      mysql_data_seek($commatprim, 0);
	  $row_commatprim = mysql_fetch_assoc($commatprim);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="6" rowspan="14"><p>&nbsp;
        </p>
        <p>&nbsp;</p>
        <p>
          <input name="enviar2" type="submit" disabled="disabled" value="Insertar registro" />
        </p></td>
    </tr>
    <tr>
      <td>Cantidad a introducir:</td>
      <td><input type="text" name="CANTIDADMATPRIMA" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Precio de la Unidad</td>
      <td><input type="text" name="PRECIOUNIDAD" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Descuento:</td>
      <td><input type="text" name="PRECIOTOTAL" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Sub_Total:</td>
      <td><input type="text" name="DESCUENTO" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Precio Total:</td>
      <td><input type="text" name="SUBTOTAL" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Iva:</td>
      <td><input type="text" name="IVA" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Total :</td>
      <td><input type="text" name="TOTAL" value="" size="32" /></td>
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

mysql_free_result($COMestadofact);

mysql_free_result($comproveedor);

mysql_free_result($comEmple);

mysql_free_result($Ctipfactura);

mysql_free_result($comunid);

mysql_free_result($commatprim);
?>
