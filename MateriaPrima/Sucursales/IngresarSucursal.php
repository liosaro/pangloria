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
  $insertSQL = sprintf("INSERT INTO CATSUCURSAL (IDSUCURSAL, NOMBRESUCURSAL, DIRECCIONSUCURSAL, TELEFONOSUCURSAL) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDSUCURSAL'], "int"),
                       GetSQLValueString($_POST['NOMBRESUCURSAL'], "text"),
                       GetSQLValueString($_POST['DIRECCIONSUCURSAL'], "text"),
                       GetSQLValueString($_POST['TELEFONOSUCURSAL'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_ingreSucur = 10;
$pageNum_ingreSucur = 0;
if (isset($_GET['pageNum_ingreSucur'])) {
  $pageNum_ingreSucur = $_GET['pageNum_ingreSucur'];
}
$startRow_ingreSucur = $pageNum_ingreSucur * $maxRows_ingreSucur;

mysql_select_db($database_basepangloria, $basepangloria);
$query_ingreSucur = "SELECT * FROM CATSUCURSAL ORDER BY IDSUCURSAL DESC";
$query_limit_ingreSucur = sprintf("%s LIMIT %d, %d", $query_ingreSucur, $startRow_ingreSucur, $maxRows_ingreSucur);
$ingreSucur = mysql_query($query_limit_ingreSucur, $basepangloria) or die(mysql_error());
$row_ingreSucur = mysql_fetch_assoc($ingreSucur);

if (isset($_GET['totalRows_ingreSucur'])) {
  $totalRows_ingreSucur = $_GET['totalRows_ingreSucur'];
} else {
  $all_ingreSucur = mysql_query($query_ingreSucur);
  $totalRows_ingreSucur = mysql_num_rows($all_ingreSucur);
}
$totalPages_ingreSucur = ceil($totalRows_ingreSucur/$maxRows_ingreSucur)-1;
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
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Ingresar Sucursal</h1></td>
    </tr>
    <tr>
      <td>Id Sucursal:</td>
      <td><input name="IDSUCURSAL" type="text" value="Automaticamente" size="32" readonly="readonly" /></td>
      <td>Nombre Sucursal:</td>
      <td><input type="text" name="NOMBRESUCURSAL" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Direccion Scursal:</td>
      <td><input type="text" name="DIRECCIONSUCURSAL" value="" size="32" /></td>
      <td>Telefono Sucursal:</td>
      <td><span id="sprytextfield1">
      <input type="text" name="TELEFONOSUCURSAL" value="" size="32" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table border="1">
    <tr>
      <td>IDSUCURSAL</td>
      <td>NOMBRESUCURSAL</td>
      <td>DIRECCIONSUCURSAL</td>
      <td>TELEFONOSUCURSAL</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_ingreSucur['IDSUCURSAL']; ?></td>
        <td><?php echo $row_ingreSucur['NOMBRESUCURSAL']; ?></td>
        <td><?php echo $row_ingreSucur['DIRECCIONSUCURSAL']; ?></td>
        <td><?php echo $row_ingreSucur['TELEFONOSUCURSAL']; ?></td>
      </tr>
      <?php } while ($row_ingreSucur = mysql_fetch_assoc($ingreSucur)); ?>
  </table>
<p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0000-0000", useCharacterMasking:true, validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($ingreSucur);
?>
