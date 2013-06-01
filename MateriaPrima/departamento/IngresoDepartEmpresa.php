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
  $insertSQL = sprintf("INSERT INTO CATDEPARTAMENEMPRESA (IDDEPTO, DEPARTAMENTO, NUMEROTELEFONO) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['IDDEPTO'], "int"),
                       GetSQLValueString($_POST['DEPARTAMENTO'], "text"),
                       GetSQLValueString($_POST['NUMEROTELEFONO'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_depar = 10;
$pageNum_depar = 0;
if (isset($_GET['pageNum_depar'])) {
  $pageNum_depar = $_GET['pageNum_depar'];
}
$startRow_depar = $pageNum_depar * $maxRows_depar;

mysql_select_db($database_basepangloria, $basepangloria);
$query_depar = "SELECT * FROM CATDEPARTAMENEMPRESA";
$query_limit_depar = sprintf("%s LIMIT %d, %d", $query_depar, $startRow_depar, $maxRows_depar);
$depar = mysql_query($query_limit_depar, $basepangloria) or die(mysql_error());
$row_depar = mysql_fetch_assoc($depar);

if (isset($_GET['totalRows_depar'])) {
  $totalRows_depar = $_GET['totalRows_depar'];
} else {
  $all_depar = mysql_query($query_depar);
  $totalRows_depar = mysql_num_rows($all_depar);
}
$totalPages_depar = ceil($totalRows_depar/$maxRows_depar)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td align="center" bgcolor="#999999"><h1>Ingreso de Departamento de La Empresa</h1></td>
        </tr>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td>Id Departamento</td>
            <td><label for="IDEMPLEADO"></label>
            <input name="IDEMPLEADO" type="text" disabled="disabled" id="IDEMPLEADO" value="
<?php echo $row_depar['IDDEPTO']+1; ?>" size="32" readonly="readonly" /></td>
            <td>Departamento</td>
            <td><span id="sprytextfield2">
              <input type="text" name="DEPARTAMENTO" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Numero de Telefono</td>
            <td><span id="sprytextfield1">
            <input type="text" name="NUMEROTELEFONO" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td>&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table border="1">
          <tr>
            <td colspan="3" align="center" bgcolor="#999999"><h2>Detalle</h2></td>
          </tr>
          <tr>
            <td>IDDEPTO</td>
            <td>DEPARTAMENTO</td>
            <td>NUMEROTELEFONO</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_depar['IDDEPTO']; ?></td>
              <td><?php echo $row_depar['DEPARTAMENTO']; ?></td>
              <td><?php echo $row_depar['NUMEROTELEFONO']; ?></td>
            </tr>
            <?php } while ($row_depar = mysql_fetch_assoc($depar)); ?>
        </table>
<input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0000-0000", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($depar);
?>
