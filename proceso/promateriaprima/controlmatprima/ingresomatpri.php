<?php require_once('../../../Connections/basepangloria.php'); ?>
<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$colname_compmatprima = "-1";
if (isset($_POST['ID_CONTROLMAT'])) {
  $colname_compmatprima = $_POST['ID_CONTROLMAT'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_compmatprima = sprintf("SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA WHERE ID_CONTROLMAT = %s ORDER BY ID_CONTROLMAT DESC", GetSQLValueString($colname_compmatprima, "int"));
$compmatprima = mysql_query($query_compmatprima, $basepangloria) or die(mysql_error());
$row_compmatprima = mysql_fetch_assoc($compmatprima);
$totalRows_compmatprima = mysql_num_rows($compmatprima);
$query_compmatprima = "SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT DESC";
$compmatprima = mysql_query($query_compmatprima, $basepangloria) or die(mysql_error());
$row_compmatprima = mysql_fetch_assoc($compmatprima);
$totalRows_compmatprima = mysql_num_rows($compmatprima);
$query_compmatprima = "SELECT ID_CONTROLMAT FROM TRNCONTROL_MAT_PRIMA ORDER BY ID_CONTROLMAT DESC";
$compmatprima = mysql_query($query_compmatprima, $basepangloria) or die(mysql_error());
$row_compmatprima = mysql_fetch_assoc($compmatprima);
$totalRows_compmatprima = mysql_num_rows($compmatprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combomatprima = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA ORDER BY IDMATPRIMA DESC";
$combomatprima = mysql_query($query_combomatprima, $basepangloria) or die(mysql_error());
$row_combomatprima = mysql_fetch_assoc($combomatprima);
$totalRows_combomatprima = mysql_num_rows($combomatprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combounidad = "SELECT IDUNIDAD, TIPOUNIDAD FROM CATUNIDADES ORDER BY IDUNIDAD DESC";
$combounidad = mysql_query($query_combounidad, $basepangloria) or die(mysql_error());
$row_combounidad = mysql_fetch_assoc($combounidad);
$totalRows_combounidad = mysql_num_rows($combounidad);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 1px;
	margin-top: 1px;
	margin-right: 1px;
	margin-bottom: 1px;
}
</style>

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

</head>

<body>
<table width="820" border="0">
  <tr>
    <td bgcolor="#CCCCCC"><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso Control Materia Prima</h1></td>
          </tr>
          <tr>
            <td width="26%">Id Control Materia Prima:</td>
            <td width="29%"><input type="text" name="ID_CONTROLMAT" value="<?php echo $row_compmatprima['ID_CONTROLMAT']+1; ?>" size="15" /></td>
            <td width="9%">Id Unidad</td>
            <td width="36%"><select name="IDUNIDAD">
              <?php
do {  
?>
              <option value="<?php echo $row_combounidad['IDUNIDAD']?>"><?php echo $row_combounidad['TIPOUNIDAD']?></option>
              <?php
} while ($row_combounidad = mysql_fetch_assoc($combounidad));
  $rows = mysql_num_rows($combounidad);
  if($rows > 0) {
      mysql_data_seek($combounidad, 0);
	  $row_combounidad = mysql_fetch_assoc($combounidad);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>Id Materia Prima</td>
            <td><select name="IDMATPRIMA">
              <?php
do {  
?>
              <option value="<?php echo $row_combomatprima['IDMATPRIMA']?>"><?php echo $row_combomatprima['DESCRIPCION']?></option>
              <?php
} while ($row_combomatprima = mysql_fetch_assoc($combomatprima));
  $rows = mysql_num_rows($combomatprima);
  if($rows > 0) {
      mysql_data_seek($combomatprima, 0);
	  $row_combomatprima = mysql_fetch_assoc($combomatprima);
  }
?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
</script> <span class="input-append">
<input name="FECHAENTREGA" type="text" id="FECHAENTREGA" data-format="yyyy-MM-dd" />
</span>
<div id="datetimepicker4" class="input-append"></input>
<span class="add-on">
<i data-time-icon="icon-time" data-date-icon="icon-calendar">
</i>
</span>
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
            <td>Cantidad Entregada:</td>
            <td><input type="text" name="CANT_ENTREGA" value="" size="15" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cantidad Devuelta:</td>
            <td><input type="text" name="CANT_DEVUELTA" value="" size="15" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Cantidad Utilizada:</td>
            <td><input type="text" name="CANT_UTILIZADA" value="" size="15" /></td>
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
            <td><input type="submit" name="enviarregistro"id="enviarregistro" value="Enviar Registro" /></td>
            <td><input type="reset" name="limpiar" id="limpiar" value="Limpiar" /></td>
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
        <p>
          <input type="hidden" name="MM_insert" value="form2" />
      </p>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($compmatprima);

mysql_free_result($combomatprima);

mysql_free_result($combounidad);
?>
