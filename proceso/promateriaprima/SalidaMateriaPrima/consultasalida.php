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
    document.consultaproducto.action ="consultaid.php?q=";
  }
  if(document.consultaproducto.radiosearch[1].checked == true)
  {
    document.consultaproducto.action ="consultacaducidad.php?q=";
  }
   if(document.consultaproducto.radiosearch[2].checked == true)
  {
    document.consultaproducto.action ="consultacosto.php?q=";
  }
   if(document.consultaproducto.radiosearch[3].checked == true)
  {
    document.consultaproducto.action ="consultanombre.php?q=" ;
  }
   if(document.consultaproducto.radiosearch[4].checked == true)
  {
    document.consultaproducto.action ="consultatodos.php";
  }
  return true;
}
</script>
</head>

</head>

<body>
<form id="form1" name="consultaproducto" onsubmit="return OnSubmitForm();" target="conte">
<table width="600" border="0">
  <tr>
    <td bgcolor="#999999"><h1>Consultar Salida de Materia Prima </h1></td>
  </tr>
  <tr>
    <td><div id="radiosearch">
      <p>
        <label for="q"></label>
        <input type="text" name="q" id="q" />
        <input type="submit" name="enviar" id="enviar" value="Enviar" />
      </p>
      <table width="820px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="186">Seleccione tipo de Consulta:</td>
          <td width="188">
          <input name="radiosearch" type="radio" value="1" checked>
          Id de Producto
       	  </td>
          <td width="39">&nbsp;</td>
          <td width="200">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="radio" name="radiosearch" id="id6" value="id" />
            Dias de Caducidad</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="radio" name="radiosearch" id="id7" value="id" />
            Precio de Costo</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="radio" name="radiosearch" id="id8" value="id" />
            Nombre de Producto</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="radio" name="radiosearch" id="id9" value="id" /> 
            Todos</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<iframe src="" width="820" height="300" scrolling="auto" name="conte"></iframe>

</form>
</body>
</html>