<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$MM_restrictGoTo = "../../../seguridad.php";
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
$query_ultregis = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD ORDER BY IDENCABEORDPROD DESC";
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../../css/forms.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Orden deProduccion:</td>
      <td><input name="IDORDENPRODUCCION" type="text" disabled="disabled" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Encabe.Orden de Produccion:</td>
      <td><input name="IDENCABEORDPROD" type="text" value="<?php echo $row_ultregis['IDENCABEORDPROD']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cantidad de Orde de Produccion:</td>
      <td><input type="text" name="CANTIDADORPROD" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Medida:</td>
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
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Producto de Orde Produccion:</td>
      <td><select name="PRODUCTOORDPRODUC" onfocus="document.form1.cuerpo.disabled=false;">
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
      <td nowrap="nowrap" align="right">Fecha y Hora del Usuario:</td>
      <td><input name="FECHAHORAUSUA" type="text" value="<?php echo date("Y-m-d H:i:s");;?> " size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Usuario:</td>
      <td><input name="IDEMPLEADO" type="text" value="<?php echo $row_textusuario['IDUSUARIO']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input name="cuerpo" type="submit" disabled id="cuerpo" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($ultregis);

mysql_free_result($comboMedida);

mysql_free_result($comboProducto);

mysql_free_result($textusuario);



?>
