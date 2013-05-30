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
  $insertSQL = sprintf("INSERT INTO CATATRIBUCIONES (ID_ATRIB, IDUSUARIO, IDROL, IDPERMISO, C, R, U, D) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ATRIB'], "int"),
                       GetSQLValueString($_POST['IDUSUARIO'], "int"),
                       GetSQLValueString($_POST['IDROL'], "int"),
                       GetSQLValueString($_POST['IDPERMISO'], "int"),
                       GetSQLValueString($_POST['C'], "int"),
                       GetSQLValueString($_POST['R'], "int"),
                       GetSQLValueString($_POST['U'], "int"),
                       GetSQLValueString($_POST['D'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_juegoatribu = "SELECT ID_ATRIB FROM CATATRIBUCIONES ORDER BY ID_ATRIB DESC";
$juegoatribu = mysql_query($query_juegoatribu, $basepangloria) or die(mysql_error());
$row_juegoatribu = mysql_fetch_assoc($juegoatribu);
$totalRows_juegoatribu = mysql_num_rows($juegoatribu);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combousuario = "SELECT IDUSUARIO, NOMBREUSUARIO FROM CATUSUARIO";
$combousuario = mysql_query($query_combousuario, $basepangloria) or die(mysql_error());
$row_combousuario = mysql_fetch_assoc($combousuario);
$totalRows_combousuario = mysql_num_rows($combousuario);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comborol = "SELECT IDROL, DESCRIPCION FROM CATROL";
$comborol = mysql_query($query_comborol, $basepangloria) or die(mysql_error());
$row_comborol = mysql_fetch_assoc($comborol);
$totalRows_comborol = mysql_num_rows($comborol);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combopermiso = "SELECT IDPERMISO, DESCRIPCION FROM CATPERMISOS";
$combopermiso = mysql_query($query_combopermiso, $basepangloria) or die(mysql_error());
$row_combopermiso = mysql_fetch_assoc($combopermiso);
$totalRows_combopermiso = mysql_num_rows($combopermiso);
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


<script language="JavaScript">
function aviso(url){
if (!confirm("OK!! se ha ha almacenado con exito el nuevo registro")) {
return false;
}
else {
document.location = url;
return true;
}
}
</script>




</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
      <table width="100%" border="0">
        <tr>
          <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso de Atribuciones</h1></td>
          </tr>
        <tr>
          <td width="12%">Id Atribución:</td>
          <td width="19%"><input type="text"  id="ID_ATRIB"  name="ID_ATRIB" value="<?php echo $row_juegoatribu['ID_ATRIB']+1; ?>" size="15" /></td>
          <td width="11%">Id Rol:</td>
          <td width="58%"><select  id="IDROL"  name="IDROL">
            <?php
do {  
?>
            <option value="<?php echo $row_comborol['IDROL']?>"><?php echo $row_comborol['DESCRIPCION']?></option>
            <?php
} while ($row_comborol = mysql_fetch_assoc($comborol));
  $rows = mysql_num_rows($comborol);
  if($rows > 0) {
      mysql_data_seek($comborol, 0);
	  $row_comborol = mysql_fetch_assoc($comborol);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td>Usuario:</td>
          <td><select  id="IDUSUARIO"  name="IDUSUARIO">
            <?php
do {  
?>
	      <option value="<?php echo $row_combousuario['IDUSUARIO']?>"><?php echo  $row_combousuario['IDUSUARIO']?>---<?php echo $row_combousuario['NOMBREUSUARIO']?></option>
            <?php
} while ($row_combousuario = mysql_fetch_assoc($combousuario));
  $rows = mysql_num_rows($combousuario);
  if($rows > 0) {
      mysql_data_seek($combousuario, 0);
	  $row_combousuario = mysql_fetch_assoc($combousuario);
  }
?>
          </select></td>
          <td>Id Permiso:</td>
          <td><select  id="IDPERMISO"  name="IDPERMISO">
            <?php
do {  
?>
            <option value="<?php echo $row_combopermiso['IDPERMISO']?>"><?php echo $row_combopermiso['DESCRIPCION']?></option>
            <?php
} while ($row_combopermiso = mysql_fetch_assoc($combopermiso));
  $rows = mysql_num_rows($combopermiso);
  if($rows > 0) {
      mysql_data_seek($combopermiso, 0);
	  $row_combopermiso = mysql_fetch_assoc($combopermiso);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>C</td>
          <td><input type="text"  id="C"  name="C" value="" size="32" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>R </td>
          <td><input type="text"  id="R"  name="R" value="" size="32" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>U:</td>
          <td><input type="text"  id="U"  name="U" value="" size="32" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>D:</td>
          <td><input type="text"  id="D"  name="D" value="" size="32" /></td>
          <td>&nbsp;</td>
          <td><input type="submit" value="Insertar registro" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
              <input type="hidden"  id="MM_insert"  name="MM_insert" value="form1" /> 
              &nbsp;
          </td>
        </tr>
  </table>
    </form>

    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($juegoatribu);

mysql_free_result($combousuario);

mysql_free_result($comborol);

mysql_free_result($combopermiso);
?>
