<?php require_once('../../../../Connections/basepangloria.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO TRNPEDIDO_MAT_PRIMA (ID_PED_MAT_PRIMA, ID_ENCAPEDIDO, IDUNIDAD, IDMATPRIMA, CANTIDADPEDMATPRI) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_PED_MAT_PRIMA'], "int"),
                       GetSQLValueString($_POST['ID_ENCAPEDIDO'], "int"),
                       GetSQLValueString($_POST['IDUNIDAD'], "int"),
                       GetSQLValueString($_POST['IDMATPRIMA'], "int"),
                       GetSQLValueString($_POST['CANTIDADPEDMATPRI'], "double"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_sumaridnuevo = "SELECT ID_ENCAPEDIDO FROM TRNENCABEZADOPEDMATPRI ORDER BY ID_ENCAPEDIDO DESC";
$sumaridnuevo = mysql_query($query_sumaridnuevo, $basepangloria) or die(mysql_error());
$row_sumaridnuevo = mysql_fetch_assoc($sumaridnuevo);
$totalRows_sumaridnuevo = mysql_num_rows($sumaridnuevo);

$maxRows_ultimodetallepedido = 10;
$pageNum_ultimodetallepedido = 0;
if (isset($_GET['pageNum_ultimodetallepedido'])) {
  $pageNum_ultimodetallepedido = $_GET['pageNum_ultimodetallepedido'];
}
$startRow_ultimodetallepedido = $pageNum_ultimodetallepedido * $maxRows_ultimodetallepedido;

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultimodetallepedido = "SELECT ID_PED_MAT_PRIMA FROM TRNPEDIDO_MAT_PRIMA ORDER BY ID_PED_MAT_PRIMA DESC";
$query_limit_ultimodetallepedido = sprintf("%s LIMIT %d, %d", $query_ultimodetallepedido, $startRow_ultimodetallepedido, $maxRows_ultimodetallepedido);
$ultimodetallepedido = mysql_query($query_limit_ultimodetallepedido, $basepangloria) or die(mysql_error());
$row_ultimodetallepedido = mysql_fetch_assoc($ultimodetallepedido);

if (isset($_GET['totalRows_ultimodetallepedido'])) {
  $totalRows_ultimodetallepedido = $_GET['totalRows_ultimodetallepedido'];
} else {
  $all_ultimodetallepedido = mysql_query($query_ultimodetallepedido);
  $totalRows_ultimodetallepedido = mysql_num_rows($all_ultimodetallepedido);
}
$totalPages_ultimodetallepedido = ceil($totalRows_ultimodetallepedido/$maxRows_ultimodetallepedido)-1;

$maxRows_ultimoingresado = 10;
$pageNum_ultimoingresado = 0;
if (isset($_GET['pageNum_ultimoingresado'])) {
  $pageNum_ultimoingresado = $_GET['pageNum_ultimoingresado'];
}
$startRow_ultimoingresado = $pageNum_ultimoingresado * $maxRows_ultimoingresado;

mysql_select_db($database_basepangloria, $basepangloria);
$encaped= $row_sumaridnuevo['ID_ENCAPEDIDO'];
$query_ultimoingresado = "SELECT * FROM TRNPEDIDO_MAT_PRIMA WHERE ID_ENCAPEDIDO = $encaped ORDER BY ID_PED_MAT_PRIMA DESC";
$query_limit_ultimoingresado = sprintf("%s LIMIT %d, %d", $query_ultimoingresado, $startRow_ultimoingresado, $maxRows_ultimoingresado);
$ultimoingresado = mysql_query($query_limit_ultimoingresado, $basepangloria) or die(mysql_error());
$row_ultimoingresado = mysql_fetch_assoc($ultimoingresado);

if (isset($_GET['totalRows_ultimoingresado'])) {
  $totalRows_ultimoingresado = $_GET['totalRows_ultimoingresado'];
} else {
  $all_ultimoingresado = mysql_query($query_ultimoingresado);
  $totalRows_ultimoingresado = mysql_num_rows($all_ultimoingresado);
}
$totalPages_ultimoingresado = ceil($totalRows_ultimoingresado/$maxRows_ultimoingresado)-1;

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboparaunidad = "SELECT IDUNIDAD, TIPOUNIDAD FROM CATUNIDADES";
$comboparaunidad = mysql_query($query_comboparaunidad, $basepangloria) or die(mysql_error());
$row_comboparaunidad = mysql_fetch_assoc($comboparaunidad);
$totalRows_comboparaunidad = mysql_num_rows($comboparaunidad);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboMatprima = "SELECT IDMATPRIMA, DESCRIPCION FROM CATMATERIAPRIMA";
$comboMatprima = mysql_query($query_comboMatprima, $basepangloria) or die(mysql_error());
$row_comboMatprima = mysql_fetch_assoc($comboMatprima);
$totalRows_comboMatprima = mysql_num_rows($comboMatprima);

$colname_unidamedida = "-1";
if (isset($_POST['IDUNIDAD'])) {
  $colname_unidamedida = $_POST['IDUNIDAD'];
}



$colname_nombremateria = "-1";
if (isset($_POST['IDMATPRIMA'])) {
  $colname_nombremateria = $_POST['IDMATPRIMA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$idtemp = $row_comboMatprima['IDMATPRIMA'];
$query_nombremateria = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$idtemp'", GetSQLValueString($colname_nombremateria, "int"));
$nombremateria = mysql_query($query_nombremateria, $basepangloria) or die(mysql_error());
$row_nombremateria = mysql_fetch_assoc($nombremateria);
$totalRows_nombremateria = mysql_num_rows($nombremateria);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../../../css/forms.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="820">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="left">
          <tr valign="baseline">
            <td colspan="3" align="right" nowrap="nowrap">Pedido de Materia Prima No.</td>
            <td><input name="ID_PED_MAT_PRIMA" type="text" disabled="disabled" value="<?php echo $row_ultimodetallepedido['ID_PED_MAT_PRIMA']+1; ?>" size="9" readonly="readonly" /></td>
            <td>Detalle Para pedido:</td>
            
            <td><input name="ID_ENCAPEDIDO" type="text" value="<?php  echo $row_sumaridnuevo['ID_ENCAPEDIDO']; ?>" size="9" readonly="readonly" /></td>
          </tr>
                          
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Cantidad:</td>
            <td nowrap="nowrap" align="right"><input type="text" name="CANTIDADPEDMATPRI" value="" size="9" /></td>
            <td nowrap="nowrap" align="right">Unidad de Medida</td>
            <td><select name="IDUNIDAD">
              <?php
do {  
?>
              <option value="<?php echo $row_comboparaunidad['IDUNIDAD']?>"><?php echo $row_comboparaunidad['TIPOUNIDAD']?></option>
              <?php
} while ($row_comboparaunidad = mysql_fetch_assoc($comboparaunidad));
  $rows = mysql_num_rows($comboparaunidad);
  if($rows > 0) {
      mysql_data_seek($comboparaunidad, 0);
	  $row_comboparaunidad = mysql_fetch_assoc($comboparaunidad);
  }
?>
            </select></td>
            <td>Materia Prima a Solicitar</td>
            <td><select name="IDMATPRIMA" onfocus="document.form1.cuerpo.disabled=false;">
              <?php
do {  
?>
              <option value="<?php echo $row_comboMatprima['IDMATPRIMA']?>"><?php echo $row_comboMatprima['DESCRIPCION']?></option>
              <?php
} while ($row_comboMatprima = mysql_fetch_assoc($comboMatprima));
  $rows = mysql_num_rows($comboMatprima);
  if($rows > 0) {
      mysql_data_seek($comboMatprima, 0);
	  $row_comboMatprima = mysql_fetch_assoc($comboMatprima);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right"><input name="cuerpo" type="submit" id="cuerpo" value="Insertar registro" disabled /></td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    </td>
  </tr>
</table>
<table width="820" border="1">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCCCCC" class="encaforms">Ultimo Registro Agregado</td>
  </tr>
  <tr class="retabla">
    <td width="75" align="center" bgcolor="#000000">Cantidad</td>
    <td width="150" align="center" bgcolor="#000000">Unidad de Medida</td>
    <td width="328" align="center" bgcolor="#000000">Materia Prima</td>
  </tr>
  <?php do { ?>
  <?php 
 // ACA CONSULTAMOS EL NOMBRE DE LA MATERIA PRIMA BASDO EN EL ID QUE ME VA TOMANDO CADA VES EL WHILE
  mysql_select_db($database_basepangloria, $basepangloria);
$idtemp = $row_ultimoingresado['IDMATPRIMA'];
$query_nombremateria = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$idtemp'", GetSQLValueString($colname_nombremateria, "int"));
$nombremateria = mysql_query($query_nombremateria, $basepangloria) or die(mysql_error());
$row_nombremateria = mysql_fetch_assoc($nombremateria);
$totalRows_nombremateria = mysql_num_rows($nombremateria);
// ACA CONSULTAMOS EL NOMBRE DE LA UNIDAD BASDO EN EL ID QUE ME VA TOMANDO CADA VES EL WHILE
$idtempunida = $row_ultimoingresado['IDUNIDAD'];
$query_unidamedida = sprintf("SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$idtempunida'", GetSQLValueString($colname_unidamedida, "int"));
$unidamedida = mysql_query($query_unidamedida, $basepangloria) or die(mysql_error());
$row_unidamedida = mysql_fetch_assoc($unidamedida);
$totalRows_unidamedida = mysql_num_rows($unidamedida);

  ?>
    <tr>
      <td><?php echo $row_ultimoingresado['CANTIDADPEDMATPRI']; ?></td>
      <td><?php echo $row_unidamedida['TIPOUNIDAD']; ?></td>
      <td align="center"><?php echo $row_nombremateria['DESCRIPCION']; ?></td>
    </tr>
    <?php } while ($row_ultimoingresado = mysql_fetch_assoc($ultimoingresado)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($sumaridnuevo);

mysql_free_result($ultimodetallepedido);

mysql_free_result($ultimoingresado);

mysql_free_result($comboparaunidad);

mysql_free_result($comboMatprima);

mysql_free_result($unidamedida);

mysql_free_result($nombremateria);
?>
