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
  $insertSQL = sprintf("INSERT INTO TRNENTREGAPRODUCTO (ID_ENTREGA, CANT_PRODUCTORECIBIDO, PRODUCTOENTRPROD, IDENCAENTREPROD, ID_MEDIDA, USUARIOENTREPRODUCTO, USUARIOFECHAYHORA) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ENTREGA'], "int"),
                       GetSQLValueString($_POST['CANT_PRODUCTORECIBIDO'], "int"),
                       GetSQLValueString($_POST['PRODUCTOENTRPROD'], "int"),
                       GetSQLValueString($_POST['IDENCAENTREPROD'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['USUARIOENTREPRODUCTO'], "int"),
                       GetSQLValueString($_POST['USUARIOFECHAYHORA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboProduc = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$comboProduc = mysql_query($query_comboProduc, $basepangloria) or die(mysql_error());
$row_comboProduc = mysql_fetch_assoc($comboProduc);
$totalRows_comboProduc = mysql_num_rows($comboProduc);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboMedida = "SELECT ID_MEDIDA, MEDIDA FROM CATMEDIDAS";
$comboMedida = mysql_query($query_comboMedida, $basepangloria) or die(mysql_error());
$row_comboMedida = mysql_fetch_assoc($comboMedida);
$totalRows_comboMedida = mysql_num_rows($comboMedida);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Id Entrega:</td>
      <td><input type="text" name="ID_ENTREGA" value="" size="32" /></td>
      <td>Id Encab. Entrega Producto:</td>
      <td><input type="text" name="IDENCAENTREPROD" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Producto:</td>
      <td><select name="PRODUCTOENTRPROD">
        <?php
do {  
?>
        <option value="<?php echo $row_comboProduc['IDPRODUCTO']?>"><?php echo $row_comboProduc['DESCRIPCIONPRODUC']?></option>
        <?php
} while ($row_comboProduc = mysql_fetch_assoc($comboProduc));
  $rows = mysql_num_rows($comboProduc);
  if($rows > 0) {
      mysql_data_seek($comboProduc, 0);
	  $row_comboProduc = mysql_fetch_assoc($comboProduc);
  }
?>
      </select></td>
      <td>Cantidad Producto Recibido:</td>
      <td><input type="text" name="CANT_PRODUCTORECIBIDO" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Medida:</td>
      <td><select name="ID_MEDIDA">
        <?php
do {  
?>
        <option value="<?php echo $row_comboMedida['ID_MEDIDA']?>"><?php echo $row_comboMedida['MEDIDA']?></option>
        <?php
} while ($row_comboMedida = mysql_fetch_assoc($comboMedida));
  $rows = mysql_num_rows($comboMedida);
  if($rows > 0) {
      mysql_data_seek($comboMedida, 0);
	  $row_comboMedida = mysql_fetch_assoc($comboMedida);
  }
?>
      </select></td>
      <td>Usuario que Entrega Producto :</td>
      <td><input type="text" name="USUARIOENTREPRODUCTO" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Fecha y Hora del Usuario:</td>
      <td><input type="text" name="USUARIOFECHAYHORA" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" value="Insertar registro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($comboProduc);

mysql_free_result($comboMedida);
?>
