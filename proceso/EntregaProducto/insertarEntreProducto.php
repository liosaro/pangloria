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
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOENTREPROD (IDENCAENTREPROD, IDORDENPRODUCCION, IDEMPLEADO, FECHA, FECHAHORAUSUA, ELIMINA, EDITA) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCAENTREPROD'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['FECHA'], "date"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"),
                       GetSQLValueString($_POST['ELIMINA'], "int"),
                       GetSQLValueString($_POST['EDITA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_encabEntreProd = "SELECT IDENCAENTREPROD FROM TRNENCABEZADOENTREPROD";
$encabEntreProd = mysql_query($query_encabEntreProd, $basepangloria) or die(mysql_error());
$row_encabEntreProd = mysql_fetch_assoc($encabEntreProd);
$totalRows_encabEntreProd = mysql_num_rows($encabEntreProd);

$colname_usuariIngre = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuariIngre = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_usuariIngre = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE NOMBREUSUARIO = %s", GetSQLValueString($colname_usuariIngre, "text"));
$usuariIngre = mysql_query($query_usuariIngre, $basepangloria) or die(mysql_error());
$row_usuariIngre = mysql_fetch_assoc($usuariIngre);
$totalRows_usuariIngre = mysql_num_rows($usuariIngre);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboOrdePro = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$comboOrdePro = mysql_query($query_comboOrdePro, $basepangloria) or die(mysql_error());
$row_comboOrdePro = mysql_fetch_assoc($comboOrdePro);
$totalRows_comboOrdePro = mysql_num_rows($comboOrdePro);
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Insertar Encab. Entrega de Producto</h1></td>
    </tr>
    <tr>
      <td>Id Encab. Entrega de Producto:</td>
      <td><input name="IDENCAENTREPROD" type="text" value="<?php echo $row_encabEntreProd['IDENCAENTREPROD']+1; ?>" size="32" readonly></td>
      <td>Orden de Poduccion:</td>
      <td><select name="IDORDENPRODUCCION">
        <?php
do {  
?>
        <option value="<?php echo $row_comboOrdePro['DESCRIPCIONPRODUC']?>"><?php echo $row_comboOrdePro['DESCRIPCIONPRODUC']?></option>
        <?php
} while ($row_comboOrdePro = mysql_fetch_assoc($comboOrdePro));
  $rows = mysql_num_rows($comboOrdePro);
  if($rows > 0) {
      mysql_data_seek($comboOrdePro, 0);
	  $row_comboOrdePro = mysql_fetch_assoc($comboOrdePro);
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
      <td>Empleado:</td>
      <td>
      <input name="textfield" type="text" value="<?php echo $row_usuariIngre['IDUSUARIO'] ?>" readonly></td>
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


<input name="FECHA" type="text" id="FECHA" data-format="yyyy-MM-dd"></input>
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
</script>
</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Elimina:</td>
      <td><input type="text" name="ELIMINA" value="" size="32"></td>
      <td>Fecha y Hora Usuario:</td>
      <td><input name="FECHAHORAUSUA" type="text" value="<?php echo date("Y-m-d H:i:s");;?>" size="32" readonly></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Edita:</td>
      <td><input type="text" name="EDITA" value="" size="32"></td>
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
      <td><input type="submit" value="Insertar registro"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
</p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($encabEntreProd);

mysql_free_result($usuariIngre);

mysql_free_result($comboOrdePro);
?>
