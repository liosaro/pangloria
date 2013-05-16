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
  $insertSQL = sprintf("INSERT INTO TRNENCAORDCOMPRA (IDORDEN, NUMEROCOTIZACIO, IDEMPLEADO, FECHAEMISIONORDCOM, FECHAENTREGA, AUTORIZADOPOR, ESTADODEORDEN) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDORDEN'], "int"),
                       GetSQLValueString($_POST['NUMEROCOTIZACIO'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['FECHAEMISIONORDCOM'], "date"),
                       GetSQLValueString($_POST['FECHAENTREGA'], "date"),
                       GetSQLValueString($_POST['AUTORIZADOPOR'], "int"),
                       GetSQLValueString($_POST['ESTADODEORDEN'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_ncoti = "SELECT IDENCABEZADO FROM TRNCABEZACOTIZACION";
$ncoti = mysql_query($query_ncoti, $basepangloria) or die(mysql_error());
$row_ncoti = mysql_fetch_assoc($ncoti);
$totalRows_ncoti = mysql_num_rows($ncoti);

mysql_select_db($database_basepangloria, $basepangloria);
$query_numorden = "SELECT IDORDEN FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$numorden = mysql_query($query_numorden, $basepangloria) or die(mysql_error());
$row_numorden = mysql_fetch_assoc($numorden);
$totalRows_numorden = mysql_num_rows($numorden);

$colname_nusuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_nusuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_nusuario = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s", GetSQLValueString($colname_nusuario, "text"));
$nusuario = mysql_query($query_nusuario, $basepangloria) or die(mysql_error());
$row_nusuario = mysql_fetch_assoc($nusuario);
$totalRows_nusuario = mysql_num_rows($nusuario);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleao = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleao = mysql_query($query_empleao, $basepangloria) or die(mysql_error());
$row_empleao = mysql_fetch_assoc($empleao);
$totalRows_empleao = mysql_num_rows($empleao);
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
}
</style>
<link href="../../SpryAssets/bootstrap-combined.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" media="screen"
     href="../../css/bootstrap-datetimepicker.min.css">
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="left"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="left">
        <tr valign="baseline">
          <td colspan="4" align="center" nowrap="nowrap" bgcolor="#999999">Ingreso de orden de compra</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">Codigo de Orden de compra:</td>
          <td nowrap="nowrap" align="left"><input name="IDORDEN" type="text" disabled="disabled" value="<?php echo $row_numorden['IDORDEN']+1; ?>" size="32" /></td>
          <td nowrap="nowrap" align="left">Numero de Cotizacion:</td>
          <td align="left"><select name="NUMEROCOTIZACIO"  onchange="conte.location.href = 'concotiza.php?coti=' + this.value">
            <?php
do {  
?>
            <option value="<?php echo $row_ncoti['IDENCABEZADO']?>"><?php echo $row_ncoti['IDENCABEZADO']?></option>
            <?php
} while ($row_ncoti = mysql_fetch_assoc($ncoti));
  $rows = mysql_num_rows($ncoti);
  if($rows > 0) {
      mysql_data_seek($ncoti, 0);
	  $row_ncoti = mysql_fetch_assoc($ncoti);
  }
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">Codigo de Empleado:</td>
          <td nowrap="nowrap" align="left"><input name="IDEMPLEADO" type="text" value="<?php echo $row_nusuario['IDUSUARIO']; ?>" size="32" readonly="readonly" /></td>
          <td nowrap="nowrap" align="left">Autorizado por:</td>
          <td align="left"><select name="AUTORIZADOPOR" onfocus="document.form1.subit.disabled=false;">
            <?php
do {  
?>
            <option value="<?php echo $row_empleao['IDEMPLEADO']?>"><?php echo $row_empleao['NOMBREEMPLEADO']?></option>
            <?php
} while ($row_empleao = mysql_fetch_assoc($empleao));
  $rows = mysql_num_rows($empleao);
  if($rows > 0) {
      mysql_data_seek($empleao, 0);
	  $row_empleao = mysql_fetch_assoc($empleao);
  }
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">Fecha de emision:</td>
          <td nowrap="nowrap" align="left"><input name="FECHAEMISIONORDCOM" type="text" id="FECHAEMISIONORDCOM" value="<?php echo date("Y-m-d H:i:s");;?> " readonly="readonly" /></td>
          <td nowrap="nowrap" align="left">Fecha de Entrega:</td>
          <td align="left"><script type="text/javascript"
      src="../../SpryAssets/jquery-1.8.3.min.js">
    </script> 
    <script type="text/javascript"
      src="../../SpryAssets/bootstrap.min.js">
    </script>
    <script type="text/javascript"
      src="../../SpryAssets/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="../../SpryAssets/bootstrap-datetimepicker.es.js">
    </script>  <div id="datetimepicker4" class="input-append">
    <input name="FECHAENTREGA" type="text" id="FECHAENTREGA" data-format="yyyy-MM-dd"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker4').datetimepicker({
      pickTime: false
    });
  });
</script></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left"><input type="submit" value="Insertar registro"  name="subit" id="subit" disabled /></td>
          <td nowrap="nowrap" align="left">&nbsp;</td>
          <td nowrap="nowrap" align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<div id="detalle"><?php  include('concotiza.php') ?></div>
</body>
</html>
<?php
mysql_free_result($ncoti);

mysql_free_result($numorden);

mysql_free_result($nusuario);

mysql_free_result($empleao);
?>
