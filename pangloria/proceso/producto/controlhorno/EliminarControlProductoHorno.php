<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820px" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" align="center" bgcolor="#999999"><h1>Eliminar Control Producto en Horno</h1></td>
  </tr>
  <tr>
    <td>Codigo de Control Producto en Horno</td>
    <td><label for="IDPRODUCTO2">
      <select name="IDSucursal2" id="IDSucursal2">
        <?php
do {  
?>
        <option value="<?php echo $row_SELCTORPROD['IDENCABEORDPROD']?>"<?php if (!(strcmp($row_SELCTORPROD['IDENCABEORDPROD'], $row_SELCTORPROD['IDENCABEORDPROD']))) {echo "selected=\"selected\"";} ?>><?php echo $row_SELCTORPROD['IDENCABEORDPROD']?></option>
        <?php
} while ($row_SELCTORPROD = mysql_fetch_assoc($SELCTORPROD));
  $rows = mysql_num_rows($SELCTORPROD);
  if($rows > 0) {
      mysql_data_seek($SELCTORPROD, 0);
	  $row_SELCTORPROD = mysql_fetch_assoc($SELCTORPROD);
  }
?>
      </select>
    </label></td>
    <td>&nbsp;</td>
    <td>Fecha </td>
    <td><input name="IDPRODUCTO2" type="text" id="IDPRODUCTO4" readonly="readonly" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="IDPRODUCTO" type="text" id="IDPRODUCTO" readonly="readonly" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>&nbsp;</p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Empleado que Ingresa</td>
    <td><input name="IDPRODUCTO3" type="text" id="IDPRODUCTO2" readonly="readonly" /></td>
    <td>&nbsp;</td>
    <td>Id de Orden Produccion Horno</td>
    <td><input name="IDPRODUCTO4" type="text" id="IDPRODUCTO4" readonly="readonly" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="186">&nbsp;</td>
    <td width="188">&nbsp;</td>
    <td width="47">&nbsp;</td>
    <td width="199">&nbsp;</td>
    <td width="200">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center" bgcolor="#999999">DETALLE</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0" id="detalleprod">
      <tr>
        <td width="8%" align="center" bgcolor="#C8C8C8">Cantidad</td>
        <td width="8%" align="center" bgcolor="#C8C8C8">Medida</td>
        <td width="14%" align="center" bgcolor="#C8C8C8">Orden Produccion Horno</td>
        <td width="70%" align="center" bgcolor="#C8C8C8">Producto</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <label for="IDMEDIDA"></label></td>
  </tr>
  <tr>
    <td colspan="5"><input type="submit" name="SEND" id="SEND" value="Eliminar" /></td>
  </tr>
</table>
</body>
</html>