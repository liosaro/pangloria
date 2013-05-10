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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO TRNDETALLECOTIZACION (IDDETALLE, IDMATPRIMA, IDENCABEZADO, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDETALLE'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANTPRODUCTO'], "int"),
                       GetSQLValueString($_POST['PRECIOUNITARIO'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
  $insertSQL = sprintf("INSERT INTO TRNDETALLECOTIZACION (IDDETALLE, IDMATPRIMA, IDENCABEZADO, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDETALLE'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANTPRODUCTO'], "int"),
                       GetSQLValueString($_POST['PRECIOUNITARIO'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_compdetalle = 10;
$pageNum_compdetalle = 0;
if (isset($_GET['pageNum_compdetalle'])) {
  $pageNum_compdetalle = $_GET['pageNum_compdetalle'];
}
$startRow_compdetalle = $pageNum_compdetalle * $maxRows_compdetalle;

mysql_select_db($database_basepangloria, $basepangloria);
$query_compdetalle = "SELECT IDMATPRIMA, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO FROM TRNDETALLECOTIZACION";
$query_limit_compdetalle = sprintf("%s LIMIT %d, %d", $query_compdetalle, $startRow_compdetalle, $maxRows_compdetalle);
$compdetalle = mysql_query($query_limit_compdetalle, $basepangloria) or die(mysql_error());
$row_compdetalle = mysql_fetch_assoc($compdetalle);

if (isset($_GET['totalRows_compdetalle'])) {
  $totalRows_compdetalle = $_GET['totalRows_compdetalle'];
} else {
  $all_compdetalle = mysql_query($query_compdetalle);
  $totalRows_compdetalle = mysql_num_rows($all_compdetalle);
}
$totalPages_compdetalle = ceil($totalRows_compdetalle/$maxRows_compdetalle)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td colspan="4" align="center" bgcolor="#999999"><strong>Detalle</strong></td>
          </tr>
        <tr>
          <td colspan="4"><table width="100%" border="1" align="center">
            <tr valign="baseline">
              <td width="17%" align="right" nowrap="nowrap">CANTPRODUCTO:</td>
              <td width="26%">IDMATPRIMA</td>
              <td width="17%">IDUNIDAD</td>
              <td width="40%">PRECIOUNITARIO:</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">                <select name="CANTPRODUCTO">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select>
                :</td>
              <td><select name="IDMATPRIMA">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><select name="IDUNIDAD">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><input type="text" name="PRECIOUNITARIO2" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><select name="CANTPRODUCTO2">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><select name="IDMATPRIMA2">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><select name="IDUNIDAD2">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><input type="text" name="PRECIOUNITARIO" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><select name="CANTPRODUCTO3">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select>
                :</td>
              <td><select name="IDMATPRIMA3">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><select name="IDUNIDAD3">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><input type="text" name="PRECIOUNITARIO3" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right"><select name="CANTPRODUCTO4">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select>
                :</td>
              <td><select name="IDMATPRIMA4">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><select name="IDUNIDAD4">
                <option value="menuitem1" >[ Etiqueta ]</option>
                <option value="menuitem2" >[ Etiqueta ]</option>
              </select></td>
              <td><input type="text" name="PRECIOUNITARIO4" value="" size="32" /></td>
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
              <td>&nbsp;</td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td width="16%">&nbsp;</td>
          <td width="13%">&nbsp;</td>
          <td width="13%">&nbsp;</td>
          <td width="58%">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" value="Insertar registro" /></td>
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
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <input type="hidden" name="MM_insert" value="form3" />
      </form>
      <p>&nbsp;</p>
<form method="post" name="form2" id="form2">
</form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form4" id="form4">
  <input type="hidden" name="MM_insert" value="form4" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($compdetalle);
?>
