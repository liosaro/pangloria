<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
}
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table width="820" align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codigo de Entrada:</td>
      <td><input type="text" name="IDENTRADA" value="" size="32" /></td>
      <td>Codigo de Encabezado:</td>
      <td><input type="text" name="IdEncabezadoEnInventario2" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Unidad de Medida:</td>
      <td><select name="IDUNIDAD">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
      <td>Materia Prima:</td>
      <td><select name="IDMATPRIMA">
        <option value="menuitem1" >[ Etiqueta ]</option>
        <option value="menuitem2" >[ Etiqueta ]</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cantidad:</td>
      <td><input type="text" name="CANTIDAD" value="" size="32" /></td>
      <td>Fecha de Expiracion:</td>
      <td><input type="text" name="FECHAEXPIRACION" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Precio de Ultima Compra</td>
      <td><input type="text" name="PRECIOULTIMACOMPRA" value="" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><input name="cuerpo" type="submit" id="cuerpo" value="Insertar registro" disabled="disabled" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<p>&nbsp;</p>
</body>
</html>