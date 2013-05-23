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

$MM_restrictGoTo = "../../seguridad.php";
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
?><head>
 <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
 </Head>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO TRNENTREGAPRODUCTO (ID_ENTREGA, FECHAHORA, CANT_PRODUCTORECIBIDO, PRODUCTOENTRPROD, IDENCAENTREPROD, ID_MEDIDA, USUARIOENTREPRODUCTO, USUARIOFECHAYHORA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ENTREGA'], "int"),
                       GetSQLValueString($_POST['FECHAHORA'], "date"),
                       GetSQLValueString($_POST['CANT_PRODUCTORECIBIDO'], "int"),
                       GetSQLValueString($_POST['PRODUCTOENTRPROD'], "int"),
                       GetSQLValueString($_POST['IDENCAENTREPROD'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['USUARIOENTREPRODUCTO'], "int"),
                       GetSQLValueString($_POST['USUARIOFECHAYHORA'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultiRegis = "SELECT IDENCAENTREPROD FROM TRNENCABEZADOENTREPROD ORDER BY IDENCAENTREPROD DESC";
$ultiRegis = mysql_query($query_ultiRegis, $basepangloria) or die(mysql_error());
$row_ultiRegis = mysql_fetch_assoc($ultiRegis);
$totalRows_ultiRegis = mysql_num_rows($ultiRegis);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboMedida = "SELECT * FROM CATMEDIDAS";
$comboMedida = mysql_query($query_comboMedida, $basepangloria) or die(mysql_error());
$row_comboMedida = mysql_fetch_assoc($comboMedida);
$totalRows_comboMedida = mysql_num_rows($comboMedida);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboProd = "SELECT IDPRODUCTO, DESCRIPCIONPRODUC FROM CATPRODUCTO";
$comboProd = mysql_query($query_comboProd, $basepangloria) or die(mysql_error());
$row_comboProd = mysql_fetch_assoc($comboProd);
$totalRows_comboProd = mysql_num_rows($comboProd);

$colname_usuarioEntre = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarioEntre = $_SESSION['MM_Username'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_usuarioEntre = sprintf("SELECT IDUSUARIO FROM CATUSUARIO WHERE IDUSUARIO = %s", GetSQLValueString($colname_usuarioEntre, "int"));
$usuarioEntre = mysql_query($query_usuarioEntre, $basepangloria) or die(mysql_error());
$row_usuarioEntre = mysql_fetch_assoc($usuarioEntre);
$totalRows_usuarioEntre = mysql_num_rows($usuarioEntre);
?>
 
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="820" border="0">
    <tr>
      <td>&nbsp;</td>
      <td>Id Entrega:</td>
      <td><input name="ID_ENTREGA" type="text" disabled="disabled" value="" size="32" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Id Encab. Entrega Producto:</td>
      <td><input name="IDENCAENTREPROD" type="text" value="<?php echo $row_ultiRegis['IDENCAENTREPROD']; ?>" size="32" readonly="readonly" /></td>
      <td>Producto Entragado:</td>
      <td><select name="PRODUCTOENTRPROD">
        <?php
do {  
?>
        <option value="<?php echo $row_comboProd['IDPRODUCTO']?>"><?php echo $row_comboProd['DESCRIPCIONPRODUC']?></option>
        <?php
} while ($row_comboProd = mysql_fetch_assoc($comboProd));
  $rows = mysql_num_rows($comboProd);
  if($rows > 0) {
      mysql_data_seek($comboProd, 0);
	  $row_comboProd = mysql_fetch_assoc($comboProd);
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
      <td>Id Medida:</td>
      <td><select name="ID_MEDIDA">
        <?php
do {  
?>
        <option value="<?php echo $row_comboMedida['ID_MEDIDA']?>"><?php echo $row_comboMedida['MEDIDA']?></option>
        <?php
} while ($row_comboMedida = mysql_fetch_assoc($comboMedida));
  $rows = mysql_num_rows($comboMedida);
  if($rows > 0) {
      mysql_data_seek($comboMedida, 0);
	  $row_comboMedida = mysql_fetch_assoc($comboMedida);
  }
?>
      </select></td>
      <td>Cantidad Producto Recibido:</td>
      <td><input type="text" name="CANT_PRODUCTORECIBIDO" value="" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Usuario Entrega Producto:</td>
      <td><input name="USUARIOENTREPRODUCTO" type="text" value="<?php echo $row_usuarioEntre['IDUSUARIO']; ?>" size="32" readonly="readonly" /></td>
      <td>Fecha y Hora:</td>
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
  <div id="datetimepicker1" class="input-append date">
    <input data-format="yyyy-MM-dd hh:mm:ss" type="text"></input>
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
</script></td>
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
      <td>Fecha y Hora del Usuario:</td>
      <td><input type="text" name="USUARIOFECHAYHORA" value="<?php echo date("Y-m-d H:i:s");;?>" size="32" /></td>
    </tr>
    <tr>
      <td><input type="submit" value="Insertar registro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($ultiRegis);

mysql_free_result($comboMedida);

mysql_free_result($comboProd);

mysql_free_result($usuarioEntre);
?>
