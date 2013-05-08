<?php require_once('../../../Connections/basepangloria.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE TRNJUSTIFICAIONPERMATPRI SET IDENCABEZADO=%s, IDUNIDAD=%s, CANT_PERDIDA=%s, MAT_PRIMA=%s, JUSTIFICACION=%s, USUARIOPERMATPRI=%s, FECHAYHORAUSUAPMATPRI=%s WHERE ID_PERDIDA=%s",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANT_PERDIDA'], "double"),
                       GetSQLValueString($_POST['MAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['JUSTIFICACION'], "text"),
                       GetSQLValueString($_POST['USUARIOPERMATPRI'], "int"),
                       GetSQLValueString($_POST['FECHAYHORAUSUAPMATPRI'], "date"),
                       GetSQLValueString($_POST['ID_PERDIDA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_concuerpo = "-1";
if (isset($_GET['root'])) {
  $colname_concuerpo = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_concuerpo = sprintf("SELECT * FROM TRNJUSTIFICAIONPERMATPRI WHERE ID_PERDIDA = %s", GetSQLValueString($colname_concuerpo, "int"));
$concuerpo = mysql_query($query_concuerpo, $basepangloria) or die(mysql_error());
$row_concuerpo = mysql_fetch_assoc($concuerpo);
$totalRows_concuerpo = mysql_num_rows($concuerpo);

mysql_select_db($database_basepangloria, $basepangloria);
$query_matpri = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$matpri = mysql_query($query_matpri, $basepangloria) or die(mysql_error());
$row_matpri = mysql_fetch_assoc($matpri);
$totalRows_matpri = mysql_num_rows($matpri);
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
</head>

<body>
<table width="820" border="0">
  <tr>
    <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Codigo de Perdia:</td>
            <td nowrap="nowrap" align="left"><?php echo $row_concuerpo['ID_PERDIDA']; ?></td>
            <td nowrap="nowrap" align="right">Codigo de Encabezado:</td>
            <td><select name="IDENCABEZADO">
              <?php
do {  
?>
              <option value="<?php echo $row_concuerpo['IDENCABEZADO']?>"<?php if (!(strcmp($row_concuerpo['IDENCABEZADO'], htmlentities($row_concuerpo['IDENCABEZADO'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_concuerpo['IDENCABEZADO']?></option>
              <?php
} while ($row_concuerpo = mysql_fetch_assoc($concuerpo));
  $rows = mysql_num_rows($concuerpo);
  if($rows > 0) {
      mysql_data_seek($concuerpo, 0);
	  $row_concuerpo = mysql_fetch_assoc($concuerpo);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Cantidad Perdia:</td>
            <td nowrap="nowrap" align="right"><input type="text" name="CANT_PERDIDA" value="<?php echo htmlentities($row_concuerpo['CANT_PERDIDA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td nowrap="nowrap" align="right">Medida:</td>
            <td><select name="IDUNIDAD">
              <?php
do {  
?>
              <option value="<?php echo $row_concuerpo['IDUNIDAD']?>"<?php if (!(strcmp($row_concuerpo['IDUNIDAD'], htmlentities($row_concuerpo['IDUNIDAD'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_concuerpo['IDUNIDAD']?></option>
              <?php
} while ($row_concuerpo = mysql_fetch_assoc($concuerpo));
  $rows = mysql_num_rows($concuerpo);
  if($rows > 0) {
      mysql_data_seek($concuerpo, 0);
	  $row_concuerpo = mysql_fetch_assoc($concuerpo);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">Materia Prima:</td>
            <td><select name="MAT_PRIMA">
              <?php
do {  
?>
              <option value="<?php echo $row_matpri['IDMATPRIMA']?>"<?php if (!(strcmp($row_matpri['IDMATPRIMA'], $row_concuerpo['MAT_PRIMA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_matpri['DESCRIPCION']?></option>
              <?php
} while ($row_matpri = mysql_fetch_assoc($matpri));
  $rows = mysql_num_rows($matpri);
  if($rows > 0) {
      mysql_data_seek($matpri, 0);
	  $row_matpri = mysql_fetch_assoc($matpri);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Usuario Ingresa:</td>
            <td nowrap="nowrap" align="right"><input type="text" name="USUARIOPERMATPRI" value="<?php echo htmlentities($row_concuerpo['USUARIOPERMATPRI'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td nowrap="nowrap" align="right">Fecha y Hora::</td>
            <td><input type="text" name="FECHAYHORAUSUAPMATPRI" value="<?php echo htmlentities($row_concuerpo['FECHAYHORAUSUAPMATPRI'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td colspan="4" align="left" nowrap="nowrap">JUSTIFICACION:
              <label for="JUSTIFICACION"></label>
            <textarea name="JUSTIFICACION" id="JUSTIFICACION" cols="45" rows="5"><?php echo htmlentities($row_concuerpo['JUSTIFICACION'], ENT_COMPAT, 'utf-8'); ?></textarea>
            <input type="submit" value="Actualizar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="ID_PERDIDA" value="<?php echo $row_concuerpo['ID_PERDIDA']; ?>" />
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($concuerpo);

mysql_free_result($matpri);
?>
