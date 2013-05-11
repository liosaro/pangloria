<?php require_once('../../../Connections/basepangloria.php'); ?>
<?php require_once('../../../../Connections/basepangloria.php'); ?>
<?php require_once('../../../../Connections/basepangloria.php'); ?>
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
<?php require_once('../../../Connections/basepangloria.php'); ?>
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

mysql_select_db($database_basepangloria, $basepangloria);
$query_llenadocontrolproductohorno = "SELECT IDENCABEZADO FROM TRNENCACONTROLPRODHORNO";
$llenadocontrolproductohorno = mysql_query($query_llenadocontrolproductohorno, $basepangloria) or die(mysql_error());
$row_llenadocontrolproductohorno = mysql_fetch_assoc($llenadocontrolproductohorno);
$totalRows_llenadocontrolproductohorno = mysql_num_rows($llenadocontrolproductohorno);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT CANTIDAD_INGRESO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset2 = "SELECT CANTIDADEGRESO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Recordset2 = mysql_query($query_Recordset2, $basepangloria) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Unidadesdemedidadeproducto = "SELECT ID_MEDIDA FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Unidadesdemedidadeproducto = mysql_query($query_Unidadesdemedidadeproducto, $basepangloria) or die(mysql_error());
$row_Unidadesdemedidadeproducto = mysql_fetch_assoc($Unidadesdemedidadeproducto);
$totalRows_Unidadesdemedidadeproducto = mysql_num_rows($Unidadesdemedidadeproducto);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Cantidadaingresarenhorno = "SELECT CANTIDAD_INGRESO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Cantidadaingresarenhorno = mysql_query($query_Cantidadaingresarenhorno, $basepangloria) or die(mysql_error());
$row_Cantidadaingresarenhorno = mysql_fetch_assoc($Cantidadaingresarenhorno);
$totalRows_Cantidadaingresarenhorno = mysql_num_rows($Cantidadaingresarenhorno);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset3 = "SELECT CANTIDADEGRESO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Recordset3 = mysql_query($query_Recordset3, $basepangloria) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
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
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="789" height="470" border="0">
    <tr>
      <td height="62" colspan="4" align="center" bgcolor="#999999"><h1>Control de Producto en Horno</h1></td>
    </tr>
    <tr>
      <td width="155" height="43">Codigo de Producto en Horno:</td>
      <td width="248"><input name="IDENCABEZADOR" type="text" disabled="disabled" id="IDENCABEZADOR" value="<?php echo $row_ultimajusti['IDENCABEZADO']+1; ?>" size="32" readonly="readonly" /></td>
      <td width="155">Codigo de Produccion:</td>
      <td width="213"><input name="IDENCABEZADOR2" type="text" id="IDENCABEZADOR2" value="<?php echo $row_ultimajusti['IDENCABEZADO']; ?>" size="5" /></td>
    </tr>
    <tr>
      <td height="41">Fecha y Hora de Ingreso:</td>
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
    </script><script type="text/javascript">
  $(function() {
    $('#datetimepicker4').datetimepicker({
      pickTime: false
    });
  });
</script>
      <input name="textfield3" type="text" id="textfield3" /></td>
      <td>Empleado que ingresa:</td>
      <td><p>
        <input type="text" name="textfield8" id="textfield8" />
      </p></td>
    </tr>
    <tr>
      <td>Fecha y Hora de Egreso:</td>
      <td><input type="text" name="textfield4" id="textfield4" /></td>
      <td>Empleado que Revisa Ingreso:</td>
      <td><input type="text" name="textfield" id="textfield" /></td>
    </tr>
    <tr>
      <td height="73">Producto que esa:</td>
      <td><select name="select" id="select">
      </select></td>
      <td>Empleado que Revisa Egreso:</td>
      <td><input type="text" name="textfield2" id="textfield2" /></td>
    </tr>
    <tr>
      <td height="22" colspan="4">Unidades de Medida:
        <label for="textfield7"></label>
      <input type="text" name="textfield7" id="textfield7" /></td>
    </tr>
    <tr>
      <td height="22" colspan="4">Cantidad que ingresa:
        <label for="textfield5"></label>
      <input type="text" name="textfield5" id="textfield5" /></td>
    </tr>
    <tr>
      <td height="56" colspan="4"><p>Cantidad que egresa:</p>
        <p>
  <input type="text" name="textfield6" id="textfield6" />        
          <label for="textfield6"></label>
      </p></td>
    </tr>
    <tr>
      <td colspan="4"><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="left" width="816">
  <tr valign="baseline">    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($comboempleado);

mysql_free_result($comboorden);

mysql_free_result($combomedida);

mysql_free_result($combomateriaprima);

mysql_free_result($ultimajusti);

mysql_free_result($usuarios);

mysql_free_result($llenadocontrolproductohorno);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Unidadesdemedidadeproducto);

mysql_free_result($Cantidadaingresarenhorno);

mysql_free_result($Recordset3);
?>
