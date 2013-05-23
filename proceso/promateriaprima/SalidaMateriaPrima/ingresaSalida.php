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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO TRNENCABEZADOSALIDMATPRIMA (IDENCABEZADOSALMATPRI, IDEMPLEADO, ID_PED_MAT_PRIMA, FECHAYHORASALIDAMATPRIMA, USUARIO, HORAFECHAUSU, ELIMIN, EDITA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDENCABEZADOSALMATPRI'], "int"),
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_PED_MAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['FECHAYHORASALIDAMATPRIMA'], "date"),
                       GetSQLValueString($_POST['USUARIO'], "int"),
                       GetSQLValueString($_POST['HORAFECHAUSU'], "date"),
                       GetSQLValueString($_POST['ELIMIN'], "int"),
                       GetSQLValueString($_POST['EDITA'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
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
$query_materiaprima = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$materiaprima = mysql_query($query_materiaprima, $basepangloria) or die(mysql_error());
$row_materiaprima = mysql_fetch_assoc($materiaprima);
$totalRows_materiaprima = mysql_num_rows($materiaprima);

mysql_select_db($database_basepangloria, $basepangloria);
$query_salida = "SELECT IDENCABEZADOSALMATPRI FROM TRNENCABEZADOSALIDMATPRIMA";
$salida = mysql_query($query_salida, $basepangloria) or die(mysql_error());
$row_salida = mysql_fetch_assoc($salida);
$totalRows_salida = mysql_num_rows($salida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_unidad = "SELECT * FROM CATUNIDADES";
$unidad = mysql_query($query_unidad, $basepangloria) or die(mysql_error());
$row_unidad = mysql_fetch_assoc($unidad);
$totalRows_unidad = mysql_num_rows($unidad);

mysql_select_db($database_basepangloria, $basepangloria);
$query_dpto = "SELECT * FROM CATDEPARTAMENEMPRESA";
$dpto = mysql_query($query_dpto, $basepangloria) or die(mysql_error());
$row_dpto = mysql_fetch_assoc($dpto);
$totalRows_dpto = mysql_num_rows($dpto);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

mysql_select_db($database_basepangloria, $basepangloria);
$query_idsalida = "SELECT * FROM TRNSALIDA_MAT_PRIM";
$idsalida = mysql_query($query_idsalida, $basepangloria) or die(mysql_error());
$row_idsalida = mysql_fetch_assoc($idsalida);
$totalRows_idsalida = mysql_num_rows($idsalida);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">

</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
      <p>&nbsp;</p>
      <table width="820" border="0">
        <tr>
          <td>ID_SALIDA</td>
          <td><input name="ID_SALIDA" type="text" disabled="disabled" value="<?php echo $row_idsalida['ID_SALIDA']+1; ?>" size="32" readonly="readonly" /></td>
          <td>Cantidad de Materia Prima </td>
          <td><input type="text" name="CANTMAT_PRIMA" value="" size="32" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>ID_MATPRIMA</td>
          <td><select name="ID_MATPRIMA">
            <?php
do {  
?>
            <option value="<?php echo $row_materiaprima['IDMATPRIMA']?>"><?php echo $row_materiaprima['DESCRIPCION']?></option>
            <?php
} while ($row_materiaprima = mysql_fetch_assoc($materiaprima));
  $rows = mysql_num_rows($materiaprima);
  if($rows > 0) {
      mysql_data_seek($materiaprima, 0);
	  $row_materiaprima = mysql_fetch_assoc($materiaprima);
  }
?>
          </select></td>
          <td>IDENCABEZADOSALMATPRI</td>
          <td><select name="IDENCABEZADOSALMATPRI">
            <?php
do {  
?>
            <option value="<?php echo $row_salida['IDENCABEZADOSALMATPRI']?>"><?php echo $row_salida['IDENCABEZADOSALMATPRI']?></option>
            <?php
} while ($row_salida = mysql_fetch_assoc($salida));
  $rows = mysql_num_rows($salida);
  if($rows > 0) {
      mysql_data_seek($salida, 0);
	  $row_salida = mysql_fetch_assoc($salida);
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
          <td>IDUNIDAD</td>
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
          <td>IDDEPTO:</td>
          <td><select name="IDDEPTO">
            <?php
do {  
?>
            <option value="<?php echo $row_dpto['IDDEPTO']?>"><?php echo $row_dpto['DEPARTAMENTO']?></option>
            <?php
} while ($row_dpto = mysql_fetch_assoc($dpto));
  $rows = mysql_num_rows($dpto);
  if($rows > 0) {
      mysql_data_seek($dpto, 0);
	  $row_dpto = mysql_fetch_assoc($dpto);
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
          <td>FECHAYHORAUSUA</td>
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
      <input data-format="yyyy-MM-dd hh:mm:ss" type="text" />
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
            <td>EMPLEADOSACA:</td>
            <td><select name="IDEMPLEADO" id="IDEMPLEADO">
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
          <td>ELIMIN</td>
          <td><input type="text" name="ELIMIN" value="" size="32" /></td>
          <td>EDITA:</td>
          <td><input type="text" name="EDITA" value="" size="32" /></td>
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
          <td><input type="submit" value="Insertar registro" /></td>
          <td>&nbsp;</td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right" valign="top">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">:</td>
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
<p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($materiaprima);

mysql_free_result($salida);

mysql_free_result($unidad);

mysql_free_result($dpto);

mysql_free_result($empleado);

mysql_free_result($idsalida);
?>
