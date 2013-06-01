<?php require_once('../../../../Connections/basepangloria.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO CATMATERIAPRIMA (IDMATPRIMA, IDTIPO, DESCRIPCION, UBICACIONBODEGA) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDTIPO'], "int"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['UBICACIONBODEGA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_materiprima = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$materiprima = mysql_query($query_materiprima, $basepangloria) or die(mysql_error());
$row_materiprima = mysql_fetch_assoc($materiprima);
$totalRows_materiprima = mysql_num_rows($materiprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_tipo = "SELECT * FROM CatTipoMatPri";
$tipo = mysql_query($query_tipo, $basepangloria) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Recordset1 = "SELECT * FROM CATUBICACION";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="1">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="1">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso de Materia Prima</h1></td>
          </tr>
          <tr>
            <td>ID MATPRIMA:</td>
            <td><label for="IDMATPRIMA"></label>
            <input name="IDMATPRIMA" type="text" disabled="disabled" id="IDMATPRIMA" value="
<?php echo $row_materiprima['IDMATPRIMA']+1; ?>" size="32" readonly="readonly" /></td>
            <td>ID TIPO DE Materia Prima</td>
            <td><select name="IDTIPO">
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['IDUBICACION']?>"><?php echo $row_Recordset1['LUGAR']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
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
            <td>DESCRIPCION</td>
            <td><textarea name="DESCRIPCION" cols="32"></textarea></td>
            <td>UBICACION DE BODEGA</td>
            <td><textarea name="UBICACIONBODEGA" cols="32"></textarea></td>
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
            <td><input type="submit" value="Insertar registro" /></td>
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
<?php
mysql_free_result($materiprima);

mysql_free_result($tipo);

mysql_free_result($Recordset1);
?>
