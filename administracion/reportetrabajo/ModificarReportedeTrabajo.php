<?php require_once('file:///C|/Users/Julio Flores/Documents/GitHub/controlinventario/Connections/basepangloria.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO TRNDETORDENPRODUCCION (IDORDENPRODUCCION, IDENCABEORDPROD, CANTIDADORPROD, ID_MEDIDA, PRODUCTOORDPRODUC, FECHAHORAUSUA, USUARIO) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['IDENCABEORDPROD'], "int"),
                       GetSQLValueString($_POST['CANTIDADORPROD'], "double"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['PRODUCTOORDPRODUC'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"),
                       GetSQLValueString($_POST['USUARIO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
</style>
</head>

<body>
<table width="820" border="1">
  <tr>
    <td bgcolor="#CCCCCC"><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#CCCCCC"><h1>Modificar Reporte de Trabajo</h1></td>
          </tr>
          <tr>
            <td width="20%" height="28" align="center">Codigo de Reporte de Trabajo:</td>
            <td width="24%"><select name="IDORDENPRODUCCION">
              <option value="menuitem1" selected="selected" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
            <td width="43%">&nbsp;</td>
            <td width="13%">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC"><p>&nbsp;</p></td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC"><strong>Periodo:</strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong>Horas Trabajadas:</strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong>Fecha y Hora Trabjada:</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="CANTIDADORPROD" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="ID_MEDIDA" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="PRODUCTOORDPRODUC" type="text" value="" size="40" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="CANTIDADORPROD2" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="ID_MEDIDA2" type="text" value="" size="25" readonly="readonly" /></td>
            <td><input name="PRODUCTOORDPRODUC2" type="text" value="" size="40" readonly="readonly" /></td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><input name="Restablecer" type="reset" value="Modificar Registro" /></td>
            <td align="center"><input name="SEND" type="submit" id="SEND" value="Aceptar" /></td>
            <td><input name="Restablecer3" type="reset" value="Cancelar" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>