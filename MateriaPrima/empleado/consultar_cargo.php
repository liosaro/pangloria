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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO CATCARGO (IDCARGO, CARGO) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IDCARGO'], "int"),
                       GetSQLValueString($_POST['CARGO'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_cargo = 10;
$pageNum_cargo = 0;
if (isset($_GET['pageNum_cargo'])) {
  $pageNum_cargo = $_GET['pageNum_cargo'];
}
$startRow_cargo = $pageNum_cargo * $maxRows_cargo;

mysql_select_db($database_basepangloria, $basepangloria);
$query_cargo = "SELECT IDCARGO, CARGO FROM CATCARGO";
$query_limit_cargo = sprintf("%s LIMIT %d, %d", $query_cargo, $startRow_cargo, $maxRows_cargo);
$cargo = mysql_query($query_limit_cargo, $basepangloria) or die(mysql_error());
$row_cargo = mysql_fetch_assoc($cargo);

if (isset($_GET['totalRows_cargo'])) {
  $totalRows_cargo = $_GET['totalRows_cargo'];
} else {
  $all_cargo = mysql_query($query_cargo);
  $totalRows_cargo = mysql_num_rows($all_cargo);
}
$totalPages_cargo = ceil($totalRows_cargo/$maxRows_cargo)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center"><h1>Consutar Cargos</h1></td>
          </tr>
          <tr>
            <td width="13%">&nbsp;</td>
            <td width="35%">&nbsp;</td>
            <td width="14%">&nbsp;</td>
            <td width="38%">&nbsp;</td>
          </tr>
          <tr>
            <td>Id Cargo.</td>
            <td><select name="IDCARGO">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
            <td>&nbsp;</td>
            <td><input name="Restablecer" type="reset" value="Volver" /></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><table border="1" align="left">
              <tr>
                <td width="162">IDCARGO</td>
                <td width="263">CARGO</td>
                </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_cargo['IDCARGO']; ?></td>
                  <td><?php echo $row_cargo['CARGO']; ?></td>
                  </tr>
                <?php } while ($row_cargo = mysql_fetch_assoc($cargo)); ?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($cargo);
?>
