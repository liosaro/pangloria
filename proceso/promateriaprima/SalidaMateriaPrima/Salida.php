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
  $insertSQL = sprintf("INSERT INTO TRNSALIDA_MAT_PRIM (ID_SALIDA, CANTMAT_PRIMA, ID_MATPRIMA, IDENCABEZADOSALMATPRI, IDUNIDAD, IDDEPTO, FECHAYHORAUSUA, EMPLEADOSACA, ELIMIN, EDITA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_SALIDA'], "int"),
                       GetSQLValueString($_POST['CANTMAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_MATPRIMA'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADOSALMATPRI'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"),
                       GetSQLValueString($_POST['FECHAYHORAUSUA'], "date"),
                       GetSQLValueString($_POST['EMPLEADOSACA'], "int"),
                       GetSQLValueString($_POST['ELIMIN'], "int"),
                       GetSQLValueString($_POST['EDITA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_salida = "SELECT * FROM TRNSALIDA_MAT_PRIM";
$salida = mysql_query($query_salida, $basepangloria) or die(mysql_error());
$row_salida = mysql_fetch_assoc($salida);
$totalRows_salida = mysql_num_rows($salida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_materia = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$materia = mysql_query($query_materia, $basepangloria) or die(mysql_error());
$row_materia = mysql_fetch_assoc($materia);
$totalRows_materia = mysql_num_rows($materia);

mysql_select_db($database_basepangloria, $basepangloria);
$query_encabeza = "SELECT IDENCABEZADOSALMATPRI FROM TRNENCABEZADOSALIDMATPRIMA";
$encabeza = mysql_query($query_encabeza, $basepangloria) or die(mysql_error());
$row_encabeza = mysql_fetch_assoc($encabeza);
$totalRows_encabeza = mysql_num_rows($encabeza);

mysql_select_db($database_basepangloria, $basepangloria);
$query_unidad = "SELECT * FROM CATUNIDADES";
$unidad = mysql_query($query_unidad, $basepangloria) or die(mysql_error());
$row_unidad = mysql_fetch_assoc($unidad);
$totalRows_unidad = mysql_num_rows($unidad);

mysql_select_db($database_basepangloria, $basepangloria);
$query_depto = "SELECT IDDEPTO, DEPARTAMENTO FROM CATDEPARTAMENEMPRESA";
$depto = mysql_query($query_depto, $basepangloria) or die(mysql_error());
$row_depto = mysql_fetch_assoc($depto);
$totalRows_depto = mysql_num_rows($depto);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="820" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingreso de Salida de Materia Prima</h1></td>
          </tr>
          <tr>
            <td>ID_SALIDA</td>
            <td><input name="ID_SALIDA" type="text" disabled="disabled" value="<?php echo $row_salida['ID_SALIDA']+1; ?>" size="32" readonly="readonly" /></td>
            <td>Cantidad de Materia Prima</td>
            <td><span id="sprytextfield1">
              <input type="text" name="CANTMAT_PRIMA" value="" size="32" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Materia Prima:</td>
            <td><select name="ID_MATPRIMA">
              <?php
do {  
?>
              <option value="<?php echo $row_materia['IDMATPRIMA']?>"><?php echo $row_materia['DESCRIPCION']?></option>
              <?php
} while ($row_materia = mysql_fetch_assoc($materia));
  $rows = mysql_num_rows($materia);
  if($rows > 0) {
      mysql_data_seek($materia, 0);
	  $row_materia = mysql_fetch_assoc($materia);
  }
?>
            </select></td>
            <td> Salida de Materia Prima</td>
            <td><select name="IDENCABEZADOSALMATPRI">
              <?php
do {  
?>
              <option value="<?php echo $row_encabeza['IDENCABEZADOSALMATPRI']?>"><?php echo $row_encabeza['IDENCABEZADOSALMATPRI']?></option>
              <?php
} while ($row_encabeza = mysql_fetch_assoc($encabeza));
  $rows = mysql_num_rows($encabeza);
  if($rows > 0) {
      mysql_data_seek($encabeza, 0);
	  $row_encabeza = mysql_fetch_assoc($encabeza);
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
            <td>Unidad de Medida</td>
            <td><select name="IDUNIDAD">
              <?php
do {  
?>
              <option value="<?php echo $row_unidad['IDUNIDAD']?>"><?php echo $row_unidad['TIPOUNIDAD']?></option>
              <?php
} while ($row_unidad = mysql_fetch_assoc($unidad));
  $rows = mysql_num_rows($unidad);
  if($rows > 0) {
      mysql_data_seek($unidad, 0);
	  $row_unidad = mysql_fetch_assoc($unidad);
  }
?>
            </select></td>
            <td>Departamento </td>
            <td><select name="IDDEPTO">
              <?php
do {  
?>
              <option value="<?php echo $row_depto['IDDEPTO']?>"><?php echo $row_depto['DEPARTAMENTO']?></option>
              <?php
} while ($row_depto = mysql_fetch_assoc($depto));
  $rows = mysql_num_rows($depto);
  if($rows > 0) {
      mysql_data_seek($depto, 0);
	  $row_depto = mysql_fetch_assoc($depto);
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
            <td>Fecha y hora</td>
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
  <div id="datetimepicker1" class="input-append date"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
            <input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="FECHAYHORAUSUA" value="" size="32" />
             </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'El Salvador'
    });
  });
</script></td>
            <td>Empleado</td>
            <td><label for="select">
              <select name="select" id="select">
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
              </select>
            </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_insert" value="form2" />
      </p>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($salida);

mysql_free_result($materia);

mysql_free_result($encabeza);

mysql_free_result($unidad);

mysql_free_result($depto);

mysql_free_result($empleado);
?>
