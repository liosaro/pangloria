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
    document.consultaproducto.action ="conatribucion.php?q=";
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
    document.consultaproducto.action ="cosultapertodo2.php?q=";
	
 }
  return true;
}
</script>
  <SCRIPT type="text/JavaScript" >

function lookup(inputString) {
		if(inputString.length == 0) {
 		// Hide the suggestion box.
        show(inputString);
        	$('#suggestions').hide();
		} else {
			$.post("clie9_sv.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup

	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 300);
	}
      </script>

</head>

<body>
<form id="form1" name="consultaproducto" onsubmit="return OnSubmitForm();" target="conte">
 <table width="820" border="0">
  <tr>
    <td bgcolor="#999999"><h1>Consultar</h1></td>
  </tr>
          <tr><div id="radiosearch">   
           <p>
            <label for="q"></label>
              <input type="text" name="q" id="q" />

             <tr> <TD><b>Digite la informacion requerida:</tr>
             <input type="text" size="50" value="" name="q" id="q"  onkeyup="lookup(this.value);" onblur="fill();" />
                                    <div class="suggestionsBox" id="suggestions" style="display: none;">

				                    <div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
                                    </div>
                                    <p>  </p>


              <input type="submit" name="enviar" id="enviar" value="Enviar" />
               </p>
      <table width="820px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="186">Seleccione un tipo de Consulta:</td>
          <td width="188">
          <input name="radiosearch" type="radio" value="1" checked>
          Id Atribucion</td>
          <td width="39">&nbsp;</td>
          <td width="200">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id6" value="id" />
              Usuario</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id7" value="id" />
              Rol</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id8" value="id" />
              Permiso</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="radiosearch" id="id5" value="id" />
             Todos</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        </table>
    </div>
  </tr>
</table>
<iframe src="" width="820" height="300" scrolling="auto" name="conte" frameborder="0"></iframe>

</form>
</body>
</html>