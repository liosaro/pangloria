<?php require_once('../../Connections/basepangloria.php'); ?><head>
<script>
function Confirm(form){

alert("Se ha agregado un nuevo registro!"); 

form.submit();

}

</script>
</head>
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
  $insertSQL = sprintf("INSERT INTO CATCONDICIONPAGO (IDCONDICION, TIPO) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IDCONDICION'], "int"),
                       GetSQLValueString($_POST['TIPO'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_ingreTipoPago = 10;
$pageNum_ingreTipoPago = 0;
if (isset($_GET['pageNum_ingreTipoPago'])) {
  $pageNum_ingreTipoPago = $_GET['pageNum_ingreTipoPago'];
}
$startRow_ingreTipoPago = $pageNum_ingreTipoPago * $maxRows_ingreTipoPago;

mysql_select_db($database_basepangloria, $basepangloria);
$query_ingreTipoPago = "SELECT * FROM CATCONDICIONPAGO ORDER BY IDCONDICION DESC";
$query_limit_ingreTipoPago = sprintf("%s LIMIT %d, %d", $query_ingreTipoPago, $startRow_ingreTipoPago, $maxRows_ingreTipoPago);
$ingreTipoPago = mysql_query($query_limit_ingreTipoPago, $basepangloria) or die(mysql_error());
$row_ingreTipoPago = mysql_fetch_assoc($ingreTipoPago);

if (isset($_GET['totalRows_ingreTipoPago'])) {
  $totalRows_ingreTipoPago = $_GET['totalRows_ingreTipoPago'];
} else {
  $all_ingreTipoPago = mysql_query($query_ingreTipoPago);
  $totalRows_ingreTipoPago = mysql_num_rows($all_ingreTipoPago);
}
$totalPages_ingreTipoPago = ceil($totalRows_ingreTipoPago/$maxRows_ingreTipoPago)-1;

mysql_free_result($ingreTipoPago);
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap bgcolor="#999999"><h1>Igresar Tipo de Pago</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id Condicion:</td>
      <td><input name="IDCONDICION" type="text" value="<?php echo $row_ingreTipoPago['IDCONDICION']+ 1; ?>" size="32" readonly></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tipo:</td>
      <td><input type="text" name="TIPO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" name="SEND" id="SEND" value="Insertar registro" onClick="Confirm(this.form)"></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
  </p>
</form>
<p>&nbsp;</p>
