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
  $insertSQL = sprintf("INSERT INTO TRNENCACONTROLPRODHORNO (IDENCABEZADO, IDORDENPRODUCCION, FECHAYHORADEINGRESO, EMPLEADEREVISA, USUARIO) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['FECHAYHORADEINGRESO'], "date"),
                       GetSQLValueString($_POST['EMPLEADEREVISA'], "int"),
                       GetSQLValueString($_POST['USUARIO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_sucur = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD WHERE ELIMIN =0 ORDER BY IDENCABEORDPROD DESC";
$sucur = mysql_query($query_sucur, $basepangloria) or die(mysql_error());
$row_sucur = mysql_fetch_assoc($sucur);
$totalRows_sucur = mysql_num_rows($sucur);


mysql_select_db($database_basepangloria, $basepangloria);
$query_ultimoenca = "SELECT IDENCABEZADO FROM TRNENCACONTROLPRODHORNO WHERE ELIMIN=0 ORDER BY IDENCABEZADO DESC";
$ultimoenca = mysql_query($query_ultimoenca, $basepangloria) or die(mysql_error());
$row_ultimoenca = mysql_fetch_assoc($ultimoenca);
$totalRows_ultimoenca = mysql_num_rows($ultimoenca);

$colname_idusuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_idusuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_idusuario = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s", GetSQLValueString($colname_idusuario, "text"));
$idusuario = mysql_query($query_idusuario, $basepangloria) or die(mysql_error());
$row_idusuario = mysql_fetch_assoc($idusuario);
$totalRows_idusuario = mysql_num_rows($idusuario);

mysql_select_db($database_basepangloria, $basepangloria);
$nom2 = $row_idusuario['IDUSUARIO'];
$query_idemple = "SELECT IDEMPLEADO FROM CATEMPLEADO WHERE IDUSUARIO = '$nom2' AND ELIMIN=0";
$idemple = mysql_query($query_idemple, $basepangloria) or die(mysql_error());
$row_idemple = mysql_fetch_assoc($idemple);
$totalRows_idemple = mysql_num_rows($idemple);

mysql_select_db($database_basepangloria, $basepangloria);
$query_emplenomb = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO WHERE ELIMIN = 0 ORDER BY NOMBREEMPLEADO ASC";
$emplenomb = mysql_query($query_emplenomb, $basepangloria) or die(mysql_error());
$row_emplenomb = mysql_fetch_assoc($emplenomb);
$totalRows_emplenomb = mysql_num_rows($emplenomb);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../css/forms.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/bootstrap-combined.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" media="screen"
     href="../../css/bootstrap-datetimepicker.min.css">
     
<script>
function cerrarse()
{
 opener.location.reload();
 window.close()
}
</script>
<script>
function Confirm(form){

alert("Se ha agregado un nuevo registro!"); 

form.submit();
 opener.location.reload();
 window.close()


}

</script>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td bgcolor="#999999" class="encaforms">Nuevo Encabezado de Control de Producto en Horno</td>
  </tr>
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Control de Producto en Horno No.:</td>
            <td nowrap="nowrap" align="right"><input name="IDENCABEZADO" type="text" value="<?php echo $row_ultimoenca['IDENCABEZADO']+1; ?>" size="9" readonly="readonly" /></td>
            <td nowrap="nowrap" align="right">No. de Orden de Produccion</td>
            <td><select name="IDORDENPRODUCCION">
              <?php 
do {  
?>
              <option value="<?php echo $row_sucur['IDENCABEORDPROD']?>" ><?php echo $row_sucur['IDENCABEORDPROD']?></option>
              <?php
} while ($row_sucur = mysql_fetch_assoc($sucur));
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">EMPLEADEREVISA:</td>
            <td nowrap="nowrap" align="right"><select name="EMPLEADEREVISA">
              <?php
do {  
?>
              <option value="<?php echo $row_emplenomb['IDEMPLEADO']?>"><?php echo $row_emplenomb['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_emplenomb = mysql_fetch_assoc($emplenomb));
  $rows = mysql_num_rows($emplenomb);
  if($rows > 0) {
      mysql_data_seek($emplenomb, 0);
	  $row_emplenomb = mysql_fetch_assoc($emplenomb);
  }
?>
            </select></td>
          <td nowrap="nowrap" align="right">Fecha y Hora del Ingreso:</td>
            <td><input name="FECHAYHORADEINGRESO" type="text" value="<?php
echo date('Y-m-d H:i:s');
?>" size="20" readonly="readonly" /></td>
          </tr>
          <tr> </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" onclick="Confirm(this.form)"/></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="USUARIO" value="<?php echo $row_idusuario['IDUSUARIO']; ?>" />
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($sucur);

mysql_free_result($empleado);

mysql_free_result($ultimoenca);

mysql_free_result($idusuario);

mysql_free_result($idemple);

mysql_free_result($emplenomb);
?>
