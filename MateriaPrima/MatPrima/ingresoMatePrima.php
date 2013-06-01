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

$currentPage = $_SERVER["PHP_SELF"];

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

$maxRows_materia = 10;
$pageNum_materia = 0;
if (isset($_GET['pageNum_materia'])) {
  $pageNum_materia = $_GET['pageNum_materia'];
}
$startRow_materia = $pageNum_materia * $maxRows_materia;

mysql_select_db($database_basepangloria, $basepangloria);
$query_materia = "SELECT * FROM CATMATERIAPRIMA";
$query_limit_materia = sprintf("%s LIMIT %d, %d", $query_materia, $startRow_materia, $maxRows_materia);
$materia = mysql_query($query_limit_materia, $basepangloria) or die(mysql_error());
$row_materia = mysql_fetch_assoc($materia);

if (isset($_GET['totalRows_materia'])) {
  $totalRows_materia = $_GET['totalRows_materia'];
} else {
  $all_materia = mysql_query($query_materia);
  $totalRows_materia = mysql_num_rows($all_materia);
}
$totalPages_materia = ceil($totalRows_materia/$maxRows_materia)-1;

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

$queryString_materia = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_materia") == false && 
        stristr($param, "totalRows_materia") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_materia = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_materia = sprintf("&totalRows_materia=%d%s", $totalRows_materia, $queryString_materia);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
            <td width="186">Id Materia Prima</td>
            <td width="223"><input name="IDMATPRIMA" type="text" disabled="disabled" value="<?php echo $row_materia['IDMATPRIMA']+1; ?>" size="32" readonly="readonly" /></td>
            <td width="116">Tipo de Materia Prima</td>
            <td width="277"><select name="IDTIPO">
              <?php
do {  
?>
              <option value="<?php echo $row_tipo['DESCRIPCIONPRODUCTO']?>"><?php echo $row_tipo['DESCRIPCIONPRODUCTO']?></option>
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
            <td><span id="sprytextfield1">
              <input type="text" name="DESCRIPCION" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
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
            <td>Ubicacion de Matereia Prima</td>
            <td><select name="UBICACIONBODEGA" id="UBICACIONBODEGA">
              <?php
do {  
?>
              <option value="<?php echo $row_ubicacion['LUGAR']?>"><?php echo $row_ubicacion['LUGAR']?></option>
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
            <td><span id="sprytextfield2">
              <input type="text" name="PrecioUltCompra" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
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
        <table border="1">
          <tr>
            <td colspan="5" align="center" bgcolor="#999999"><a href="<?php printf("%s?pageNum_materia=%d%s", $currentPage, 0, $queryString_materia); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_materia=%d%s", $currentPage, max(0, $pageNum_materia - 1), $queryString_materia); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_materia=%d%s", $currentPage, min($totalPages_materia, $pageNum_materia + 1), $queryString_materia); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_materia=%d%s", $currentPage, $totalPages_materia, $queryString_materia); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
          </tr>
          <tr>
            <td colspan="5" align="center" bgcolor="#999999"><h2>Detalle</h2></td>
          </tr>
          <tr>
            <td>Id Materia Prima</td>
            <td>Tipo de Materia Prima</td>
            <td>Descripcion</td>
            <td>Ubicacion de Matereia Prima</td>
            <td>PrecioUltima Compra</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_materia['IDMATPRIMA']; ?></td>
              <td><?php echo $row_materia['IDTIPO']; ?></td>
              <td><?php echo $row_materia['DESCRIPCION']; ?></td>
              <td><?php echo $row_materia['UBICACIONBODEGA']; ?></td>
              <td><?php echo $row_materia['PrecioUltCompra']; ?></td>
            </tr>
            <?php } while ($row_materia = mysql_fetch_assoc($materia)); ?>
        </table>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($materia);

mysql_free_result($tipo);

mysql_free_result($ubicacion);
?>
