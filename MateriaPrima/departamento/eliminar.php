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

if ((isset($_POST['idborrar'])) && ($_POST['idborrar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM CATDEPARTAMENEMPRESA WHERE IDDEPTO=%s",
                       GetSQLValueString($_POST['idborrar'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($deleteSQL, $basepangloria) or die(mysql_error());

  $deleteGoTo = "modificaciondepa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST['idborrar'])) && ($_POST['idborrar'] != "")) {
  $deleteSQL = sprintf("DELETE FROM CATDEPARTAMENEMPRESA WHERE IDDEPTO=%s",
                       GetSQLValueString($_POST['idborrar'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($deleteSQL, $basepangloria) or die(mysql_error());

  $deleteGoTo = "IngresoDepartEmpresa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_elimi = "-1";
if (isset($_GET['Id'])) {
  $colname_elimi = $_GET['Id'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_elimi = sprintf("SELECT * FROM CATDEPARTAMENEMPRESA WHERE IDDEPTO = %s", GetSQLValueString($colname_elimi, "int"));
$elimi = mysql_query($query_elimi, $basepangloria) or die(mysql_error());
$row_elimi = mysql_fetch_assoc($elimi);
$totalRows_elimi = mysql_num_rows($elimi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <input name="idborrar" type="hidden" id="idborrar" value="<?php echo $row_elimi['IDDEPTO']; ?>" />
  <input type="submit" name="button" id="button" value="Eliminar " />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>id departamento: <?php echo $row_elimi['IDDEPTO']; ?></p>
<p>departamento: <?php echo $row_elimi['DEPARTAMENTO']; ?></p>
<p>Numero de Telefono:<?php echo $row_elimi['NUMEROTELEFONO']; ?></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($elimi);
?>
