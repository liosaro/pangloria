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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE CATDEPARTAMENEMPRESA SET DEPARTAMENTO=%s, NUMEROTELEFONO=%s WHERE IDDEPTO=%s",
                       GetSQLValueString($_POST['DEPARTAMENTO'], "text"),
                       GetSQLValueString($_POST['NUMEROTELEFONO'], "text"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_consultadepa = "-1";
if (isset($_GET['root'])) {
  $colname_consultadepa = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consultadepa = sprintf("SELECT * FROM CATDEPARTAMENEMPRESA WHERE IDDEPTO = %s ORDER BY IDDEPTO DESC", GetSQLValueString($colname_consultadepa, "int"));
$consultadepa = mysql_query($query_consultadepa, $basepangloria) or die(mysql_error());
$row_consultadepa = mysql_fetch_assoc($consultadepa);
$totalRows_consultadepa = mysql_num_rows($consultadepa);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDDEPTO:</td>
      <td><?php echo $row_consultadepa['IDDEPTO']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DEPARTAMENTO:</td>
      <td><input type="text" name="DEPARTAMENTO" value="<?php echo htmlentities($row_consultadepa['DEPARTAMENTO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">NUMEROTELEFONO:</td>
      <td><input type="text" name="NUMEROTELEFONO" value="<?php echo htmlentities($row_consultadepa['NUMEROTELEFONO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDDEPTO" value="<?php echo $row_consultadepa['IDDEPTO']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultadepa);
?>
