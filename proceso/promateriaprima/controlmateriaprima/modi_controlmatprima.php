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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TRNCONTROL_MAT_PRIMA (ID_CONTROLMAT, IDMATPRIMA, ID_SALIDA, IDUNIDAD, CANT_ENTREGA, CANT_DEVUELTA, CANT_UTILIZADA, FECHA_CONTROL) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_CONTROLMAT'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['ID_SALIDA'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['CANT_ENTREGA'], "double"),
                       GetSQLValueString($_POST['CANT_DEVUELTA'], "double"),
                       GetSQLValueString($_POST['CANT_UTILIZADA'], "double"),
                       GetSQLValueString($_POST['FECHA_CONTROL'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_consultamatprima = 10;
$pageNum_consultamatprima = 0;
if (isset($_GET['pageNum_consultamatprima'])) {
  $pageNum_consultamatprima = $_GET['pageNum_consultamatprima'];
}
$startRow_consultamatprima = $pageNum_consultamatprima * $maxRows_consultamatprima;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultamatprima = "SELECT CANT_ENTREGA, CANT_DEVUELTA, CANT_UTILIZADA FROM TRNCONTROL_MAT_PRIMA ORDER BY IDMATPRIMA DESC";
$query_limit_consultamatprima = sprintf("%s LIMIT %d, %d", $query_consultamatprima, $startRow_consultamatprima, $maxRows_consultamatprima);
$consultamatprima = mysql_query($query_limit_consultamatprima, $basepangloria) or die(mysql_error());
$row_consultamatprima = mysql_fetch_assoc($consultamatprima);

if (isset($_GET['totalRows_consultamatprima'])) {
  $totalRows_consultamatprima = $_GET['totalRows_consultamatprima'];
} else {
  $all_consultamatprima = mysql_query($query_consultamatprima);
  $totalRows_consultamatprima = mysql_num_rows($all_consultamatprima);
}
$totalPages_consultamatprima = ceil($totalRows_consultamatprima/$maxRows_consultamatprima)-1;
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
            <td colspan="4" align="center" bgcolor="#999999"><h1>Consutar Control de Materia Prima</h1></td>
          </tr>
          <tr>
            <td width="23%">Id Control Materia Prima::</td>
            <td width="16%"><input type="text" name="ID_CONTROLMAT" value="" size="20" /></td>
            <td width="9%">Id Salida:</td>
            <td width="52%"><select name="ID_SALIDA">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr>
            <td>Id Materia Prima</td>
            <td><select name="IDMATPRIMA">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
            <td>Id Unidad:</td>
            <td><select name="IDUNIDAD">
              <option value="menuitem1" >[ Etiqueta ]</option>
              <option value="menuitem2" >[ Etiqueta ]</option>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;
              <table border="1">
                <tr>
                  <td>CANT_ENTREGA</td>
                  <td>CANT_DEVUELTA</td>
                  <td>CANT_UTILIZADA</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td><?php echo $row_consultamatprima['CANT_ENTREGA']; ?></td>
                    <td><?php echo $row_consultamatprima['CANT_DEVUELTA']; ?></td>
                    <td><?php echo $row_consultamatprima['CANT_UTILIZADA']; ?></td>
                  </tr>
                  <?php } while ($row_consultamatprima = mysql_fetch_assoc($consultamatprima)); ?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="consultar nuvo registro" type="reset" id="consultar nuvo registro" value="Consultar nuevo registro" /></td>
            <td><input type="reset" name="cancelar" id="cancelar" value="Cancelar" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
mysql_free_result($consultamatprima);
?>
