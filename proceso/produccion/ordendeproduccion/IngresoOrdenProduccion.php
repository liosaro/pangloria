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
<head>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>


<?php require_once('../../../Connections/basepangloria.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOORDENPROD (IDENCABEORDPROD, IDEMPLEADO, IDSUCURSAL, FECHA) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEORDPROD'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDSUCURSAL'], "int"),
                       GetSQLValueString($_POST['FECHA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD ORDER BY IDENCABEORDPROD DESC";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboSucursal = "SELECT IDSUCURSAL, NOMBRESUCURSAL FROM CATSUCURSAL";
$comboSucursal = mysql_query($query_comboSucursal, $basepangloria) or die(mysql_error());
$row_comboSucursal = mysql_fetch_assoc($comboSucursal);
$totalRows_comboSucursal = mysql_num_rows($comboSucursal);
mysql_select_db($database_basepangloria, $basepangloria);
$query_textboxempleados = "SELECT IDEMPLEADO FROM CATEMPLEADO";
$textboxempleados = mysql_query($query_textboxempleados, $basepangloria) or die(mysql_error());
$row_textboxempleados = mysql_fetch_assoc($textboxempleados);
$totalRows_textboxempleados = mysql_num_rows($textboxempleados);

$colname_usuarioingresa = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarioingresa = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_usuarioingresa = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s", GetSQLValueString($colname_usuarioingresa, "text"));
$usuarioingresa = mysql_query($query_usuarioingresa, $basepangloria) or die(mysql_error());
$row_usuarioingresa = mysql_fetch_assoc($usuarioingresa);
$totalRows_usuarioingresa = mysql_num_rows($usuarioingresa);

$maxRows_encabOrdenProd = 10;
$pageNum_encabOrdenProd = 0;
if (isset($_GET['pageNum_encabOrdenProd'])) {
  $pageNum_encabOrdenProd = $_GET['pageNum_encabOrdenProd'];
}
$startRow_encabOrdenProd = $pageNum_encabOrdenProd * $maxRows_encabOrdenProd;

mysql_select_db($database_basepangloria, $basepangloria);
$query_encabOrdenProd = "SELECT * FROM TRNENCABEZADOORDENPROD";
$query_limit_encabOrdenProd = sprintf("%s LIMIT %d, %d", $query_encabOrdenProd, $startRow_encabOrdenProd, $maxRows_encabOrdenProd);
$encabOrdenProd = mysql_query($query_limit_encabOrdenProd, $basepangloria) or die(mysql_error());
$row_encabOrdenProd = mysql_fetch_assoc($encabOrdenProd);

if (isset($_GET['totalRows_encabOrdenProd'])) {
  $totalRows_encabOrdenProd = $_GET['totalRows_encabOrdenProd'];
} else {
  $all_encabOrdenProd = mysql_query($query_encabOrdenProd);
  $totalRows_encabOrdenProd = mysql_num_rows($all_encabOrdenProd);
}
$totalPages_encabOrdenProd = ceil($totalRows_encabOrdenProd/$maxRows_encabOrdenProd)-1;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<link href="../../../css/forms.css" rel="stylesheet" type="text/css" />
</head>

<body>

     </table>
<table width="100%" border="0">
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="left">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_encabOrdenProduccion:</td>
      <td nowrap="nowrap" align="right"><input name="IDENCABEORDPROD" type="text" value="<?php echo $row_Recordset1['IDENCABEORDPROD']+1; ?>" size="32" readonly /></td>
      <td nowrap="nowrap" align="right">Empleado:</td>
      <td><input name="IDEMPLEADO" type="text" size="32" value="<?php echo $row_usuarioingresa['IDUSUARIO'];?>" readonly /></td>
    </tr>
    <tr valign="baseline">
      <td height="36" align="right" nowrap="nowrap">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sucursal:</td>
      <td nowrap="nowrap" align="right"><select name="IDSUCURSAL">
        <?php
do {  
?>
        <option value="<?php echo $row_comboSucursal['IDSUCURSAL']?>"><?php echo $row_comboSucursal['NOMBRESUCURSAL']?></option>
        <?php
} while ($row_comboSucursal = mysql_fetch_assoc($comboSucursal));
  $rows = mysql_num_rows($comboSucursal);
  if($rows > 0) {
      mysql_data_seek($comboSucursal, 0);
	  $row_comboSucursal = mysql_fetch_assoc($comboSucursal);
  }
?>
      </select></td>
      <td nowrap="nowrap" align="right">Fecha:</td>
      <td><script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
   <div class="welsl">
  <div id="datetimepicker1" class="input-append date">
    <input data-format="yyyy-MM-dd hh:mm:ss" type="text"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>
</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><input type="submit" value="Insertar registro" /></td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr></table> <input type="hidden" name="MM_insert" value="form1" />
</form>
  
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<table width="820" border="0">
  <tr>
    <td><iframe src="inserdetalle.php" name="conte" width="820" height="250" scrolling="auto" frameborder="0"></iframe>&nbsp;</td>
  </tr>
</table>
<table border="1">
  <tr>
    <td>IDENCABEORDPROD</td>
    <td>IDEMPLEADO</td>
    <td>IDSUCURSAL</td>
    <td>FECHA</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_encabOrdenProd['IDENCABEORDPROD']; ?></td>
      <td><?php echo $row_encabOrdenProd['IDEMPLEADO']; ?></td>
      <td><?php echo $row_encabOrdenProd['IDSUCURSAL']; ?></td>
      <td><?php echo $row_encabOrdenProd['FECHA']; ?></td>
    </tr>
    <?php } while ($row_encabOrdenProd = mysql_fetch_assoc($encabOrdenProd)); ?>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($comboSucursal);

mysql_free_result($textboxempleados);

mysql_free_result($usuarioingresa);

mysql_free_result($encabOrdenProd);

mysql_free_result($comboproducto);

mysql_free_result($combomedida);
?>

