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

mysql_select_db($database_basepangloria, $basepangloria);
$query_corden = "SELECT IDORDEN FROM TRNENCAORDCOMPRA ORDER BY IDORDEN ASC";
$corden = mysql_query($query_corden, $basepangloria) or die(mysql_error());
$row_corden = mysql_fetch_assoc($corden);
$totalRows_corden = mysql_num_rows($corden);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comDetencom = "SELECT * FROM TRNENCABEZADOCOMPRA ORDER BY ID_DETENCCOM DESC";
$comDetencom = mysql_query($query_comDetencom, $basepangloria) or die(mysql_error());
$row_comDetencom = mysql_fetch_assoc($comDetencom);
$totalRows_comDetencom = mysql_num_rows($comDetencom);

$maxRows_consultacompra = 5;
$pageNum_consultacompra = 0;
if (isset($_GET['pageNum_consultacompra'])) {
  $pageNum_consultacompra = $_GET['pageNum_consultacompra'];
}
$startRow_consultacompra = $pageNum_consultacompra * $maxRows_consultacompra;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultacompra = "SELECT * FROM TRNDETALLECOMPRA ORDER BY IDCOMPRA DESC";
$query_limit_consultacompra = sprintf("%s LIMIT %d, %d", $query_consultacompra, $startRow_consultacompra, $maxRows_consultacompra);
$consultacompra = mysql_query($query_limit_consultacompra, $basepangloria) or die(mysql_error());
$row_consultacompra = mysql_fetch_assoc($consultacompra);

if (isset($_GET['totalRows_consultacompra'])) {
  $totalRows_consultacompra = $_GET['totalRows_consultacompra'];
} else {
  $all_consultacompra = mysql_query($query_consultacompra);
  $totalRows_consultacompra = mysql_num_rows($all_consultacompra);
}
$totalPages_consultacompra = ceil($totalRows_consultacompra/$maxRows_consultacompra)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="820" border="0" align="left">
    <tr>
      <td><table width="99%" border="">
        <tr>
          <td colspan="8" align="center" bgcolor="#999999"><h1>&nbsp;</h1>
            <h1>Formulario para el Ingreso de Compra</h1></td>
          </tr>
        <tr>
          <td width="16%" align="center">ID_DETENCCOM</td>
          <td width="14%" align="center"><label for="IDCOMPRA"></label>
                   
            <input name="IDCOMPRA2" type="text" id="IDCOMPRA" readonly="readonly" />
            <?php echo $row_conDetencom ['ID_DETENCOM']; ?> </td>
            
            
         
                    
            
          <td width="12%" align="left">Nombre de Proveedor:</td>
          <td width="4%" align="left"><select name="IDPROVEEDOR" title="<?php echo $row_comDetencom['IDPROVEEDOR']; ?>">
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
          <td height="67" align="left">Codigo de Orden de Compra:</td>
          <td align="left"><label for="select"></label>
            <label for="ordenc"></label>
            <select name="ordenc" id="ordenc">
              <?php
do {  
?>
              <option value="<?php echo $row_corden['IDORDEN']?>"><?php echo $row_corden['IDORDEN'];?></option>
              <?php
} while ($row_corden = mysql_fetch_assoc($corden));
  $rows = mysql_num_rows($corden);
  if($rows > 0) {
      mysql_data_seek($corden, 0);
	  $row_corden = mysql_fetch_assoc($corden);
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
          <td align="center">Estado de la factura: </td>
          <td align="left"><select name="IDESTAFACTURA">
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
          <td align="left" valign="top">Tipo de factura:</td>
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
        </tr>
        
        <tr>
          <td colspan="8"><p>
            <input name="enviar" type="submit" id="enviar" value="Insertar registro" />
          </p>
            <p>&nbsp; </p>
            <table border="1">
              <tr>
                <td> Modificación </td>
                <td>Codigo de la Compra</td>
                <td>Unidad</td>
                <td>ID_DETENCCOM</td>
                <td>Materia Prima Cantidad</td>
                <td>Nombre de la Materia Prima</td>
                <td>Precio Por Unidad</td>
                <td>Precio Total</td>
                <td>Descuento</td>
                <td>SubTotal</td>
                <td>IVA</td>
                <td>Total</td>
              </tr>
              <?php do { ?>
                <tr>
                  <td>Modificar</td>
                  <td><?php echo $row_consultacompra['IDCOMPRA']; ?></td>
                  <td><?php echo $row_consultacompra['IDUNIDAD']; ?></td>
                  <td><?php echo $row_consultacompra['ID_DETENCCOM']; ?></td>
                  <td><?php echo $row_consultacompra['CANTIDADMATPRIMA']; ?></td>
                  <td><?php echo $row_consultacompra['MATERIAPRIMA']; ?></td>
                  <td><?php echo $row_consultacompra['PRECIOUNIDAD']; ?></td>
                  <td><?php echo $row_consultacompra['PRECIOTOTAL']; ?></td>
                  <td><?php echo $row_consultacompra['DESCUENTO']; ?></td>
                  <td><?php echo $row_consultacompra['SUBTOTAL']; ?></td>
                  <td><?php echo $row_consultacompra['IVA']; ?></td>
                  <td><?php echo $row_consultacompra['TOTAL']; ?></td>
                </tr>
                <?php } while ($row_consultacompra = mysql_fetch_assoc($consultacompra)); ?>
            </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($COMestadofact);

mysql_free_result($comproveedor);

mysql_free_result($comEmple);

mysql_free_result($Ctipfactura);

mysql_free_result($comunid);

mysql_free_result($commatprim);

mysql_free_result($corden);

mysql_free_result($comDetencom);

mysql_free_result($consultacompra);
?>
