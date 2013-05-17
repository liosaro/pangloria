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
  $insertSQL = sprintf("INSERT INTO TRNDETACONTROL_PRODUCTO_HORNO (ID_CONTROLPRODHORNO, IDPRODUCTO, IDENCABEZADO, ID_MEDIDA, CANTIDAD_INGRESO, CANTIDADEGRESO) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_CONTROLPRODHORNO'], "int"),
                       GetSQLValueString($_POST['IDPRODUCTO'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['CANTIDAD_INGRESO'], "double"),
                       GetSQLValueString($_POST['CANTIDADEGRESO'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNENCACONTROLPRODHORNO (IDENCABEZADO, IDORDENPRODUCCION, FECHAYHORADEINGRESO, EMPLEADEREVISA, USUARIO, FECHAYHORATRANSAC) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['FECHAYHORADEINGRESO'], "date"),
                       GetSQLValueString($_POST['EMPLEADEREVISA'], "int"),
                       GetSQLValueString($_POST['USUARIO'], "int"),
                       GetSQLValueString($_POST['FECHAYHORATRANSAC'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_Codigocontrolhorno = "SELECT ID_CONTROLPRODHORNO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Codigocontrolhorno = mysql_query($query_Codigocontrolhorno, $basepangloria) or die(mysql_error());
$row_Codigocontrolhorno = mysql_fetch_assoc($Codigocontrolhorno);
$totalRows_Codigocontrolhorno = mysql_num_rows($Codigocontrolhorno);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Codigodeencabezado = "SELECT IDENCABEZADO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Codigodeencabezado = mysql_query($query_Codigodeencabezado, $basepangloria) or die(mysql_error());
$row_Codigodeencabezado = mysql_fetch_assoc($Codigodeencabezado);
$totalRows_Codigodeencabezado = mysql_num_rows($Codigodeencabezado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Codigodemedida = "SELECT ID_MEDIDA FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Codigodemedida = mysql_query($query_Codigodemedida, $basepangloria) or die(mysql_error());
$row_Codigodemedida = mysql_fetch_assoc($Codigodemedida);
$totalRows_Codigodemedida = mysql_num_rows($Codigodemedida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_Codigodeproduccion = "SELECT IDPRODUCTO FROM TRNDETACONTROL_PRODUCTO_HORNO";
$Codigodeproduccion = mysql_query($query_Codigodeproduccion, $basepangloria) or die(mysql_error());
$row_Codigodeproduccion = mysql_fetch_assoc($Codigodeproduccion);
$totalRows_Codigodeproduccion = mysql_num_rows($Codigodeproduccion);

$colname_Producto = "-1";
if (isset($_GET['IDPRODUCTO'])) {
  $colname_Producto = $_GET['IDPRODUCTO'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_Producto = sprintf("SELECT IDPRODUCTO FROM TRNDETACONTROL_PRODUCTO_HORNO WHERE IDPRODUCTO = %s ORDER BY IDPRODUCTO ASC", GetSQLValueString($colname_Producto, "int"));
$Producto = mysql_query($query_Producto, $basepangloria) or die(mysql_error());
$row_Producto = mysql_fetch_assoc($Producto);
$totalRows_Producto = mysql_num_rows($Producto);

$colname_codigoproduccion = "-1";
if (isset($_GET['IDORDENPRODUCCION'])) {
  $colname_codigoproduccion = $_GET['IDORDENPRODUCCION'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_codigoproduccion = sprintf("SELECT IDORDENPRODUCCION FROM TRNENCACONTROLPRODHORNO WHERE IDORDENPRODUCCION = %s ORDER BY IDORDENPRODUCCION ASC", GetSQLValueString($colname_codigoproduccion, "int"));
$codigoproduccion = mysql_query($query_codigoproduccion, $basepangloria) or die(mysql_error());
$row_codigoproduccion = mysql_fetch_assoc($codigoproduccion);
$totalRows_codigoproduccion = mysql_num_rows($codigoproduccion);
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
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">


</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso Control de Producto Horno</h1></td>
          </tr>
          <tr>
            <td width="26%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            <td width="16%">&nbsp;</td>
            <td width="28%">&nbsp;</td>
          </tr>
          <tr>
            <td>Codigo de Control Horno</td>
            <td><input name="ID_CONTROLPRODHORNO" type="text" disabled="disabled" value="<?php echo $row_Codigocontrolhorno['ID_CONTROLPRODHORNO']; ?>" size="32" readonly="readonly" /></td>
            <td>Codigo Produccion</td>
            <td><select name="codigoproduccion" id="codigoproduccion">
              <option value=""  <?php if (!(strcmp("", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>></option>
              <option value=""  <?php if (!(strcmp("", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="value" <?php if (!(strcmp("value", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="" <?php if (!(strcmp("", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Codigodeproduccion['IDPRODUCTO']?>"<?php if (!(strcmp($row_Codigodeproduccion['IDPRODUCTO'], $row_codigoproduccion['IDORDENPRODUCCION']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Codigodeproduccion['IDPRODUCTO']?></option>
              <?php
} while ($row_Codigodeproduccion = mysql_fetch_assoc($Codigodeproduccion));
  $rows = mysql_num_rows($Codigodeproduccion);
  if($rows > 0) {
      mysql_data_seek($Codigodeproduccion, 0);
	  $row_Codigodeproduccion = mysql_fetch_assoc($Codigodeproduccion);
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
            <td>Usuario:</td>
            <td><input type="text" name="USUARIO" value="" size="32" /></td>
            <td>Producto:</td>
            <td><select name="producto" id="producto">
              <?php
do {  
?>
              <option value="<?php echo $row_Producto['IDPRODUCTO']?>"<?php if (!(strcmp($row_Producto['IDPRODUCTO'], $row_Producto['IDPRODUCTO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Producto['IDPRODUCTO']?></option>
              <?php
} while ($row_Producto = mysql_fetch_assoc($Producto));
  $rows = mysql_num_rows($Producto);
  if($rows > 0) {
      mysql_data_seek($Producto, 0);
	  $row_Producto = mysql_fetch_assoc($Producto);
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
            <td>Codigo Encabezado </td>
            <td><select name="IDENCABEZADO">
              <option value=""  <?php if (!(strcmp("", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>></option>
              <option value=""  <?php if (!(strcmp("", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="" <?php if (!(strcmp("", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Codigodeencabezado['IDENCABEZADO']?>"<?php if (!(strcmp($row_Codigodeencabezado['IDENCABEZADO'], $row_Codigodeencabezado['IDENCABEZADO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Codigodeencabezado['IDENCABEZADO']?></option>
              <?php
} while ($row_Codigodeencabezado = mysql_fetch_assoc($Codigodeencabezado));
  $rows = mysql_num_rows($Codigodeencabezado);
  if($rows > 0) {
      mysql_data_seek($Codigodeencabezado, 0);
	  $row_Codigodeencabezado = mysql_fetch_assoc($Codigodeencabezado);
  }
?>
            </select></td>
            <td>Codigo Medida</td>
            <td><select name="ID_MEDIDA">
              <option value=""  <?php if (!(strcmp("", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>></option>
              <option value=""  <?php if (!(strcmp("", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="value" <?php if (!(strcmp("value", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>>label</option>
              <option value="" <?php if (!(strcmp("", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>></option>
              <option value="" <?php if (!(strcmp("", $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Codigodemedida['ID_MEDIDA']?>"<?php if (!(strcmp($row_Codigodemedida['ID_MEDIDA'], $row_Codigodemedida['ID_MEDIDA']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Codigodemedida['ID_MEDIDA']?></option>
              <?php
} while ($row_Codigodemedida = mysql_fetch_assoc($Codigodemedida));
  $rows = mysql_num_rows($Codigodemedida);
  if($rows > 0) {
      mysql_data_seek($Codigodemedida, 0);
	  $row_Codigodemedida = mysql_fetch_assoc($Codigodemedida);
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
            <td>Cantidad de Ingreso</td>
            <td><input type="text" name="CANTIDAD_INGRESO" value="" size="32" /></td>
            <td>Cantidad de Egreso</td>
            <td><input type="text" name="CANTIDADEGRESO" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Fecha y hora de Ingreso</td>
            
            
           
            
            
            
            
            <td><span id="spryfechahora">
           
           <script type="text/javascript"
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

           
           
          
    <input name="FECHAYHORADEINGRESO" type="text" id="FECHAYHORADEINGRESO" data-format="yyyy-MM-dd"></input>
<span class="add-on"><script type="text/javascript"
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
</script> <div class="well">
  <div id="datetimepicker1" class="input-append date"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>

    
            
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td>Empleado que Revisa:</td>
            <td><input type="text" name="textfield" id="textfield" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><span id="Horadeingreso"><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            
            <td>Fecha y hora de Egreso</td>
            <td><span id="spryfechahora2">
            
          <script type="text/javascript"
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
   
       
    <input name="FECHAYHORATRANSAC" type="text" id="FECHAYHORATRANSAC" data-format="yyyy-MM-dd"></input>
    
    
<span class="add-on"><script type="text/javascript"
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
</script>  <div class="well">
  <div id="datetimepicker2" class="input-append date"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker2').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>
    
            
            
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
          </tr>
          
<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="submit" value="Insertar registro" /></td>
            <td>&nbsp;</td>
           <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p>&nbsp;</p>
<p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryfechahora", "date", {format:"yyyy-mm-dd"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("spryfechahora2", "date", {format:"yyyy-mm-dd"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("spryhoradeingreso", "time", {format:"HH:mm:ss"});
</script>
</body>
</html>
<?php
mysql_free_result($Codigocontrolhorno);

mysql_free_result($Codigodeencabezado);

mysql_free_result($Codigodemedida);

mysql_free_result($Codigodeproduccion);

mysql_free_result($Producto);

mysql_free_result($codigoproduccion);
?>
