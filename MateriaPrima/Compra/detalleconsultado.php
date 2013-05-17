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

mysql_select_db($database_basepangloria, $basepangloria);
$query_selecclaOrd = "SELECT IDORDEN, FECHAENTREGA FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$selecclaOrd = mysql_query($query_selecclaOrd, $basepangloria) or die(mysql_error());
$row_selecclaOrd = mysql_fetch_assoc($selecclaOrd);
$totalRows_selecclaOrd = mysql_num_rows($selecclaOrd);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820">
  <tr>
    <td>Selecciones Orden de Compra : 
      <label for="conordenC"></label>
      <select name="conordenC" id="conordenC">
        <?php
do {  
?>
        <option value="<?php echo $row_selecclaOrd['IDORDEN']?>"><?php echo $row_selecclaOrd['IDORDEN']?>---<?php echo $row_selecclaOrd['FECHAENTREGA']?></option>
        <?php
} while ($row_selecclaOrd = mysql_fetch_assoc($selecclaOrd));
  $rows = mysql_num_rows($selecclaOrd);
  if($rows > 0) {
      mysql_data_seek($selecclaOrd, 0);
	  $row_selecclaOrd = mysql_fetch_assoc($selecclaOrd);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($selecclaOrd);
?>
