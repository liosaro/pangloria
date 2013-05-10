<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="ordcompra" name="ordcompra" method="post" action="">
  <table width="820px" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="5" align="center" bgcolor="#999999"><h1>Consultar Vendedor de Proveedor</h1></td>
    </tr>
    <tr>
      <td width="186">Seleccione tipo de Consulta</td>
      <td width="188"><label for="IDPRODUCTO">
        <input type="radio" name="radio" id="id" value="id" />
        Numero de ingreso vendededor de proveedor</label></td>
      <td width="47">&nbsp;</td>
      <td width="199"><select name="select3" id="select3">
      </select></td>
      <td width="200">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="radio" name="radio" id="id2" value="id" />
        Rango de Fecha </td>
      <td>desde:</td>
      <td><input name="IDPRODUCTO3" type="text" id="datepicker" readonly="readonly" />
        Hasta:</td>
      <td><input name="IDPRODUCTO" type="text" id="datepicker" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="radio" name="radio" id="id3" value="id" />
      Vendedor</td>
      <td>&nbsp;</td>
      <td><label for="select"></label>
        <select name="select" id="select">
          <?php
do {  
?>
          <option value="<?php echo $row_empleado['IDEMPLEADO']?>"<?php if (!(strcmp($row_empleado['IDEMPLEADO'], $row_empleado['NOMBREEMPLEADO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_empleado['NOMBREEMPLEADO']?></option>
          <?php
} while ($row_empleado = mysql_fetch_assoc($empleado));
  $rows = mysql_num_rows($empleado);
  if($rows > 0) {
      mysql_data_seek($empleado, 0);
	  $row_empleado = mysql_fetch_assoc($empleado);
  }
?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><select name="select2" id="select2">
        <?php
do {  
?>
        <option value="<?php echo $row_consultasucursal['IDSUCURSAL']?>"<?php if (!(strcmp($row_consultasucursal['IDSUCURSAL'], $row_consultasucursal['NOMBRESUCURSAL']))) {echo "selected=\"selected\"";} ?>><?php echo $row_consultasucursal['NOMBRESUCURSAL']?></option>
        <?php
} while ($row_consultasucursal = mysql_fetch_assoc($consultasucursal));
  $rows = mysql_num_rows($consultasucursal);
  if($rows > 0) {
      mysql_data_seek($consultasucursal, 0);
	  $row_consultasucursal = mysql_fetch_assoc($consultasucursal);
  }
?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="SEND" id="SEND" value="Consultar" />
        <input type="reset" name="add2" id="add2" value="Limpiar" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center" bgcolor="#999999">DETALLE</td>
    </tr>
    <tr>
      <td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0" id="detalleprod">
        <tr>
          <td width="8%" align="center" bgcolor="#C8C8C8">Movil</td>
          <td width="8%" align="center" bgcolor="#C8C8C8">Fijo</td>
          <td width="70%" align="center" bgcolor="#C8C8C8">Nombre</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
        <label for="IDMEDIDA"></label></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
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
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>