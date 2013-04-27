<?php require_once('../../../Connections/basepangloria.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../../seguridad.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE TRNENCABEZADOJUSTPERMATPRIM SET IDEMPLEADO=%s, IDORDENPRODUCCION=%s, FECHAINGRESOJUSTIFICA=%s, EMPLEADOINGRESA=%s, FECHAHORAUSUA=%s WHERE IDENCABEZADO=%s",
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSTIFICA'], "date"),
                       GetSQLValueString($_POST['EMPLEADOINGRESA'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"),
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$maxRows_encabezado = 10;
$pageNum_encabezado = 0;
if (isset($_GET['pageNum_encabezado'])) {
  $pageNum_encabezado = $_GET['pageNum_encabezado'];
}
$startRow_encabezado = $pageNum_encabezado * $maxRows_encabezado;

$colname_encabezado = "-1";
if (isset($_POST['filtrojust'])) {
  $colname_encabezado = $_POST['filtrojust'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_encabezado = sprintf("SELECT * FROM TRNENCABEZADOJUSTPERMATPRIM WHERE IDENCABEZADO = %s", GetSQLValueString($colname_encabezado, "int"));
$query_limit_encabezado = sprintf("%s LIMIT %d, %d", $query_encabezado, $startRow_encabezado, $maxRows_encabezado);
$encabezado = mysql_query($query_limit_encabezado, $basepangloria) or die(mysql_error());
$row_encabezado = mysql_fetch_assoc($encabezado);

if (isset($_GET['totalRows_encabezado'])) {
  $totalRows_encabezado = $_GET['totalRows_encabezado'];
} else {
  $all_encabezado = mysql_query($query_encabezado);
  $totalRows_encabezado = mysql_num_rows($all_encabezado);
}
$totalPages_encabezado = ceil($totalRows_encabezado/$maxRows_encabezado)-1;

$maxRows_cuerpo = 10;
$pageNum_cuerpo = 0;
if (isset($_GET['pageNum_cuerpo'])) {
  $pageNum_cuerpo = $_GET['pageNum_cuerpo'];
}
$startRow_cuerpo = $pageNum_cuerpo * $maxRows_cuerpo;

$colname_cuerpo = "-1";
if (isset($_POST['filtrojust'])) {
  $colname_cuerpo = $_POST['filtrojust'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_cuerpo = sprintf("SELECT * FROM TRNJUSTIFICAIONPERMATPRI WHERE IDENCABEZADO = %s", GetSQLValueString($colname_cuerpo, "int"));
$query_limit_cuerpo = sprintf("%s LIMIT %d, %d", $query_cuerpo, $startRow_cuerpo, $maxRows_cuerpo);
$cuerpo = mysql_query($query_limit_cuerpo, $basepangloria) or die(mysql_error());
$row_cuerpo = mysql_fetch_assoc($cuerpo);

if (isset($_GET['totalRows_cuerpo'])) {
  $totalRows_cuerpo = $_GET['totalRows_cuerpo'];
} else {
  $all_cuerpo = mysql_query($query_cuerpo);
  $totalRows_cuerpo = mysql_num_rows($all_cuerpo);
}
$totalPages_cuerpo = ceil($totalRows_cuerpo/$maxRows_cuerpo)-1;

$colname_conmedi = "-1";
if (isset($_POST['ID_MEDIDA'])) {
  $colname_conmedi = $_POST['ID_MEDIDA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$medi = $row_cuerpo['IDUNIDAD'];
$query_conmedi = sprintf("SELECT MEDIDA FROM CATMEDIDAS WHERE ID_MEDIDA = '$medi'", GetSQLValueString($colname_conmedi, "int"));
$conmedi = mysql_query($query_conmedi, $basepangloria) or die(mysql_error());
$row_conmedi = mysql_fetch_assoc($conmedi);
$totalRows_conmedi = mysql_num_rows($conmedi);

$colname_materia = "-1";
if (isset($_POST['MAT_PRIMA'])) {
  $colname_materia = $_POST['MAT_PRIMA'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$buscar = $row_cuerpo['MAT_PRIMA'];
$query_materia = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$buscar'", GetSQLValueString($colname_materia, "int"));
$materia = mysql_query($query_materia, $basepangloria) or die(mysql_error());
$row_materia = mysql_fetch_assoc($materia);
$totalRows_materia = mysql_num_rows($materia);
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
	text-align: center;
}
</style>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="IDENCABEZADO" value="<?php echo $row_encabezado['IDENCABEZADO']; ?>" />
      <table width="820" align="left">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Codigo de Encabezado:</td>
          <td><?php echo $row_encabezado['IDENCABEZADO']; ?></td>
          <td>Codigo de empleado:</td>
          <td><input name="IDEMPLEADO" type="text" value="<?php echo htmlentities($row_encabezado['IDEMPLEADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly="readonly" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Orden de Produccion:</td>
          <td><input type="text" name="IDORDENPRODUCCION" value="<?php echo htmlentities($row_encabezado['IDORDENPRODUCCION'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          <td>Fecha Ingreso:</td>
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
    <input name="FECHAINGRESOJUSTIFICA" type="text" value="<?php echo htmlentities($row_encabezado['FECHAINGRESOJUSTIFICA'], ENT_COMPAT, 'utf-8'); ?>" data-format="yyyy-MM-dd"></input>
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
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Emplead:</td>
          <td><input type="text" name="EMPLEADOINGRESA" value="<?php echo htmlentities($row_encabezado['EMPLEADOINGRESA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          <td>Fecha y Hora de usuario:</td>
          <td><input name="FECHAHORAUSUA" type="text" value="<?php echo htmlentities($row_encabezado['FECHAHORAUSUA'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly="readonly" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" value="Actualizar registro" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td><iframe src="modcuerpo.php" name="mocu" width="820" align="left"  height="250" scrolling="auto" frameborder="0"></iframe>&nbsp;</td>
  </tr>
</table>



<table width="820" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8" align="center">Detalles</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Modificar</td>
    <td>Codigo de Perdida</td>
    <td>Codigo de Encabezado</td>
    <td>Medida</td>
    <td>Cantidad</td>
    <td>Materia Prima</td>
    <td>Justificacion</td>
    <td>Usuario Ingreso</td>
    <td>Fecha y Hora de Ingreso</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center"><a href="modcuerpo.php?root=<?php echo $row_cuerpo['ID_PERDIDA']; ?>" target="mocu">Modificar</a></td>
    <td><?php echo $row_cuerpo['ID_PERDIDA']; ?></td>
    <td><?php echo $row_cuerpo['IDENCABEZADO']; ?></td>
    <td><?php echo $row_conmedi['MEDIDA']; ?></td>
    <td><?php echo $row_cuerpo['CANT_PERDIDA']; ?></td>
    <td><?php echo $row_materia['DESCRIPCION']; ?></td>
    <td><?php echo $row_cuerpo['JUSTIFICACION']; ?></td>
    <td><?php echo $row_cuerpo['USUARIOPERMATPRI']; ?></td>
    <td><?php echo $row_cuerpo['FECHAYHORAUSUAPMATPRI']; ?></td>
  </tr>
  <?php } while ($row_cuerpo = mysql_fetch_assoc($cuerpo)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($encabezado);

mysql_free_result($cuerpo);

mysql_free_result($conmedi);

mysql_free_result($materia);

mysql_free_result($encabezado);

mysql_free_result($cuerpojustifica);

mysql_free_result($nombreprod);
?>
