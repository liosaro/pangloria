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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO CATMATERIAPRIMA (IDMATPRIMA, IDTIPO, DESCRIPCION, UBICACIONBODEGA, PrecioUltCompra) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDTIPO'], "text"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['UBICACIONBODEGA'], "text"),
                       GetSQLValueString($_POST['PrecioUltCompra'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_materia = "SELECT * FROM CATMATERIAPRIMA";
$materia = mysql_query($query_materia, $basepangloria) or die(mysql_error());
$row_materia = mysql_fetch_assoc($materia);
$totalRows_materia = mysql_num_rows($materia);

mysql_select_db($database_basepangloria, $basepangloria);
$query_tipo = "SELECT * FROM CatTipoMatPri";
$tipo = mysql_query($query_tipo, $basepangloria) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ubicacion = "SELECT * FROM CATUBICACION";
$ubicacion = mysql_query($query_ubicacion, $basepangloria) or die(mysql_error());
$row_ubicacion = mysql_fetch_assoc($ubicacion);
$totalRows_ubicacion = mysql_num_rows($ubicacion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="820" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h2>Ingresar Materia Prima </h2></td>
          </tr>
          <tr>
            <td>Id Materia Prima</td>
            <td><input name="IDMATPRIMA" type="text" disabled="disabled" value="" size="32" readonly="readonly" /></td>
            <td>Tipo de Materia Prima</td>
            <td><select name="IDTIPO">
              <?php
do {  
?>
              <option value="<?php echo $row_tipo['IDTIPO']?>"><?php echo $row_tipo['DESCRIPCIONPRODUCTO']?></option>
              <?php
} while ($row_tipo = mysql_fetch_assoc($tipo));
  $rows = mysql_num_rows($tipo);
  if($rows > 0) {
      mysql_data_seek($tipo, 0);
	  $row_tipo = mysql_fetch_assoc($tipo);
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
            <td>Descripcion</td>
            <td><input type="text" name="DESCRIPCION" value="" size="32" /></td>
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
            <td>ubicacion de Matereia Prima</td>
            <td><select name="UBICACIONBODEGA" id="UBICACIONBODEGA">
              <?php
do {  
?>
              <option value="<?php echo $row_ubicacion['IDUBICACION']?>"><?php echo $row_ubicacion['LUGAR']?></option>
              <?php
} while ($row_ubicacion = mysql_fetch_assoc($ubicacion));
  $rows = mysql_num_rows($ubicacion);
  if($rows > 0) {
      mysql_data_seek($ubicacion, 0);
	  $row_ubicacion = mysql_fetch_assoc($ubicacion);
  }
?>
            </select></td>
            <td>PrecioUltima Compra</td>
            <td><input type="text" name="PrecioUltCompra" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_insert" value="form1" />
      </p>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($materia);

mysql_free_result($tipo);

mysql_free_result($ubicacion);
?>
