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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNDEVOLUCIONCOMPRA (IDDEVOLUCION, IDEMPLEADO, ID_DETENCCOM, DOCADEVOLVER, FECHADEVOLUCION, IMPORTE, GASTOGENERADO, OBSERVACION) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDEVOLUCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['DOCADEVOLVER'], "text"),
                       GetSQLValueString($_POST['FECHADEVOLUCION'], "date"),
                       GetSQLValueString($_POST['IMPORTE'], "double"),
                       GetSQLValueString($_POST['GASTOGENERADO'], "double"),
                       GetSQLValueString($_POST['OBSERVACION'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNDEVOLUCIONCOMPRA (IDDEVOLUCION, IDEMPLEADO, ID_DETENCCOM, DOCADEVOLVER, FECHADEVOLUCION, IMPORTE, GASTOGENERADO, OBSERVACION) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDEVOLUCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "text"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['DOCADEVOLVER'], "text"),
                       GetSQLValueString($_POST['FECHADEVOLUCION'], "date"),
                       GetSQLValueString($_POST['IMPORTE'], "double"),
                       GetSQLValueString($_POST['GASTOGENERADO'], "double"),
                       GetSQLValueString($_POST['OBSERVACION'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_devolulu = 10;
$pageNum_devolulu = 0;
if (isset($_GET['pageNum_devolulu'])) {
  $pageNum_devolulu = $_GET['pageNum_devolulu'];
}
$startRow_devolulu = $pageNum_devolulu * $maxRows_devolulu;

mysql_select_db($database_basepangloria, $basepangloria);
$query_devolulu = "SELECT * FROM TRNDEVOLUCIONCOMPRA";
$query_limit_devolulu = sprintf("%s LIMIT %d, %d", $query_devolulu, $startRow_devolulu, $maxRows_devolulu);
$devolulu = mysql_query($query_limit_devolulu, $basepangloria) or die(mysql_error());
$row_devolulu = mysql_fetch_assoc($devolulu);

if (isset($_GET['totalRows_devolulu'])) {
  $totalRows_devolulu = $_GET['totalRows_devolulu'];
} else {
  $all_devolulu = mysql_query($query_devolulu);
  $totalRows_devolulu = mysql_num_rows($all_devolulu);
}
$totalPages_devolulu = ceil($totalRows_devolulu/$maxRows_devolulu)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_factura = "SELECT * FROM CATTIPOFACTURA";
$factura = mysql_query($query_factura, $basepangloria) or die(mysql_error());
$row_factura = mysql_fetch_assoc($factura);
$totalRows_factura = mysql_num_rows($factura);

mysql_select_db($database_basepangloria, $basepangloria);
$query_compra = "SELECT ID_DETENCCOM FROM TRNDETALLECOMPRA";
$compra = mysql_query($query_compra, $basepangloria) or die(mysql_error());
$row_compra = mysql_fetch_assoc($compra);
$totalRows_compra = mysql_num_rows($compra);

$queryString_devolulu = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_devolulu") == false && 
        stristr($param, "totalRows_devolulu") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_devolulu = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_devolulu = sprintf("&totalRows_devolulu=%d%s", $totalRows_devolulu, $queryString_devolulu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1255" border="0">
  <tr>
    <td width="1249"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table width="820" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h2>Ingreso de Devolcion de Compra </h2></td>
          </tr>
          <tr>
            <td>Id Devolucion</td>
            <td><input name="IDDEVOLUCION" type="text" disabled="disabled" value="<?php echo $row_devolulu['IDDEVOLUCION']+1; ?>" size="32" readonly="readonly" /></td>
            <td>Empleado que devolvio:</td>
            <td><select name="IDEMPLEADO">
              <?php
do {  
?>
              <option value="<?php echo $row_empleado['IDEMPLEADO']?>"><?php echo $row_empleado['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_empleado = mysql_fetch_assoc($empleado));
  $rows = mysql_num_rows($empleado);
  if($rows > 0) {
      mysql_data_seek($empleado, 0);
	  $row_empleado = mysql_fetch_assoc($empleado);
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
            <td colspan="4" align="center">Documento a devolver:
              <label for="DOCADEVOLVER"></label>
              <span id="sprytextfield1">
              <input type="text" name="DOCADEVOLVER" id="DOCADEVOLVER" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Fecha de Devolucion:</td>
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
</script> <div id="datetimepicker4" class="input-append">


<input name="FECHADEVOLUCION" type="text" id="FECHADEVOLUCION" data-format="yyyy-MM-dd"></input>
<span class="add-on"><script type="text/javascript"
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
</script> <div id="datetimepicker4" class="input-append">

<i data-time-icon="icon-time" data-date-icon="icon-calendar">
</i>
</span>
</div>
<script type="text/javascript">
$(function() {
$('#datetimepicker4').datetimepicker({
pickTime: false
});
});
</script>
</td>
            <td>IMPORTE:</td>
            <td><span id="sprytextfield2">
              <input type="text" name="IMPORTE" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Gasto Generado:</td>
            <td><span id="sprytextfield3">
              <input type="text" name="GASTOGENERADO" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>Observacion:</td>
            <td><input type="text" name="OBSERVACION" value="" size="32" /></td>
          </tr>
          <tr>
            <td colspan="4" align="center">

					 <input type="submit" value="Insertar registro" />
          </tr>
        </table>
        <table border="1">
          <tr align="center">
            <td colspan="7" bgcolor="#999999"><a href="<?php printf("%s?pageNum_devolulu=%d%s", $currentPage, 0, $queryString_devolulu); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_devolulu=%d%s", $currentPage, max(0, $pageNum_devolulu - 1), $queryString_devolulu); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_devolulu=%d%s", $currentPage, min($totalPages_devolulu, $pageNum_devolulu + 1), $queryString_devolulu); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_devolulu=%d%s", $currentPage, $totalPages_devolulu, $queryString_devolulu); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></td>
          </tr>
          <tr align="center">
            <td colspan="7" bgcolor="#999999"><h2>Detalle </h2></td>
          </tr>
          <tr>
            <td align="center">Id Devolucion</td>
            <td>Id Empleado que devolvio:</td>
            <td>Documento a devolver:</td>
            <td>Fecha</td>
            <td>IMPORTE</td>
            <td>Gasto Generado</td>
            <td>OBSERVACION</td>
          </tr>
          <?php do { ?>
            <tr>
              <td align="center"><?php echo $row_devolulu['IDDEVOLUCION']; ?></td>
              <td><?php echo $row_devolulu['IDEMPLEADO']; ?></td>
              <td><?php echo $row_devolulu['DOCADEVOLVER']; ?></td>
              <td><?php echo $row_devolulu['FECHADEVOLUCION']; ?></td>
              <td><?php echo $row_devolulu['IMPORTE']; ?></td>
              <td><?php echo $row_devolulu['GASTOGENERADO']; ?></td>
              <td><?php echo $row_devolulu['OBSERVACION']; ?></td>
            </tr>
            <?php } while ($row_devolulu = mysql_fetch_assoc($devolulu)); ?>
        </table>
<p>
          <input type="hidden" name="MM_insert" value="form1" />
      </p>
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html>
<?php
mysql_free_result($devolulu);

mysql_free_result($empleado);

mysql_free_result($factura);

mysql_free_result($compra);
?>
