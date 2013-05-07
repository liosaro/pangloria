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
$query_Recordset1 = "SELECT IdEncabezadoEnInventario, fechaIngresoInventario FROM TrnEncaEntrInventario ORDER BY IdEncabezadoEnInventario DESC";
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="consultaentrainventa.php" method="post" name="form1" target="conte" id="form1" onsubmit="changeContent">
      <p>
        <label for="filtrador">Elija o Ingrese el Numero de Entrada a Inventario</label>
        <select name="filtrador" id="filtrador">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['IdEncabezadoEnInventario']?>"><?php echo $row_Recordset1['IdEncabezadoEnInventario']."</b>"?>----<?php echo $row_Recordset1['fechaIngresoInventario']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
        <input type="submit" name="Filtrar" id="Filtrar" value="Buscar" />
      </p>
    </form>
    <form action="consultacaducidad.php" method="get" name="focadu" target="conte">
      <input type="submit" name="caduenvia" id="caduenvia" value="Consultar productos proximos a caducar" />
    </form></td>
  </tr>
</table>
<p><iframe src="consultaentrainventa.php" name="conte" width="820" height="400" scrolling="auto" frameborder="0"></iframe>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
