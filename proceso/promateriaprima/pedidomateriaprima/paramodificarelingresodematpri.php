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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNPEDIDO_MAT_PRIMA (ID_PED_MAT_PRIMA, ID_ENCAPEDIDO, IDUNIDAD, IDMATPRIMA, CANTIDADPEDMATPRI) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_PED_MAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_ENCAPEDIDO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['CANTIDADPEDMATPRI'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="99%" border="1">
        <tr>
          <td colspan="4" align="center" bgcolor="#999999"><h1>Modificar Ingreso de Materia Prima</h1></td>
          </tr>
        <tr>
          <td>ID_ENCAPEDIDO</td>
          <td><input type="text" name="ID_PED_MAT_PRIMA" value="" size="32" /></td>
          <td>ID_PED_MAT_PRIMA:</td>
          <td><input type="text" name="ID_ENCAPEDIDO" value="" size="32" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>IDUNIDAD</td>
          <td><select name="IDUNIDAD">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td>IDMATPRIMA</td>
          <td><select name="IDMATPRIMA">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>CANTIDADPEDMATPRI</td>
          <td><select name="CANTIDADPEDMATPRI">
            <option value="menuitem1" >[ Etiqueta ]</option>
            <option value="menuitem2" >[ Etiqueta ]</option>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input name="eviar" type="submit" id="eviar" value="Insertar registro" /></td>
        </tr>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>