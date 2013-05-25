<?php require_once('Connections/basepangloria.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../../../seguridad.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
  $insertSQL = sprintf("INSERT INTO TRNDETORDENPRODUCCION (IDORDENPRODUCCION, IDENCABEORDPROD, CANTIDADORPROD, ID_MEDIDA, PRODUCTOORDPRODUC, FECHAHORAUSUA, USUARIO) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['IDENCABEORDPROD'], "int"),
                       GetSQLValueString($_POST['CANTIDADORPROD'], "double"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['PRODUCTOORDPRODUC'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"),
                       GetSQLValueString($_POST['USUARIO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultregis = "SELECT * FROM TRNENCABEZADOORDENPROD where ELIMIN = '0' ORDER BY IDENCABEORDPROD DESC";
$ultregis = mysql_query($query_ultregis, $basepangloria) or die(mysql_error());
$row_ultregis = mysql_fetch_assoc($ultregis);
$totalRows_ultregis = mysql_num_rows($ultregis);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboMedida = "SELECT ID_MEDIDA, MEDIDA FROM CATMEDIDAS";
$comboMedida = mysql_query($query_comboMedida, $basepangloria) or die(mysql_error());
$row_comboMedida = mysql_fetch_assoc($comboMedida);
$totalRows_comboMedida = mysql_num_rows($comboMedida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboProducto = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$comboProducto = mysql_query($query_comboProducto, $basepangloria) or die(mysql_error());
$row_comboProducto = mysql_fetch_assoc($comboProducto);
$totalRows_comboProducto = mysql_num_rows($comboProducto);

$colname_textusuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_textusuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_textusuario = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s", GetSQLValueString($colname_textusuario, "text"));
$textusuario = mysql_query($query_textusuario, $basepangloria) or die(mysql_error());
$row_textusuario = mysql_fetch_assoc($textusuario);
$totalRows_textusuario = mysql_num_rows($textusuario);

$colname_ultdetad = "-1";
if (isset($_GET['IDENCABEORDPROD'])) {
  $colname_ultdetad = $_GET['IDENCABEORDPROD'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$Ultenca = $row_ultregis['IDENCABEORDPROD'];
$query_ultdetad = sprintf("SELECT IDORDENPRODUCCION, CANTIDADORPROD, ID_MEDIDA, PRODUCTOORDPRODUC FROM TRNDETORDENPRODUCCION WHERE IDENCABEORDPROD = '$Ultenca' AND ELIMIN = '0' ORDER BY IDORDENPRODUCCION DESC");
$ultdetad = mysql_query($query_ultdetad, $basepangloria) or die(mysql_error());
$row_ultdetad = mysql_fetch_assoc($ultdetad);
$totalRows_ultdetad = mysql_num_rows($ultdetad);

$colname_empleado = "-1";
if (isset($_POST['IDEMPLEADO'])) {
  $colname_empleado = $_POST['IDEMPLEADO'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$emple = $row_ultregis['IDEMPLEADO'];
$query_empleado = sprintf("SELECT NOMBREEMPLEADO FROM CATEMPLEADO WHERE IDEMPLEADO = '$emple'");
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);
$colname_Sucursal = "-1";
if (isset($_GET['IDSUCURSAL'])) {
  $colname_Sucursal = $_GET['IDSUCURSAL'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$sucu = $row_ultregis['IDSUCURSAL'];
$query_Sucursal = sprintf("SELECT NOMBRESUCURSAL FROM CATSUCURSAL WHERE IDSUCURSAL = '$sucu='");
$Sucursal = mysql_query($query_Sucursal, $basepangloria) or die(mysql_error());
$row_Sucursal = mysql_fetch_assoc($Sucursal);
$totalRows_Sucursal = mysql_num_rows($Sucursal);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../../../css/forms.css" rel="stylesheet" type="text/css" />
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td bgcolor="#999999" class="encaforms">Ingresar Orden de Produccion</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="NO">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="retorno"><a href="encabeza.php" target="popup" onClick="window.open(this.href, this.target, 'width=810,height=285,resizable = 0'); return false;"><img src="../../../../imagenes/icono/new.png" alt="" width="32" height="32" "/></a></td>
  </tr>
  <tr>
    <td>Orden de Produccion No.:</td>
    <td align="center" class="NO"><?php echo $row_ultregis['IDENCABEORDPROD']; ?></td>
    <td>Fecha:</td>
    <td class="retorno"><?php echo $row_ultregis['FECHA']; ?></td>
  </tr>
  <tr>
    <td>Empleado:</td>
    <td class="retorno"><?php echo $row_empleado['NOMBREEMPLEADO']; ?></td>
    <td>Sucursal:</td>
    <td class="retorno"><?php echo $row_Sucursal['NOMBRESUCURSAL']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="retorno">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="retorno">&nbsp;</td>
  </tr>
    </table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="1">
      <tr>
        <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table width="100%" align="center">
            <tr valign="baseline">
              <td colspan="6" align="left" nowrap="nowrap">Detalle Para Orden No.:
                <input name="IDENCABEORDPROD" type="text" value="<?php echo $row_ultregis['IDENCABEORDPROD']; ?>" size="32" readonly="readonly" /></td>
            </tr>
            <tr valign="baseline">
              <td width="11%" align="right" nowrap="nowrap">Cantidad:</td>
              <td width="10%"><span id="ordprodcant">
              <input type="text" name="CANTIDADORPROD" value="" size="9" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span></td>
              <td width="9%">Medida:</td>
              <td width="8%"><select name="ID_MEDIDA">
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
              <td width="18%">Producto :</td>
              <td width="44%" align="left"><select name="PRODUCTOORDPRODUC" onfocus="document.form1.cuerpo.disabled=false;">
                <?php
do {  
?>
                <option value="<?php echo $row_comboProducto['IDPRODUCTO']?>"><?php echo $row_comboProducto['DESCRIPCIONPRODUC']?></option>
                <?php
} while ($row_comboProducto = mysql_fetch_assoc($comboProducto));
  $rows = mysql_num_rows($comboProducto);
  if($rows > 0) {
      mysql_data_seek($comboProducto, 0);
	  $row_comboProducto = mysql_fetch_assoc($comboProducto);
  }
?>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" class="etiquetauser">Fecha y Hora del Usuario:</td>
              <td align="left"><input name="FECHAHORAUSUA" type="text" value="<?php echo date("Y-m-d H:i:s");;?> " size="32" readonly="readonly" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" class="etiquetauser">Usuario:</td>
              <td align="left"><input name="IDEMPLEADO" type="text" value="<?php echo $row_textusuario['IDUSUARIO']; ?>" size="32" readonly="readonly" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input name="cuerpo" type="submit" disabled="disabled" id="cuerpo" value="Insertar registro" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1">
      <tr>
        <td bgcolor="#CCCCCC" class="deta">Registros Agregados</td>
      </tr>
      <tr>
        <td>
          <table width="100%" border="1" align="left" cellpadding="0" cellspacing="0">
            <tr class="retabla">
              <td width="10%" align="center" bgcolor="#000000">Cantidad</td>
              <td width="20%" align="center" bgcolor="#000000">Medida</td>
              <td width="70%" align="center" bgcolor="#000000">Producto</td>
            </tr>
            <?php do { ?>
            <?php 
			mysql_select_db($database_basepangloria, $basepangloria);
$filprod = $row_ultdetad['PRODUCTOORDPRODUC'];
$filmedi = $row_ultdetad['ID_MEDIDA'];
$query_Medida = "SELECT MEDIDA FROM CATMEDIDAS where ID_MEDIDA = '$filmedi'";
$Medida = mysql_query($query_Medida, $basepangloria) or die(mysql_error());
$row_Medida = mysql_fetch_assoc($Medida);
$totalRows_Medida = mysql_num_rows($Medida);
$query_Producto = "SELECT DESCRIPCIONPRODUC FROM CATPRODUCTO WHERE IDPRODUCTO = '$filprod'";
$Producto = mysql_query($query_Producto, $basepangloria) or die(mysql_error());
$row_Producto = mysql_fetch_assoc($Producto);
$totalRows_Producto = mysql_num_rows($Producto);

			?>
              <tr>
                <td align="center" bgcolor="#CCCCCC"><?php echo $row_ultdetad['CANTIDADORPROD']; ?></td>
                <td align="center" bgcolor="#999999"><?php echo $row_Medida['MEDIDA']; ?></td>
                <td align="left" bgcolor="#666666"><?php echo $row_Producto['DESCRIPCIONPRODUC']; ?></td>
              </tr>
              <?php } while ($row_ultdetad = mysql_fetch_assoc($ultdetad)); ?>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("ordprodcant", "real", {validateOn:["change"], minValue:0});
</script>
</body>
</html>
<?php
mysql_free_result($Sucursal);

mysql_free_result($empleado);

mysql_free_result($ultregis);

mysql_free_result($comboMedida);

mysql_free_result($comboProducto);

mysql_free_result($textusuario);

mysql_free_result($ultdetad);
?>
