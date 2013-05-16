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
  $insertSQL = sprintf("INSERT INTO CATATRIBUCIONES (ID_ATRIB, IDUSUARIO, IDROL, IDPERMISO, C, R, U, D) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ATRIB'], "int"),
                       GetSQLValueString($_POST['IDUSUARIO'], "int"),
                       GetSQLValueString($_POST['IDROL'], "int"),
                       GetSQLValueString($_POST['IDPERMISO'], "int"),
                       GetSQLValueString($_POST['C'], "int"),
                       GetSQLValueString($_POST['R'], "int"),
                       GetSQLValueString($_POST['U'], "int"),
                       GetSQLValueString($_POST['D'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}
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


<script type="text/javascript">
function OnSubmitForm()
{
  if(document.consultaproducto.radiosearch[0].checked == true)
  {
    document.consultaproducto.action ="conatribucion1.php?q=";
  }
  if(document.consultaproducto.radiosearch[1].checked == true)
  {
    document.consultaproducto.action ="conatribucion.php?q=";
  }
   if(document.consultaproducto.radiosearch[2].checked == true)
  {
    document.consultaproducto.action ="conatribucion.php?q=";
  }
   if(document.consultaproducto.radiosearch[3].checked == true)
  {
    document.consultaproducto.action ="conatribucion.php?q=";
	
 }
  return true;
}
</script>




</head>

<body>
<form id="form1" name="consultaproducto" onsubmit="return OnSubmitForm();" target="conte">

<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="60%" border="0">
          <tr>
            <td colspan="3" align="center" bgcolor="#999999"><h1>Consultar Atribuciones</h1></td>
          </tr>
          <tr><div id="radiosearch">   
                             
            <td width="27%"><label for="q"></label>
              <input type="text" name="q" id="q" />
              <input type="submit" name="enviar" id="enviar" value="Enviar" /></td>
            <td width="69%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
          </tr>
          <tr>
            <td>Seleccione tipo de Consulta.</td>
            <td><input name="radiosearch" type="radio" value="id"  checked />
              Id Atribucion</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id6" value="id" />
              Usuario</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id7" value="id" />
              Rol</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id8" value="id" />
              Permiso</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="boton5" value="id" />
            <label for="boton5"></label>
            Todos</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><iframe src="" width="820" height="200" name="conte"scrolling="auto"></iframe>&nbsp;</td>
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