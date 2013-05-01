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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE CATDEPARTAMENEMPRESA SET DEPARTAMENTO=%s, NUMEROTELEFONO=%s WHERE IDDEPTO=%s",
                       GetSQLValueString($_POST['DEPARTAMENTO'], "text"),
                       GetSQLValueString($_POST['NUMEROTELEFONO'], "text"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_depa = "SELECT * FROM CATDEPARTAMENEMPRESA";
$depa = mysql_query($query_depa, $basepangloria) or die(mysql_error());
$row_depa = mysql_fetch_assoc($depa);
$totalRows_depa = mysql_num_rows($depa);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empl = "SELECT * FROM CATDEPARTAMENEMPRESA";
$empl = mysql_query($query_empl, $basepangloria) or die(mysql_error());
$row_empl = mysql_fetch_assoc($empl);
$totalRows_empl = mysql_num_rows($empl);
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
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td><table width="100%" border="0">
            <tr>
              <td align="center" bgcolor="#999999"><h1>Modificar Departamento de La Empresa</h1></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">IDDEPTO:</td>
            <td><select name="IDDEPTO">
              <?php
do {  
?>
              <option value="<?php echo $row_depa['DEPARTAMENTO']?>"<?php if (!(strcmp($row_depa['DEPARTAMENTO'], $row_depa['IDDEPTO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_depa['IDDEPTO']?></option>
              <?php
} while ($row_depa = mysql_fetch_assoc($depa));
  $rows = mysql_num_rows($depa);
  if($rows > 0) {
      mysql_data_seek($depa, 0);
	  $row_depa = mysql_fetch_assoc($depa);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">DEPARTAMENTO:</td>
            <td><input type="text" name="DEPARTAMENTO" value="<?php echo htmlentities($row_depa['DEPARTAMENTO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">NUMEROTELEFONO:</td>
            <td><input type="text" name="NUMEROTELEFONO" value="<?php echo htmlentities($row_depa['NUMEROTELEFONO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Actualizar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="IDDEPTO" value="<?php echo $row_depa['IDDEPTO']; ?>" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($depa);

mysql_free_result($empl);
?>
