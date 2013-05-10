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
  $insertSQL = sprintf("INSERT INTO TRNDETALLEORDENCOMPRA (IDDETALLECOMP, IDORDEN, IDMATPRIMA, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDETALLECOMP'], "int"),
                       GetSQLValueString($_POST['IDORDEN'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANTPRODUCTO'], "int"),
                       GetSQLValueString($_POST['PRECIOUNITARIO'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">IDDETALLECOMP:</td>
      <td><input type="text" name="IDDETALLECOMP" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">IDORDEN:</td>
      <td><input type="text" name="IDORDEN" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">IDMATPRIMA:</td>
      <td><input type="text" name="IDMATPRIMA" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">IDUNIDAD:</td>
      <td><input type="text" name="IDUNIDAD" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">CANTPRODUCTO:</td>
      <td><input type="text" name="CANTPRODUCTO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">PRECIOUNITARIO:</td>
      <td><input type="text" name="PRECIOUNITARIO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
