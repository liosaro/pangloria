<head>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

</Head>

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
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOENTREPROD (IDENCAENTREPROD, IDORDENPRODUCCION, IDEMPLEADO, FECHA, FECHAHORAUSUA) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCAENTREPROD'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['FECHA'], "date"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_IngrEncEntrPro = "SELECT IDENCAENTREPROD FROM TRNENCABEZADOENTREPROD ORDER BY IDENCAENTREPROD DESC";
$IngrEncEntrPro = mysql_query($query_IngrEncEntrPro, $basepangloria) or die(mysql_error());
$row_IngrEncEntrPro = mysql_fetch_assoc($IngrEncEntrPro);
$totalRows_IngrEncEntrPro = mysql_num_rows($IngrEncEntrPro);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboOrdenPro = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$comboOrdenPro = mysql_query($query_comboOrdenPro, $basepangloria) or die(mysql_error());
$row_comboOrdenPro = mysql_fetch_assoc($comboOrdenPro);
$totalRows_comboOrdenPro = mysql_num_rows($comboOrdenPro);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboOrdenProd = "SELECT IDORDENPRODUCCION FROM TRNDETORDENPRODUCCION";
$comboOrdenProd = mysql_query($query_comboOrdenProd, $basepangloria) or die(mysql_error());
$row_comboOrdenProd = mysql_fetch_assoc($comboOrdenProd);
$totalRows_comboOrdenProd = mysql_num_rows($comboOrdenProd);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Ingresar Entrega de Producto</h1></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Id Encab.Entrega Producto:</td>
      <td><input name="IDENCAENTREPROD" type="text" value="<?php echo $row_IngrEncEntrPro['IDENCAENTREPROD'] +1; ?>" size="32" readonly="readonly" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Id Orden Produccion:</td>
      <td><select name="IDORDENPRODUCCION">
        <?php
do {  
?>
        <option value="<?php echo $row_comboOrdenProd['IDORDENPRODUCCION']?>"><?php echo $row_comboOrdenProd['IDORDENPRODUCCION']?></option>
        <?php
} while ($row_comboOrdenProd = mysql_fetch_assoc($comboOrdenProd));
  $rows = mysql_num_rows($comboOrdenProd);
  if($rows > 0) {
      mysql_data_seek($comboOrdenProd, 0);
	  $row_comboOrdenProd = mysql_fetch_assoc($comboOrdenProd);
  }
?>
      </select></td>
      <td>Empleado:</td>
      <td><input type="text" name="IDEMPLEADO" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Fecha:</td>
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


<input name="FECHAENTREGA" type="text" id="FECHAENTREGA" data-format="yyyy-MM-dd"></input>
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
      <td>Fecha y Hora del Usuario:</td>
      <td><input type="text" name="FECHAHORAUSUA" value="<?php echo date("Y-m-d H:i:s");;?>" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" value="Insertar registro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p><iframe src="insertDetalleEntrProd.php" name="conten" width="820" height="400" scrolling="No"></iframe></p>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($IngrEncEntrPro);

mysql_free_result($comboOrdenPro);

mysql_free_result($comboOrdenProd);
?>
