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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNJUSTIFICACIONFALTAPRODUCTO (ID_JUSTIFICACION, IDCONTROLPRODUCCION, CANTIDA_FALTANTE, IDPRODUCTOFALTA, ID_MEDIDA, FECHAINGRESOJUSFAPROD, JUSTIFICACIONFALTAPROD) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_JUSTIFICACION'], "int"),
                       GetSQLValueString($_POST['IDCONTROLPRODUCCION'], "int"),
                       GetSQLValueString($_POST['CANTIDA_FALTANTE'], "double"),
                       GetSQLValueString($_POST['IDPRODUCTOFALTA'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSFAPROD'], "date"),
                       GetSQLValueString($_POST['JUSTIFICACIONFALTAPROD'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_justifi = "SELECT ID_JUSTIFICACION FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$justifi = mysql_query($query_justifi, $basepangloria) or die(mysql_error());
$row_justifi = mysql_fetch_assoc($justifi);
$totalRows_justifi = mysql_num_rows($justifi);
$query_justifi = "SELECT ID_JUSTIFICACION FROM TRNJUSTIFICACIONFALTAPRODUCTO ORDER BY ID_JUSTIFICACION DESC";
$justifi = mysql_query($query_justifi, $basepangloria) or die(mysql_error());
$row_justifi = mysql_fetch_assoc($justifi);
$totalRows_justifi = mysql_num_rows($justifi);

mysql_select_db($database_basepangloria, $basepangloria);
$query_control = "SELECT ID_CONTROLPRODUCCION FROM TRNCONTROL_DEPRODUCCION";
$control = mysql_query($query_control, $basepangloria) or die(mysql_error());
$row_control = mysql_fetch_assoc($control);
$totalRows_control = mysql_num_rows($control);

mysql_select_db($database_basepangloria, $basepangloria);
$query_producto = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$producto = mysql_query($query_producto, $basepangloria) or die(mysql_error());
$row_producto = mysql_fetch_assoc($producto);
$totalRows_producto = mysql_num_rows($producto);

mysql_select_db($database_basepangloria, $basepangloria);
$query_medidas = "SELECT * FROM CATMEDIDAS";
$medidas = mysql_query($query_medidas, $basepangloria) or die(mysql_error());
$row_medidas = mysql_fetch_assoc($medidas);
$totalRows_medidas = mysql_num_rows($medidas);

$maxRows_justificacion = 10;
$pageNum_justificacion = 0;
if (isset($_GET['pageNum_justificacion'])) {
  $pageNum_justificacion = $_GET['pageNum_justificacion'];
}
$startRow_justificacion = $pageNum_justificacion * $maxRows_justificacion;

mysql_select_db($database_basepangloria, $basepangloria);
$query_justificacion = "SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO";
$query_limit_justificacion = sprintf("%s LIMIT %d, %d", $query_justificacion, $startRow_justificacion, $maxRows_justificacion);
$justificacion = mysql_query($query_limit_justificacion, $basepangloria) or die(mysql_error());
$row_justificacion = mysql_fetch_assoc($justificacion);

if (isset($_GET['totalRows_justificacion'])) {
  $totalRows_justificacion = $_GET['totalRows_justificacion'];
} else {
  $all_justificacion = mysql_query($query_justificacion);
  $totalRows_justificacion = mysql_num_rows($all_justificacion);
}
$totalPages_justificacion = ceil($totalRows_justificacion/$maxRows_justificacion)-1;

$queryString_justificacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_justificacion") == false && 
        stristr($param, "totalRows_justificacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_justificacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_justificacion = sprintf("&totalRows_justificacion=%d%s", $totalRows_justificacion, $queryString_justificacion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="1">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="1">
        <tr>
          <td align="center" bgcolor="#999999"><h1>Ingreso de Justificacion de Producto</h1></td>
        </tr>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID_JUSTIFICACION:</td>
            <td nowrap="nowrap"><input name="ID_JUSTIFICACION" type="text" disabled="disabled"  value="<?php echo $row_justifi['ID_JUSTIFICACION']+1; ?>" size="32" readonly="readonly" /></td>
            <td nowrap="nowrap">ID CONTROL PRODUCCION</td>
            <td nowrap="nowrap"><select name="IDCONTROLPRODUCCION">
              <?php
do {  
?>
              <option value="<?php echo $row_control['ID_CONTROLPRODUCCION']?>"><?php echo $row_control['ID_CONTROLPRODUCCION']?></option>
              <?php
} while ($row_control = mysql_fetch_assoc($control));
  $rows = mysql_num_rows($control);
  if($rows > 0) {
      mysql_data_seek($control, 0);
	  $row_control = mysql_fetch_assoc($control);
  }
?>
            </select></td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">CANTIDAD FALTANTE:</td>
            <td><span id="sprytextfield1">
              <input type="text" name="CANTIDA_FALTANTE" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>PRODUCTO FALTANTE:</td>
            <td><select name="IDPRODUCTOFALTA" id="IDPRODUCTOFALTA">
              <?php
do {  
?>
              <option value="<?php echo $row_producto['IDPRODUCTO']?>"><?php echo $row_producto['DESCRIPCIONPRODUC']?></option>
              <?php
} while ($row_producto = mysql_fetch_assoc($producto));
  $rows = mysql_num_rows($producto);
  if($rows > 0) {
      mysql_data_seek($producto, 0);
	  $row_producto = mysql_fetch_assoc($producto);
  }
?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">MEDIDA:</td>
            <td><select name="ID_MEDIDA">
              <?php
do {  
?>
              <option value="<?php echo $row_medidas['ID_MEDIDA']?>"><?php echo $row_medidas['MEDIDA']?></option>
              <?php
} while ($row_medidas = mysql_fetch_assoc($medidas));
  $rows = mysql_num_rows($medidas);
  if($rows > 0) {
      mysql_data_seek($medidas, 0);
	  $row_medidas = mysql_fetch_assoc($medidas);
  }
?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td colspan="4" align="right" nowrap="nowrap"><p>FECHA DE INGRESO:</p>              <script type="text/javascript"

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
              
              
              
              <input name="FECHAINGRESOJUSFAPROD" type="text" id="FECHAINGRESOJUSFAPROD" data-format="yyyy-MM-dd"></input>
              
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
  
  
  
  </div>
              
            <script type="text/javascript">

$(function() {

$('#datetimepicker4').datetimepicker({

pickTime: false

});

});
</script></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"><p>JUSTIFICACION DE FALTA DE</p>
            <p> PRODUCTO:</p></td>
            <td><span id="sprytextfield2">
              <label for="text1"></label>
              <textarea name="text1" id="text1"></textarea>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_insert" value="form2" />
        </p>
        <p><a href="<?php printf("%s?pageNum_justificacion=%d%s", $currentPage, 0, $queryString_justificacion); ?>"><img src="../../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_justificacion=%d%s", $currentPage, max(0, $pageNum_justificacion - 1), $queryString_justificacion); ?>"><img src="../../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_justificacion=%d%s", $currentPage, min($totalPages_justificacion, $pageNum_justificacion + 1), $queryString_justificacion); ?>"><img src="../../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_justificacion=%d%s", $currentPage, $totalPages_justificacion, $queryString_justificacion); ?>"><img src="../../../imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
        <table border="1">
          <tr>
            <td colspan="6" align="center" bgcolor="#999999"><h1>Detalle</h1></td>
          </tr>
          <tr>
            <td>Id Justificacion</td>
            <td>Control de Produccion</td>
            <td>Cantidad Faltante</td>
            <td>Producto Faltante</td>
            <td>Medida</td>
            <td>Fecha de Ingreso</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_justificacion['ID_JUSTIFICACION']; ?></td>
              <td><?php echo $row_justificacion['IDCONTROLPRODUCCION']; ?></td>
              <td><?php echo $row_justificacion['CANTIDA_FALTANTE']; ?></td>
              <td><?php echo $row_producto['DESCRIPCIONPRODUC']; ?></td>
              <td><?php echo $row_medidas['MEDIDA']; ?></td>
              <td><?php echo $row_justificacion['FECHAINGRESOJUSFAPROD']; ?></td>
            </tr>
            <?php } while ($row_justificacion = mysql_fetch_assoc($justificacion)); ?>
        </table>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($justifi);

mysql_free_result($control);

mysql_free_result($producto);

mysql_free_result($medidas);

mysql_free_result($justificacion);
?>
