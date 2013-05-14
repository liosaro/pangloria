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

mysql_select_db($database_basepangloria, $basepangloria);
$query_conmodificar = "SELECT ID_ENCAPEDIDO, FECHA FROM TRNENCABEZADOPEDMATPRI ORDER BY FECHA DESC";
$conmodificar = mysql_query($query_conmodificar, $basepangloria) or die(mysql_error());
$row_conmodificar = mysql_fetch_assoc($conmodificar);
$totalRows_conmodificar = mysql_num_rows($conmodificar);
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
    <td><form action="modpedmatpri.php" method="post" name="form1" target="contemodi" id="form1">
      Ingrese o seleccione el codigo de Pedido de Materia Prima a modificar:
          <label for="filtrojust"></label>
      <select name="filtrojust" id="filtrojust" onchange="submit">
        <?php
do {  
?>
        <option value="<?php echo $row_conmodificar['ID_ENCAPEDIDO']?>"><?php echo $row_conmodificar['ID_ENCAPEDIDO']?>--<?php echo $row_conmodificar['FECHA']?></option>
        <?php
} while ($row_conmodificar = mysql_fetch_assoc($conmodificar));
  $rows = mysql_num_rows($conmodificar);
  if($rows > 0) {
      mysql_data_seek($conmodificar, 0);
	  $row_conmodificar = mysql_fetch_assoc($conmodificar);
  }
?>
      </select>
      <input type="submit" name="enviar" id="enviar" value="Enviar" />
    S
    </form></td>
  </tr>
  <tr>
    <td><iframe src="modpedmatpri.php" name="contemodi" width="820" height="600" scrolling="auto" frameborder="0"></iframe>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($conmodificar);
?>
