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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOJUSTPERMATPRIM (IDENCABEZADO, IDEMPLEADO, IDORDENPRODUCCION, FECHAINGRESOJUSTIFICA, EMPLEADOINGRESA, FECHAHORAUSUA) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSTIFICA'], "date"),
                       GetSQLValueString($_POST['EMPLEADOINGRESA'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboempleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$comboempleado = mysql_query($query_comboempleado, $basepangloria) or die(mysql_error());
$row_comboempleado = mysql_fetch_assoc($comboempleado);
$totalRows_comboempleado = mysql_num_rows($comboempleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboorden = "SELECT IDENCABEORDPROD FROM TRNENCABEZADOORDENPROD";
$comboorden = mysql_query($query_comboorden, $basepangloria) or die(mysql_error());
$row_comboorden = mysql_fetch_assoc($comboorden);
$totalRows_comboorden = mysql_num_rows($comboorden);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td colspan="4" align="center" bgcolor="#999999"><h1>Justificacion de Perdida de Materia Prima</h1></td>
    </tr>
    <tr>
      <td width="213">Codigo de Justificacion:</td>
      <td width="215"><input name="IDENCABEZADO" type="text" disabled="disabled" value="" size="32" readonly="readonly" /></td>
      <td width="154">Empleado que Justifica:</td>
      <td width="220"><select name="IDEMPLEADO">
        <?php
do {  
?>
        <option value="<?php echo $row_comboempleado['IDEMPLEADO']?>"><?php echo $row_comboempleado['NOMBREEMPLEADO']?></option>
        <?php
} while ($row_comboempleado = mysql_fetch_assoc($comboempleado));
  $rows = mysql_num_rows($comboempleado);
  if($rows > 0) {
      mysql_data_seek($comboempleado, 0);
	  $row_comboempleado = mysql_fetch_assoc($comboempleado);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Fecha de Ingreso</td>
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
    </script>
   <div class="welsl">
  <div id="datetimepicker4" class="input-append">
    <input data-format="yyyy-MM-dd" type="text" name="FECHAINGRESOJUSTIFICA"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker4').datetimepicker({
      pickTime: false
    });
  });
</script></td>
      <td>Orden de Produccion:</td>
      <td><p>
        <select name="IDORDENPRODUCCION">
          <?php
do {  
?>
          <option value="<?php echo $row_comboorden['IDENCABEORDPROD']?>"><?php echo $row_comboorden['IDENCABEORDPROD']?></option>
          <?php
} while ($row_comboorden = mysql_fetch_assoc($comboorden));
  $rows = mysql_num_rows($comboorden);
  if($rows > 0) {
      mysql_data_seek($comboorden, 0);
	  $row_comboorden = mysql_fetch_assoc($comboorden);
  }
?>
        </select>
      </p></td>
    </tr>
    <tr>
      <td><input type="submit" value="Insertar registro" /></td>
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
  </table>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($comboempleado);

mysql_free_result($comboorden);
?>
