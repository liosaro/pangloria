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
  $insertSQL = sprintf("INSERT INTO TRNPEDIDO_MAT_PRIMA (ID_PED_MAT_PRIMA, ID_ENCAPEDIDO, IDUNIDAD, IDMATPRIMA, CANTIDADPEDMATPRI, USUARIOPEDMAT, FECHAYHORA) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_PED_MAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_ENCAPEDIDO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['CANTIDADPEDMATPRI'], "double"),
                       GetSQLValueString($_POST['USUARIOPEDMAT'], "int"),
                       GetSQLValueString($_POST['FECHAYHORA'], "date"));

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
AC
<table width="820">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="99%">
  <tr>
    <td colspan="4" align="center" bgcolor="#999999"><h1>Pedido de Materia Prima</h1></td>
  </tr>
  <tr>
    <td width="16%" align="left">Codigo de Pedido de Materia Prima</td>
    <td width="10%"><select name="ID_PED_MAT_PRIMA">
      <option value="menuitem1" >[ Etiqueta ]</option>
      <option value="menuitem2" >[ Etiqueta ]</option>
    </select></td>
    <td width="17%" align="center">Materia Prima</td>
    <td width="57%"><input type="text" name="IDMATPRIMA" value="" size="32" /></td>
  </tr>
  <tr>
    <td>Codigo del Encabezado de pedido</td>
    <td><select name="ID_ENCAPEDIDO">
      <option value="menuitem1" >[ Etiqueta ]</option>
      <option value="menuitem2" >[ Etiqueta ]</option>
    </select></td>
    <td>Cantidad de Materia Prima:</td>
    <td><input type="text" name="CANTIDADPEDMATPRI" value="" size="32" /></td>
  </tr>
  <tr>
    <td>Unidad</td>
    <td><select name="IDUNIDAD">
      <option value="menuitem1" >[ Etiqueta ]</option>
      <option value="menuitem2" >[ Etiqueta ]</option>
    </select></td>
    <td>Usuario que hizo el pedido</td>
    <td><input type="text" name="USUARIOPEDMAT" value="" size="32" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Fecha y Hora:</td>
    <td><input type="text" name="FECHAYHORA" value="" size="32" /></td>
  </tr>
  <tr>
    <td colspan="4"><form id="form2" name="form2" method="post" action="">
      <input type="submit" name="guardar" id="guardar" value="Guardar" />
      <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar" />
    </form></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<table width="820">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>