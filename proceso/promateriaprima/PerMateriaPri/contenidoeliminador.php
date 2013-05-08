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
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form action="elimina.php" method="post" name="form1" target="contelimin" id="form1">
      <label for="filtrador">Ingrese el numero de Justificacion que desea eliminar:</label>
      <span id="sprytextfield1">
      <input type="text" name="filtrador" id="filtrador" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span>
      <input type="submit" name="buscar" id="buscar" value="Enviar" />
    </form></td>
  </tr>
  <tr>
    <td><iframe src="elimina.php" name="contelimin" width="820" height="600" scrolling="auto" frameborder="0"></iframe>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minValue:0, validateOn:["blur"]});
</script>
</body>
</html>