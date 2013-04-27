<?php require_once('../../Connections/basepangloria.php'); ?>
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

$MM_restrictGoTo = "../../seguridad.php";
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
<?php require_once('../../Connections/basepangloria.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO TRNJUSTIFICAIONPERMATPRI (ID_PERDIDA, IDENCABEZADO, IDUNIDAD, CANT_PERDIDA, MAT_PRIMA, JUSTIFICACION, USUARIOPERMATPRI, FECHAYHORAUSUAPMATPRI) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_PERDIDA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADOR'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANT_PERDIDA'], "double"),
                       GetSQLValueString($_POST['MAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['JUSTIFICACION'], "text"),
                       GetSQLValueString($_POST['USUARIOPERMATPRI'], "int"),
                       GetSQLValueString($_POST['FECHAYHORAUSUAPMATPRI'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOJUSTPERMATPRIM (IDENCABEZADO, IDEMPLEADO, IDORDENPRODUCCION, FECHAINGRESOJUSTIFICA, EMPLEADOINGRESA, FECHAHORAUSUA) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSTIFICA'], "date"),
                       GetSQLValueString($_POST['EMPLEADOINGRESA'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboempleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$comboempleado = mysql_query($query_comboempleado, $basepangloria) or die(mysql_error());
$row_comboempleado = mysql_fetch_assoc($comboempleado);
$totalRows_comboempleado = mysql_num_rows($comboempleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboorden = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD";
$comboorden = mysql_query($query_comboorden, $basepangloria) or die(mysql_error());
$row_comboorden = mysql_fetch_assoc($comboorden);
$totalRows_comboorden = mysql_num_rows($comboorden);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combomedida = "SELECT * FROM CATMEDIDAS";
$combomedida = mysql_query($query_combomedida, $basepangloria) or die(mysql_error());
$row_combomedida = mysql_fetch_assoc($combomedida);
$totalRows_combomedida = mysql_num_rows($combomedida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combomateriaprima = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$combomateriaprima = mysql_query($query_combomateriaprima, $basepangloria) or die(mysql_error());
$row_combomateriaprima = mysql_fetch_assoc($combomateriaprima);
$totalRows_combomateriaprima = mysql_num_rows($combomateriaprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultimajusti = "SELECT IDENCABEZADO FROM TRNENCABEZADOJUSTPERMATPRIM ORDER BY IDENCABEZADO DESC";
$ultimajusti = mysql_query($query_ultimajusti, $basepangloria) or die(mysql_error());
$row_ultimajusti = mysql_fetch_assoc($ultimajusti);
$totalRows_ultimajusti = mysql_num_rows($ultimajusti);

$colname_usuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_usuarios = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s", GetSQLValueString($colname_usuarios, "text"));
$usuarios = mysql_query($query_usuarios, $basepangloria) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
}
</style>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Reporte de Trabajo</h1></td>
    </tr>
    <tr>
      <td width="213">Codigo de Reporte de Trabajo</td>
      <td width="215"><input name="IDENCABEZADOR" type="text" disabled="disabled" id="IDENCABEZADOR" value="<?php echo $row_ultimajusti['IDENCABEZADO']+1; ?>" size="32" readonly="readonly" /></td>
      <td width="154">Codigo de Producto:</td>
      <td width="220"><label for="textfield"></label>
      <input type="text" name="textfield" id="textfield" /></td>
    </tr>
    <tr>
      <td>Codigo de Empleado:</td>
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
     <label for="textfield8"></label>
     <input type="text" name="textfield3" id="textfield8" />
   </div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker4').datetimepicker({
      pickTime: false
    });
  });
</script></td>
      <td>Codigo de Control de Produccion</td>
      <td><p>
        <label for="textfield2"></label>
        <input type="text" name="textfield2" id="textfield2" />
      </p></td>
    </tr>
    <tr>
      <td><p>Codigo de Usuario:</p></td>
      <td><label for="textfield4"></label>
      <input type="text" name="textfield4" id="textfield4" /></td>
      <td>:</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Codigo de Empleado:</td>
      <td><label for="textfield5"></label>
      <input type="text" name="textfield5" id="textfield5" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="left" width="820">
    <tr valign="baseline">
      <td width="209" align="right" nowrap="nowrap">Codigo de Orden de Reporte de Trabajo:</td>
      <td width="211"><input name="IDENCABEZADOR" type="text" id="IDENCABEZADOR" value="<?php echo $row_ultimajusti['IDENCABEZADO']; ?>" size="5" /></td>
      <td width="160">Fecha y Hora Reportadas Trabajadas::</td>
      <td width="220"><label for="textfield7"></label>
      <input type="text" name="textfield7" id="textfield7" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><p>&nbsp;</p>
      <p>Periodo::</p></td>
      <td><label for="textfield6"></label>
      <input type="text" name="textfield6" id="textfield6" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Horas Trabajadas::</td>
      <td><span id="CANTIDAPERDIDA">
      <input type="text" name="CANT_PERDIDA" value="" size="32" />
      <span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">&nbsp;</td>
      <td colspan="3"><span id="sprytextarea1"><span class="textareaRequiredMsg">Se necesita un valor.</span></span>        <input type="submit" value="Imprimir " /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("CANTIDAPERDIDA", "real", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($comboempleado);

mysql_free_result($comboorden);

mysql_free_result($combomedida);

mysql_free_result($combomateriaprima);

mysql_free_result($ultimajusti);

mysql_free_result($usuarios);
?>
