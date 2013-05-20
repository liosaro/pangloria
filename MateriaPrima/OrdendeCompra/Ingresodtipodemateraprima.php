
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap bgcolor="#999999"><h1>Ingresar Tipo de Materia Prima</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id Tipo de Materia Prima:</td>
      <td><input name="IDTIPO" type="text" disabled value="" size="32" readonly></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Descripcion del Producto:</td>
      <td><input type="text" name="DESCRIPCIONPRODUCTO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
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
  $insertSQL = sprintf("INSERT INTO CatTipoMatPri (IDTIPO, DESCRIPCIONPRODUCTO) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IDTIPO'], "int"),
                       GetSQLValueString($_POST['DESCRIPCIONPRODUCTO'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_ingreTipoMate = "SELECT * FROM CatTipoMatPri ORDER BY IDTIPO ASC";
$ingreTipoMate = mysql_query($query_ingreTipoMate, $basepangloria) or die(mysql_error());
$row_ingreTipoMate = mysql_fetch_assoc($ingreTipoMate);
$totalRows_ingreTipoMate = mysql_num_rows($ingreTipoMate);

mysql_free_result($ingreTipoMate);
?>
