<?php require_once('Connections/basepangloria.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO TRNDEVOLUCIONCOMPRA (IDDEVOLUCION, IDEMPLEADO, ID_DETENCCOM, DOCADEVOLVER, FECHADEVOLUCION, IMPORTE, GASTOGENERADO, OBSERVACION) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDEVOLUCION'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['DOCADEVOLVER'], "text"),
                       GetSQLValueString($_POST['FECHADEVOLUCION'], "date"),
                       GetSQLValueString($_POST['IMPORTE'], "double"),
                       GetSQLValueString($_POST['GASTOGENERADO'], "double"),
                       GetSQLValueString($_POST['OBSERVACION'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_devolu = "SELECT IDDEVOLUCION FROM TRNDEVOLUCIONCOMPRA";
$devolu = mysql_query($query_devolu, $basepangloria) or die(mysql_error());
$row_devolu = mysql_fetch_assoc($devolu);
$totalRows_devolu = mysql_num_rows($devolu);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_dect = "SELECT ID_DETENCCOM FROM TRNDETALLECOMPRA";
$dect = mysql_query($query_dect, $basepangloria) or die(mysql_error());
$row_dect = mysql_fetch_assoc($dect);
$totalRows_dect = mysql_num_rows($dect);
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
    <td align="center"><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td align="center" bgcolor="#999999"><h1>Ingreso de Devoluciones de Compra</h1></td>
        </tr>
      </table>
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
        <table width="100%" border="1">
          <tr>
            <td>ID DEVOLUCION:</td>
            <td><input type="text" name="IDDEVOLUCION" id="IDDEVOLUCION" value="
<?php echo $row_devolu['IDDEVOLUCION']+1; ?>" size="32" readonly="readonly" /></td>
            <td>ID EMPLEADO:</td>
            <td><select name="IDEMPLEADO">
              <?php
do {  
?>
              <option value="<?php echo $row_empleado['IDEMPLEADO']?>"><?php echo $row_empleado['NOMBREEMPLEADO']?></option>
              <?php
} while ($row_empleado = mysql_fetch_assoc($empleado));
  $rows = mysql_num_rows($empleado);
  if($rows > 0) {
      mysql_data_seek($empleado, 0);
	  $row_empleado = mysql_fetch_assoc($empleado);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>ID_DETENCCOM</td>
            <td><select name="ID_DETENCCOM">
              <?php
do {  
?>
              <option value="<?php echo $row_dect['ID_DETENCCOM']?>"><?php echo $row_dect['ID_DETENCCOM']?></option>
              <?php
} while ($row_dect = mysql_fetch_assoc($dect));
  $rows = mysql_num_rows($dect);
  if($rows > 0) {
      mysql_data_seek($dect, 0);
	  $row_dect = mysql_fetch_assoc($dect);
  }
?>
            </select></td>
            <td>DOCUMENTO A DEVOLVER</td>
            <td><input type="text" name="DOCADEVOLVER" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>FECHA DEVOLUCION:</td>
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
    <input data-format="yyyy-MM-dd" type="text" name="FECHAINGRESOJUSTIFICA">
    <label for="textfield3"></label>
    <input type="text" name="textfield3" id="textfield3" />
    </input>
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
           
            <td>IMPORTE</td>
            <td><input type="text" name="IMPORTE" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>GASTO GENERADO:</td>
            <td><input type="text" name="GASTOGENERADO" value="" size="32" /></td>
            <td>OBSERVACION:</td>
            <td><input type="text" name="OBSERVACION" value="" size="32" /></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form3" />
      </form>
      <p>&nbsp;</p>
<form method="post" name="form2" id="form2">
  <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($devolu);

mysql_free_result($empleado);

mysql_free_result($dect);
?>
