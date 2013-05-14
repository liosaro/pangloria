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
  $insertSQL = sprintf("INSERT INTO CATCARGO (IDCARGO, CARGO) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IDCARGO'], "int"),
                       GetSQLValueString($_POST['CARGO'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_codigocargo = "SELECT IDCARGO FROM CATCARGO ORDER BY IDCARGO DESC";
$codigocargo = mysql_query($query_codigocargo, $basepangloria) or die(mysql_error());
$row_codigocargo = mysql_fetch_assoc($codigocargo);
$totalRows_codigocargo = mysql_num_rows($codigocargo);
?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<table width="820" border="0">
  <tr>
    <td><form name="form1" method="post" action="">
    </form>
      <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center"><h1>Ingresar Cargos</h1></td>
          </tr>
          <tr>
            <td width="9%">Id Cargo:</td>
            <td width="28%"><input  name="IDCARGO" type="text" disabled="disabled" id="IDCARGO" value="<?php echo $row_codigocargo['IDCARGO']+1; ?>" size="32"readonly="readonly" /></td>
            <td width="17%">&nbsp;</td>
            <td width="46%">&nbsp;</td>
          </tr>
          <tr>
            <td>Cargo:</td>
            <td><input type="text" name="CARGO" value="" size="32"></td>
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
            <td align="center"><input type="submit" value="Insertar registro"></td>
            
            <td align="center"><INPUT TYPE="BUTTON" VALUE="Volver" ONCLICK="window.location.href='base.php'"></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2">
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table> 
<?php
mysql_free_result($codigocargo);
?>
